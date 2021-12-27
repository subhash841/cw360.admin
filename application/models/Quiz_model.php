<?php

class Quiz_model extends CI_Model{

	function __construct() {
        parent::__construct();
	}

	function add_update_quiz($inputs){ 
		$quiz_id          = trim($inputs['quiz_id']);
		$user_id          = trim($inputs['user_id']);
        $category         = trim($inputs['question_category']);
		$topics           = implode(",",$inputs['topics']);
		$name             = trim($inputs['name']);
		$description      = trim($inputs['description']);
		$image            = trim($inputs['uploaded_filename']);
		$meta_ketwords    = trim($inputs['meta_keywords']);
		$meta_description = trim($inputs['meta_description']);
		$end_data         = trim(date( "y-m-d H:i:s", strtotime( $inputs['end_date']."23:59:59" )));
        $noofquestions    = trim($inputs['total_questions']);
        $is_published    =  trim($inputs['is_published']);
        //print_r($topics);die;   
		if(empty($quiz_id)){ 
			$insert_quiz = array(
							'user_id'         => $user_id,
                            'category'        => $category,
							'topic_id'        => $topics,
							'name'            => $name,
							'description'     => $description,
							'image'           => $image,
                            'total_questions' => $noofquestions,
							'meta_keywords'   => $meta_ketwords,
							'meta_description'=> $meta_description,
                            'is_published'    => $is_published,
                            'is_active'       => "1",
							'end_date'        => $end_data
						);
			$this->db->insert('quiz',$insert_quiz);
			return $this -> db -> insert_id();
		}
		else{ 
			$update_array = array(
							'user_id'         => $user_id,
							'name'            => $name,
                            'category'        => $category,
							'topic_id'        => $topics,
							'description'     => $description,
							'image'           => $image,
                            'total_questions' => $noofquestions,
							'meta_keywords'   => $meta_ketwords,
							'meta_description'=> $meta_description,
                            'is_published'    => $is_published,
                            'is_active'       => "1",
							'end_date'        => $end_data
						);

			$this -> db -> where('quiz_id',$quiz_id);
			$this -> db -> update('quiz',$update_array);
		}
	}



    function validate_quiz(){
                
            $this->form_validation->set_rules($this->config->item('Quiz','validation_rules'));
            if($this->form_validation->run() == FALSE){
                    return FALSE;
                } else {
                    return TRUE;
                }
    } 



    function validate_quizquestion(){
                
            $this->form_validation->set_rules($this->config->item('Question','validation_rules'));
            if($this->form_validation->run() == FALSE){
                    return FALSE;
                } else {
                    return TRUE;
                }
    } 


            

	function get_list($offset = 0){
		$this-> db -> select('quiz_id, user_id, name, description, image, meta_keywords, meta_description, is_published,is_active, end_date, created_date');
		$this -> db -> from('quiz');
        $this -> db -> where("is_active",1);
        $this-> db -> order_by('quiz_id','DESC');
        $this -> db -> limit( 10, $offset );
		return $this -> db -> get() -> result_array();
	}

	function get_topic_list() {
        $this -> db -> select( "*" );
        $this -> db -> from( "topics" );
        return $this -> db -> get() -> result_array();
	}

    function get_topic_list_by_category($category_id = 0) {
        $this -> db -> select( "*" );
        $this -> db -> from( "topics" );
        $this -> db -> where("category", $category_id);
        return $this -> db -> get() -> result_array();
    }

	function get_quiz_details($quiz_id){
		$this -> db -> select('quiz_id, user_id, category, topic_id, name, description, image, meta_keywords, meta_description, total_questions, is_active,is_published,end_date, created_date');
		$this -> db -> from('quiz');
		$this -> db -> where('quiz_id',$quiz_id);
		$this -> db -> limit(1);
		$quiz_data =  $this -> db -> get() -> row_array();

		$topics_id = array();
        $topic_id  = $quiz_data['topic_id'];
        $topics    = explode(',',$topic_id); 

        if(!empty($topics)){
            $this -> db -> select( "t.topic,t.id" );
            $this -> db -> from( "topics t" );
            $this -> db -> where_in( 'id' , $topics );
            $topics_data = $this -> db -> get() -> result_array();
            $quiz_data['topics_associated'] = $topics_data;
        }

        return $quiz_data;
	}

	function get_filtered_list($inputs){
       
        $offset = 0;
		$topic_id         = trim($inputs['topic_id']);
		$quiz_name        = trim($inputs['quiz_name']);
		$quiz_description = trim($inputs['quiz_description']);
		$startdate        = $inputs[ 'start_date' ];
        $enddate          = $inputs[ 'end_date' ];
        $offset           = $inputs[ 'offSet' ]; 

        $start_date = date( "Y-m-d", strtotime( $startdate ) );
        $end_date = date( "Y-m-d", strtotime( $enddate ) );
        $this -> db -> select('*');
        $this -> db -> from('quiz');

        if ( $topic_id != "" ) {
            // $this -> db -> where( 'topic_id', $topic_id );
            $this->db->where("topic_id REGEXP CONCAT('(^|,)(', REPLACE('$topic_id', ',', '|'), ')(,|$)')");
        }

        if( $quiz_name != "" ){
        	$this -> db -> where("name LIKE '%$quiz_name%'");
        }

        if( $quiz_description != "" ){
        	$this -> db -> where('description',$quiz_description);
        }

        if ( $startdate != "" ) {
            $this -> db -> where( 'created_date >=', $start_date );
        }

        if ( $enddate != "" ) {
            $this -> db -> where( 'DATE_FORMAT(end_date, "%Y-%m-%d") =', $end_date );
        }

        $this -> db -> where( 'is_active=', 1 );
        $this -> db -> order_by('quiz_id','DESC');
        $this -> db -> limit( 10, $offset );
        return $this -> db -> get() -> result_array();
       
         
	}


    function get_filtered_list_exported_q( $inputs ){

       
        $offset = 0;
        $topic_id         = trim($inputs['topic_id']);
        $quiz_name        = trim($inputs['quiz_name']);
        $quiz_description = trim($inputs['quiz_description']);
        $startdate        = $inputs[ 'start_date' ];
        $enddate          = $inputs[ 'end_date' ];
        $offset           = $inputs[ 'offSet' ]; 

        $start_date = date( "Y-m-d", strtotime( $startdate ) );
        $end_date = date( "Y-m-d", strtotime( $enddate ) );

        $this -> db -> select('quiz_id,name,description,created_date');
        $this -> db -> from('quiz');

        if ( $topic_id != "" ) {
            $this -> db -> where( 'topic_id', $topic_id );
        }

        if( $quiz_name != "" ){
            // $this -> db -> where("name LIKE %$quiz_name%");
             $this -> db -> where( 'name', $quiz_name );
        }

        if( $quiz_description != "" ){
            $this -> db -> where('description',$quiz_description);
        }

        if ( $startdate != "" ) {
            $this -> db -> where( 'created_date >=', $start_date );
        }

        if ( $enddate != "" ) {
            $this -> db -> where( 'end_date <=', $end_date );
        }

        $this -> db -> where('is_active',1); 
        $this -> db -> order_by('quiz_id','DESC');
      
        $res= $this -> db -> get() -> result_array();
        // echo $this -> db ->last_query() ;die;
        return $res;
    }

    function get_filtered_list_exported_qq($inputs){
        $offset = 0;
        $question        = trim($inputs['question_name']);
        $question_desc   = trim($inputs['question_desc']);
        $startdate       = $inputs[ 'start_date' ];
        $start_date = date( "Y-m-d", strtotime( $startdate ) );
        $offset = $inputs[ 'offSet' ];
        
        $this -> db -> select('*');
        $this -> db -> from('questions');

        if( $question != "" ){
            $this -> db -> where('question LIKE "%'.$question.'%"');
        }
        if( $question_desc != "" ){
            $this -> db -> where('description',$question_desc);
        }
        if ( $startdate != "" ) {
            $this -> db -> where( 'created_date >=', $start_date );
        }

        $this -> db -> where('is_active',1); 
        $this -> db ->order_by('id','DESC');
        return $this -> db -> get() -> result_array();

    }

	function active_inactive_quiz_mod( $inputs ) {
        $quiz_id   = $inputs[ 'quiz_id' ];
       
        $update = array (
            "is_active" => 0
        );
        $this -> db -> where( "quiz_id = '$quiz_id'" );
        $this -> db -> update( "quiz", $update );
        return TRUE;
    }

    function get_quiz_list(){
    	$this -> db -> select('quiz_id, name');
    	$this -> db -> from('quiz');
    	return $this -> db -> get() -> result_array();

    }

    function add_update_question($inputs){

    	$question_id               = trim($inputs['question_id']);
        $question_category         = trim($inputs['question_category']);
        $question_topics           = implode(',',$inputs['topics']);
    	$question                  = trim($inputs['question']);
    	$question_desc             = trim($inputs['question_desc']);
    	$question_meta_keywords    = trim($inputs['question_meta_keywords']);
    	$question_meta_description = trim($inputs['question_meta_description']);
        $question_image            = trim($inputs['uploaded_filename']);
        $meta_keywords             = trim($inputs['meta_keywords']);
    	$meta_description          = trim($inputs['meta_description']);
    	//$question_quiz             = implode($inputs['quiz']);
    	$user_id                   = $inputs['user_id'];
        //$is_published              = $inputs['is_published'];  
       if(isset($inputs[ 'is_published' ])){
                $is_published = 1;
            } else {
                $is_published = 0;
        }

    	if(empty($question_id))
    	{
    		$input_array = array(
    				    'user_id'          => $user_id,
                        'category'         => $question_category,
                        'topic_id'         => $question_topics,
    					'question'         => $question,
    					'description'      => $question_desc,
                        'is_published'      => $is_published,
    					'meta_keywords'    => $question_meta_keywords,
    					'meta_description' => $question_meta_description,
    					'image'            => $question_image
    					//'quiz_id'          => $question_quiz
    					);
            // print_r($input_array);
            // exit();
    		$this->db->insert('questions',$input_array);
    		$question_id      = $this -> db -> insert_id();
    		$choices          = $inputs['choices'];
    		$selected_choice  = $inputs['selected_choice'];    		
    		$i = 1;  
    		foreach($choices as $choice){
    			if(!(strcmp($selected_choice,'radio_'.$i))){
    				$correct_choice = 'yes';    				    				
    			}
    			else{
    				$correct_choice = 'no'; 	
    			}
    			$input_array = array(
    							'question_id'     => $question_id,
    							'choice'          => $choice,
    							'correct_choice'  => $correct_choice  
    							);
    			
    			$this -> db -> insert('question_choices', $input_array);
    			$i++;
    		}
    	}else{
    		$update_array = array(
    				    'user_id'          => $user_id,
                        'category'         => $question_category,
                        'topic_id'         => $question_topics,
    					'question'         => $question,
    					'description'      => $question_desc,
                        'is_published'      => $is_published,
    					'meta_keywords'    => $question_meta_keywords,
    					'meta_description' => $question_meta_description,
    					'image'            => $question_image,
    					//'quiz_id'          => $question_quiz
    					);

    		$this -> db -> where('id',$question_id);
    		$this -> db -> update('questions',$update_array);    		
    		$this -> db -> where('question_id', $question_id);
			$this -> db -> delete('question_choices');
			$choices          = $inputs['choices'];
    		$selected_choice  = $inputs['selected_choice'];
			$i = 1; 

    		foreach($choices as $choice){
    			if(!(strcmp($selected_choice,'radio_'.$i))){
    				$correct_choice = 'yes';    				    				
    			}
    			else{
    				$correct_choice = 'no'; 	
    			}
    			$input_array = array(
    							'question_id'     => $question_id,
    							'choice'          => $choice,
    							'correct_choice'  => $correct_choice,
                                'modified_date'   => date("Y-m-d")
    							);
    			
    			$this -> db -> insert('question_choices', $input_array);
    			$i++;
    		}    		
    	}

    	return $this->db->affected_rows();	  
    }

    function get_question_list(){
    	$this -> db -> select('id, question, description, is_active, is_published,created_date');
    	$this -> db -> from('questions');
        $this -> db -> where('is_active',1);
        $this -> db -> order_by('id','DESC');
        $this -> db -> limit( 10, $offset );
        return $this -> db -> get() -> result_array();	
    }

    function get_filtered_question_list($inputs){    	

    	
		$question        = trim($inputs['question_name']);
		$question_desc   = trim($inputs['question_desc']);
		$startdate       = $inputs[ 'start_date' ];
        $start_date = date( "Y-m-d", strtotime( $startdate ) );
        $offset = $inputs[ 'offSet' ];
        
        $this -> db -> select('id, question, description, is_active, is_published,created_date');
        $this -> db -> from('questions');

        if( $question != "" ){
        	$this -> db -> where('question LIKE "%'.$question.'%"');
        }

        if( $question_desc != "" ){
        	$this -> db -> where('description',$question_desc);
        }

        if ( $startdate != "" ) {
            $this -> db -> where( 'DATE_FORMAT(created_date, "%Y-%m-%d") =', $start_date );
        }
        $this -> db -> where('is_active',1);
        $this -> db ->order_by('id','DESC');
        $this -> db -> limit( 10, $offset );
        return $this -> db -> get() -> result_array();
    }


    function changepublishquiz( $id, $newstatus ) {
                $this -> db -> where( 'quiz_id', $id );
                $this -> db -> update( "quiz", array ( 'is_published' => $newstatus ) );
                if ( $newstatus == 0 ) {
                        return FALSE;
                } else {
                        return TRUE;
                }
        }


    function changepublishquestion( $id, $newstatus ) {
                $this -> db -> where( 'id', $id );
                $this -> db -> update( "questions", array ( 'is_published' => $newstatus ) );
                if ( $newstatus == 0 ) {
                        return FALSE;
                } else {
                        return TRUE;
                }
        }

    function active_inactive_question($inputs){
    	$question_id   = $inputs[ 'question_id' ];
        $type          = $inputs[ 'type' ];
        $update = array (
            "is_active" => 0
        );  
        $this -> db -> where( "id = '$question_id'" );
        $this -> db -> update( "questions", $update );
        return TRUE;	
    }

    function get_question_details($question_id){
    	//$query = $this->db->query("SELECT id, category, topic_id, question, description, meta_keywords, meta_description, quiz_id, image, created_date FROM questions WHERE id = ".$question_id);
    	//return $query->row_array();
        $this -> db -> select( "*" );
        $this -> db -> from( "questions q" );
        $this -> db -> where( 'id' , $question_id );
        $topic_data = $this->db->get()->row_array();

        $topics_id = array();
        $topic_id = $topic_data['topic_id'];
        $topics = explode(',',$topic_id); 

        if(!empty($topics)){
            $this -> db -> select( "t.topic,t.id" );
            $this -> db -> from( "topics t" );
            $this -> db -> where_in( 'id' , $topics );
            //$this-> db ->where_not_in('category', $topic_data['category']);
            $topics_data = $this -> db -> get() -> result_array();
        }
        $topic_data['topics_associated'] = $topics_data;
        /*   echo '<pre>';print_r($game_data);
            exit();*/
        return $topic_data;
    }

    function get_question_quiz($question){
    	$this -> db -> select('quiz_id, name');
    	$this -> db -> from('quiz');
    	$this -> db -> where_in('quiz_id',$question['quiz']);
        return $this -> db -> get() -> result_array();
    }

    function get_question_choices($question_id){        
    	$query = $this->db->query("SELECT choice, correct_choice FROM question_choices WHERE question_id = ".$question_id);
    	return $query->result_array();
    }


    function search($quiz,$cat_id){
    	$this -> db -> select( "quiz_id as id, name as text" );
        $this -> db -> from( "quiz" );
        $this -> db -> where('category',$cat_id);
        $this -> db -> like( 'name', $quiz, 'both' );
        /*if ( count( $ids ) > 0 ) {
            $this -> db -> where_not_in( 'quiz_id', $ids );
        }*/
        $result = $this -> db -> get() -> result_array();
        //echo $this->db->last_query();
        return $result;     
    }

    function search_topic( $topic,$category ){
    	$this -> db -> select( "id, topic as text" );
        $this -> db -> from( "topics" );
        $this -> db -> where("category", $category);
        $this -> db -> where("is_active", 1);
        $this -> db -> like( 'topic', $topic, 'both' );
        if ( count( $ids ) > 0 ) {
            $this -> db -> where_not_in( 'id', $ids );
        }
        $result = $this -> db -> get() -> result_array();
        return $result;
    }
}
?>