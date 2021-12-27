<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Survey_model extends CI_Model {

        function __construct() {
                parent::__construct();

        }

        function get_list( $offset = 0 ) {
                $this -> db -> select( "p.*,group_concat(pch.choice) as choices" );
                $this -> db -> from( "survey p" );
                //$this->db->join("survey_category pc", "pc.id = p.category_id", "INNER");
                $this -> db -> join( "survey_choices pch", "pch.survey_id = p.id", "INNER" );
                $this -> db -> group_by( "p.id" );
                $this -> db -> order_by( "p.is_approved ASC, p.id DESC" );
                $this -> db -> limit( 10, $offset );
                return $this -> db -> get() -> result_array();

        }

        function get_topic_list() {
                $this -> db -> select( "*" );
                $this -> db -> from( "topics" );
                return $this -> db -> get() -> result_array();

        }

        function get_filtered_list( $inputs ) {
                //$offset = 0;
                $topicname = $inputs[ 'topic_id' ];
                $question = $inputs[ 'survey_quest' ];
                $description = $inputs[ 'survey_desc' ];
                $startdate = $inputs[ 'start_date' ];
                $enddate = $inputs[ 'end_date' ];
                $offset = $inputs[ 'offSet' ];

                $start_date = date( "y-m-d", strtotime( $startdate ) );
                $end_date = date( "y-m-d", strtotime( $enddate ) );

                $this -> db -> select( "p.*,group_concat(pch.choice) as choices" );
                $this -> db -> from( "survey p" );
                if ( $topicname != "" ) {
                        $this -> db -> where( 'topic_id', $topicname );
                }
                if ( $question != "" ) {
                        $this -> db -> where( "question like '%$question%'" );
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
                //$this -> db -> join("survey_category pc", "pc.id = p.category_id", "INNER");
                $this -> db -> join( "survey_choices pch", "pch.survey_id = p.id", "INNER" );
                $this -> db -> group_by( "p.id" );
                $this -> db -> order_by( "p.is_approved ASC, p.id DESC" );
                $this -> db -> limit( 10, $offset );
                return $this -> db -> get() -> result_array();

        }

        function get_filtered_list_exported( $inputs ) {
                $topicname = '';
                $question = '';
                $description = '';
                $startdate = '';
                $enddate = '';
                if ( isset( $inputs[ 'topic_id' ] ) ) {
                        $topicname = $inputs[ 'topic_id' ];
                }
                if ( isset( $inputs[ 'survey_quest' ] ) ) {
                        $question = $inputs[ 'survey_quest' ];
                }
                if ( isset( $inputs[ 'survey_desc' ] ) ) {
                        $description = $inputs[ 'survey_desc' ];
                }
                if ( isset( $inputs[ 'start_date' ] ) ) {
                        $startdate = $inputs[ 'start_date' ];
                }
                if ( isset( $inputs[ 'end_date' ] ) ) {
                        $enddate = $inputs[ 'end_date' ];
                }

                $start_date = date( "y-m-d", strtotime( $startdate ) );
                $end_date = date( "y-m-d", strtotime( $enddate ) );

                $this -> db -> select( "p.*,group_concat(pch.choice) as choices" );
                $this -> db -> from( "survey p" );
                if ( $topicname != "" ) {
                        $this -> db -> where( 'topic_id', $topicname );
                }
                if ( $question != "" ) {
                        $this -> db -> where( 'question', $question );
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
                //$this -> db -> join("survey_category pc", "pc.id = p.category_id", "INNER");
                $this -> db -> join( "survey_choices pch", "pch.survey_id = p.id", "INNER" );
                $this -> db -> group_by( "p.id" );
                $this -> db -> order_by( "p.is_approved ASC, p.id DESC" );
                return $this -> db -> get() -> result_array();

        }

        function get_details_survey( $survey_id ) {
                $this -> db -> select( "p.*,COALESCE(u.name,'') as user, t.topic as topic" );
                $this -> db -> from( "survey p" );
                //$this->db->join("survey_category pc", "pc.id = p.category_id", "INNER");
                $this -> db -> join( "users u", "u.id = p.user_id", "LEFT" );
                $this -> db -> join( "topics t", "t.id = p.topic_id", "LEFT" );
                $this -> db -> where( "p.id = '$survey_id'" );
                $survey_data = $this -> db -> get() -> row_array();

                $this -> db -> select( "pc.*" );
                $this -> db -> from( "survey_choices pc" );
                $this -> db -> where( "survey_id = '$survey_id'" );
                $survey_data[ 'choices' ] = $this -> db -> get() -> result_array();

                return $survey_data;

        }

        function get_survey_count( $survey_id ) {
                $this -> db -> select( "count(1) as total_surveys" );
                $this -> db -> from( "survey_comments" );
                $this -> db -> where( "id = '$survey_id'" );
                $survey_count[ 'surveys' ] = $this -> db -> get() -> row_array();

                return $survey_count;

        }

        function get_survey_replies( $survey_id ) {
                $this -> db -> select( "count(1) as total_replies" );
                $this -> db -> from( "survey_comment_reply" );
                $this -> db -> where( "id = '$survey_id'" );
                $survey_reply[ 'replies' ] = $this -> db -> get() -> row_array();
                return $survey_reply;

        }

        function get_user_surveys_filtered( $inputs ) {

                $data_item_list = array ();

                $status = 1;
                $offset = 0;
                $userid = $inputs[ 'user_id' ];
                $status = $inputs[ 'survey_status' ];
                $title = $inputs[ 'survey_quest' ];
                $description = $inputs[ 'survey_desc' ];
                $startdate = $inputs[ 'survey_cstart_date' ];
                $enddate = $inputs[ 'survey_cend_date' ];
                $offset = $inputs[ 'offset' ];

                $start_date = date( "y-m-d", strtotime( $startdate ) );
                $end_date = date( "y-m-d", strtotime( $enddate ) );

                if ( $status == 2 ) {
                        $this -> db -> select( "*" );
                        $this -> db -> from( "survey_action" );
                        if ( $userid != "" ) {
                                $this -> db -> where( 'user_id', $userid );
                        }
                        $participated_survey_list = $this -> db -> get() -> result_array();

                        foreach ( $participated_survey_list as $key => $item ) {
                                array_push( $data_item_list, $item[ 'poll_id' ] );
                        }
                }

                $this -> db -> select( "p.*,group_concat(pch.choice) as choices" );
                $this -> db -> from( "survey p" );
                if ( $status == 2 ) {
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
                $this -> db -> join( "survey_choices pch", "pch.survey_id = p.id", "INNER" );
                $this -> db -> group_by( "p.id" );
                $this -> db -> order_by( "p.is_approved ASC, p.id DESC" );
                $this -> db -> limit( 10, $offset );
                return $this -> db -> get() -> result_array();

        }

        function export_filter_user_surveys( $inputs ) {

                $data_item_list = array ();

                $userid = $title = $description = $startdate = $enddate = "";

                $status = 1;

                if ( isset( $inputs[ 'user_id' ] ) ) {
                        $userid = $inputs[ 'user_id' ];
                }
                if ( isset( $inputs[ 'survey_status' ] ) ) {
                        $status = $inputs[ 'survey_status' ];
                }
                if ( isset( $inputs[ 'survey_quest' ] ) ) {
                        $title = $inputs[ 'survey_quest' ];
                }
                if ( isset( $inputs[ 'survey_desc' ] ) ) {
                        $description = $inputs[ 'survey_desc' ];
                }
                if ( isset( $inputs[ 'survey_cstart_date' ] ) ) {
                        $startdate = $inputs[ 'survey_cstart_date' ];
                }
                if ( isset( $inputs[ 'survey_cend_date' ] ) ) {
                        $enddate = $inputs[ 'survey_cend_date' ];
                }
                //$offset = $inputs[ 'offset' ];

                $start_date = date( "y-m-d", strtotime( $startdate ) );
                $end_date = date( "y-m-d", strtotime( $enddate ) );

                if ( $status == 2 ) {
                        $this -> db -> select( "*" );
                        $this -> db -> from( "survey_action" );
                        if ( $userid != "" ) {
                                $this -> db -> where( 'user_id', $userid );
                        }
                        $participated_survey_list = $this -> db -> get() -> result_array();

                        foreach ( $participated_survey_list as $key => $item ) {
                                array_push( $data_item_list, $item[ 'poll_id' ] );
                        }
                }

                $this -> db -> select( "p.*,group_concat(pch.choice) as choices" );
                $this -> db -> from( "survey p" );
                if ( $status == 2 ) {
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
                $this -> db -> join( "survey_choices pch", "pch.survey_id = p.id", "INNER" );
                $this -> db -> group_by( "p.id" );
                $this -> db -> order_by( "p.is_approved ASC, p.id DESC" );
                return $this -> db -> get() -> result_array();

        }

        function get_survey_details( $survey_id ) {
                $this -> db -> select( "p.*,COALESCE(u.name,'') as user" );
                $this -> db -> from( "survey p" );
                //$this->db->join("survey_category pc", "pc.id = p.category_id", "INNER");
                $this -> db -> join( "users u", "u.id = p.user_id", "LEFT" );
                $this -> db -> where( "p.id = '$survey_id'" );
                $survey_data = $this -> db -> get() -> row_array();
                $this -> db -> select( "ta.*,t.topic" );
                $this -> db -> from( "topic_association ta" );
                $this -> db -> where( "post_id = '$survey_id'" );
                $this -> db -> join( "topics t", "t.id = ta.topic_id", "INNER" );
                $topic_associated = $this -> db -> get() -> result_array();
                if ( ! empty( $topic_associated ) ) {
                        $survey_data[ 'topic_associated' ] = $topic_associated;
                } else {
                        $survey_data[ 'topic_associated' ] = array ();
                }
                $this -> db -> select( "pc.*" );
                $this -> db -> from( "survey_choices pc" );
                $this -> db -> where( "survey_id = '$survey_id'" );
                $survey_data[ 'choices' ] = $this -> db -> get() -> result_array();

                return $survey_data;

        }

//    function get_survey_category() {
//        $this->db->select("*");
//        $this->db->from("survey_category");
//        $this->db->where("is_active = '1'");
//        return $this->db->get()->result_array();
//    }

        function add_update_survey( $inputs ) {

                $uid          = $inputs[ 'user_id' ];
                $survey_id    = $inputs[ 'survey_id' ];
                $survey_title = $inputs[ 'survey_title' ];
                $survey_desc  = $inputs[ 'survey_desc' ];
                $survey_meta_keywords = $inputs[ 'survey_meta_keywords' ];
                $survey_meta_description = $inputs[ 'survey_meta_description' ];
                //$preview = htmlspecialchars( $inputs[ 'previewdata' ] );
                $preview          = "";
                $image_uploaded   = $inputs[ 'uploaded_filename' ];
                //$survey_category_id = $inputs['survey_category'];
                $choices          = $inputs[ 'choice' ];
                $choicetype       = $inputs[ 'survey_choice' ];
                //$end_date = date("Y-m-d", strtotime($inputs['end_date']));
                $is_topic_change  = $inputs[ 'is_topic_change' ];
                $is_choice_change = $inputs[ 'is_choice_change' ];

                $topics = array ();
                if ( isset( $inputs[ 'topics' ] ) ) {
                        $topics = $inputs[ 'topics' ];
                }

                if ( $survey_id == 0 ) {
                        //insert Polls
                        $insert_survey = array (
                            "user_id" => $uid,
                            "category_id" => 0,
                            "raised_by_admin" => "1",
                            "question" => $survey_title,
                            "description" => $survey_desc,
                            "preview" => $preview,
                            "image" => $image_uploaded,
                            "meta_keywords" => $survey_meta_keywords,
                            "meta_description" => $survey_meta_description,
                            "is_multiple" => $choicetype,
                            "is_approved" => "1",
                            "approved_by" => $uid,
                            "is_active" => "1",
                        );
                        $this -> db -> insert( 'survey', $insert_survey );
                        $surveyid = $this -> db -> insert_id();

                        //insert Choices
                        foreach ( $choices as $key => $ch ) {

                                if ( $ch == "See the Results" ) {
                                        $ctype = 0;
                                } else {
                                        $ctype = 1;
                                }

                                $insert_choices[] = array (
                                    "survey_id" => $surveyid,
                                    "choice" => $ch,
                                    "type" => $ctype,
                                    "is_active" => "1"
                                );
                        }

                        $this -> db -> insert_batch( 'survey_choices', $insert_choices );

                        //insert Topics
                        foreach ( $topics as $key => $ch ) {
                                $insert_topics[] = array (
                                    "topic_id" => $ch,
                                    "post_id" => $surveyid,
                                    "type" => "Survey"
                                );
                        }

                        $this -> db -> insert_batch( 'topic_association', $insert_topics );
                } else {

                        /* Update Poll details */
                        $update_survey = array (
                            "category_id" => 0,
                            //"raised_by_admin" => "1",
                            "question" => $survey_title,
                            "description" => $survey_desc,
                            "is_approved" => "1",
                            "approved_by" => $uid,
                            "preview" => $preview,
                            "meta_keywords" => $survey_meta_keywords,
                            "meta_description" => $survey_meta_description,
                            "is_multiple" => $choicetype,
                            "is_active" => "1",
                        );

                        if ( $is_choice_change == "1" ) {
                                $update_survey[ 'total_votes' ] = 0;
                        }

                        if ( $image_uploaded != "" ) {
                                $update_survey[ 'image' ] = $image_uploaded;
                        }

                        $this -> db -> where( array ( "id" => $survey_id ) );
                        $this -> db -> update( 'survey', $update_survey );
                        /* Update Poll details */

                        //$this -> db -> where( 'poll_id', $survey_id );
                        //$this -> db -> delete( 'survey_comments' );
                        //$this -> db -> where( 'poll_id', $survey_id );
                        //$this -> db -> delete( 'survey_comment_reply' );

                        /* Delete action of users when survey update */
                        //$this -> db -> where( "poll_id = '$survey_id' and action = 'Vote'" );
                        //$this -> db -> delete( 'survey_action' );
                        /* Delete action of users when survey update */

                        if ( $is_topic_change == "1" ) {
                                /* Delete old topic associations */
                                $this -> db -> where( "post_id = '$survey_id' AND type = 'Survey'" );
                                $this -> db -> delete( 'topic_association' );
                                /* Delete old topic associations */

                                //insert New Topics
                                foreach ( $topics as $key => $ch ) {
                                        $insert_topics[] = array (
                                            "topic_id" => $ch,
                                            "post_id" => $survey_id,
                                            "type" => "Survey"
                                        );
                                }

                                $this -> db -> insert_batch( 'topic_association', $insert_topics );
                        }

                        if ( $is_choice_change == "1" ) {
                                $this -> db -> where( 'poll_id', $survey_id );
                                $this -> db -> where( 'action', 'Vote' );
                                $this -> db -> delete( 'survey_action' );
                                
                                /* Delete old choices */
                                $this -> db -> where( "survey_id = '$survey_id'" );
                                $this -> db -> delete( 'survey_choices' );
                                /* Delete old choices */

                                //insert New Choices
                                foreach ( $choices as $key => $ch ) {
                                        if ( $ch == "See the Results" ) {
                                                $ctype = 0;
                                        } else {
                                                $ctype = 1;
                                        }

                                        $insert_choices[] = array (
                                            "survey_id" => $survey_id,
                                            "choice" => $ch,
                                            "type" => $ctype,
                                            "is_active" => "1"
                                        );
                                }
                                $this -> db -> insert_batch( 'survey_choices', $insert_choices );
                        }
                }

        }

        function approve_survey( $inputs ) {
                $survey_id = $inputs[ 'survey_id' ];
                $user_id = $inputs[ 'user_id' ];

                $update = array (
                    "is_approved" => "1",
                    "approved_by" => $user_id
                );

                $this -> db -> where( "id = '$survey_id'" );
                $this -> db -> update( "survey", $update );

                return TRUE;

        }

        function active_inactive_survey_mod( $inputs ) {
                $survey_id = $inputs[ 'survey_id' ];
                $type = $inputs[ 'type' ];
                $current = $inputs[ 'current' ];

                $current = ($current == "1") ? 0 : 1;

                $update = array (
                    "is_active" => $current
                );

                $this -> db -> where( "id = '$survey_id'" );
                $this -> db -> update( "survey", $update );

                return TRUE;

        }
        
        function stop_active_survey_mod( $inputs ) {
                $survey_id = $inputs[ 'survey_id' ];
                $type = $inputs[ 'type' ];
                $current = $inputs[ 'current' ];

                $current = ($current == "1") ? 0 : 1;

                $update = array (
                    "is_stop" => $current
                );

                $this -> db -> where( "id = '$survey_id'" );
                $this -> db -> update( "survey", $update );

                return TRUE;

        }

}
