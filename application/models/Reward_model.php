<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Reward_model extends CI_Model {

        function __construct() {
                parent::__construct();
                $this->load->library('MY_Form_validation');
               

        }

        function get_list( $offset = 0 ) {
                $this -> db -> select( "r.*" );
                $this -> db -> from( "rewards r" );
                $this -> db -> where( 'r.is_active=', 1 );
                $this -> db -> order_by( "r.id DESC" );
                $this -> db -> limit( 10, $offset );
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

          public function validate_reward(){
                
            $this->form_validation->set_rules($this->config->item('Reward','validation_rules'));
            if($this->form_validation->run() == FALSE){
                    return FALSE;
                } else {
                    
                    return TRUE;
                  }
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


        function get_games_list() {
                $this -> db -> select( "g.*,t.topic" );
                $this -> db -> from( "games g" );
                $this -> db -> join( "topics t", "g.topic_id = t.id");
                $this -> db -> order_by( "g.id DESC" );
                $res=$this -> db -> get() -> result_array();
                // echo $this->db->last_query();die();
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

                $this -> db -> select( "r.*" );
                $this -> db -> from( "rewards r" );

               /* if ( $title != "" ) {
                        $this -> db -> where( "title like '%$title%'" );
                }
                
                if ( $start_date != "" ) {
                        $this -> db -> where( 'g.start_date >=', $start_date );
                }

                if ( $end_date != "" ) {
                        $this -> db -> where( 'g.end_date <=', $end_date );
                }*/
                $this -> db -> where( 'r.is_active=', 1 );
                $this -> db -> order_by( "r.id DESC" );
                $this -> db -> limit( 10, $offset );
               
                return $this -> db -> get() -> result_array();
                /* print_r($this->db->last_query());
                 exit();*/
               
             

        }

        function get_filtered_list_exported( $inputs ) {
                $topicname = '';
                $description = '';
                $startdate = '';
                $enddate = '';

                if ( isset( $inputs[ 'topic_id' ] ) ) {
                        $topicname = $inputs[ 'topic_id' ];
                }

                if ( isset( $inputs[ 'poll_desc' ] ) ) {
                        $description = $inputs[ 'poll_desc' ];
                }
                if ( isset( $inputs[ 'start_date' ] ) ) {
                        $startdate = $inputs[ 'start_date' ];
                }
                if ( isset( $inputs[ 'end_date' ] ) ) {
                        $enddate = $inputs[ 'end_date' ];
                }

                $start_date = date( "y-m-d", strtotime( $startdate ) );
                $end_date = date( "y-m-d", strtotime( $enddate ) );

                $this -> db -> select( "p.*,pc.name as category,group_concat(pch.choice) as choices,right_choice" );
                $this -> db -> from( "poll p" );
                if ( $topicname != "" ) {
                        $this -> db -> where( 'topic_id', $topicname );
                }
                // if ($question != "") {
                //     $this->db->where('', $question);
                // }
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


        function get_reward_details( $reward_id ) {
                $this -> db -> select( "r.*" );
                $this -> db -> from( "rewards r" );
                $this -> db -> where( "id = '$reward_id'" );
                $reward_data = $this -> db -> get() -> row_array();
                return $reward_data;

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





        function add_update_reward( $inputs ) {

                $uid = $inputs[ 'user_id' ];
                $reward_id = $inputs['reward_id'];
                $title = $inputs[ 'title' ];
                $req_coins = $inputs[ 'req_coins'];
                $is_published = $inputs[ 'is_published' ];
                $image_uploaded = $inputs[ 'uploaded_filename' ];
                if ( $reward_id == 0 ) {
                        //insert Rewards
                        $insert_reward = array (
                            "title" => $title,
                            "req_coins" => $req_coins,
                            "image" => $image_uploaded,
                            "is_published" => $is_published,
                            "is_active" => "1",
                            "created_date" =>date('Y-m-d H:i:s'),
                        );

                        $this -> db -> insert( 'rewards', $insert_reward );
                        $reward_id = $this -> db -> insert_id();
                        

                    } else {

                        $update_reward = array (

                                "title" => $title,
                                "req_coins" => $req_coins,
                                "is_published" => $is_published,
                                "is_active" => "1",
                                "modified_date" =>date('Y-m-d H:i:s'),
                                );

                            if ( $image_uploaded != "" ) {
                                        $update_reward[ 'image' ] = $image_uploaded;
                                }

                            $this -> db -> where( array ( "id" => $reward_id ) );
                            $this -> db -> update( 'rewards', $update_reward );
                                /* Update Reward details */

                     }

        }


        function changepublishreward( $id, $newstatus ) {

                $this -> db -> where( 'id', $id );
                $this -> db -> update( "rewards", array ( 'is_published' => $newstatus ) );
                if ( $newstatus == 0 ) {
                        return FALSE;
                } else {
                        return TRUE;
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

        function active_inactive_reward_mod( $inputs ) {
                $reward_id = $inputs[ 'reward_id' ];
                $type = $inputs[ 'type' ];
                
                $update = array (
                    "is_active" => 0,
                    "is_published" => 0,
                );
                $this -> db -> where( "id = '$reward_id'" );
                $this -> db -> update( "rewards", $update );
                return TRUE;

        }

}
