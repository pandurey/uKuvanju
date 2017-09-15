<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pocetna extends Frontend {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('recipes_model');
	}	

	public function index()
	{
		
		$data['title']				= 'uKuvanju.com | Recepti za svačiji ukus';

		$data['recipes_popular']	= $this->recipes_model->get_popular_recipes(4)->result();
		$data['recipes_latest']		= $this->recipes_model->get_latest_recipes(6)->result();

		$this->load_view('template/recipes', $data);
		
	}
}