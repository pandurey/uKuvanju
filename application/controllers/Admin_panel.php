<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_panel extends Backend 
{

	var $data = array();

	public function __construct()
	{
		parent::__construct();

		$this->load->model('user_model', 'korisnici');
		$this->load->model('admin_model', 'admin');
		$this->load->library('table');
		$this->load->library('pagination');
		$this->load->library('form_validation');
	
	}

	function index()
	{
		
		$this->load_view('admin/admin', $this->data);
	}

	function korisnici($akcija = null){
		
		// paginacija
		$this->pagination->initialize($this->admin->pagination('korisnici'));
		$page 	= ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		$this->data['users'] = $this->admin->get_table('users',10, $this->uri->segment(3))->result();


		$this->load_view('admin/korisnici', $this->data);
	}

	function ankete(){
		$this->data['ovo'] = 1;
		$this->load_view('admin/ankete', $this->data);
	}

	function navigacija()
	{
		// paginacija
		$this->pagination->initialize($this->admin->pagination('navigacija'));
		$page 	= ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		$this->data['nav'] = $this->admin->get_table('nav',10, $this->uri->segment(3))->result();

		$this->data['nav_items'] = $this->admin->get_table('nav')->result();
		$this->load_view('admin/navigacija', $this->data);
	}

	function recepti(){}

	function obrisi()
	{
		$id = $this->input->post('id');
		$tabela = $this->input->post('tip'); //korisnik, anketa, navigacija, recept, kategorija

		$this->admin->del($tabela, $id);

		$this->session->set_flashdata('alert', '<span>Podatak je obrisan</span>');
		
	}

	function dodaj(){
		$post = array();
		
		foreach ( $_POST as $key => $value ):
			$post[$key] = $this->input->post($key);
		endforeach;

		switch ($post['tip']):
			
			case 'korisnici':
				$this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[users.email]', array('required' => 'Niste uneli email', 'valid_email' => 'Email nije u odgovarajućem formatu', 'is_unique' => 'Email već postoji u bazi'));
				$this->form_validation->set_rules('username', 'Korisničko ime', 'required|trim|is_unique[users.username]', array('required' => 'Niste uneli korisničko ime', 'is_unique' => 'Korisničko ime već postoji u bazi'));
				$this->form_validation->set_rules('pass', 'Lozinka', 'trim');

					if($this->form_validation->run() == FALSE):
						
						print_r(validation_errors());
					
					else:

						$q = $this->admin->insert_user($post['email'], $post['username'], $post['pass'], $post['active_status'], $post['is_admin']);
						
						if($q):
							print_r('OK');
							$this->session->set_flashdata('alert', '<span>Korisnik je uspešno dodat</span>');
						else:
							print_r('Došlo je do greške');
			
						endif;

					endif;

				break;
			
			case 'navigacija':
				$q = $this->admin->insert_nav($post['naziv'], $post['link'], $post['id_parent'], $post['has_submenu']);
					$this->admin->add_has_submenu($post['id_parent']);
				if($q):
					print_r('OK');
					$this->session->set_flashdata('alert', '<span>Link je uspešno dodat</span>');
				else:
					print_r('Došlo je do greške');
					
				endif;

				break;
			default:
				
				break;
		endswitch;
		
		
	}
}