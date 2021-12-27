<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class FromTheWeb_model extends CI_Model {

        function __construct() {
                parent::__construct();
        }

        function special_character( $string ) {
                $string = str_replace( "'", "&#039;", $string );
                $string = str_replace( '"', '&#039;', $string );
                return $string;
        }

        function get_list( $offset = 0 ) {
                $this -> db -> select( "id,title,description,is_active,created_date" );
                $this -> db -> from( "web w" );
                $this -> db -> order_by( "w.is_active ASC" );
                if ( $offset > 0 || $offset == 0 ) {
                        $this -> db -> limit( 10, $offset );
                }

                return $this -> db -> get() -> result_array();
        }

        function get_web_details( $id ) {
                if ( $id !== 0 ) {
                        $this -> db -> select( 'w.id,w.title,w.image,w.description,w.data' );
                        $this -> db -> where( 'w.id', $id );
                        $this -> db -> from( 'web w' );
                        $result = $this -> db -> get() -> result_array();
                        $result[ 0 ][ 'topic_associated' ] = $this -> get_web_topics( $result[ 0 ][ 'id' ] );
                        return $result;
                }
        }

        function get_web_topics( $postid ) {
                $this -> db -> select( "ta.topic_id,ta.type, t.topic" );
                $this -> db -> from( "topic_association ta" );
                $this -> db -> join( "topics t", "ta.topic_id = t.id", "INNER" );
                $this -> db -> where( "ta.post_id = '$postid' AND ta.type = 'Web'" );
                $result = $this -> db -> get() -> result_array();

                return $result;
        }

        function active_inactive_web_mod( $inputs ) {
                $web_id = $inputs[ 'web_id' ];
                $type = $inputs[ 'type' ];
                $current = $inputs[ 'current' ];

                $current = ($current == "1") ? 0 : 1;

                $update = array (
                    "is_active" => $current
                );

                $this -> db -> where( "id = '$web_id'" );
                $this -> db -> update( "web", $update );

                return TRUE;
        }

        function add_update_web( $inputs ) {
                $web_id = $inputs[ 'web_id' ];
                $title = $this -> special_character( $inputs[ 'web_title' ] );
                $desc = $this -> special_character( $inputs[ 'web_desc' ] );
                $topics = $inputs[ 'topics' ];
                $image = $inputs[ 'uploaded_filename' ];
                $is_topic_change = $inputs[ 'is_topic_change' ];
                $json = $inputs[ 'json_data' ];

                if ( $web_id > 0 ) {

                        $update_array = array (
                            "title" => $title,
                            "image" => $image,
                            "description" => $desc,
                            "data" => $json
                        );

                        $this -> db -> where( array ( "id" => $web_id ) );
                        $this -> db -> update( "web", $update_array );

                        if ( $is_topic_change != "0" ) {
                                //delete all the existing Topics of paricular question
                                $this -> db -> where( "post_id = '$web_id ' AND type = 'Web'" );
                                $this -> db -> delete( "topic_association" );

                                //Question topics update
                                foreach ( $topics as $tp ) {
                                        $topics_insert[] = array (
                                            "topic_id" => $tp,
                                            "post_id" => $web_id,
                                            "title" => $title,
                                            "description" => "",
                                            "type" => "Web"
                                        );
                                }
                                $this -> db -> insert_batch( 'topic_association', $topics_insert );
                        }

                        return TRUE;
                } else {

                        $insert_array = array (
                            "title" => $title,
                            "image" => $image,
                            "description" => $desc,
                            "data" => $json
                        );

                        $this -> db -> insert( "web", $insert_array );
                        $last_web_id = $this -> db -> insert_id();

                        //Wall topics addition
                        foreach ( $topics as $tp ) {
                                $topics_insert[] = array (
                                    "topic_id" => $tp,
                                    "post_id" => $last_web_id,
                                    "title" => $title,
                                    "description" => "",
                                    "type" => "Web"
                                );
                        }
                        $this -> db -> insert_batch( 'topic_association', $topics_insert );
                        return TRUE;
                }
        }

        function web_mod_filter( $inputs ) {
                $title = '';
                $startdate = '';
                $enddate = '';
                if ( isset( $inputs[ 'web_title' ] ) ) {
                        $title = $inputs[ 'web_title' ];
                }
                if ( isset( $inputs[ 'start_date' ] ) ) {
                        $startdate = $inputs[ 'start_date' ];
                }
                if ( isset( $inputs[ 'end_date' ] ) ) {
                        $enddate = $inputs[ 'end_date' ];
                }
                $start_date = date( "y-m-d", strtotime( $startdate ) );
                $end_date = date( "y-m-d", strtotime( $enddate ) );

                $this -> db -> select( "id,title,description,is_active,created_date" );
                $this -> db -> from( "web w" );
                if ( $title != "" ) {
                        $this -> db -> like( 'w.title', $title );
                }
                if ( $startdate != "" ) {
                        $this -> db -> where( 'w.created_date >=', $start_date );
                }
                if ( $enddate != "" ) {
                        $this -> db -> where( 'w.created_date <=', $end_date );
                }
                $this -> db -> order_by( "w.is_active ASC" );
                $result = $this -> db -> get() -> result_array();
                return $result;
        }

//        function get_topic_list () {
//            $this -> db -> select ("*");
//            $this -> db -> from ("web");
//            return $this -> db -> get() -> result_array();
//        }
//        function get_filtered_list( $inputs ) {
//                //$offset = 0;
//                $topicname = $inputs[ 'topic_id' ];
//                $question = $inputs[ 'article_quest' ];
//                $description = $inputs[ 'article_desc' ];
//                $startdate = $inputs[ 'start_date' ];
//                $enddate = $inputs[ 'end_date' ];
//                $offset = $inputs[ 'offSet' ];
//
//                $start_date = date( "y-m-d", strtotime( $startdate ) );
//                $end_date = date( "y-m-d", strtotime( $enddate ) );
//
//                $this -> db -> select( "p.*, group_concat(pch.choice) as choices" );
//                $this -> db -> from( "article p" );
//                if ( $topicname != "" ) {
//                        $this -> db -> where( 'topic_id', $topicname );
//                }
//                if ( $question != "" ) {
//                        $this -> db -> where( 'question', $question );
//                }
//                if ( $description != "" ) {
//                        $this -> db -> where( 'description', $description );
//                }
//                if ( $startdate != "" ) {
//                        $this -> db -> where( 'p.created_date >=', $start_date );
//                }
//                if ( $enddate != "" ) {
//                        $this -> db -> where( 'p.created_date <=', $end_date );
//                }
//
//                $this -> db -> join( "article_choices pch", "pch.article_id = p.id", "INNER" );
//                $this -> db -> group_by( "p.id" );
//                $this -> db -> order_by( "p.is_approved ASC, p.id DESC" );
//                $this -> db -> limit( 10, $offset );
//                return $this -> db -> get() -> result_array();
//        }
//
//        function get_filtered_list_exported( $inputs ) {
//                $topicname = '';
//                $question = '';
//                $description = '';
//                $startdate = '';
//                $enddate = '';
//                if ( isset( $inputs[ 'topic_id' ] ) ) {
//                        $topicname = $inputs[ 'topic_id' ];
//                }
//                if ( isset( $inputs[ 'article_quest' ] ) ) {
//                        $question = $inputs[ 'article_quest' ];
//                }
//                if ( isset( $inputs[ 'article_desc' ] ) ) {
//                        $description = $inputs[ 'article_desc' ];
//                }
//                if ( isset( $inputs[ 'start_date' ] ) ) {
//                        $startdate = $inputs[ 'start_date' ];
//                }
//                if ( isset( $inputs[ 'end_date' ] ) ) {
//                        $enddate = $inputs[ 'end_date' ];
//                }
//
//                $start_date = date( "y-m-d", strtotime( $startdate ) );
//                $end_date = date( "y-m-d", strtotime( $enddate ) );
//
//                $this -> db -> select( "p.*, group_concat(pch.choice) as choices" );
//                $this -> db -> from( "article p" );
//                if ( $topicname != "" ) {
//                        $this -> db -> where( 'topic_id', $topicname );
//                }
//                if ( $question != "" ) {
//                        $this -> db -> where( 'question', $question );
//                }
//                if ( $description != "" ) {
//                        $this -> db -> where( 'description', $description );
//                }
//                if ( $startdate != "" ) {
//                        $this -> db -> where( 'p.created_date >=', $start_date );
//                }
//                if ( $enddate != "" ) {
//                        $this -> db -> where( 'p.created_date <=', $end_date );
//                }
//
//                $this -> db -> join( "article_choices pch", "pch.article_id = p.id", "INNER" );
//                $this -> db -> group_by( "p.id" );
//                $this -> db -> order_by( "p.is_approved ASC, p.id DESC" );
//                return $this -> db -> get() -> result_array();
//        }
//
//        function get_details_article( $article_id ) {
//                $this -> db -> select( "p.*, COALESCE(u.name, '') as user, t.topic as topic" );
//                $this -> db -> from( "article p" );
//                //$this -> db->join("article_category pc", "pc.id = p.category_id", "INNER");
//                $this -> db -> join( "users u", "u.id = p.user_id", "LEFT" );
//                $this -> db -> join( "topics t", "t.id = p.topic_id", "LEFT" );
//                $this -> db -> where( "p.id = '$article_id'" );
//                $article_data = $this -> db -> get() -> row_array();
//
//                $this -> db -> select( "pc.*" );
//                $this -> db -> from( "article_choices pc" );
//                $this -> db -> where( "article_id = '$article_id'" );
//                $article_data[ 'choices' ] = $this -> db -> get() -> result_array();
//
//                return $article_data;
//        }
//
//        function get_article_count( $article_id ) {
//                $this -> db -> select( "count(1) as total_articles" );
//                $this -> db -> from( "article_comments" );
//                $this -> db -> where( "id = '$article_id'" );
//                $article_count[ 'articles' ] = $this -> db -> get() -> row_array();
//
//                return $article_count;
//        }
//
//        function get_article_replies( $article_id ) {
//                $this -> db -> select( "count(1) as total_replies" );
//                $this -> db -> from( "article_comment_reply" );
//                $this -> db -> where( "id = '$article_id'" );
//                $article_reply[ 'replies' ] = $this -> db -> get() -> row_array();
//                return $article_reply;
//        }
//
//        function get_user_articles_filtered( $inputs ) {
//
//                $data_item_list = array ();
//
//                $status = 1;
//                $userid = $inputs[ 'user_id' ];
//                $status = $inputs[ 'article_status' ];
//                $title = $inputs[ 'article_quest' ];
//                $description = $inputs[ 'article_desc' ];
//                $startdate = $inputs[ 'article_cstart_date' ];
//                $enddate = $inputs[ 'article_cend_date' ];
//                $offset = $inputs[ 'offset' ];
//
//                $start_date = date( "y-m-d", strtotime( $startdate ) );
//                $end_date = date( "y-m-d", strtotime( $enddate ) );
//
//                if ( $status == 2 ) {
//                        $this -> db -> select( "*" );
//                        $this -> db -> from( "article_action" );
//                        if ( $userid != "" ) {
//                                $this -> db -> where( 'user_id', $userid );
//                        }
//                        $participated_article_list = $this -> db -> get() -> result_array();
//
//                        foreach ( $participated_article_list as $key => $item ) {
//                                array_push( $data_item_list, $item[ 'article_id' ] );
//                        }
//                }
//
//                $this -> db -> select( "p.*, group_concat(pch.choice) as choices" );
//                $this -> db -> from( "article p" );
//                if ( $status == 2 ) {
//                        $this -> db -> where_in( 'p.id', $data_item_list );
//                } else {
//                        $this -> db -> where( 'user_id', $userid );
//                }
//                if ( $title != "" ) {
//                        $this -> db -> where( 'question', $title );
//                }
//                if ( $description != "" ) {
//                        $this -> db -> where( 'description', $description );
//                }
//                if ( $startdate != "" ) {
//                        $this -> db -> where( 'p.created_date >=', $start_date );
//                }
//                if ( $enddate != "" ) {
//                        $this -> db -> where( 'p.created_date <=', $end_date );
//                }
//                //$this -> db->join("article_category pc", "pc.id = p.category_id", "INNER");
//                $this -> db -> join( "article_choices pch", "pch.article_id = p.id", "INNER" );
//                $this -> db -> group_by( "p.id" );
//                $this -> db -> order_by( "p.is_approved ASC, p.id DESC" );
//                $this -> db -> limit( 10, $offset );
//                return $this -> db -> get() -> result_array();
//        }
//
//        function export_filter_user_articles( $inputs ) {
//
//                $data_item_list = array ();
//
//                $status = 1;
//
//                $userid = $title = $description = $startdate = $enddate = "";
//
//                if ( isset( $inputs[ 'user_id' ] ) ) {
//                        $userid = $inputs[ 'user_id' ];
//                }
//                if ( isset( $inputs[ 'article_status' ] ) ) {
//                        $status = $inputs[ 'article_status' ];
//                }
//                if ( isset( $inputs[ 'article_quest' ] ) ) {
//                        $title = $inputs[ 'article_quest' ];
//                }
//                if ( isset( $inputs[ 'article_desc' ] ) ) {
//                        $description = $inputs[ 'article_desc' ];
//                }
//                if ( isset( $inputs[ 'article_cstart_date' ] ) ) {
//                        $startdate = $inputs[ 'article_cstart_date' ];
//                }
//                if ( isset( $inputs[ 'article_cend_date' ] ) ) {
//                        $enddate = $inputs[ 'article_cend_date' ];
//                }
//                //$offset = $inputs[  'offset' ];
//
//                $start_date = date( "y-m-d", strtotime( $startdate ) );
//                $end_date = date( "y-m-d", strtotime( $enddate ) );
//
//                if ( $status == 2 ) {
//                        $this -> db -> select( "*" );
//                        $this -> db -> from( "article_action" );
//                        if ( $userid != "" ) {
//                                $this -> db -> where( 'user_id', $userid );
//                        }
//                        $participated_article_list = $this -> db -> get() -> result_array();
//
//                        foreach ( $participated_article_list as $key => $item ) {
//                                array_push( $data_item_list, $item[ 'article_id' ] );
//                        }
//                }
//
//                $this -> db -> select( "p.*, group_concat(pch.choice) as choices" );
//                $this -> db -> from( "article p" );
//                if ( $status == 2 ) {
//                        $this -> db -> where_in( 'p.id', $data_item_list );
//                } else {
//                        $this -> db -> where( 'user_id', $userid );
//                }
//                if ( $title != "" ) {
//                        $this -> db -> where( 'question', $title );
//                }
//                if ( $description != "" ) {
//                        $this -> db -> where( 'description', $description );
//                }
//                if ( $startdate != "" ) {
//                        $this -> db -> where( 'p.created_date >=', $start_date );
//                }
//                if ( $enddate != "" ) {
//                        $this -> db -> where( 'p.created_date <=', $end_date );
//                }
//                //$this -> db->join("article_category pc", "pc.id = p.category_id", "INNER");
//                $this -> db -> join( "article_choices pch", "pch.article_id = p.id", "INNER" );
//                $this -> db -> group_by( "p.id" );
//                $this -> db -> order_by( "p.is_approved ASC, p.id DESC" );
//                //$this -> db ->limit(10, $offset);
//                return $this -> db -> get() -> result_array();
//        }

}
