<?php
/**
 * User Class
 *
 * Üye işlemlerinin yapılabilmesi için metodlar içerir
 *
 * @author Mete Ercan Pakdil
 */
class User extends Controller {

	/**
	* User sınıfını yükler.
	*/
	function User()
	{
		parent::Controller();
	}
	
	/**
	* Varsayılan olarak hiç bir metod tarayıcıdan çağırılmadığında gelecektir.
	*/
	function index()
	{
		$this->load->view('header');
		$this->load->view('index');
		$this->load->view('footer');
	}
	
	/**
	* Kullanıcıya ait projeleri gösterir
	*/
	function projects(){
		if (!$this->gu_session->isLogged()) redirect("");
		$this->load->view('header');
		$data["projects"]=$this->db->where("uid",$this->gu_session->getUID())->order_by('date','DESC')->get("projects");
		$this->load->view('user/projects',$data);
		$this->load->view('footer');
	}
	
	/**
	 * Google ile oturum aç
	 */
	function login_with_google()
	{
		$this->load->library('openid',array('host'=>'http://localhost/poligon_hesabi'));
		if(!$this->input->get('openid_mode')) {
			$this->openid->identity = 'https://www.google.com/accounts/o8/id';
			redirect($this->openid->authUrl());
		}
		elseif($_GET['openid_mode'] == 'cancel')
		{
			redirect('');
		}
		else {
			if($this->openid->validate()){
				$this->_login($_GET);
			}
			else{
				redirect('');
			}
		}
	}
	
	/**
	 * myOpenID ile oturum aç
	 */
	function login_with_myopenid()
	{
		$this->load->library('openid',array('host'=>'http://localhost/poligon_hesabi'));
		if(!$this->input->get('openid_mode')) {
			$this->openid->identity = 'https://www.myopenid.com/';
			redirect($this->openid->authUrl());
		}
		elseif($_GET['openid_mode'] == 'cancel')
		{
			redirect('');
		}
		else {
			if($this->openid->validate()){
				$this->_login($_GET);
			}
			else{
				redirect('');
			}
		}
	}
	
	
	/**
	 * OpenID sağlayıcısından gelen bilgilerle oturum açar
	 *
	 * @param Array $openid_data OpenID sağlayıcısından gelen bilgiler (gerekli)
	 */
	private function _login($openid_data)
	{
		$dbResult=$this->db->where('uid',$openid_data['openid_identity'])->get('users')->row();
		if ($dbResult==NULL){
			//Kullanıcı daha önce veritabanında yoksa veritabınında kullanıcı için yeni bir kayıt oluşturulur.
			$dbResult=$this->db->insert('users',array('uid'=>(string)$openid_data['openid_identity']));
			if (!$dbResult)
				show_error('Bilgileriniz veritabanına kaydedilemedi.<br>Lütfen tekrar deneyin.');
			//Kullanıcı için her poligon türünden bir örnek proje oluşturulur.
			$this->_loadSampleData((string)$openid_data['openid_claimed_id']);
		}
		$this->session->set_userdata(array('uid' => $openid_data['openid_claimed_id']));
		redirect('user/projects');
	}
	
	/**
	 * Oturumu sonlandırır
	 *
	 */
	function logout()
	{
		if ($this->gu_session->isLogged()) {
			$this->session->sess_destroy();
		}
		redirect('');
	}
		
	/**
	* Örnek proje verileri yükleyen özel(private) metod.
	* 
	* @param Integer $uid üye hesap numarası (gerekli)
	*/
	function _loadSampleData($uid) {
		$this->db->query('
		INSERT INTO ph_projects (uid, tag, date, type, num_points, id, angle, azimuth, distance, x, y) VALUES
		(\''.$uid.'\', \'Kapalı Poligon Örneği\', '.time().', \'ring\', 4, \'a:4:{i:0;s:4:"P101";i:1;s:4:"P104";i:2;s:4:"P103";i:3;s:4:"P102";}\', \'a:4:{i:1;s:8:"103.8750";i:2;s:8:"115.5870";i:3;s:7:"95.5400";i:0;s:7:"84.9970";}\', \'a:1:{i:0;s:8:"169.7210";}\', \'a:4:{i:0;s:6:"92.760";i:1;s:6:"66.270";i:2;s:6:"78.890";i:3;s:6:"92.390";}\', \'a:1:{i:0;s:7:"1502.43";}\', \'a:1:{i:0;s:7:"1515.05";}\'),
		(\''.$uid.'\', \'Açık Poligon Örneği\', '.time().', \'free\', 4, \'a:4:{i:0;s:4:"P101";i:1;s:4:"P104";i:2;s:4:"P103";i:3;s:4:"P102";}\', \'a:2:{i:1;s:8:"103.8750";i:2;s:8:"115.5870";}\', \'a:1:{i:0;s:7:"169.721";}\', \'a:3:{i:0;s:5:"92.76";i:1;s:5:"66.27";i:2;s:5:"78.89";}\', \'a:1:{i:0;s:7:"1515.05";}\', \'a:1:{i:0;s:7:"1515.05";}\'),
		(\''.$uid.'\', \'Bağlı Poligon Örneği\', '.time().', \'closed\', 3, \'a:7:{i:0;s:1:"a";i:1;s:1:"b";i:2;s:1:"1";i:3;s:1:"2";i:4;s:1:"3";i:5;s:1:"c";i:6;s:1:"d";}\', \'a:5:{i:0;s:8:"146.3430";i:1;s:8:"199.2480";i:2;s:8:"272.7160";i:3;s:8:"138.6770";i:4;s:8:"143.0110";}\', \'\', \'a:4:{i:0;s:6:"96.454";i:1;s:6:"89.121";i:2;s:6:"65.235";i:3;s:7:"109.677";}\', \'a:4:{i:0;s:11:"4552508.798";i:1;s:11:"4552450.808";i:5;s:11:"4552179.984";i:6;s:11:"4552179.984";}\', \'a:4:{i:0;s:10:"417409.667";i:1;s:10:"417409.667";i:5;s:10:"417598.977";i:6;s:10:"417663.715";}\');
		');
	}
	
	/**
	 * GU lisans sistemi ile kaydedilen projeleri yükler.
	 *
	 */
	function load_gu_projects()
	{
		$uid = floatval($this->input->post("id"));
		$result=$this->db->where('uid',(string)$uid)->get('projects');
		$count = 0;
		try{
			foreach ($result->result() as $row)
			{
				$this->db->where('pid',$row->pid)->update('projects',array('uid'=>$this->gu_session->getUID()));
				$count++;
			}
			if ($count > 0)
			{
				echo '<div class="alert alert-success">Toplam '.$count.' projeniz yeni hesabınıza aktarıldı.</div>';
			}
			else
			{
				echo '<div class="alert">Hesap numarasına ilişkin herhangi bir proje bulunamadı.</div>';
			}
		}catch(Exception $ex)
		{
			echo '<div class="alert alert-error">İşlem tamamlanamadı!</div>';
		}
	}
	
}