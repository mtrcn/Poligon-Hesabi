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
		$this->load->library('gupa');	
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
	* GUPA ve kendi veritabanını kullanarak lisans ve temel kullanıcı bilgilerini gösterir
	*/
	function account(){
		if (!$this->gu_session->isLogged()) redirect("");
		$this->load->view('header');
		$data["user"]=$this->db->where("uid",$this->gu_session->getUID())->get("users")->row();
		$data["license"]=json_decode($this->gupa->api('/license/get_license',array('user_id'=>$this->gu_session->getUID()),NULL));
		$this->load->view('user/account',$data);
		$this->load->view('footer');
	}
	
	/**
	* Oturum açma metodudur.
	*/
	function login(){
		//Query String parametre olarak gelen "license", GUPA kütüphanesi tarafından doğrulanır.
		$license_code = $this->gupa->validateQueryLicenseCode();
		if ($license_code==FALSE){
			show_error("Geçersiz İstek.");
		}
		
		//GUPA license/get_token servisinden yeni OAuth parametreleri istenir.
		$licResult=json_decode($this->gupa->api('/license/get_token',array('license'=>$license_code),NULL));

		if ($licResult->error_code!=0){ //Eğer hata varsa kullanıcıya gösterilir.
			show_error('Lisans doğrulama hatası.<br>Hata Kodu: '.$licResult->error_code);
		}else{ 
			//Eğer hata oluşmamışsa bu kullanıcı daha önce "users" veritabınında varmı kontrol edilir.
			$dbResult=$this->db->where('uid',$licResult->user_id)->get('users')->row();
			if ($dbResult!=NULL){
				//Kullanıcı daha önce kayıt edilmişse yeni gelen parametrelerle kaydı güncellenir.
				$this->db->where('uid',$licResult->user_id)->update('users',array('oauth_token'=>$licResult->token,'oauth_token_secret'=>$licResult->token_secret));
			}else{
				//Kullanıcı daha önce veritabanında yoksa GUPA'nın /user/get_info servisinden temel kullanıcı bilgileri de sitenir.
				$userResult=json_decode($this->gupa->api('/user/get_info/',array(),array($licResult->token,$licResult->token_secret)));
				
				if (isset($userResult->error_code)){ //Eğer hata varsa gösterilir.
					show_error('Bir hata oluştu, tekrar deneyin.<br>Hata Kodu: u'.$userResult->error_code);
				}
				//Gelen temel kullanıcı bilgileriyle birlikte veritabınında kullanıcı için yeni bir kayıt oluşturulur.
				$dbResult=$this->db->insert('users',array('uid'=>$userResult->user_id,'name'=>$userResult->first_name,'surname'=>$userResult->last_name,'oauth_token'=>$licResult->token,'oauth_token_secret'=>$licResult->token_secret));
				if (!$dbResult)
					show_error('Bilgileriniz veritabanına kaydedilemedi.<br>Lütfen tekrar deneyin.');
				//Kullanıcı için her poligon türünden bir örnek proje oluşturulur.
				$this->_loadSampleData($userResult->user_id);
			}
		}
		//Oturum boyunca saklanacak veriler hazırlanır
		$data = array('uid' => $licResult->user_id,'oauth_token'=>$licResult->token,'oauth_token_secret'=>$licResult->token_secret);
        $this->session->set_userdata($data);
        //Kullanıcı projelerin listelendiği sayfaya yönlendirilir.
        redirect('user/projects');
	}
	
	/**
	* Örnek proje verileri yükleyen özel(private) metod.
	* 
	* @param Integer $uid üye hesap numarası (gerekli)
	*/
	function _loadSampleData($uid) {
		$this->db->query('
		INSERT INTO ph_projects (uid, tag, date, type, num_points, id, angle, azimuth, distance, x, y) VALUES
		('.$uid.', \'Kapalı Poligon Örneği\', '.time().', \'ring\', 4, \'a:4:{i:0;s:4:"P101";i:1;s:4:"P104";i:2;s:4:"P103";i:3;s:4:"P102";}\', \'a:4:{i:1;s:8:"103.8750";i:2;s:8:"115.5870";i:3;s:7:"95.5400";i:0;s:7:"84.9970";}\', \'a:1:{i:0;s:8:"169.7210";}\', \'a:4:{i:0;s:6:"92.760";i:1;s:6:"66.270";i:2;s:6:"78.890";i:3;s:6:"92.390";}\', \'a:1:{i:0;s:7:"1502.43";}\', \'a:1:{i:0;s:7:"1515.05";}\'),
		('.$uid.', \'Açık Poligon Örneği\', '.time().', \'free\', 4, \'a:4:{i:0;s:4:"P101";i:1;s:4:"P104";i:2;s:4:"P103";i:3;s:4:"P102";}\', \'a:2:{i:1;s:8:"103.8750";i:2;s:8:"115.5870";}\', \'a:1:{i:0;s:7:"169.721";}\', \'a:3:{i:0;s:5:"92.76";i:1;s:5:"66.27";i:2;s:5:"78.89";}\', \'a:1:{i:0;s:7:"1515.05";}\', \'a:1:{i:0;s:7:"1515.05";}\'),
		('.$uid.', \'Bağlı Poligon Örneği\', '.time().', \'closed\', 3, \'a:7:{i:0;s:1:"a";i:1;s:1:"b";i:2;s:1:"1";i:3;s:1:"2";i:4;s:1:"3";i:5;s:1:"c";i:6;s:1:"d";}\', \'a:5:{i:0;s:8:"146.3430";i:1;s:8:"199.2480";i:2;s:8:"272.7160";i:3;s:8:"138.6770";i:4;s:8:"143.0110";}\', \'\', \'a:4:{i:0;s:6:"96.454";i:1;s:6:"89.121";i:2;s:6:"65.235";i:3;s:7:"109.677";}\', \'a:4:{i:0;s:11:"4552508.798";i:1;s:11:"4552450.808";i:5;s:11:"4552179.984";i:6;s:11:"4552179.984";}\', \'a:4:{i:0;s:10:"417409.667";i:1;s:10:"417409.667";i:5;s:10:"417598.977";i:6;s:10:"417663.715";}\');
		');
	}
	
}