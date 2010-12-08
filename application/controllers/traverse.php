<?php
/**
 * Traverse Class
 *
 * Poligon hesabı işlemleri için gereken metdolar
 *
 * @author Mete Ercan Pakdil
 */
class Traverse extends Controller {

	var $title_tr = array('free' => 'Açık','ring' => 'Kapalı','closed' => 'Bağlı');
	
	/**
	* Traverse sınıfını yükler.
	*/
	function Traverse()
	{
		parent::Controller();
		$this->load->library('gupa');
		$this->load->model('TraverseModel', '', TRUE);
	}

	/**
	* Yeni proje oluşturmak için 
	*/
	function new_project(){
		if (!$this->gu_session->isLogged()) redirect("");
		$this->load->view('header');
		$this->load->view('traverse/new_project');
		$this->load->view('footer');
	}
	
	/**
	* Seçilen poligon tipine göre poligon hesabı çizelgesini yükler.
	*/
	function table(){
		if (!$this->gu_session->isLogged()) redirect("");
		$data=$this->TraverseModel->getData();
		$data['title']=$this->title_tr[$data['traverseType']].' Poligon Hesabı';
		$this->load->view('header');
		$this->load->view('traverse/table_header',$data);
		$this->load->view('traverse/'.$data['traverseType'].'_traverse_table',$data);
		$this->load->view('traverse/table_footer',$data);
		$this->load->view('footer');
	}
	
	/**
	* Çizelgeden gelen verilere göre poligon hesabını yapar.
	*/
	function calculate(){
		if (!$this->gu_session->isLogged()) redirect("");
		//POST global değişkeni ile gelen parametreler okunur
		$data=$this->TraverseModel->getData();
		//Gerekli parametreler gelmiş mi kontrol edilir
		if (!$data['isEmpty'])
		{
			//Poligon tipine göre ilgili hesap metodu çağırılır
			switch ($data['traverseType'])
			{
				case "free":
					$data=$this->TraverseModel->freeTraverse($data);
					break;
				case "ring":
					$data=$this->TraverseModel->ringTraverse($data);
					break;
				case "closed":
					$data=$this->TraverseModel->closedTraverse($data);
					break;
			}
		}else //Eğer gerekli parametreler yoksa hata mesajı oluşturulur
		{
			$data['errorMessage']="Lütfen tüm eksik alanları doldurun aksi halde hesaplama gerçekleşmeyecektir!";
		}

		$data['title']=$this->title_tr[$data['traverseType']].' Poligon Hesabı';
		$data['regulation'] = $this->_prepareRegulation($data);
		$this->load->view('header');
		$this->load->view('traverse/table_header',$data);
		$this->load->view('traverse/'.$data['traverseType'].'_traverse_table',$data);
		$this->load->view('traverse/table_footer',$data);
		$this->load->view('footer');
	}
	
	/**
	* Poligon hesabını daha sonra çalışmak üzere kaydeder.
	*/
	function save(){
		if (!$this->gu_session->isLogged()) die("Erişim Yetkiniz Yok!");
		$tag = trim($this->input->post('tag',TRUE));
		if (empty($tag))
		{
			echo '<div id="warning">Lütfen etiket alanını boş bırakmayın.</div>';
			exit();
		}
		$data=$this->TraverseModel->getData();
		if (!$data['isEmpty'])
		{
			$isExist = $this->TraverseModel->isExist($tag);
			if ($isExist)
			{
				echo '<div id="warning">Bu etiketle başka bir proje kaydetmişsiniz. Lütfen farklı bir etiket kullanın.</div>';
			}else
			{
				$saveData=array(
					'uid' => $this->gu_session->getUID(),
					'date' => time(),
					'tag' => $tag,
					'type' => $data['traverseType'],
					'num_points' => $data['numPoints'],
					'id' => serialize($data['id']),
					'angle' => serialize($data['angle']),
					'distance' => serialize($data['distance']),
					'x' => serialize($data['X']),
					'y' => serialize($data['Y'])
				);
				if ($data['traverseType']!='closed')
				{
					$saveData['azimuth'] = serialize($data['azimuth']);
				}
				$this->TraverseModel->save($saveData);
				echo '<div id="success">Projeniz başarıyla kaydedildi.</div>';
			}
		}else
		{
			echo '<div id="warning">Tablodaki tüm alanları doldurmadan projenizi kaydedemezsiniz.</div>';
		}
	}

	/**
	* Daha önceden kaydedilmiş poligon hesabı projesini yükler
	*/
	function open()
	{
		if (!$this->gu_session->isLogged()) redirect("");
		$pid = intval($this->uri->segment(3));
		if (!$pid)
		{
			redirect("user/projects");
		}
		$data = $this->TraverseModel->getDataFromDB($pid);
		if ($data==null)
		{
			show_error("Proje bulunamadı!");
			exit();
		}
		$data['title']=$this->title_tr[$data['traverseType']].' Poligon Hesabı';
		$this->load->view('header');
		$this->load->view('traverse/table_header',$data);
		$this->load->view('traverse/'.$data['traverseType'].'_traverse_table',$data);
		$this->load->view('traverse/table_footer',$data);
		$this->load->view('footer');
	}
	
	/**
	* Kayıtlı projeyi siler
	*/
	function delete()
	{
		if (!$this->gu_session->isLogged()) redirect("");
		$pid = intval($this->uri->segment(3));
		if (!$pid)
		{
			redirect("user/projects");
		}
		$this->TraverseModel->delete($pid);
		redirect("user/projects");	
	}
	
	/**
	* Büyük Ölçekli Harita ve Harita Bilgileri Üretim yönetmeliğine göre hesap kontrollerini görselleştiren özel(private) metod.
	* 
	* @param Array $data hesap kontrolleri için gerekli parametreler (gerekli)
	* @return String
	*/
	function _prepareRegulation($data, $fb, $maxFb, $fq, $maxFq, $fl, $maxFl, $S, $type='ring', $fx=0, $fy=0){
		$regulation  = '<fieldset><legend><b>Hesap Kontrolü</b></legend>';
		$regulation .= '<table cellspacing="10" width="100%"><tr><td valign="top" width="40%" class="regulation">';
		if ($data['traverseType']=='ring')
		{
			$regulation .= '<img src="'.base_url().'images/regulation/f_b.png" align="absbottom"> = '.sprintf("%.4f",$data['fb']).'<br>';
		}else
		{
			$regulation .= '<img src="'.base_url().'images/regulation/f_b_2.png" align="absbottom"> = '.sprintf("%.4f",$data['fb']).'<br>';
		}
		$regulation .= '<img src="'.base_url().'images/regulation/FB.png" align="absbottom"> = '.sprintf("%.4f",$data['maxFb']).'<br>';
		if ($data['traverseType']=='closed')
		{
			$regulation .= '<img src="'.base_url().'images/regulation/fx_2.png" align="absbottom"> = '.sprintf("%.4f",$data['fx']).'<br>';
			$regulation .= '<img src="'.base_url().'images/regulation/fy_2.png" align="absbottom"> = '.sprintf("%.4f",$data['fy']).'<br>';
		}
		$regulation .= '<img src="'.base_url().'images/regulation/S.png" align="absbottom"> = '.sprintf("%.4f",$data['S']).'<br>';
		$regulation .= '</td><td class="yonetmelik" width="40%">';
		$regulation .= '<img src="'.base_url().'images/regulation/f_q.png" align="absbottom"> = '.sprintf("%.4f",$data['fq']).'<br>';
		$regulation .= '<img src="'.base_url().'images/regulation/f_l.png" align="absbottom"> = '.sprintf("%.4f",$data['fl']).'<br>';
		$regulation .= '<img src="'.base_url().'images/regulation/FQ.png" align="absbottom"> = '.sprintf("%.4f",$data['maxFq']).'<br>';
		$regulation .= '<img src="'.base_url().'images/regulation/FL.png" align="absbottom"> = '.sprintf("%.4f",$data['maxFl']).'<br>';
		$regulation .= '</td><td align="center">';
		$regulation .= '<img src="'.base_url().'images/regulation/kosul.png" align="absbottom"><br><br>(BÖHHBÜY 2005)';
		$regulation .= '<td></tr></table></fieldset>';
		return $regulation;
	}
}