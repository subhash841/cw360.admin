<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Wall_model extends CI_Model {

        function __construct() {
                parent::__construct();
        }

        function special_character( $string ) {
                $string = str_replace( "'", "&#039;", $string );
                $string = str_replace( '"', '&#039;', $string );
                return $string;
        }

        function get_wall_details( $id ) {
                if ( $id !== 0 ) {
                        $this -> db -> select( 'f.id,f.title,f.image' );
                        $this -> db -> where( 'f.id', $id );
                        $this -> db -> from( 'forums f' );
                        $result = $this -> db -> get() -> result_array();
                        $result[ 0 ][ 'topic_associated' ] = $this -> get_wall_topics( $result[ 0 ][ 'id' ] );
                        return $result;
                }
        }

        function get_wall_topics( $postid ) {
                $this -> db -> select( "ta.topic_id,ta.type, t.topic" );
                $this -> db -> from( "topic_association ta" );
                $this -> db -> join( "topics t", "ta.topic_id = t.id", "INNER" );
                $this -> db -> where( "ta.post_id = '$postid' AND ta.type = 'Wall'" );
                $result = $this -> db -> get() -> result_array();

                return $result;
        }

        function get_wall_list( $offset = 0 ) {
                if ( $offset > 0 || $offset == 0 ) {
                        $this -> db -> select( 'f.id, f.title ,f.created_date ,f.is_active' );
                        $this -> db -> from( 'forums f' );
                        $this -> db -> order_by( 'f.id DESC' );
                        $this -> db -> limit( 10, $offset );
                        $result = $this -> db -> get() -> result_array();
                        return $result;
                } else {
                        $this -> db -> select( 'f.id, f.title ,f.created_date ,f.is_active' );
                        $this -> db -> from( 'forums f' );
                        $this -> db -> order_by( 'f.id DESC' );
                        $result = $this -> db -> get() -> result_array();
                        return $result;
                }
        }

        function active_inactive_wall_mod( $inputs ) {
                $survey_id = $inputs[ 'survey_id' ];
                $type = $inputs[ 'type' ];
                $current = $inputs[ 'current' ];

                $current = ($current == "1") ? 0 : 1;

                $update = array (
                    "is_active" => $current
                );

                $this -> db -> where( "id = '$survey_id'" );
                $this -> db -> update( "forums", $update );

                return TRUE;
        }

        function wall_detail( $id ) {
                $this -> db -> select( 'f.total_like,f.total_neutral,f.total_dislike,f.image,f.title,f.created_date,ta.title' );
                $this -> db -> from( 'forums f' );
                $this -> db -> join( 'topic_association ta', "ta.post_id=f.id AND ta.post_id = $id AND ta.type = 'Wall'", 'inner' );
                $result = $data = $this -> db -> get() -> result_array();
                return $result;
        }

        function add_update_wall( $inputs ) {
                $wall_id = $inputs[ 'wall_id' ];
                $title = $this -> special_character( $inputs[ 'wall_title' ] );
                $topics = $inputs[ 'topics' ];
                $image = $inputs[ 'uploaded_filename' ];
                $is_topic_change = $inputs[ 'is_topic_change' ];

                if ( $wall_id > 0 ) {

                        $update_array = array (
                            "title" => $title,
                            "image" => $image
                        );

                        $this -> db -> where( array ( "id" => $wall_id ) );
                        $this -> db -> update( "forums", $update_array );

                        if ( $is_topic_change != "0" ) {
                                //delete all the existing Topics of paricular question
                                $this -> db -> where( "post_id = '$wall_id' AND type = 'Wall'" );
                                $this -> db -> delete( "topic_association" );

                                //Question topics update
                                foreach ( $topics as $tp ) {
                                        $topics_insert[] = array (
                                            "topic_id" => $tp,
                                            "post_id" => $wall_id,
                                            "title" => $title,
                                            "description" => "",
                                            "type" => "Wall"
                                        );
                                }
                                $this -> db -> insert_batch( 'topic_association', $topics_insert );
                        }
                        return TRUE;
                } else {

                        $insert_array = array (
                            "title" => $title,
                            "image" => $image
                        );

                        $this -> db -> insert( "forums", $insert_array );
                        $last_wall_id = $this -> db -> insert_id();

                        //Wall topics addition
                        foreach ( $topics as $tp ) {
                                $topics_insert[] = array (
                                    "topic_id" => $tp,
                                    "post_id" => $last_wall_id,
                                    "title" => $title,
                                    "description" => "",
                                    "type" => "Wall"
                                );
                        }
                        $this -> db -> insert_batch( 'topic_association', $topics_insert );
                        return TRUE;
                }
        }

        function wall_mod_filter( $inputs ) {
                $title = '';
                $startdate = '';
                $enddate = '';
                if ( isset( $inputs[ 'wall_title' ] ) ) {
                        $title = $inputs[ 'wall_title' ];
                }
                if ( isset( $inputs[ 'start_date' ] ) ) {
                        $startdate = $inputs[ 'start_date' ];
                }
                if ( isset( $inputs[ 'end_date' ] ) ) {
                        $enddate = $inputs[ 'end_date' ];
                }
                $start_date = date( "y-m-d", strtotime( $startdate ) );
                $end_date = date( "y-m-d", strtotime( $enddate ) );
                $this -> db -> select( 'f.id, f.title ,f.created_date ,f.is_active' );
                $this -> db -> from( 'forums f' );

                if ( $title != "" ) {
                        $this -> db -> like( 'f.title', $title );
                }
                if ( $startdate != "" ) {
                        $this -> db -> where( 'f.created_date >=', $start_date );
                }
                if ( $enddate != "" ) {
                        $this -> db -> where( 'f.created_date <=', $end_date );
                }

                $result = $this -> db -> get() -> result_array();
                return $result;
        }

}
