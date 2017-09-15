<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class O_autoru extends Frontend {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$data['title'] = "O autoru | uKuvanju.com";
		$this->load_view('template/about', $data);
	}
}
