<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Poll_model extends CI_Model {

        function __construct() {
                parent::__construct();

        }

        function get_list( $offset = 0 ) {
                $this -> db -> select( "p.*,pc.name as category,group_concat(pch.choice) as choices,right_choice" );
                $this -> db -> from( "poll p" );
                $this -> db -> join( "poll_category pc", "pc.id = p.category_id", "LEFT" );
                $this -> db -> join( "poll_choices pch", "pch.poll_id = p.id", "INNER" );
                $this -> db -> group_by( "p.id" );
                $this -> db -> order_by( "p.is_approved ASC, p.id DESC" );
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
//                $this -> db -> limit( 10, $offset );
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
                return $this -> db -> get() -> result_array();

        }

        function get_filtered_list( $inputs ) {

                //$offset = 0;
                $topicname = $inputs[ 'topic_id' ];
                $question = $inputs[ 'poll_quest' ];
                $description = $inputs[ 'poll_desc' ];
                $startdate = $inputs[ 'start_date' ];
                $enddate = $inputs[ 'end_date' ];
                $offset = $inputs[ 'offSet' ];

                $start_date = date( "y-m-d", strtotime( $startdate ) );
                $end_date = date( "y-m-d", strtotime( $enddate ) );

                $this -> db -> select( "p.*,pc.name as category,group_concat(pch.choice) as choices,right_choice" );
                $this -> db -> from( "poll p" );
                if ( $topicname != "" ) {
                        $this -> db -> where( 'topic_id', $topicname );
                }
                if ( $question != "" ) {
                        $this -> db -> where( "poll like '%$question%'" );
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
                $this -> db -> join( "poll_category pc", "pc.id = p.category_id", "LEFT" );
                $this -> db -> join( "poll_choices pch", "pch.poll_id = p.id", "INNER" );
                $this -> db -> group_by( "p.id" );
                $this -> db -> order_by( "p.is_approved ASC, p.id DESC" );
                $this -> db -> limit( 10, $offset );
                return $this -> db -> get() -> result_array();

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

        function get_poll_details( $poll_id ) {
                $this -> db -> select( "p.*, COALESCE(u.name,'') as user" );
                $this -> db -> from( "poll p" );
                //$this -> db -> join( "poll_category pc", "pc.id = p.category_id", "INNER" );
                $this -> db -> join( "users u", "u.id = p.user_id", "LEFT" );
                $this -> db -> where( "p.id = '$poll_id'" );
                $poll_data = $this -> db -> get() -> row_array();

                /* $this -> db -> select( "p.*,pc.name as category, COALESCE(u.name,'') as user" );
                  $this -> db -> from( "poll p" );
                  $this -> db -> join( "poll_category pc", "pc.id = p.category_id", "INNER" );
                  $this -> db -> join( "users u", "u.id = p.user_id", "LEFT" );
                  $this -> db -> where( "p.id = '$poll_id'" );
                  $poll_data = $this -> db -> get() -> row_array(); */

                $this -> db -> select( "ta.*,t.topic" );
                $this -> db -> from( "topic_association ta" );
                $this -> db -> where( "post_id = '$poll_id'" );
                $this -> db -> join( "topics t", "t.id = ta.topic_id", "INNER" );
                $topic_associated = $this -> db -> get() -> result_array();
                if ( ! empty( $topic_associated ) ) {
                        $poll_data[ 'topic_associated' ] = $topic_associated;
                } else {
                        $poll_data[ 'topic_associated' ] = array ();
                }

                $this -> db -> select( "pc.*" );
                $this -> db -> from( "poll_choices pc" );
                $this -> db -> where( "poll_id = '$poll_id'" );
                $poll_data[ 'choices' ] = $this -> db -> get() -> result_array();

                return $poll_data;

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

        function add_update_poll( $inputs ) {

                $uid = $inputs[ 'user_id' ];
                $poll_id = $inputs[ 'poll_id' ];
                $poll_title = $inputs[ 'poll_title' ];
                $poll_desc = $inputs[ 'poll_desc' ];
                //$poll_category_id = $inputs[ 'poll_category' ];
                $choices = $inputs[ 'choice' ];
                $average = $inputs[ 'average' ];
                $preview = htmlspecialchars( $inputs[ 'previewdata' ] );
                $end_date = date( "Y-m-d", strtotime( $inputs[ 'end_date' ] ) );
                $image_uploaded = $inputs[ 'uploaded_filename' ];
                $meta_description = $inputs[ 'meta_description' ];
                $meta_keywords = $inputs[ 'meta_keywords' ];

                $is_topic_change = $inputs[ 'is_topic_change' ];
                $poll_detail_change = $inputs[ 'only_poll_detail_change' ];
                $only_end_date_change = $inputs[ 'only_end_date_change' ];
                $only_avg_change = $inputs[ 'only_avg_change' ];

                $topics = array ();
                if ( isset( $inputs[ 'topics' ] ) ) {
                        $topics = $inputs[ 'topics' ];
                }

                if ( $poll_id == 0 ) {
                        //insert Polls
                        $insert_poll = array (
                            "user_id" => $uid,
                            //"category_id" => $poll_category_id,
                            "category_id" => 0,
                            "raised_by_admin" => "1",
                            "poll" => $poll_title,
                            "description" => $poll_desc,
                            "is_approved" => "1",
                            "approved_by" => $uid,
                            "is_active" => "1",
                            "preview" => $preview,
                            "image" => $image_uploaded,
                            "average" => $average,
                            "end_date" => $end_date,
                            "meta_keywords" => $meta_keywords,
                            "meta_description" => $meta_description,
                        );
                        $this -> db -> insert( 'poll', $insert_poll );
                        $pollid = $this -> db -> insert_id();

                        //insert Choices
                        foreach ( $choices as $key => $ch ) {

                                if ( $ch == "See the Results" ) {
                                        $ctype = 0;
                                } else {
                                        $ctype = 1;
                                }

                                $insert_choices[] = array (
                                    "poll_id" => $pollid,
                                    "choice" => $ch,
                                    "type" => $ctype,
                                    "is_active" => "1"
                                );
                        }

                        $this -> db -> insert_batch( 'poll_choices', $insert_choices );

                        //insert Topics
                        foreach ( $topics as $key => $ch ) {
                                $insert_topics[] = array (
                                    "topic_id" => $ch,
                                    "post_id" => $pollid,
                                    "type" => "Poll"
                                );
                        }

                        $this -> db -> insert_batch( 'topic_association', $insert_topics );
                } else {

                        $already_choices = $this -> get_poll_choice_count( $poll_id );
                        $newchoices = count( $choices );

                        //if new choices count more than already availble choices
                        if ( $poll_detail_change == "1" ) { //$newchoices != $already_choices || 
//                print_r($inputs);
//                echo "inside if";exit;
                                /* Update Poll details */
                                $update_poll = array (
                                    //"category_id" => $poll_category_id,
                                    //"raised_by_admin" => "1",
                                    "category_id" => 0,
                                    "poll" => $poll_title,
                                    "description" => $poll_desc,
                                    "is_approved" => "1",
                                    "approved_by" => $uid,
                                    "is_active" => "1",
                                    "average" => $average,
                                    "end_date" => $end_date,
                                    "preview" => $preview,
                                    "total_votes" => 0,
                                    "total_comments" => 0,
                                    "meta_keywords" => $meta_keywords,
                                    "meta_description" => $meta_description,
                                );

                                if ( $image_uploaded != "" ) {
                                        $update_poll[ 'image' ] = $image_uploaded;
                                }

                                $this -> db -> where( array ( "id" => $poll_id ) );
                                $this -> db -> update( 'poll', $update_poll );
                                /* Update Poll details */

                                /* Delete old choices */
                                $this -> db -> where( "poll_id = '$poll_id'" );
                                $this -> db -> delete( 'poll_choices' );
                                /* Delete old choices */

                                /* Delete old topic associations */
                                if ( $is_topic_change == "1" ) {
                                        /* Delete old topic associations */
                                        $this -> db -> where( "post_id = '$poll_id' AND type = 'Poll'" );
                                        $this -> db -> delete( 'topic_association' );
                                        /* Delete old topic associations */

                                        //insert New Topics
                                        foreach ( $topics as $key => $ch ) {
                                                $insert_topics[] = array (
                                                    "topic_id" => $ch,
                                                    "post_id" => $poll_id,
                                                    "type" => "Poll"
                                                );
                                        }

                                        $this -> db -> insert_batch( 'topic_association', $insert_topics );
                                }
                                /* Delete old topic associations */

                                $this -> db -> where( 'poll_id', $poll_id );
                                $this -> db -> delete( 'poll_comments' );

                                $this -> db -> where( 'poll_id', $poll_id );
                                $this -> db -> delete( 'poll_comment_reply' );
                                //insert New Choices
                                foreach ( $choices as $key => $ch ) {

                                        if ( $ch == "See the Results" ) {
                                                $ctype = 0;
                                        } else {
                                                $ctype = 1;
                                        }

                                        $insert_choices[] = array (
                                            "poll_id" => $poll_id,
                                            "choice" => $ch,
                                            "type" => $ctype,
                                            "is_active" => "1"
                                        );
                                }
                                $this -> db -> insert_batch( 'poll_choices', $insert_choices );

                                //insert New Topics
                                foreach ( $topics as $key => $ch ) {
                                        $insert_topics[] = array (
                                            "topic_id" => $ch,
                                            "post_id" => $poll_id,
                                            "type" => "Poll"
                                        );
                                }

                                $this -> db -> insert_batch( 'topic_association', $insert_topics );

                                /* Delete action of users when poll update */
                                $this -> db -> where( "poll_id = '$poll_id' and action = 'Vote'" );
                                $this -> db -> delete( 'poll_action' );
                                /* Delete action of users when poll update */
                        } else {
                                //echo "inside else";exit;
                                //when only end date or avg change then update those detail only
                                if ( $only_end_date_change == "1" || $only_avg_change == "1" ) {
                                        /* Update Poll details */
                                        $update_poll = array (
                                            "average" => $average,
                                            "end_date" => $end_date,
                                            "meta_keywords" => $meta_keywords,
                                            "meta_description" => $meta_description,
                                        );
                                        if ( $image_uploaded != "" ) {
                                                $update_poll[ 'image' ] = $image_uploaded;
                                        }
                                        $this -> db -> where( array ( "id" => $poll_id ) );
                                        $this -> db -> update( 'poll', $update_poll );
                                        /* Update Poll details */
                                } else {
                                        /* Update Poll details */
                                        $update_poll = array (
                                            "category_id" => $poll_category_id,
                                            //"raised_by_admin" => "1",
                                            "poll" => $poll_title,
                                            "description" => $poll_desc,
                                            "is_approved" => "1",
                                            "approved_by" => $uid,
                                            "is_active" => "1",
                                            "average" => $average,
                                            "end_date" => $end_date,
                                            "preview" => $preview,
                                            "total_comments" => 0,
                                            "meta_keywords" => $meta_keywords,
                                            "meta_description" => $meta_description,
                                        );
                                        if ( $image_uploaded != "" ) {
                                                $update_poll[ 'image' ] = $image_uploaded;
                                        }
                                        $this -> db -> where( array ( "id" => $poll_id ) );
                                        $this -> db -> update( 'poll', $update_poll );

                                        if ( $is_topic_change == "1" ) {
                                                /* Delete old topic associations */
                                                $this -> db -> where( "post_id = '$poll_id' AND type = 'Poll'" );
                                                $this -> db -> delete( 'topic_association' );
                                                /* Delete old topic associations */

                                                //insert New Topics
                                                foreach ( $topics as $key => $ch ) {
                                                        $insert_topics[] = array (
                                                            "topic_id" => $ch,
                                                            "post_id" => $poll_id,
                                                            "type" => "Poll"
                                                        );
                                                }

                                                $this -> db -> insert_batch( 'topic_association', $insert_topics );
                                        }
                                        /* Update Poll details */
                                }
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

        function active_inactive_poll_mod( $inputs ) {
                $poll_id = $inputs[ 'poll_id' ];
                $type = $inputs[ 'type' ];
                $current = $inputs[ 'current' ];

                $current = ($current == "1") ? 0 : 1;

                $update = array (
                    "is_active" => $current
                );

                $this -> db -> where( "id = '$poll_id'" );
                $this -> db -> update( "poll", $update );

                return TRUE;

        }

}
