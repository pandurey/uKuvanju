<?php
	
	class Question_model extends CI_Model
	{
	

		function __construct(){
			parent::__construct();

			$this->load->database();
		}

		

		function get_question()
		{
			$this->db->select('*');
			$this->db->from('anketa a');
			$this->db->where('aktivna', 1);

			return $this->db->get();
		}

		function get_options($id)
		{
			$this->db->select('*');
			$this->db->from('anketa_opcije');
			$this->db->where('id_ankete', $id);
			return $this->db->get();
		}

		function get_results($id){
			$this->db->select('id_opcije, COUNT(id_opcije) AS count');
			$this->db->from('anketa_odgovori o');
			$this->db->where('o.id_ankete', $id);
			$this->db->group_by('id_opcije');
			$q =  $this->db->get();

			if($q->num_rows() > 0){
				return $q;
			}
		}

		function add_vote($id_a, $id_user, $id_o)
		{
			$data = array(
				'id_user' => $id_user,
				'id_ankete' => $id_a,
				'id_opcije' => $id_o
			);
			$this->db->insert('anketa_odgovori', $data);
		}

		function get_total_votes($id){
			$this->db->count_all_results('anketa_odgovori');
			$this->db->where('id_ankete', $id);
		}

		function user_voted_questionnaire($anketa, $user)
		{
			$this->db->select('id_user');
			$this->db->from('anketa_odgovori');
			$this->db->where(array('id_user'=> $user, 'id_ankete' => $anketa));
			$q = $this->db->get();

			if($q->num_rows() > 0):
				return TRUE;
			else:
				return FALSE;
			endif;
		}

		function results(){
			$question = $this->get_question()->row();
			$options  = $this->get_options($question->id_anketa)->result();
			$results  = $this->get_results($question->id_anketa)->result();
			$total	  = 0;
			foreach ($options as $i => $opt) 
			{
				
				foreach ($results as $j => $r) 
				{
					if($opt->id_opcija == $r->id_opcije)
					{
						${'opt_sum_'.$i} = $r->count;
						break;
					}
					else
					{
						${'opt_sum_'.$i} = 0;
					}
				}
				
				$data[] = array(
					'option' => $opt->opcija,
					'votes' => ${'opt_sum_'.$i}
				);

				$total += ${'opt_sum_'.$i};
			
			}
			$data['total'] = $total;
			return $data;
		}



	}