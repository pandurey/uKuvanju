<?php
	
	class Nav_model extends CI_Model
	{
	

		function __construct(){
			parent::__construct();

			$this->load->database();
		}

		

		function get_parents()
		{
			$this->db->where('id_parent', 0);
			return $this->db->get('nav');
		}

		function get_children()
		{
			return $this->db->get_where('nav', array('id_parent !=' => 0));
		}

		function get_nav()
		{
			return $this->db->get('nav');
		}

		



	}