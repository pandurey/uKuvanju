<?php  
	
	class User_model extends CI_Model 
	{
		function __construct(){
			parent::__construct();

			$this->load->database();
			$this->load->library('email');
			$this->load->helper('string');
		}

		function log_in($email, $pass)
		{
			$this->db->select('*');
			$this->db->from('users');
			$this->db->join('uloge', 'users.id_uloge = uloge.id_uloga');
			$this->db->where(array('email' => $email, 'password' => md5($pass), 'active_status' => '1'));
			return $this->db->get();
		}

		function get_user($id = null)
		{
			$this->db->select('*');
			$this->db->from('users');
			$this->db->join('uloge', 'users.id_uloge = uloge.id_uloga');
			$this->db->where('id', $id);
			return $this->db->get();
		}

		function register($email, $user, $pass)
		{	
			$verification_code = random_string('alnum', 16);
			
			$data = array(
				'email'		=> $email,
				'username' 	=> $user,
				'password'	=> md5($pass),
				'picture_url' => "assets/img/user-pictures/default.jpg",
				'verification_code' => $verification_code,
				'active_status'	=> 0,
				'id_uloge'	=> 2,
				'created'   => date('Y-m-d H:i:s'),
				'modified'	=> date('Y-m-d H:i:s')
			);
			$this->db->insert('users', $data);

			$this->send_email($email, $verification_code);

		}

		function send_email($email, $code){
			$config = Array(
			     'protocol' => 'smtp',
			     'smtp_host' => 'smtp.ukuvanju.com.',
			     'smtp_port' => 465,
			     'smtp_user' => 'admin@ukuvanju.com', 
			     'smtp_pass' => '########', 
			     'mailtype' => 'html',
			     'charset' => 'iso-8859-1',
			     'wordwrap' => TRUE
  			);

  			$this->load->library('email', $config);
		 	$this->email->set_newline("\r\n");
		 	$this->email->from('admin@uKuvanju.com', "uKuvanju.com");
		 	$this->email->to($email);  
		 	$this->email->subject("Verifikacija naloga");
		 	$this->email->message("Poštovani korisniče,\nDa biste aktivirali vaš nalog, kliknite na link\n\n http://192.168.0.16/verifikacija/".$verification_code."\n"."\n\nHvala Vam na poverenju\nuKuvanju.com");
			$this->email->send();

		}

		function verify_user($code)
		{
			$this->db->set('active_status', 1);
			$this->db->where('verification_code', $code);
			$this->db->update('users');

			return $this->db->affected_rows();
		}

		function insert_login($ip, $email, $success)
		{
			$data = array(
				'ip_address'	=> $ip,
				'login' 		=> $email,
				'success'		=> $success
			);
			$this->db->insert('login_attempts', $data);
		}

		function get_user_joined($id)
		{
			$this->db->select('DATE_FORMAT(created, "%d.%m.%Y") AS joined,');
			$this->db->from('users');
			$this->db->where('id', $id);
			return $this->db->get();
		}

		
		function update_user($id, $username, $email, $img = null, $pass = null)
		{
			$this->db->set('username', $username);
			$this->db->set('email', $email);
			$this->db->set('modified', date('Y-m-d H:i:s'));
			if($img != null):
				$this->db->set('picture_url', $img);
			endif;
			
			if($pass != null):
				$this->db->set('password', md5($pass));
			endif;
			$this->db->where('id', $id);
			$this->db->update('users');
		}

		

		function get_users($limit = null, $offset = null)
		{	
			return $this->db->get('users', $limit, $offset);
		}

		

		function count_users(){
			return $this->db->count_all('users');
		}

		

		

			
	}