<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Recepti extends Frontend {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('recipes_model');
		
	}

	public function index()
	{
		
		$data['title']				= 'Recepti | uKuvanju.com';
		$data['categories']			= $this->recipes_model->get_categories()->result();
		$data['recipes']			= $this->recipes_model->get_popular_recipes()->result();

		$this->load_view('template/recipes_browse', $data );
		
	}

	public function id($id = null)
	{	
		if($id != null && preg_match('/^\d+$/', $id) == 1):	

			$recipe 					= $this->recipes_model->get_recipe($id);
			$data['voted']				= $this->recipes_model->check_user_voted($this->session->userdata('id'), $id);

			if($recipe != null):
				$recipe 				= $this->recipes_model->get_recipe($id)->row();
				$category_id			= $this->recipes_model->get_category_id($id)->row()->id_kategorija;
				$recipes_similar 		= $this->recipes_model->get_similar_recipes($category_id, $id, 4)->result();
				$recipes_user			= $this->recipes_model->get_user_recipes($recipe->id_user, $id, 4)->result();

				$data['recipes_similar']	= $recipes_similar;
				$data['recipes_user']		= $recipes_user;
				$data['recipe']				= $recipe;
				$data['title']				= $recipe->naziv . " | uKuvanju.com";

				//ako je korisnik video recept u sesiji, ne povecava preglede
				if($this->session->userdata('recipe'.$id.'viewed') == null):
					$this->recipes_model->add_view($id);
					$this->session->set_userdata('recipe'.$id.'viewed', TRUE);
				endif;

				$this->load_view('template/recipe', $data);
				
			else:
				redirect('/recepti/');
			endif;
		else:
			redirect('/recepti/');
		endif;
	}

	public function recepti()
	{	

		$type 	= $this->input->post('type'); //kategorija, naziv
		$order	= $this->input->post('order'); // asc, desc,
		$sort	= $this->input->post('sort'); //naziv, pregledi, ocene(likes- dislikes), datum
		$term 	= $this->input->post('term'); // sta se trazi
		$recepti;
		switch ($type):
			case 'category':
				$recepti = $this->recipes_model->get_category_recipes($term, $order, $sort);
				break;
			case 'title':
				$recepti = $this->recipes_model->get_recipes_like($term, $order, $sort);
				break;
		endswitch;
		

		if($recepti != false):
			
			$data['result'] = $recepti;

		else:
			$data['result'] = 'null';
		endif;
		

		print json_encode($data);
	}


	public function glasaj()
	{	
		$id_recipe	= $this->input->post('id_recipe');
		$vote 		= $this->input->post('vote');
		$id_user 	= $this->session->userdata('id');
		
		$q = $this->recipes_model->rate_recipe($vote, $id_user, $id_recipe);
		
		if($q != null):
			$r = $this->recipes_model->get_votes($id_recipe);

			$likes = $q->row()->likes;
			$dislikes = $q->row()->dislikes;
			
			$data['result'] = $likes - $dislikes;
		else:
			$data['result'] = "NaN";
		endif;
		print json_encode($data);
	}

}