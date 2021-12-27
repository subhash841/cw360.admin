<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Topics_model extends CI_Model {

        function __construct() {
                parent::__construct();
        }

        function get_topics_list() {

                $this -> db -> select( 't.*, bc.name as categoryname' );
                $this -> db -> from( 'topics t' );
                $this -> db -> join( "blog_category bc", "bc.id = t.category", "LEFT" );
                $this -> db -> order_by("t.id desc");
                $result = $this -> db -> get() -> result_array();
                return $result;
        }

        function add_update_topic( $inputs ) {

                $topicid = $inputs[ 'topicid' ];
                $uploaded_filename = $inputs[ 'uploaded_filename' ];
                $uploaded_icon_filename = $inputs[ 'uploaded_icon_filename' ];
                $category = $inputs[ 'blog_id' ];

                if(isset($inputs[ 'topic_trending' ])){
                    $trending = 1;
                    $trending_date = date('Y-m-d h:i:s');
                } else {
                    $trending = 0;
                    $trending_date = '0000-00-00 00:00:00';
                }

                $data = array (
                    "topic" => $inputs[ 'topic_name' ],
                    "image" => $uploaded_filename,
                    "icon" => $uploaded_icon_filename,
                    "category" => $category,
                    "is_trending" => $trending,
                    'trending_created_date' => $trending_date
                );

                if ( $topicid == 0 ) {

                    $data['created_date']=date('Y-m-d h:i:s');
                    $this -> db -> insert( "topics", $data );

                } else {

                        $data['modified_date']=date('Y-m-d h:i:s');
                        $this -> db -> where( "id = '$topicid'" );
                        $this -> db -> update( "topics", $data );

                }
                return TRUE;


        }

        function changeActiveStatus( $id, $newstatus ) {

                $this -> db -> where( 'id', $id );
                $this -> db -> update( "topics", array ( 'is_active' => $newstatus ) );
                if ( $newstatus == 0 ) {
                        return FALSE;
                } else {
                        return TRUE;
                }
        }

        function changeTrendingStatus( $id, $newstatus ) {

                $this ->db->where( 'id', $id );
                if( $newstatus == 1 ){
                $this ->db-> update( "topics", array ( 'is_trending' => $newstatus, 'trending_created_date' => date('Y-m-d h:i:s')));
                return TRUE;
                } else {
                $this ->db-> update( "topics", array ( 'is_trending' => $newstatus, 'trending_created_date' => '0000-00-00 00:00:00'));
                return FALSE;
                }


        }

        function get_blog_category() {

                $this -> db -> select( 'name,id' );
                $this -> db -> from( 'blog_category' );
                $this -> db -> where( 'is_active', '1' );
                $result = $this -> db -> get() -> result_array();
                return $result;
                
        }

}
