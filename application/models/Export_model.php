<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
 
class Export_model extends CI_Model {

    function __construct() {
      parent::__construct();
    }


    function get_state(){
    	$query = $this->db->query('select * from states where is_active = 1');
    	return $query->result();
    }



    function get_filtered_list_exported(){
    	$export = array();
		$query = $this->db->query("SELECT u.id,(case when u.name IS NULL then 'NA' else u.name end) as name,u.email,u.unearned_points,(case when u.dob IS NULL then 'NA' else u.dob end) as dob,(case when u.gender IS NULL then 'NA' when u.gender = 'm' then 'Male' when u.gender = 'f' THEN 'Female' when u.gender = '' then 'NA' else u.gender end) as gender,(case when u.phone IS NULL then 'NA' else u.phone end) as phone,c.coins as wallet_coins FROM users u 
    		LEFT JOIN coins c ON u.id = c.user_id 
    		GROUP BY u.id");
		/*$query = $this->db->query('SELECT u.id,(case when u.name IS NULL then "NA" else name end) as name,u.email,u.unearned_points,sum(w.coins) as wallet_coins FROM users u JOIN wallet_history w ON u.id = w.user_id  WHERE (w.type !="3" AND w.type != "4") GROUP BY u.id');*/
		$result = $query -> result_array();
		return $result;
    }

	function ExportDetails($id){
		$query = $this->db->query('SELECT uf.user_id, u.login_type, uf.party_id, u.name, u.email,p.abbreviation,uf.seat_forecast,uf.vote_forcast,s.name as location,pr.name as party_affiliation,uf.modified_date FROM user_forecasting uf INNER JOIN users u ON u.id = uf.user_id INNER JOIN parties p ON p.id = uf.party_id LEFT JOIN states s ON s.id = u.location LEFT JOIN parties pr ON pr.id = u.party_affiliation WHERE state_id = '.$id.' order by uf.user_id');
		return $query -> result_array();
		
	 }


	 function get_user_coinshistory(){
		$query = $this -> db ->query("SELECT count(qa.id) as quiz_count, u.email , u.id, u.name,(select sum(coins) as spend_coins from wallet_history where user_id= qa.user_id and `type` in ('6') group by user_id) as total_lost,(select sum(coins) as spend_coins from wallet_history where user_id= qa.user_id and `type` in ('5') group by user_id) as total_earn FROM `quiz_attempted` as qa left join users u ON qa.user_id=u.id group by qa.`user_id`");
		$result = $query -> result_array();
		return $result;
	 }


	 function SurveyDetails(){
	 	$query = $this->db->query("SELECT sa.poll_id as ques_id, u.name as user, u.alise as alias, u.email, s.question, sc_o.choice as option_name, 
		(SELECT COUNT(1) FROM survey_action sa_s LEFT JOIN survey_choices sc_i ON sc_i.id = sa_s.choice WHERE sa_s.choice = sa.choice GROUP BY sa_s.choice) as total_votes, sa.created_date
		FROM survey_action sa
		INNER JOIN survey s on s.id = sa.poll_id
		INNER JOIN survey_choices sc_o ON sc_o.id = sa.choice 
		INNER JOIN users u on u.id = sa.user_id
		WHERE sa.created_date BETWEEN '2018-08-16' AND '2018-08-28'
		ORDER BY sa.poll_id");
	 	return $query -> result_array();
	}


	function PredictionDetails(){
		$query = $this->db->query("SELECT pa.poll_id as ques_id, u.name as user,u.alise as alias, u.email,pcat.name as category,p.poll,pc_o.choice as option_name,
		(SELECT COUNT(1) FROM poll_action pa_s LEFT JOIN poll_choices pc_i ON pc_i.id = pa_s.choice WHERE pa_s.choice = pa.choice GROUP BY pa_s.choice) as total_votes, pa.created_date, s.name as location, pr.name as party_affiliation
		FROM poll_action pa
		INNER JOIN poll p on p.id = pa.poll_id
		INNER JOIN poll_choices pc_o ON pc_o.id = pa.choice 
		INNER JOIN users u on u.id = pa.user_id
		LEFT JOIN states s ON s.id = u.location
		LEFT JOIN parties pr ON pr.id = u.party_affiliation
		LEFT JOIN poll_category pcat on pcat.id = pa.category_id
		ORDER BY pa.poll_id");
	 	return $query -> result_array();
	}


	function Exportpoints(){
		$query = $this->db->query('select  u.id,  u.name,  u.social_id,  u.twitter_id,  u.email,  u.rank,  u.points,u.earned_points as gold_points,u.unearned_points as silver_points, u.created_date, s.name as location, p.name as party
			FROM users u
			LEFT JOIN states s ON s.id = u.location
			LEFT JOIN parties p ON p.id = u.party_affiliation
			order by u.id');
		return $query -> result_array();

	}


	function get_quizanswer($quiz_id){
		$query = $this->db->query("SELECT qa.user_id,IFNULL(u.name, CONCAT('CW360#',qa.user_id)) as name,IFNULL(u.email,'NA') as email,que.question,qa.ans_status 
				FROM quiz_action qa 
				LEFT JOIN users u ON qa.user_id = u.id 
				LEFT JOIN questions que ON qa.question_id = que.id
				WHERE qa.quiz_id = ".$quiz_id." order by qa.id desc");

		return $query -> result_array();

	}
	function quiz_name($quiz_id){
		$this->db->select("name");
		$this->db->from("quiz");
		$this->db->where("quiz_id",$quiz_id);
		$res=$this->db->get()->row_array();
		return $res['name'];

	}





    

}
