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

	function korisnici($action = null, $id = null){
		
		switch($action):
			case 'edit':	
				$this->data['user'] = $this->korisnici->get_user($id)->row();
				break;
			case 'korisnik':
				$has_image = FALSE;
				$has_pass = FALSE;
				$id_user = $this->input->post('user_id');
				$this->admin->set_id_user($id_user);

				$user = $this->korisnici->get_user($id_user)->row();
				$this->data['user'] = $user;

				$username = $this->input->post('editusername');
				$email = $this->input->post('editemail');
				$pass = $this->input->post('editpassword');
				$admin = $this->input->post('editadmin') ? 1 : 2;
				$active = $this->input->post('editactive') ? 1 : 0;

				if($username != $user->username):
					$this->form_validation->set_rules('editusername', 'Korisničko ime', 'trim|required|min_length[5]|is_unique[users.username]', array(
						'required'	=> '{field} ne sme bit prazno',
						'is_unique' => '{field} je zauzeto',
						'min_length' => '{field} ne sme biti kraće od {param} karaktera'
					));
				else:
					$this->form_validation->set_rules('editusername', 'Korisničko ime', 'trim|required', array(
						'required'	=> 'Morate uneti {field}'
					));
				endif;

				if($email != $user->email):
					$this->form_validation->set_rules('editemail', 'Email', 'trim|required|valid_email|is_unique[users.email]', array(
						'valid_email' => '{field} mora biti u odgovarajućem formatu',
						'required'	=> 'Morate uneti {field}',
						'is_unique' => '{field} je zauzet'
					));
				else:
					$this->form_validation->set_rules('editemail', 'Email', 'trim|required|valid_email', array(
						'valid_email' => '{field} mora biti u odgovarajućem formatu',
						'required'	=> '{field} ne sme biti prazan'
					));
				endif;

				if(trim($pass) != ""):
					$has_pass = TRUE;
					$this->form_validation->set_rules('editPassword', 'Lozinka', 'trim|required|min_length[6]', 
						array(
							'required'	=> 'Morate uneti {field}',
							'min_length' => '{field} mora imati više od {param} karaktera'
						)
					);

				endif;


				if ($_FILES['editImg']['size'] != 0 && $_FILES['editImg']['error'] == 0):	
				    $has_image = true;
				endif;

				if($this->form_validation->run() == FALSE)
				{
					$err = array('validation_err' => validation_errors());

					$this->session->set_flashdata('error', $err );

					redirect($_SERVER['HTTP_REFERER']);
				}else
				{
					if($has_image):
						$config['upload_path']          = './uploads/';
						$config['folder']				= "uploads/";
			            $config['allowed_types']        = 'gif|jpg|png';
			            $config['max_size']             = 150;
			            $config['max_width']            = 1024;
			            $config['max_height']           = 768;

			            $this->load->library('upload', $config);

			            if(!$this->upload->do_upload('editImg')):
			            	$err = array('validation_err' => $this->upload->display_errors() );

			            	$this->session->set_flashdata('error', $err );
							redirect($_SERVER['HTTP_REFERER']);
			            else:
			            	$img	= $config['folder'].$this->upload->data('orig_name');
			            endif;  
			        else:
			        	$img = null;
					endif;
					//$id_uloge = $is_admin ? 1 : 2;
					$user_data = array(
						'username' => $username,
						'email' => $email,
						'active_status' => $active,
						'id_uloge' => $admin,
						'picture_url' => $img,
						'modified' => date('Y-m-d H:i:s')
					);

					$this->admin->update('korisnici', $user_data);

					redirect('admin-panel/korisnici');
				}

				break;
			default:
				// paginacija
				$this->pagination->initialize($this->admin->pagination('korisnici'));
				$page 	= ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
				$this->data['users'] = $this->admin->get_table('users',10, $this->uri->segment(3))->result();
		endswitch;

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

	function dodaj()
	{
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