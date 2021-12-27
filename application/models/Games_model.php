<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Games_model extends CI_Model {

        function __construct() {
                parent::__construct();
                $this->load->library('MY_Form_validation');
               

        }

        function get_list( $offset = 0 ) {
                $this -> db -> select( "g.*,t.topic" );
                $this -> db -> from( "games g" );
                $this -> db -> join( "topics t", "g.topic_id = t.id", "LEFT" );
                $this -> db -> where( 'g.is_active=', 1 );
                $this -> db -> order_by( "g.id DESC" );
                $this -> db -> limit( 10, $offset );
                return $this -> db -> get() -> result_array();
        }

        function get_user_list(){

                $this -> db -> select("id,name,email");
                $this -> db -> from( "users u");   
                return $this -> db -> get() -> result_array();
        }

        function get_polls() {

                $this -> db -> select( "p.*,pc.name as category,group_concat(pch.choice) as choices,right_choice" );
                $this -> db -> from( "poll p" );
                $this -> db -> join( "poll_category pc", "pc.id = p.category_id", "LEFT" );
                $this -> db -> join( "poll_choices pch", "pch.poll_id = p.id", "INNER" );
                $this -> db -> group_by( "p.id" );
                $this -> db -> order_by( "p.is_approved ASC, p.id DESC" );
//              $this -> db -> limit( 10, $offset );
                return $this -> db -> get() -> result_array();
//                
//                $this -> db -> select( "p.*,pc.name as category,group_concat(pch.choice) as choices,right_choice" );
//                $this -> db -> from( "poll p" );
//                $this -> db -> join( "poll_category pc", "pc.id = p.category_id", "INNER" );
//                $this -> db -> join( "poll_choices pch", "pch.poll_id = p.id", "INNER" );
//                $this -> db -> group_by( "p.id" );
//                $this -> db -> order_by( "p.is_approved ASC, p.id DESC" );
//                return $this -> db -> get() -> result_array();

        }

    public function all_prediction_price($game_id) {

        $this->db->select('id, (CASE WHEN prediction_executed = 0 then current_price
            WHEN prediction_executed = 1 && wrong_prediction = 0 then current_price
            ELSE 0
            END)as current_price');
        $this->db->from('predictions');
        $this->db->where_in('id',"SELECT prediction_id from executed_predictions where game_id=$game_id GROUP BY prediction_id",false);
        return $this->db->get()->result_array();
    }


    /*public function leaderboard_details($game_id) {

        $this->db->select("ep.id, ep.user_id, GROUP_CONCAT(ep.bonus_points) as bonus_points, GROUP_CONCAT(DISTINCT(ep.prediction_id) SEPARATOR ',') as predictions, IFNULL(u.name, CONCAT('CW360#',ep.user_id)) as name, u.image, (SELECT points from points where user_id = ep.user_id and game_id=$game_id limit 1) as points,u.email");
        $this->db->from('executed_predictions as ep');
        $this->db->join('users as u','ep.user_id = u.id','LEFT');
        // $this->db->where(array('ep.game_id' => $game_id,'ep.swipe_status' => 'agreed'));
        $this->db->where('ep.game_id', $game_id);
        $this->db->where('ep.swipe_status', 'agreed');
        $this->db->group_by('ep.user_id');
        $this->db->order_by('ep.id','ASC');
        return $this->db->get()->result_array();
        // $this->db->get()->result_array();
        // echo $this->db->last_query();
    }*/

    function leaderboard_details($game_id) {
        $this->db->select("id, user_id, GROUP_CONCAT(bonus_points) as bonus_points, GROUP_CONCAT(DISTINCT(prediction_id) SEPARATOR ',') as predictions");
        $this->db->from('executed_predictions');
        // $this->db->where(array('ep.game_id' => $game_id,'ep.swipe_status' => 'agreed'));
        // $this->db->where('game_id', $game_id);
        // $this->db->where('swipe_status', 'agreed');
        if($game_id <= 268){        
                $this->db->where("(swipe_status = 'agreed' AND game_id = $game_id)");
        }else{
        $this->db->where("(swipe_status = 'agreed' AND game_id = $game_id)");
        $this->db->or_where("(bonus_points > 0 AND game_id = $game_id)");
        }
        $this->db->group_by('user_id');
        $this->db->order_by('id','ASC');
        return $this->db->get()->result_array();
        // $this->db->get()->result_array();
        // echo $this->db->last_query();
    }

    function all_users_details($game_id) {
        $this->db->select("p.id, p.user_id, p.points, IFNULL(u.name, CONCAT('CW360#',p.user_id)) as name, u.email, u.image,u.phone");
        $this->db->from('points as p');
        $this->db->join('users as u','p.user_id = u.id','LEFT');
        // $this->db->where(array('ep.game_id' => $game_id,'ep.swipe_status' => 'agreed'));
        $this->db->where('p.game_id', $game_id);
        $this->db->order_by('p.id','ASC');
        return $this->db->get()->result_array();
    }

    function validate_game(){
            
        $this->form_validation->set_rules($this->config->item('Game','validation_rules'));
        if($this->form_validation->run() == FALSE){
                return FALSE;
            } else {
                return TRUE;
              }
        } 

    function validate_walletcoin(){
        $this->form_validation->set_rules($this->config->item('walletcoin','validation_rules'));
        if($this->form_validation->run() == FALSE){
                return FALSE;
            } else {
                return TRUE;
              }
        } 
    function validate_add_deduct_points(){
        $this->form_validation->set_rules($this->config->item('add_deduct_points','validation_rules'));
        if($this->form_validation->run() == FALSE){
                return FALSE;
            } else {
                return TRUE;
              }
        } 

        function add_deduct_points($game_id,$prediction_id,$swipe_status,$points,$action){
            // print_r($prediction_id);
                // TO CHECK WHETHER THE USER HAVE BUY PREDICTION                
                $where=array("game_id"=>$game_id,"prediction_id"=>$prediction_id,"swipe_status"=>$swipe_status);
                $this->db->select("GROUP_CONCAT(DISTINCT(user_id) SEPARATOR ',') as user_id");
                $this->db->from('executed_predictions');
                $this->db->where($where);
                $result = $this->db->get()->row_array();
                $user_ids=$result['user_id'];
                if(!empty($user_ids)){                        
                // print_r($res);
                // die;
                if($action == 'add'){     
                       $action_type="+";
                       $type="6";
                       $status="Add";
                }else if($action == 'deduct') {
                        $action_type="-";        
                        $type="7";
                        $status="Deduct";
                }
                //game name
                $this->db->select('title');
                $this->db->from('games');
                $this->db->where('id',$game_id);
                $game = $this->db->get()->row_array();

                //predictions name
                $this->db->select('title');
                $this->db->from('predictions');
                $this->db->where('id',$prediction_id);
                $prediction = $this->db->get()->row_array();

                //Update points for points table                                     
                $this->db->set("points", "points $action_type $points", FALSE);
                $this->db->set("update_type", $type);
                $this->db->where('game_id',$game_id);
                $this->db->where_in("user_id",$user_ids,FALSE);
                if($this->db->update('points')){
                        $insert_add_deduct_point_history = array(
                                'user_ids' => $user_ids,
                                'game_name' => $game['title'],
                                'prediction_name' => $prediction['title'],
                                'points' => $points,
                                'type' => $status,
                                'game_id'=>$game_id,
                                'prediction_id'=>$prediction_id,
                                'created_date' => date('Y-m-d h:i:s')
                        );
                        $this->db->insert('add_deduct_point_history' ,$insert_add_deduct_point_history);
                }        
        }
               
    }      

        function get_userpoints_history($offset=0){
        $this->db->select('*');
        $this->db->from('add_deduct_point_history');
        $this->db->order_by('id','DESC');
        $this -> db -> limit(20, $offset);
        $result = $this->db->get()->result_array();
        // echo $this->db->last_query();
        return $result;
        } 

        


        function get_filtered_userpoints_history( $inputs,$filter=""){
       
                // print_r($inputs);
                if(!empty($inputs[ 'start_date' ])){
                        $start_date = date( "Y-m-d", strtotime( $inputs[ 'start_date' ] ) );
                }
                
        if(!empty($inputs[ 'end_date' ])){
                $end_date = date( "Y-m-d", strtotime( $inputs[ 'end_date' ] ) );
                
        }
        
        
        $fgame_id = $inputs[ 'fgame_id' ];
        $fprediction_id = $inputs['fprediction_id'];
        $offset = 0;
        
        
        //print_r($fprediction_id);exit();
        
        
        $this -> db -> select("*");
        $this -> db -> from("add_deduct_point_history");
        
        
        if(!empty($fprediction_id)){
                $this -> db ->where( 'prediction_name', $fprediction_id);
        } 
        
        if(!empty($fgame_id)){
                 
                $this -> db ->where( 'game_name', $fgame_id);
        }
        
        if ( $start_date != "" && empty($end_date)) {
                $this -> db -> where( 'DATE_FORMAT(created_date, "%Y-%m-%d")>=', $start_date);
        }else if ( $end_date != "" && empty($start_date) ) {                
                $this -> db -> where( 'DATE_FORMAT(created_date, "%Y-%m-%d")<=', $end_date );
        }else if ( $end_date != "" ) {
                $this -> db -> where( 'DATE_FORMAT(created_date, "%Y-%m-%d")>=', $start_date);
                $this -> db -> where( 'DATE_FORMAT(created_date, "%Y-%m-%d")<=', $end_date );
        }
        $this -> db -> order_by( "id DESC" );
        /* $this -> db -> order_by( "p.title DESC" );*/
        $offset = $inputs[ 'offSet' ];
        // print_r($offset);die;
        if(empty($filter)){
                $this -> db -> limit(20, $offset);
        }
        $result=$this -> db -> get() -> result_array();
        //        echo $this->db->last_query(); die;
        return  $result;
    }    

        function search( $name, $ids ) {
            $this -> db -> select( "*" );
            $this -> db -> from( "topics" );
            $this -> db -> like( 'topic', $name, 'both' );
            if ( count( $ids ) > 0 ) {
                    $this -> db -> where_not_in( 'id', $ids );
            }
            $result = $this -> db -> get() -> result_array();
            return $result;

    }


    function search_user($user,$game_id){
    $this -> db -> select( "u.id as id, u.name as text" );
    $this -> db -> from( "users" );
    $this -> db -> join( "coins c", "u.id = c.user_id", "LEFT" );
    $this -> db -> where('c.id',$game_id);
    $this -> db -> like( 'name', $quiz, 'both' );

    /*if ( count( $ids ) > 0 ) {
        $this -> db -> where_not_in( 'quiz_id', $ids );
    }*/

    $result = $this -> db -> get() -> result_array();

    //echo $this->db->last_query();
     return $result;     
    }



    // function get_prediction_topics( $postid ) {
    //     $this -> db -> select( "ta.topic_id,ta.type, t.topic" );
    //     $this -> db -> from( "topic_association ta" );
    //     $this -> db -> join( "topics t", "ta.topic_id = t.id", "INNER" );
    //     $this -> db -> where( "ta.post_id = '$postid' AND ta.type = 'poll'" );
    //     $result = $this -> db -> get() -> result_array();
    //     return $result;
    // }

    function get_topic_list() {
            $this -> db -> select( "*" );
            $this -> db -> from( "topics" );
            $this -> db -> where( 'is_active=', 1 );
            return $this -> db -> get() -> result_array();

    }

    function get_all_games_list($condtion="") {
        $this -> db -> select( "g.*" );
        $this -> db -> from( "games g" );
        if(!empty($condtion)){
            $this -> db -> where( 'g.is_published =', '1');
            $this -> db -> where( 'g.is_active =', '1');
            $this->db->where("NOW() between date_format(str_to_date(g.start_date, '%Y-%m-%d %H:%i:%s'), '%Y-%m-%d %H:%i:%s') and (date_format(str_to_date(g.end_date, '%Y-%m-%d %H:%i:%s'), '%Y-%m-%d %H:%i:%s'))");
        }else {
                /* $this -> db -> join( "add_deduct_point_history ad", "ad.game_name = g.title");
                $this -> db -> group_by( "ad.game_name" ); */

                $this -> db -> join( "add_deduct_point_history ad", "ad.game_id = g.id");
                $this -> db -> group_by( "ad.game_id" );
            }
        $this -> db -> order_by( "g.id DESC" );
        $res=$this -> db -> get() -> result_array();
    //     echo $this->db->last_query();
        return $res; 

}


    function get_games_list($condtion="") {
            $this -> db -> select( "g.*,t.topic" );
            $this -> db -> from( "games g" );
            $this -> db -> join( "topics t", "g.topic_id = t.id");
            if($condtion!="1"){
            $this -> db -> where( 'g.is_published =', '1');
            $this -> db -> where( 'g.is_active =', '1');
                }
            $this->db->where("NOW() between date_format(str_to_date(g.start_date, '%Y-%m-%d %H:%i:%s'), '%Y-%m-%d %H:%i:%s') and (date_format(str_to_date(g.end_date, '%Y-%m-%d %H:%i:%s'), '%Y-%m-%d %H:%i:%s'))");
            $this -> db -> order_by( "g.id DESC" );
            $res=$this -> db -> get() -> result_array();
        //     echo $this->db->last_query();die;
            return $res; 

    }


    function get_topic_name($game_id){
         $this -> db -> select( "t.topic" );
         $this -> db -> from( "topics t" ); 
         $this -> db -> join( "games g", "t.id = g.topic_id", "LEFT" ); 
         $this -> db -> where( 'g.id =', $game_id );
        return $this -> db -> get() -> result_array();

    }


    function get_filtered_list( $inputs ) {

            $offset = 0;

            $title = $inputs[ 'title' ];
            $offset = $inputs[ 'offSet' ];

            if(!empty($inputs[ 'start_date' ])){
                 $start_date = date( "Y-m-d", strtotime( $inputs[ 'start_date' ] ) );
            }

            if(!empty($inputs[ 'end_date' ])){
                $end_date = date( "Y-m-d", strtotime( $inputs[ 'end_date' ] ) );
            }
            $this -> db -> select( "g.*,t.topic" );
            $this -> db -> from( "games g" );

            if ( $title != "" ) {
                    $this -> db -> where( "title like '%$title%'" );
            }
            
            if ( $start_date != "" ) {
                    $this -> db -> where( 'DATE_FORMAT(g.start_date, "%Y-%m-%d") >=', $start_date );
            }

            if ( $end_date != "" ) {
                    $this -> db -> where( 'DATE_FORMAT(g.end_date, "%Y-%m-%d") <=', $end_date );
            }
            $this -> db -> where( 'g.is_active=', 1 );
            $this -> db -> join( "topics t", "g.topic_id = t.id", "LEFT" );
            $this -> db -> order_by( "g.id DESC" );
            $this -> db -> limit( 10, $offset );
           
            return $this -> db -> get() -> result_array();
            /* print_r($this->db->last_query());
             exit();*/
           
         

    }

    function get_filtered_list_exported( $inputs ) {

            $offset = 0;
            $title = $inputs[ 'title' ];
            $offset = $inputs[ 'offSet' ];
            if(!empty($inputs[ 'start_date' ])){
                 $start_date = date( "Y-m-d", strtotime( $inputs[ 'start_date' ] ) );
            }

            if(!empty($inputs[ 'end_date' ])){
                $end_date = date( "Y-m-d", strtotime( $inputs[ 'end_date' ] ) );
            }
            $this -> db -> select( "g.id,g.title,g.start_date,g.end_date,t.topic" );
            $this -> db -> from( "games g" );

            if ( $title != "" ) {
                    $this -> db -> where( "title like '%$title%'" );
            }
            
            if ( $start_date != "" ) {
                    $this -> db -> where( 'g.start_date >=', $start_date );
            }

            if ( $end_date != "" ) {
                    $this -> db -> where( 'g.end_date <=', $end_date );
            }
            $this -> db -> where( 'g.is_active=', 1 );
            $this -> db -> join( "topics t", "g.topic_id = t.id", "LEFT" );
            $this -> db -> order_by( "g.id DESC" );
             return $this -> db -> get() -> result_array();

    }

    function get_details_poll( $poll_id ) {
            $this -> db -> select( "p.*,pc.name as category, COALESCE(u.name,'') as user, t.topic as topic" );
            $this -> db -> from( "poll p" );
            $this -> db -> join( "poll_category pc", "pc.id = p.category_id", "INNER" );
            $this -> db -> join( "users u", "u.id = p.user_id", "LEFT" );
            $this -> db -> join( "topics t", "t.id = p.topic_id", "LEFT" );
            $this -> db -> where( "p.id = '$poll_id'" );
            $poll_data = $this -> db -> get() -> row_array();


            $this -> db -> select( "pc.*" );
            $this -> db -> from( "poll_choices pc" );
            $this -> db -> where( "poll_id = '$poll_id'" );
            $poll_data[ 'choices' ] = $this -> db -> get() -> result_array();

            return $poll_data;

    }

    function get_poll_count( $poll_id ) {
            $this -> db -> select( "count(1) as total_polls" );
            $this -> db -> from( "poll_comments" );
            $this -> db -> where( "id = '$poll_id'" );
            $poll_count[ 'polls' ] = $this -> db -> get() -> row_array();

            return $poll_count;

    }

    function get_poll_replies( $poll_id ) {
            $this -> db -> select( "count(1) as total_replies" );
            $this -> db -> from( "poll_comment_reply" );
            $this -> db -> where( "id = '$poll_id'" );
            $poll_reply[ 'replies' ] = $this -> db -> get() -> row_array();
            return $poll_reply;

    }

    function get_user_polls_filtered( $inputs ) {

            $data_item_list = array ();

            $type = 1;
            $userid = $inputs[ 'user_id' ];
            $type = $inputs[ 'poll_type' ];
            $title = $inputs[ 'poll_quest' ];
            $description = $inputs[ 'poll_desc' ];
            $status = $inputs[ 'poll_status' ];
            $startdate = $inputs[ 'poll_cstart_date' ];
            $enddate = $inputs[ 'poll_cend_date' ];
            $offset = $inputs[ 'offset' ];

            $start_date = date( "y-m-d", strtotime( $startdate ) );
            $end_date = date( "y-m-d", strtotime( $enddate ) );

            if ( $type == 2 ) {
                    $this -> db -> select( "*" );
                    $this -> db -> from( "survey_action" );
                    if ( $userid != "" ) {
                            $this -> db -> where( 'user_id', $userid );
                    }
                    $participated_poll_list = $this -> db -> get() -> result_array();

                    foreach ( $participated_poll_list as $key => $item ) {
                            array_push( $data_item_list, $item[ 'poll_id' ] );
                    }
            }

            $this -> db -> select( "p.*,pc.name as category,group_concat(pch.choice) as choices,right_choice" );
            $this -> db -> from( "poll p" );
            if ( $type == 2 ) {
                    $this -> db -> where_in( 'p.id', $data_item_list );
            } else {
                    $this -> db -> where( 'user_id', $userid );
            }
            if ( $title != "" ) {
                    $this -> db -> where( 'question', $title );
            }
            if ( $description != "" ) {
                    $this -> db -> where( 'description', $description );
            }
            if ( $startdate != "" ) {
                    $this -> db -> where( 'p.created_date >=', $start_date );
            }
            if ( $enddate != "" ) {
                    $this -> db -> where( 'p.created_date <=', $end_date );
            }
            $this -> db -> join( "poll_category pc", "pc.id = p.category_id", "INNER" );
            $this -> db -> join( "poll_choices pch", "pch.poll_id = p.id", "INNER" );
            $this -> db -> group_by( "p.id" );
            $this -> db -> order_by( "p.is_approved ASC, p.id DESC" );
            $this -> db -> limit( 10, $offset );
            return $this -> db -> get() -> result_array();

    }

    function export_filter_user_polls( $inputs ) {

            $data_item_list = array ();

            $type = 1;

            $userid = $type = $title = $description = $status = $startdate = $enddate = "";

            if ( isset( $inputs[ 'user_id' ] ) ) {
                    $userid = $inputs[ 'user_id' ];
            }
            if ( isset( $inputs[ 'poll_type' ] ) ) {
                    $type = $inputs[ 'poll_type' ];
            }
            if ( isset( $inputs[ 'poll_quest' ] ) ) {
                    $title = $inputs[ 'poll_quest' ];
            }
            if ( isset( $inputs[ 'poll_desc' ] ) ) {
                    $description = $inputs[ 'poll_desc' ];
            }
            if ( isset( $inputs[ 'poll_status' ] ) ) {
                    $status = $inputs[ 'poll_status' ];
            }
            if ( isset( $inputs[ 'poll_cstart_date' ] ) ) {
                    $startdate = $inputs[ 'poll_cstart_date' ];
            }
            if ( isset( $inputs[ 'poll_cend_date' ] ) ) {
                    $enddate = $inputs[ 'poll_cend_date' ];
            }
            //$offset = $inputs[ 'offset' ];

            $start_date = date( "y-m-d", strtotime( $startdate ) );
            $end_date = date( "y-m-d", strtotime( $enddate ) );

            if ( $type == 2 ) {
                    $this -> db -> select( "*" );
                    $this -> db -> from( "survey_action" );
                    if ( $userid != "" ) {
                            $this -> db -> where( 'user_id', $userid );
                    }
                    $participated_poll_list = $this -> db -> get() -> result_array();

                    foreach ( $participated_poll_list as $key => $item ) {
                            array_push( $data_item_list, $item[ 'poll_id' ] );
                    }
            }

            $this -> db -> select( "p.*,pc.name as category,group_concat(pch.choice) as choices,right_choice" );
            $this -> db -> from( "poll p" );
            if ( $type == 2 ) {
                    $this -> db -> where_in( 'p.id', $data_item_list );
            } else {
                    $this -> db -> where( 'user_id', $userid );
            }
            if ( $title != "" ) {
                    $this -> db -> where( 'question', $title );
            }
            if ( $description != "" ) {
                    $this -> db -> where( 'description', $description );
            }
            if ( $startdate != "" ) {
                    $this -> db -> where( 'p.created_date >=', $start_date );
            }
            if ( $enddate != "" ) {
                    $this -> db -> where( 'p.created_date <=', $end_date );
            }
            $this -> db -> join( "poll_category pc", "pc.id = p.category_id", "INNER" );
            $this -> db -> join( "poll_choices pch", "pch.poll_id = p.id", "INNER" );
            $this -> db -> group_by( "p.id" );
            $this -> db -> order_by( "p.is_approved ASC, p.id DESC" );
            //$this -> db ->limit(10, $offset);
            return $this -> db -> get() -> result_array();

    }


    function get_games_details( $game_id ) {
            $this -> db -> select( "g.*" );
            $this -> db -> from( "games g" );
            $this -> db -> where( "id = '$game_id'" );
            $game_data = $this -> db -> get() -> row_array();
           
            $topics_id = array();
            $topic_id = $game_data['topic_id'];
            $topics = explode(',',$topic_id); 

            if(!empty($topics)){
            $this -> db -> select( "t.topic,t.id" );
            $this -> db -> from( "topics t" );
            $this -> db -> where_in( 'id' , $topics );
            $topics_data = $this -> db -> get() -> result_array();
            }
            $game_data['topics_associated'] = $topics_data;
         /*   echo '<pre>';print_r($game_data);
            exit();*/

            $this -> db -> select( "gr.*" );
            $this -> db -> from( "games_reward gr" );
            $this -> db -> where( "gr.game_id = '$game_id'" );
            $game_data[ 'reward' ] = $this -> db -> get() -> result_array();
            return $game_data;

    }


    function find_old_game_data( $game_id ) {
        $this -> db -> select( "`topic_id`, `title`, `req_game_points`, `min_game_points`, `max_game_points`, `top_news`, `description`, `image`, `initial_game_points`, `bonus_point_yes_right`, `deduct_point_yes_wrong`, `bonus_point_no_wrong`, `deduct_point_no_right`, `coin_transfer_limit`, `point_value_per_coin`,`reward`, `start_date`, TIME_FORMAT(`start_time`,'%H:%i') as`start_time`, `end_date`, TIME_FORMAT(`end_time`,'%H:%i') as end_time, `min_no_trade`, `shortsell_portfolio_limit`, `meta_keywords`, `meta_description`, `status`, `change_prediction_time`, `is_published`, `is_active`,`max_players`" );
        $this -> db -> from( "games" );
        $this -> db -> where( "id = '$game_id'" );
        $game_data = $this -> db -> get() -> row_array();
        return $game_data;
    }

    function update_answer_mod( $inputs ) {
            $poll_id = $inputs[ 'poll_id' ];
            $choice_id = $inputs[ 'choice' ];

            $this -> db -> where( "id", $poll_id );
            $this -> db -> update( "poll", array ( "right_choice" => $choice_id ) );

            $user_ids = array ();
            $this -> db -> select( "DISTINCT(user_id)" );
            $this -> db -> from( "poll_action" );
            $this -> db -> where( "poll_id = '$poll_id' AND choice = '$choice_id'" );
            $result = $this -> db -> get() -> result_array();

            foreach ( $result as $userids_data ) {
                    $user_ids[] = $userids_data[ 'user_id' ];
            }


            $add_gold_points = array ();
            foreach ( $user_ids as $uid ) {
                    $add_gold_points[] = array (
                        "type" => "poll",
                        "topic_id" => "0",
                        "post_id" => $poll_id,
                        "user_id" => $uid,
                        "choice_id" => $choice_id,
                        "points" => "1",
                        "point_type" => "Gold",
                        "action" => "Correct Vote"
                    );
            }

            if ( ! empty( $user_ids ) ) {
                    $this -> db -> insert_batch( "points_history", $add_gold_points );
                    $this -> db -> where_in( "id", $user_ids );
                    $this -> db -> set( 'earned_points', 'earned_points+1', FALSE );
                    $this -> db -> update( "users" );
            }

    }

    function get_poll_category() {
            $this -> db -> select( "*" );
            $this -> db -> from( "poll_category" );
            $this -> db -> where( "is_active = '1'" );
            return $this -> db -> get() -> result_array();

    }

    function changepublishgame( $id, $newstatus ) {
            $this -> db -> where( 'id', $id );
            $this -> db -> update( "games", array ( 'is_published' => $newstatus ) );
            if ($newstatus==1) {
                $this->db->select('title,image');
                $this->db->from('games');
                $this->db->where('id',$id);
                $game_result = $this->db->get()->row_array();

                $game_id = $id;
                $this->db->select('id');
                $this->db->from('notifications');
                $this->db->where("game_id = $game_id AND prediction_id IS NULL");
                $result = $this->db->get()->result_array();
                if (empty($result)) {
                    $game_notification = array('game_id'=>$game_id,
                                                'game_title'=>$game_result['title'],
                                                'game_image'=>$game_result['image']
                                );
                    $this->db->insert('notifications', $game_notification);
                    $this -> notification -> get_ids_and_fields($game_notification,'All');
                }
            }
            if ( $newstatus == 0 ) {
                    return FALSE;
            } else {
                    return TRUE;
            }
    }



    function add_update_coins($user_id=0,$coins,$action){
        /*print_r($action);
        exit();*/
        $this-> db ->select('id,coins');
        $this -> db -> from( "coins" );
        $this -> db -> where(array('user_id'=>$user_id));
        $result = $this->db->get()->row_array();

        if($action == 'add'){

        $this->db->where('user_id', $user_id);                          //Update coins for coins table
        $this->db->set("coins", "coins + $coins", FALSE);
        $this->db->update('coins');

        $insertadded_coins = array(
                              'user_id' => $user_id,
                              'coins' => $coins,
                              'previous_coins' => $result['coins'],
                              'new_game_coins' => $result['coins'] + $coins,
                              'type' => $action,
                              'created_date' => date('Y-m-d H:i:s')
                        );

        $this->db->insert('added_game_coins', $insertadded_coins);     //Tbl maintained for listing coins activity


        $insert_wallet_history = array(
                            'user_id' => $user_id,
                            'coins' => $coins,
                            'type' => '2',
                            'created_date' => date('Y-m-d h:i:s')
        );
        $this->db->insert('wallet_history' ,$insert_wallet_history);

        $insert_coins_notification = array(
                            'user_id' => $user_id,
                            'coins' => $coins,
                            'add_deduct' => '1'
        );
        $this->db->insert('notifications',$insert_coins_notification);
        $this -> notification -> get_ids_and_fields($insert_coins_notification,$user_id);

        } elseif($action == 'deduct') {

        $this->db->where('user_id', $user_id);                      
        $this->db->set("coins", "coins - $coins", FALSE);
        $this->db->update('coins');

        $deductadded_coins = array(
                              'user_id' => $user_id,
                              'coins' => $coins,
                              'previous_coins' => $result['coins'],
                              'new_game_coins' => $result['coins'] - $coins,
                              'type' => $action,
                              'created_date' => date('Y-m-d H:i:s')
                        );

        $this->db->insert('added_game_coins', $deductadded_coins);


        $insert_wallet_history = array(
                            'user_id' => $user_id,
                            'coins' => $coins,
                            'type' => '4',
                            'created_date' => date('Y-m-d h:i:s')
        );

        $this->db->insert('wallet_history' ,$insert_wallet_history);

        $insert_coins_notification = array(
                            'user_id' => $user_id,
                            'coins' => $coins,
                            'add_deduct' => '2'
        );
        $this->db->insert('notifications',$insert_coins_notification);
        $this -> notification -> get_ids_and_fields($insert_coins_notification,$user_id);

        }

    }



    function add_update_game( $inputs ) {

            $uid = $inputs[ 'user_id' ];
            $game_id = $inputs[ 'game_id' ];
            $max_players = $inputs[ 'max_players' ];
            $topic_id = implode(',',$inputs['topics']);
            /*$initial_game_points = $inputs[ 'initial_game_points' ];*/
            $req_game_points = $inputs[ 'req_game_points' ];
            //$game_points are initial portfolio points of user,display after User entered in prediction
            $initial_game_points = $inputs[ 'initial_game_points' ];
           /*$max_game_points = $inputs[ 'max_game_points' ];*/
            $title = $inputs[ 'title' ];
            /*$link = $inputs[ 'link' ];*/
            $description = $inputs[ 'description' ];
            $reward = $inputs[ 'reward' ];
            $start_date = date('Y-m-d H:i:s', strtotime($inputs['start_date'].date("G:i", strtotime($inputs['start_time']))));
            $end_date = date('Y-m-d H:i:s', strtotime($inputs['end_date'].date("G:i", strtotime($inputs['end_time']))));
            $start_time = date("G:i", strtotime($inputs['start_time']));
            $end_time = date("G:i", strtotime($inputs['end_time']));
            $image_uploaded = $inputs[ 'uploaded_filename' ];
            $meta_description = $inputs[ 'meta_description'];
            $meta_keywords = $inputs[ 'meta_keywords' ];
            $meta_keywords = $inputs[ 'meta_keywords' ];
            $is_published = $inputs['is_published'];
            $reward_description =  $inputs['reward_description'];
            $price = $inputs['price']; 
            $reward_array = array_combine($reward_description,$price);
            $is_reward_change = $inputs[ 'is_reward_change' ];
            $change_prediction_time = $inputs[ 'change_prediction_time' ];
            /*print_r($is_reward_change);exit();*/
            $bonus_point_yes_right = @$inputs['bonus_point_yes_right'];
            //$deduct_point_yes_wrong = $inputs['deduct_point_yes_wrong'];
            $deduct_point_yes_wrong = 0;
            $bonus_point_no_wrong = @$inputs['bonus_point_no_wrong'];
            $deduct_point_no_right = @$inputs['deduct_point_no_right'];
           
            $coin_transfer_limit = $inputs['coin_transfer_limit'];
            $point_value_per_coin = $inputs['point_value_per_coin'];

            $bonus_point_yes_right = $inputs['bonus_point_yes_right'];
            //$deduct_point_yes_wrong = $inputs['deduct_point_yes_wrong'];
            $deduct_point_yes_wrong = 0;
            $bonus_point_no_wrong = $inputs['bonus_point_no_wrong'];
            $deduct_point_no_right = $inputs['deduct_point_no_right'];
            $coin_transfer_limit = $inputs['coin_transfer_limit'];
            $point_value_per_coin = $inputs['point_value_per_coin'];

        
        //print_r($end_date);die;


            if ( $game_id == 0 ) {
                    //insert Polls
                    $insert_game = array (
                        "topic_id" => $topic_id,
                        "title" => $title,
                        /*"link" => $link,*/
                        "description" => $description,
                        "reward" => $reward,
                        "image" => $image_uploaded,
                        "req_game_points" => $req_game_points,
                        "initial_game_points" => $initial_game_points,
                        /*"max_game_points" => $max_game_points,*/
                        "max_players" => $max_players,
                        "start_date" => $start_date,
                        "end_date" => $end_date,
                        "start_time" => $start_time,
                        "end_time" => $end_time,
                        "meta_keywords" => $meta_keywords,
                        "meta_description" => $meta_description,
                        "is_published" => $is_published,
                        "change_prediction_time" => $change_prediction_time,
                        "is_active" => "1",
                        "created_date" =>date('Y-m-d H:i:s'),
                        "created_by" => $uid,
                        "bonus_point_yes_right"=>$bonus_point_yes_right,
                        "deduct_point_yes_wrong"=>$deduct_point_yes_wrong,
                        "bonus_point_no_wrong"=>$bonus_point_no_wrong,
                        "deduct_point_no_right"=>$deduct_point_no_right,
                        "coin_transfer_limit"=>$coin_transfer_limit,
                        "point_value_per_coin"=>$point_value_per_coin,
                    );

            
                 
                    $this -> db -> insert( 'games', $insert_game );
                    $game_id = $this -> db -> insert_id();
                    if ($is_published==1) {
                        $game_notification = array('game_id' => $game_id, 'game_title' => $title, 'game_image' => $image_uploaded);
                        $this->insert_game_notification($game_notification,'add_game');     //insert new game notification
                    }
                    //insert Rewards
                    foreach ( $reward_array as $des => $p ) {
                            $games_reward[] = array (
                                "game_id" => $game_id,
                                "description" => $des,
                                "price" => $p,
                            );
                    }

                    $this -> db -> insert_batch( 'games_reward', $games_reward );

                } else {

                    $update_game = array (
                            "topic_id" => $topic_id,
                            "title" => $title,
                            /*"link" => $link,*/
                            "description" => $description,
                            "reward" => $reward,
                            "image" => $image_uploaded,
                            "req_game_points" => $req_game_points,
                            "initial_game_points" => $initial_game_points,
                            /*"max_game_points" => $max_game_points,*/
                            "max_players" => $max_players,
                            "start_date" => $start_date,
                            "end_date" => $end_date,
                            "start_time" => $start_time,
                            "end_time" => $end_time,
                            "meta_keywords" => $meta_keywords,
                            "meta_description" => $meta_description,
                            "is_published" => $is_published,                            
                            "change_prediction_time" => $change_prediction_time,
                            "is_active" => "1",
                            "modified_date" =>date('Y-m-d H:i:s'),
                            "modified_by" => $uid,
                            "bonus_point_yes_right"=>$bonus_point_yes_right,
                            "deduct_point_yes_wrong"=>$deduct_point_yes_wrong,
                            "bonus_point_no_wrong"=>$bonus_point_no_wrong,
                            "deduct_point_no_right"=>$deduct_point_no_right,
                            "coin_transfer_limit"=>$coin_transfer_limit,
                            "point_value_per_coin"=>$point_value_per_coin,
                            );

                            $old_game_data = $this->find_old_game_data($game_id);  
                            $game_result=array_diff($update_game,$old_game_data);
                            $game_result['game_id']=$game_id;
                            $game_result['user_id']=$uid;
                            $game_result['table_name']="games";
                            $order_history_value=game_history_update($game_result);
                        //     print_r($order_history_value);die;

                            if ( $image_uploaded != "" ) {
                                    $update_game[ 'image' ] = $image_uploaded;
                            }

                            $this -> db -> where( array ( "id" => $game_id ) );
                            $this -> db -> update( 'games', $update_game );
                            /* Update games details */  
                            if ($is_published==1) {
                                $game_notification = array('game_id' => $game_id, 'game_title' => $title, 'game_image' => $image_uploaded);
                                $this->insert_game_notification($game_notification,'update_game');     //insert game notification if does not exist
                            }

                        if ( $is_reward_change == "1" ) {
                            
                        /* Delete old choices */
                            $this -> db -> where( "game_id = '$game_id'" );
                            $this -> db -> delete( 'games_reward' );
                            /* Delete old choices */
                        // //insert New Choices
                        // print_r($reward_array);
                        // echo"---------------";
                           foreach ( $reward_array as $des => $p ) {
                            $games_reward[] = array (
                                "game_id" => $game_id,
                                "description" => $des,
                                "price" => $p,
                            );
                         }
                        //  print_r($games_reward);die;
                    $this -> db -> insert_batch( 'games_reward', $games_reward );
                    }
            }

        }

        function get_poll_choice_count( $poll_id ) {
                $this -> db -> select( "count(1) as total_choices" );
                $this -> db -> from( "poll_choices" );
                $this -> db -> where( "poll_id = '$poll_id'" );
                $result = $this -> db -> get() -> row_array();
                return $result[ 'total_choices' ];

        }

        function approve_poll( $inputs ) {
                $poll_id = $inputs[ 'poll_id' ];
                $user_id = $inputs[ 'user_id' ];

                $update = array (
                    "is_approved" => "1",
                    "approved_by" => $user_id
                );

                $this -> db -> where( "id = '$poll_id'" );
                $this -> db -> update( "poll", $update );

                return TRUE;

        }

        function active_inactive_game_mod( $inputs ) {
                $game_id = $inputs[ 'game_id' ];
                $type = $inputs[ 'type' ];
                
                $update = array (
                    "is_active" => 0
                );
                $this -> db -> where( "id = '$game_id'" );
                $this -> db -> update( "games", $update );
                return TRUE;

        }

        private function insert_game_notification($game_notification,$type){
                // echo "cc";
            if ($type=='add_game') {
                $this->db->insert('notifications', $game_notification);
                $this -> notification -> get_ids_and_fields($game_notification,'All');
            }else if($type=='update_game'){
                $game_id = $game_notification['game_id'];
                $this->db->select('id');
                $this->db->from('notifications');
                $this->db->where("game_id = $game_id AND prediction_id IS NULL");
                $result = $this->db->get()->result_array();
                if (empty($result)) {
                        $this->db->insert('notifications', $game_notification);
                        $this->db->select('user_id');
                        $this->db->from('points');
                        $this->db->where("game_id = $game_id");
                        $user_id = $this->db->get()->result_array();
                        // echo $this->db->last_query();
                        // print_r($user_id);die;
                    $this -> notification -> get_ids_and_fields($game_notification,$user_id);
                }
            }
        }

}
