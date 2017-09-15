<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Anketa extends Frontend {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model('question_model');
	}

	function index()
	{
		$id_a 		= $this->input->post('id_quest');
		$id_o 		= $this->input->post('id_opt');

		$sum 		= 0;
		
		//add vote
		$this->question_model->add_vote($id_a, $this->session->userdata('id'), $id_o );
		
		$options    = $this->question_model->get_options($id_a)->result();
		$results	= $this->question_model->get_results($id_a)->result();


		//response
		foreach ($options as $i => $opt) :

			foreach ($results as $j => $r): 
			
				if($opt->id_opcija == $r->id_opcije):
					
					${'opt_sum_'.$i} = $r->count;
					break;

				else:

					${'opt_sum_'.$i} = 0;
				
				endif;
			endforeach;
			
			$option['data'][] = array(
				'option' => $opt->opcija,
				'votes' => ${'opt_sum_'.$i}
			);

			$sum += ${'opt_sum_'.$i};
		
		endforeach;
		$option['total'] = $sum;
		$data['result'] = $option;

		print json_encode($data);

	}

}




