<?php  
	
class Admin_model extends CI_Model 
{
	function __construct()
	{
		parent::__construct();

		$this->load->database();
		$this->load->library('email');
		$this->load->helper('string');
	}

	function get_table($table, $limit = null, $offset = null)
	{	
		return $this->db->get($table, $limit, $offset);
	}

	function insert_user($email, $username, $pass, $is_active, $is_admin)
	{
		$id_uloge = ($is_admin) ? 1 : 2;

		$data =array(
			'email'		=> $email,
			'username' 	=> $username,
			'password'	=> md5($pass),
			'picture_url' => "assets/img/user-pictures/default.jpg",
			'verification_code' => "",
			'active_status'	=> $is_active,
			'id_uloge'	=> $id_uloge,
			'created'   => date('Y-m-d H:i:s'),
			'modified'	=> date('Y-m-d H:i:s')
		);

		return $this->db->insert('users', $data);
	}

	function insert_nav($naziv, $link, $id_parent, $has_submenu)
	{
		$data =array(
			'naziv'		=> $naziv,
			'link' 		=> $link,
			'id_parent' => $id_parent,
			'has_submenu' => $has_submenu
		);

		return $this->db->insert('nav', $data);
	}

	function add_has_submenu($id)
	{
		$this->db->set('has_submenu', 1);
		$this->db->where('id_nav', $id);
		$this->db->update('nav');
	}

	function del($tip = null, $id = null){
		if($tip == "korisnici"):
			$this->db->where('id', $id);
			$this->db->delete('users');
		endif;
		if($tip == "navigacija"):
			$this->db->where('id_nav', $id);
			$this->db->delete('nav');
		endif;
		if($tip == "recept"):
			$this->db->where('id', id);
			$this->db->delete('recepti');
		endif;
		if($tip == 'kategorija'):
			$this->db->where('id_kategorije', $id);
			$this->db->delete('kategorija');
		endif;
		if($tip == 'anketa'):
			$this->db->where('id_anketa', $id);
			$this->db->delete('anketa');
			$this->db->where('id_ankete', $id);
			$this->db->delete('anketa_opcije');
			$this->db->where('id_ankete', $id);
			$this->db->delete('anketa_odgovori');
		endif;

	}

	function pagination($page)
	{
		$config['base_url'] 	= base_url().'/admin-panel/'.$page.'/';
		$config['total_rows'] 	= $this->korisnici->count_users();
		$config['per_page'] 	= 10;
		$config["uri_segment"] 	= 3;
		$config['attributes'] = array('class' => 'admin-pagination');
		$config['cur_tag_open'] = '<a href="' .base_url("/admin-panel/$page").'" class="admin-pagination active">';
		$config['cur_tag_close'] = '</a>';
		$config['next_link'] 	= false;
		$config['prev_link'] 	= false;
		
		$config['attributes']['rel'] = FALSE;

		return $config;

	}

	function write_active_status($status){
		if($status == 1):
		
			return "<span class='circle-a'></span>";
		else:
			return "<span class='circle-d'></span>";
		endif;
		
	}

		
}