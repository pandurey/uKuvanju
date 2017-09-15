<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Korisnik extends Frontend {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model('user_model');
		$this->load->model('recipes_model');
		
	}

	function id($id = null)
	{
		 				
		
		if($id != null && preg_match('/^\d+$/', $id) == 1):
			$data['recipes'] = $this->recipes_model->get_user_recepies_all($id)->result();
			$data['userjoined'] = $this->user_model->get_user_joined($id)->row();
			$data['title'] = $data['recipes'][0]->username . " | uKuvanju.com";
			$this->load_view('template/user', $data);

		endif;

	}

	public function edit()
	{
		$has_image = FALSE;
		$has_pass = FALSE;

		$oldEmail = $this->session->userdata('email');
		$newEmail = $this->input->post('cngEmail');

		$userid = $this->session->userdata('id');

		if($oldEmail != $newEmail):
			$this->form_validation->set_rules('cngEmail', 'Email', 'trim|required|valid_email|is_unique[users.email]', array(
				'valid_email' => '{field} mora biti u odgovarajućem formatu',
				'required'	=> 'Morate uneti {field}',
				'is_unique' => '{field} je zauzet'
			));
		else:
			$this->form_validation->set_rules('cngEmail', 'Email', 'trim|required|valid_email', array(
				'valid_email' => '{field} mora biti u odgovarajućem formatu',
				'required'	=> '{field} ne sme biti prazan'
			));
		endif;

		$oldUsername = $this->session->userdata('username');
		$newUsername = $this->input->post('cngUsername');

		if($oldUsername != $newUsername):
			$this->form_validation->set_rules('cngUsername', 'Korisničko ime', 'trim|required|min_length[5]|is_unique[users.username]', array(
				'required'	=> '{field} ne sme bit prazno',
				'is_unique' => '{field} je zauzeto',
				'min_length' => '{field} ne sme biti kraće od {param} karaktera'
			));
		else:
			$this->form_validation->set_rules('cngUsername', 'Korisničko ime', 'trim|required', array(
				'required'	=> 'Morate uneti {field}'
			));
		endif;

		$pass = $this->input->post('cngPassword');
		

		if(trim($pass) != ""):
			$has_pass = TRUE;
			$this->form_validation->set_rules('cngPassword', 'Lozinka', 'trim|required|min_length[6]', 
				array(
					'required'	=> 'Morate uneti {field}',
					'min_length' => '{field} mora imati više od {param} karaktera'
				)
			);

			$this->form_validation->set_rules('cngPasswordCon', 'Potvrda lozinke', 'trim|required|matches[cngPassword]', 
				array(
					'matches' => 'Lozinke moraju biti iste',
					'required'	=> 'Morate potvrditi lozinku'
				));
		endif;

		if ($_FILES['cngImg']['size'] != 0 && $_FILES['cngImg']['error'] == 0):	
		    $has_image = true;
		endif;

		//validacija

		if($this->form_validation->run() == FALSE)
		{
			$err = array(
				'validation_err' => validation_errors()
			);

			//otvara meni
			$this->session->set_flashdata('usermenu', TRUE);
			$this->session->set_flashdata('editMsg', $err );

			redirect($_SERVER['HTTP_REFERER']);
			
		}else{
			if($has_image):	
				//promeni upload folder ////////////////////////////////////
				//upload slike
				$config['upload_path']          = './uploads/';
				$config['folder']				= "uploads/";
	            $config['allowed_types']        = 'gif|jpg|png';
	            $config['max_size']             = 150;
	            $config['max_width']            = 1024;
	            $config['max_height']           = 768;

	            $this->load->library('upload', $config);

	            if(!$this->upload->do_upload('cngImg')):
	            	$err = array('validation_err' => $this->upload->display_errors() );
	            else:
	            	$img	= $config['folder'].$this->upload->data('orig_name');
	            endif;

	            //promena u sesiji
	            $this->session->set_userdata('img', $img);

	            //promene u bazi
				

				if($has_pass):
					$this->user_model->update_user($userid, $newUsername, $newEmail, $img, $pass);
				else:
					$this->user_model->update_user($userid, $newUsername, $newEmail, $img);
				endif;
				$err 	= array('message' => 'Promene su uspešno izvršene');

			else:

				if($has_pass):
					$this->user_model->update_user($userid, $newUsername, $newEmail, null, $pass);
				else:
					$this->user_model->update_user($userid, $newUsername, $newEmail);
				endif;
				$err 	= array('message' => 'Promene su uspešno izvršene');
				
            endif;

			//promene u sessiji
			$this->session->set_userdata('username', $newUsername);
			$this->session->set_userdata('email', $newEmail);
			
			$this->session->set_flashdata('usermenu', TRUE);
			$this->session->set_flashdata('editMsg', $err );
			redirect($_SERVER['HTTP_REFERER']);
			
		}

	}



}




