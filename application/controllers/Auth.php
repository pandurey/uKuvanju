<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends Frontend {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model('user_model');
		
	}

	public function index()
	{
		redirect('/');
	}

	public function login()
	{
		$this->form_validation->set_rules('tbEmail', 'Email', 'required|trim|valid_email', array('valid_email' => '%s mora biti u odgovarajućem formatu', 'required' => 'Morate uneti email'));
		$this->form_validation->set_rules('tbPassword', 'Password', 'required|trim', array('required' => 'Morate uneti lozinku'));

		if($this->form_validation->run() == FALSE)
		{	
			
			$this->session->set_flashdata('usermenu', TRUE);

			$err = array(
				'validation_err' => validation_errors(),
				'email' => $this->input->post('tbEmail')
			);

			$this->session->set_flashdata('usermenu', TRUE);
			$this->session->set_flashdata('loginMsg', $err);

			redirect($_SERVER['HTTP_REFERER']);
		}
		else
		{	
			$email 	= $this->input->post('tbEmail');
			$pass  	= $this->input->post('tbPassword');
			$d 		= $this->user_model->log_in($email, $pass);
			
			//proverava da li postoji 
			if($d->num_rows() == 1)
			{
				foreach ($d->result_array() as $data) {
					$session = array(
						'username' 	=> $data['username'],
						'email' 	=> $data['email'],
						'img'		=> $data['picture_url'],
						'id'		=> $data['id'],
						'role'		=> $data['naziv_uloge'],
						'logged-in' => TRUE
					);
				}
				//upis logovanja
				//$ip = $this->input->ip_address();
				//$this->user_model->insert_login($ip, $email, TRUE);
				
				$this->session->set_flashdata('usermenu', TRUE);
				$this->session->set_userdata($session);
				redirect($_SERVER['HTTP_REFERER']);
			}
			else{
				//upis logovanja
				//$ip = $this->input->ip_address();
				//$this->user_model->insert_login($ip, $email, FALSE);
				$err = array(
					'validation_err' => "Logovanje neuspešno. <br>Proverite da li ste uneli tačne podatke i da li ste aktivirali svoj nalog...",
					'email' => $this->input->post('tbEmail')
				);
				
				$this->session->set_flashdata('usermenu', TRUE);
				$this->session->set_flashdata('loginMsg', $err);
					redirect($_SERVER['HTTP_REFERER']);
				}
			
		}
	}

	function register(){
		$this->form_validation->set_rules('tbEmails', 'Email', 'required|trim|valid_email|is_unique[users.email]', 
			array(
				'required' => 'Morate uneti email',
				'valid_email' => 'Email mora biti u odgovarajućem formatu',
				'is_unique' => 'Email je zauzet'
			) 
		);

		$this->form_validation->set_rules('tbUsernames', 'Korisničko ime', 'required|trim|is_unique[users.username]', 
			array(
				'required' => 'Korisničko ime ne sme biti prazno',
				'is_unique' => 'Ovo korisničko ime je zauzeto'
			)
		);

		$this->form_validation->set_rules('tbPassword', 'Lozinka', 'required|trim|min_length[5]', 
			array(
				'required' => 'Morate uneti lozinku',
				'min_length' => 'Lozinka mora imati minimum 5 karaktera'
			)
		);

		$this->form_validation->set_rules('tbPasswordConfirm', 'Lozinka Ponovo', 'trim|required|matches[tbPassword]', 
			array(
				'required' => 'Morate potvrditi lozinku',
				'matches' => 'Lozinke moraju biti iste'
			)
		);

		if($this->form_validation->run() == FALSE)
		{	
			$err = array(
				'validation_err' => validation_errors(),
				'email' => $this->input->post('tbEmails'),
				'username' => $this->input->post('tbUsernames'),
				
				'emailErr' => form_error('tbEmails'),
				'userErr'  => form_error('tbUsernames'),
				'passErr'  => form_error('tbPassword'),
				'passConErr' => form_error('tbPasswordConfirm')
			);
			//otvara meni
			$this->session->set_flashdata('usermenu', TRUE);
			$this->session->set_flashdata('regMsg', $err );

			redirect($_SERVER['HTTP_REFERER']);
		}else{
			$email 		= $this->input->post('tbEmails');
			$username 	= $this->input->post('tbUsernames');
			$pass  		= $this->input->post('tbPassword');

			//db
			$this->user_model->register($email, $username, $pass);
			

			$data = array(
				'message' => "Na Vaš email je poslat zahtev za verifikaciju. Klikom na link ćete aktivirati svoj nalog."
			);

			$this->session->set_flashdata('usermenu', TRUE);
			$this->session->set_flashdata('loginMsg', $data);
			redirect($_SERVER['HTTP_REFERER']);
		}


	}

	public function verifikacija($code = null){
		$verify_user = $this->user_model->verify_user($code);

		if($verify_user != 0):
			$err = array('validation_err' => 'Vaš nalog je uspešno aktiviran!');
		else:
			$err = array('validation_err' => 'Žao nam je, došlo je do greške prilikom verifikacije!');
		endif;
		$this->session->set_flashdata('usermenu', TRUE);
		$this->session->set_flashdata('loginMsg', $err);
		redirect('/');

	}

	public function logout()
	{
        $this->session->sess_destroy();
        redirect($_SERVER['HTTP_REFERER']);
	}
}