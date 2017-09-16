<?php
	class MY_Controller extends CI_Controller {
	
	var $data = array();
		
		function __construct() {
			parent::__construct();
			$this->load->model('recipes_model');
			$this->load->model('nav_model');
			$this->load->model('question_model');

			//userdata
			$this->data['userdata']		= $this->session->userdata();
			$this->data['userMenu'] 	= $this->session->usermenu;
			$this->data['logged'] 		= logged();
			$this->data['role'] 		= $this->session->role;
		}

	}

	class Frontend extends MY_Controller 
	{

		function __construct() {
			parent::__construct();
			
		}

		public function load_view($view, $data)
		{	
			//messages
			$data['loginMsg']	= checkFlashdata('loginMsg');
			$data['regMsg']		= checkFlashdata('regMsg');
			$data['editMsg']	= checkFlashdata('editMsg');
			$data['error']		= checkFlashdata('error');
			$data['values'] 	= checkFlashdata('values');

			//meni
			$data['parents']	= $this->nav_model->get_parents()->result();
			$data['children']	= $this->nav_model->get_children()->result();
			
			//anketa
			$question			= $this->question_model->get_question()->row();
			$options 			= $this->question_model->get_options($question->id_anketa)->result();
			$user_voted			= $this->question_model->user_voted_questionnaire($question->id_anketa, $this->session->userdata('id'));

			$data['question'] 	= $question;
			$data['options']	= $options;
			$data['voted']		= $user_voted;
			$data['quest_results'] = $this->question_model->results();


			$var = array_merge($this->data,$data);

			$this->load->view('template/header', $var);
			$this->load->view($view, $var);
			$this->load->view('template/footer', $var);
		}
	}

	class Backend extends MY_Controller
	{

		function __construct() {
			parent::__construct();

		}

		public function load_view($view, $data)
		{	
			$data['error']		= checkFlashdata('error');

			if($this->data['role'] != 'admin') {redirect('/');}

			$var = array_merge($this->data,$data);

			$this->load->view('admin/header', $var);
			$this->load->view($view, $var);
			$this->load->view('admin/footer', $var);
		}
	}