<?php
/**
 * TraverseModel Class
 *
 * Poligon hesabı işlemleri
 *
 * @author Mete Ercan Pakdil
 */
class TraverseModel extends Model {

	function TraverseModel()
	{
		parent::Model();
	}

	/**
	 * Çizelge verilerini POST global değişkeninden çekerek dizi oluşturur
	 *
	 * @return Array
	 */
	function getData(){
		$result=array(
      		'numPoints'=>$this->input->post('num_points'),
      		'traverseType'=>$this->input->post('traverse_type'),
      		'isValid'=>TRUE,
      		'isEmpty'=>FALSE
		);
		foreach($_POST as $key=>$value)
		{
			if(in_array(preg_replace('/[^A-z]/', '', $key), array('id', 'distance','angle','azimuth','X','Y'))){
				if(!empty($value))
				{
					$result[preg_replace('/[^A-z]/', '', $key)][preg_replace('/[^0-9]/', '', $key)]=$value;
				}else
				{
					$result['isEmpty']=TRUE;
					$result['isValid']=FALSE;
				}
			}
		}
		return $result;
	}

	/**
	 * Proje verilerini veritabanından yükler
	 *
	 * @param Integer $pid proje no (gerekli)
	 * @return Array
	 */
	function getDataFromDB($pid)
	{
		$dbResult = $this->db->where('pid',$pid)->where('uid',$this->gu_session->getUID())->get('projects')->row();
		if ($dbResult==null)
		{
			return null;
		}
		$result = array(
			'traverseType' => $dbResult->type,
			'numPoints' => $dbResult->num_points,
			'angle' => unserialize($dbResult->angle),
			'distance' => unserialize($dbResult->distance),
			'azimuth' => unserialize($dbResult->azimuth),
			'id' => unserialize($dbResult->id),
			'X' => unserialize($dbResult->x),
			'Y' => unserialize($dbResult->y),
			'isValid'=>TRUE,
      		'isEmpty'=>FALSE
		);
		return $result;
	}

	/**
	 * Proje daha önce kayıtlı mı kontrol eder
	 *
	 * @param String $tag proje etiketi (gerekli)
	 * @return Boolean
	 */
	function isExist($tag){
		$isExist=$this->db->where('uid',$this->gu_session->getUID())->where('tag',$tag)->get('projects')->num_rows();
		if ($isExist)
		{
			return TRUE;
		}else
		{
			return FALSE;
		}
	}
	
	/**
	 * Yeni proje kayıt eder
	 *
	 * @param Array $data proje verileri (gerekli)
	 * @return Boolean
	 */
	function save($data){
		return $this->db->insert('projects',$data);
	}
	
	/**
	 * Kayıtlı projeyi siler
	 *
	 * @param Integer $pid proje no (gerekli)
	 * @return Boolean
	 */
	function delete($pid)
	{
		$dbResult = $this->db->where('pid',$pid)->where('uid',$this->gu_session->getUID())->delete('projects');
		return $dbResult;
	}

	/**
	 * Açık poligon hesabını GUPA servisini kullanarak gerçekleştirir
	 *
	 * @param Array $data hesap çizelgesi verileri (gerekli)
	 * @return Array
	 */
	function freeTraverse($data){
		#debug print_r($data);
		$params=array(
			'point'=>'POINT('.$data['X'][0].' '.$data['Y'][0].')',
			'azimuth'=>$data['azimuth'][0],
			'angle'=>implode(',', $data['angle']),
			'distance'=>implode(',', $data['distance'])
		);
		$result=json_decode($this->gupa->api('/traverse/free/',$params,NULL),TRUE);
		if ($result == null)
		{
			$data['errorMessage']="GUPA ile iletişim kurulamadı!";
			return $data;
		}
		if ($result['error_code']==0)
		{
			#debug print_r($result);
			$this->load->library('wkt');
			$pt_array = $this->wkt->read($result['point']);
			$data['X'] = $pt_array['X'];
			$data['Y'] = $pt_array['Y'];
			unset($result['point']);
			return array_merge($data,$result);
		}else
		{
			$data['errorMessage']=$this->gupaErrorMessage($result['error_code']);
			return $data;
		}
	}

	/**
	 * Kapalı poligon hesabını GUPA servisini kullanarak gerçekleştirir
	 *
	 * @param Array $data hesap çizelgesi verileri (gerekli)
	 * @return Array
	 */
	function ringTraverse($data){
		#debug print_r($data);
		$params=array(
			'point'=>'POINT('.$data['X'][0].' '.$data['Y'][0].')',
			'azimuth'=>$data['azimuth'][0],
			'angle'=>implode(',', $data['angle']),
			'distance'=>implode(',', $data['distance'])
		);
		$result=json_decode($this->gupa->api('/traverse/ring/',$params,NULL),TRUE);
		if ($result == null)
		{
			$data['errorMessage']="GUPA ile iletişim kurulamadı!";
			return $data;
		}
		if ($result['error_code']==0)
		{
			#debug print_r($result);
			$maxFb=1.50*sqrt($data['numPoints'])/100;
			$maxFq=0.05+0.15*sqrt(array_sum($data['distance'])/1000);
			$maxFl=0.05+0.04*sqrt($data['numPoints']-1);
			$S=sqrt(pow(array_sum($result['dy']),2)+pow(array_sum($result['dx']),2));
			$fq=0; //Kapalı poligonda her zaman sıfır
			$fl=1/$S*(pow(array_sum($result['dy']),2)+pow(array_sum($result['dx']),2));
			//Açı Kapanma Hatası Kontrolü
			if (abs($result['fb'])>$maxFb)
			{
				$data['errorMessage']="Açı kapanma hatası oluştu!";
				return array_merge($data,$result);
			}
			//Koordinat Kapanma Hatası Kontrolü
			if (abs($fq)>$maxFq || abs($fl)>$maxFl)
			{
				$data['errorMessage']="Koordinat kapanma hatası oluştu!";
				return array_merge($data,$result);
			}
			$this->load->library('wkt');
			$pt_array = $this->wkt->read($result['point']);
			$data['X'] = $pt_array['X'];
			$data['Y'] = $pt_array['Y'];
			$data['aDiff'] = floatval($result['fb'])/count($data['angle']);
			unset($result['point']);
			return array_merge($data,$result);
		}else
		{
			$data['errorMessage']=$this->gupaErrorMessage($result['error_code']);
			return $data;
		}
	}

	/**
	 * Bağlı poligon hesabını GUPA servisini kullanarak gerçekleştirir
	 *
	 * @param Array $data hesap çizelgesi verileri (gerekli)
	 * @return Array
	 */
	function closedTraverse($data){
		#debug print_r($data);
		$params=array(
			'point'=>'MULTIPOINT(
					 '.$data['X'][0].' '.$data['Y'][0].', 
					 '.$data['X'][1].' '.$data['Y'][1].', 
					 '.$data['X'][$data['numPoints']+2].' '.$data['Y'][$data['numPoints']+2].', 
					 '.$data['X'][$data['numPoints']+3].' '.$data['Y'][$data['numPoints']+3].')',
			'angle'=>implode(',', $data['angle']),
			'distance'=>implode(',', $data['distance'])
		);
		$result=json_decode($this->gupa->api('/traverse/closed/',$params,NULL),TRUE);
		if ($result == null)
		{
			$data['errorMessage']="GUPA ile iletişim kurulamadı!";
			return $data;
		}
		if ($result['error_code']==0)
		{
			#debug print_r($result);
			$result['maxFb']=1.50*sqrt($data['numPoints'])/100;
			//Koordinat kapanma hatası kontrolü
			$result['maxFq']=0.05+0.15*sqrt(array_sum($data['distance'])/1000);
			$result['maxFl']=0.05+0.04*sqrt($data['numPoints']-1);
			$result['S']=sqrt(pow(array_sum($result['dy']),2)+pow(array_sum($result['dx']),2));
			$result['fq']=1/$result['S']*(array_sum($result['dx'])*$result['fy']+array_sum($result['dx'])*$result['fx']);
			$result['fl']=1/$result['S']*(array_sum($result['dy'])*$result['fy']+array_sum($result['dx'])*$result['fx']);
			//Açı Kapanma Hatası Kontrolü
			if (abs($result['fb'])>$maxFb)
			{
				$data['errorMessage']="Açı kapanma hatası oluştu!";
				return array_merge($data,$result);
			}
			//Koordinat Kapanma Hatası Kontrolü
			if (abs($fq)>$maxFq || abs($fl)>$maxFl)
			{
				$data['errorMessage']="Koordinat kapanma hatası oluştu!";
				return array_merge($data,$result);
			}
			$this->load->library('wkt');
			$pt_array = $this->wkt->read($result['point']);
			$data['X'] = $pt_array['X'];
			$data['Y'] = $pt_array['Y'];
			$data['aDiff'] = floatval($result['fb'])/count($data['angle']);
			unset($result['point']);
			return array_merge($data,$result);
		}else
		{
			$data['errorMessage']=$this->gupaErrorMessage($result['error_code']);
			return $data;
		}
	}
	
	/**
	 * GUPA servisinden gelen error_code parametresine göre hata mesajı üretir.
	 *
	 * @param Integer $code GUPA hata kodu (gerekli)
	 * @return String
	 */
	private function gupaErrorMessage($code){
		switch ($code) {
			case 100:
				return "Lütfen girdiğiniz sayısal değerlerin nokta ile ayrılmış ve sadece rakamlardan oluştuğuna emin olun";
				break;
					
			default:
				return $code.': Bilinmeyen bir hata oluştu!';
				break;
		}
	}
}