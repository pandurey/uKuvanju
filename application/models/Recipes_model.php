<?php
	
	class Recipes_model extends CI_Model
	{
	

		function __construct(){
			parent::__construct();

			$this->load->database();
			$this->resize_img();
		}

		function get_recipe($id_recipe = null)
		{
			if($id_recipe != null):
				
				$this->db->select('recepti.id as id, naziv, sastojci, priprema, img, img_small, pregledi, id_user, username, likes, dislikes');
				$this->db->from('recepti');
				$this->db->join('users', 'users.id = recepti.id_user');
				$this->db->where('recepti.id', $id_recipe );
				
				$q = $this->db->get();

				if( $q->num_rows() == 1 ):
					return $q;
				else:
					return null;
				endif;
			else:

				return null;

			endif;
		}

		function add_view($id)
		{
			$this->db->set('pregledi', 'pregledi+1', FALSE);
			$this->db->where('id', $id);
			$this->db->update('recepti');
			
		}

		

		function get_category_id($id = null)
		{
			$this->db->select('id_kategorija');
			$this->db->from('recepti_kategorije');
			$this->db->where('id_recept', $id);
			
			return $this->db->get();
		}

		function get_similar_recipes($id_category, $id_recipe,$limit = null)
		{
			$this->db->select('recepti.id as id, naziv, img, img_small, pregledi, id_user, username');
			$this->db->from('recepti');
			$this->db->join('recepti_kategorije', 'recepti_kategorije.id_recept = recepti.id');
			$this->db->join('users', 'users.id = recepti.id_user');
			$this->db->where('id_kategorija', $id_category);
			$this->db->where('id_recept !=', $id_recipe);
			$this->db->order_by('recepti.id','RANDOM');
			if($limit != null):
				$this->db->limit($limit);
			endif;
			return $this->db->get();
		}

		function get_popular_recipes($limit = null)
		{
			$this->db->select('recepti.id as id, recepti.naziv as naziv_recepta, img, img_small, pregledi, id_user, username, likes, dislikes, picture_url, id_kategorija, kategorija.naziv as naziv_kategorije, likes, dislikes, recepti.created as recepti_created');
			$this->db->from('recepti');
			$this->db->join('recepti_kategorije', 'recepti_kategorije.id_recept = recepti.id');
			$this->db->join('users', 'users.id = recepti.id_user');
			$this->db->join('kategorija', 'kategorija.id_kategorije = recepti_kategorije.id_kategorija');
			$this->db->order_by('pregledi DESC');
			
			if($limit != null):
				$this->db->limit($limit);
			endif;
			return $this->db->get();
		}

		function get_user_recipes($id_user, $id_recipe, $limit = null)
		{
			$this->db->select('recepti.id as id, naziv, img, img_small, pregledi, id_user, username');
			$this->db->from('recepti');
			$this->db->join('users', 'users.id = recepti.id_user');
			$this->db->where('id_user', $id_user);
			$this->db->where('recepti.id !=', $id_recipe);
			$this->db->order_by('recepti.id','RANDOM');
			if($limit != null):
				$this->db->limit($limit);
			endif;
			return $this->db->get();
		}

		function get_latest_recipes($limit = null)
		{
			$this->db->select('recepti.id as id, naziv, img, img_small, pregledi, id_user, username');
			$this->db->from('recepti');
			$this->db->join('users', 'users.id = recepti.id_user');
			$this->db->order_by('recepti.created','DESC');
			if($limit != null):
				$this->db->limit($limit);
			endif;
			return $this->db->get();
		}

		function get_categories()
		{
			return $this->db->get('kategorija');
		}

		function rate_recipe($vote, $user_id, $rec_id)
		{
			
			if(!$this->check_user_voted($user_id, $rec_id))
			{
				$data = array('id_user' => $user_id, 'id_recept' => $rec_id, 'vote' => TRUE);
				$this->db->insert('recepti_glasanje', $data);

				
				$this->db->set($vote, $vote." + 1", FALSE);
				$this->db->where('id', $rec_id);
				$this->db->update('recepti');

				return $this->get_votes($rec_id);
			}else{
				return null;
			}
		}

		function check_user_voted($id_user, $id_rec)
		{
			$q = $this->db->get_where('recepti_glasanje', array('id_user' => $id_user, 'id_recept' => $id_rec));
			

			if($q->num_rows() == 1)
			{
				return TRUE;
			}
			else
			{
				return FALSE;
			}
		}

		function get_votes($id_rec)
		{
			$this->db->select('id, likes, dislikes');
			$this->db->from('recepti');
			$this->db->where('id', $id_rec);
			$q = $this->db->get();
			return $q;
		}


		function get_recipes_like($term, $order, $sort)
		{
			$this->db->select('recepti.id as id, recepti.naziv as naziv_recepta, img, img_small, pregledi, id_user, username, likes, dislikes, (likes - dislikes) as rating, kategorija.naziv as naziv_kategorije, DATE_FORMAT(recepti.created, "%Y-%m-%d %h:%m:%s") AS recepti_created, recepti_kategorije.id_kategorija');
			$this->db->from('recepti');
			$this->db->join('recepti_kategorije', 'recepti_kategorije.id_recept = recepti.id');
			$this->db->join('users', 'users.id = recepti.id_user');
			$this->db->join('kategorija', 'kategorija.id_kategorije = recepti_kategorije.id_kategorija');
			$this->db->like('recepti.naziv', $term);
			if($sort == "naziv"):
				$this->db->order_by('recepti.naziv', $order);
			else:
				$this->db->order_by($sort, $order);
			endif;
			$q = $this->db->get();
			if($q->num_rows() > 0):
				foreach ($q->result() as $r):
					$data['recipe'][] = $r;
				endforeach;

				return $data;
			else:
				return false;
			endif;
		}

		function get_category_recipes($category, $order, $sort){
			$this->db->select('recepti.id as id, recepti.naziv as naziv_recepta, img, img_small, pregledi, id_user, username, likes, dislikes, (likes - dislikes) as rating, kategorija.naziv AS naziv_kategorije, DATE_FORMAT(recepti.created, "%Y-%m-%d %h:%m:%s") AS recepti_created, recepti_kategorije.id_kategorija');
			$this->db->from('recepti');
			$this->db->join('recepti_kategorije', 'recepti_kategorije.id_recept = recepti.id');
			$this->db->join('users', 'users.id = recepti.id_user');
			$this->db->join('kategorija', 'kategorija.id_kategorije = recepti_kategorije.id_kategorija');
			$this->db->where('kategorija.naziv', $category);
			
			if($sort == "naziv"):
				$this->db->order_by('kategorija.naziv', $order);
			else:
				$this->db->order_by($sort, $order);
			endif;
			
			
			$q = $this->db->get();

			if($q->num_rows() > 0):
				foreach ($q->result() as $r):
					$data['recipe'][] = $r;
				endforeach;

				return $data;
			else:
				return false;
			endif;
		}


		function get_user_recepies_all($id_user)
		{
			$this->db->select('recepti.id as id, recepti.naziv as naziv_recepta, img, img_small, pregledi, id_user, username, picture_url, id_kategorija, kategorija.naziv as naziv_kategorije, likes, dislikes');
			$this->db->from('recepti');
			$this->db->join('recepti_kategorije', 'recepti_kategorije.id_recept = recepti.id');
			$this->db->join('users', 'users.id = recepti.id_user');
			$this->db->join('kategorija', 'kategorija.id_kategorije = recepti_kategorije.id_kategorija');
			$this->db->where('id_user', $id_user);
			$this->db->order_by('pregledi', 'DESC');

			return $this->db->get();

			
		}

		function resize_img(){
			$this->db->select('id, img, img_small');
			$this->db->from('recepti');
			$this->db->where(array('img_small' => NULL));
			$q = $this->db->get();

			$this->load->library('image_lib');
			foreach($q->result() as $i => $image):
				$config['image_library'] = 'gd2';
			    $config['source_image'] = './'.$image->img;
			    $config['new_image'] 	= './assets/img/food/';
			    $config['create_thumb'] = TRUE;
			    $config['maintain_ratio'] = TRUE;
			    $config['width']     = 290;
			    $config['height']   = 220;
			    $config['thumb_marker'] = '_s';


			    $this->image_lib->initialize($config);
			    $this->image_lib->resize();
			    $this->image_lib->clear();

			    $this->db->set('img_small', substr($image->img, 0, -4)."_s.". substr($image->img, -3));
			    $this->db->where('id', $image->id);
			    $this->db->update('recepti');
			endforeach;
		}
	}