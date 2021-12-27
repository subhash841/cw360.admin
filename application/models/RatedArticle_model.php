<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class RatedArticle_model extends CI_Model {

        function __construct() {
                parent::__construct();

        }

        function get_list( $offset = 0 ) {
                $this -> db -> select( "p.*,group_concat(pch.choice) as choices" );
                $this -> db -> from( "article p" );
                //$this->db->join("article_category pc", "pc.id = p.category_id", "INNER");
                $this -> db -> join( "article_choices pch", "pch.article_id = p.id", "INNER" );
                $this -> db -> group_by( "p.id" );
                $this -> db -> order_by( "p.is_approved ASC, p.id DESC" );
                $this -> db ->limit(10, $offset);
                return $this -> db -> get() -> result_array();

        }

        function get_topic_list () {
            $this -> db -> select ("*");
            $this -> db -> from ("topics");
            return $this -> db -> get() -> result_array();
        }

        function get_filtered_list ( $inputs ) {
            //$offset = 0;
            $topicname = $inputs['topic_id'];
            $question = $inputs['article_quest'];
            $description = $inputs['article_desc'];
            $startdate = $inputs['start_date'];
            $enddate = $inputs['end_date'];
            $offset = $inputs['offSet'];

            $start_date = date("y-m-d", strtotime($startdate));
            $end_date = date("y-m-d", strtotime($enddate));

            $this -> db -> select( "p.*,group_concat(pch.choice) as choices" );
            $this -> db -> from( "article p" );
            if ($topicname != "") {
                $this->db->where('topic_id', $topicname);
            }            
            if ($question != "") {
                 $this->db->where('question', $question);
            }
            if ($description != "") {
                $this -> db -> where('description', $description);
            }
            if ($startdate != "") {
                $this -> db -> where('p.created_date >=', $start_date);
            }
            if ($enddate != "") {
                $this -> db -> where('p.created_date <=', $end_date);
            }

            $this -> db -> join( "article_choices pch", "pch.article_id = p.id", "INNER" );
            $this -> db -> group_by( "p.id" );
            $this -> db -> order_by( "p.is_approved ASC, p.id DESC" );
            $this -> db ->limit(10, $offset);
            return $this -> db -> get() -> result_array();
        }

        function get_filtered_list_exported ( $inputs ) {
            $topicname = '';
            $question = '';
            $description = '';
            $startdate = '';
            $enddate = '';
            if (isset($inputs['topic_id'])) {
                $topicname = $inputs['topic_id'];
            }
            if (isset($inputs['article_quest'])) {
                $question = $inputs['article_quest'];
            }
            if (isset($inputs['article_desc'])) {
                $description = $inputs['article_desc'];
            }
            if (isset($inputs['start_date'])) {
                $startdate = $inputs['start_date'];
            }
            if (isset($inputs['end_date'])) {
                $enddate = $inputs['end_date'];
            }

            $start_date = date("y-m-d", strtotime($startdate));
            $end_date = date("y-m-d", strtotime($enddate));

            $this -> db -> select( "p.*,group_concat(pch.choice) as choices" );
            $this -> db -> from( "article p" );
            if ($topicname != "") {
                $this->db->where('topic_id', $topicname);
            }            
            if ($question != "") {
                 $this->db->where('question', $question);
            }
            if ($description != "") {
                $this -> db -> where('description', $description);
            }
            if ($startdate != "") {
                $this -> db -> where('p.created_date >=', $start_date);
            }
            if ($enddate != "") {
                $this -> db -> where('p.created_date <=', $end_date);
            }

            $this -> db -> join( "article_choices pch", "pch.article_id = p.id", "INNER" );
            $this -> db -> group_by( "p.id" );
            $this -> db -> order_by( "p.is_approved ASC, p.id DESC" );
            return $this -> db -> get() -> result_array();
        }

        function get_details_article ( $article_id ) {
                $this -> db -> select( "p.*,COALESCE(u.name,'') as user, t.topic as topic" );
                $this -> db -> from( "article p" );
                //$this->db->join("article_category pc", "pc.id = p.category_id", "INNER");
                $this -> db -> join( "users u", "u.id = p.user_id", "LEFT" );
                $this -> db -> join("topics t", "t.id = p.topic_id", "LEFT");
                $this -> db -> where( "p.id = '$article_id'" );
                $article_data = $this -> db -> get() -> row_array();

                $this -> db -> select( "pc.*" );
                $this -> db -> from( "article_choices pc" );
                $this -> db -> where( "article_id = '$article_id'" );
                $article_data[ 'choices' ] = $this -> db -> get() -> result_array();

                return $article_data;
        }

        function get_article_count ( $article_id ) {
            $this -> db -> select("count(1) as total_articles");
            $this -> db -> from("article_comments");
            $this -> db -> where("id = '$article_id'");
            $article_count['articles'] = $this -> db -> get() -> row_array();

            return $article_count;
        }

        function get_article_replies ( $article_id ) {
            $this -> db -> select("count(1) as total_replies");
            $this -> db -> from("article_comment_reply");
            $this -> db -> where("id = '$article_id'");
            $article_reply['replies'] = $this -> db -> get() -> row_array();
            return $article_reply;
        }


        function get_user_articles_filtered($inputs) {

                $data_item_list = array();

                $status = 1;
                $userid = $inputs[ 'user_id' ];
                $status = $inputs[ 'article_status' ];
                $title = $inputs[ 'article_quest' ];
                $description = $inputs[ 'article_desc' ];
                $startdate = $inputs[ 'article_cstart_date' ];
                $enddate = $inputs[ 'article_cend_date' ];
                $offset = $inputs[ 'offset' ];

                $start_date = date("y-m-d", strtotime($startdate));
                $end_date = date("y-m-d", strtotime($enddate));

                if($status == 2){
                    $this -> db -> select( "*" );
                    $this -> db -> from( "article_action" );
                    if($userid != ""){
                    $this -> db -> where('user_id', $userid);
                    }
                    $participated_article_list = $this -> db -> get() -> result_array();

                    foreach ($participated_article_list as $key => $item){
                        array_push($data_item_list, $item['article_id']);
                    }
                }

                $this -> db -> select( "p.*,group_concat(pch.choice) as choices" );
                $this -> db -> from( "article p" );
                if($status == 2){
                    $this -> db -> where_in('p.id', $data_item_list);
                } else {
                    $this -> db -> where('user_id', $userid);
                }
                if($title != ""){
                $this -> db -> where('question', $title);
                }
                if($description != ""){
                $this -> db -> where('description', $description);
                }
                if($startdate != ""){
                $this -> db -> where('p.created_date >=', $start_date);
                }
                if($enddate != ""){
                $this -> db -> where('p.created_date <=', $end_date);
                }
                //$this->db->join("article_category pc", "pc.id = p.category_id", "INNER");
                $this -> db -> join( "article_choices pch", "pch.article_id = p.id", "INNER" );
                $this -> db -> group_by( "p.id" );
                $this -> db -> order_by( "p.is_approved ASC, p.id DESC" );
                $this -> db ->limit(10, $offset);
                return $this -> db -> get() -> result_array();

        }



        function export_filter_user_articles($inputs) {

                $data_item_list = array();

                $status = 1;

                $userid = $title = $description = $startdate = $enddate = "";

                if(isset($inputs[ 'user_id' ])){
                    $userid = $inputs[ 'user_id' ];
                }
                if(isset($inputs[ 'article_status' ])){
                    $status = $inputs[ 'article_status' ];
                }
                if(isset($inputs[ 'article_quest' ])){
                    $title = $inputs[ 'article_quest' ];
                }
                if(isset($inputs[ 'article_desc' ])){
                    $description = $inputs[ 'article_desc' ];
                }
                if(isset($inputs[ 'article_cstart_date' ])){
                    $startdate = $inputs[ 'article_cstart_date' ];
                }
                if(isset($inputs[ 'article_cend_date' ])){
                    $enddate = $inputs[ 'article_cend_date' ];
                }
                //$offset = $inputs[ 'offset' ];

                $start_date = date("y-m-d", strtotime($startdate));
                $end_date = date("y-m-d", strtotime($enddate));

                if($status == 2){
                    $this -> db -> select( "*" );
                    $this -> db -> from( "article_action" );
                    if($userid != ""){
                    $this -> db -> where('user_id', $userid);
                    }
                    $participated_article_list = $this -> db -> get() -> result_array();

                    foreach ($participated_article_list as $key => $item){
                        array_push($data_item_list, $item['article_id']);
                    }
                }

                $this -> db -> select( "p.*,group_concat(pch.choice) as choices" );
                $this -> db -> from( "article p" );
                if($status == 2){
                    $this -> db -> where_in('p.id', $data_item_list);
                } else {
                    $this -> db -> where('user_id', $userid);
                }
                if($title != ""){
                $this -> db -> where('question', $title);
                }
                if($description != ""){
                $this -> db -> where('description', $description);
                }
                if($startdate != ""){
                $this -> db -> where('p.created_date >=', $start_date);
                }
                if($enddate != ""){
                $this -> db -> where('p.created_date <=', $end_date);
                }
                //$this->db->join("article_category pc", "pc.id = p.category_id", "INNER");
                $this -> db -> join( "article_choices pch", "pch.article_id = p.id", "INNER" );
                $this -> db -> group_by( "p.id" );
                $this -> db -> order_by( "p.is_approved ASC, p.id DESC" );
                //$this -> db ->limit(10, $offset);
                return $this -> db -> get() -> result_array();

        }



        function get_article_details( $article_id ) {
                $this -> db -> select( "p.*,COALESCE(u.name,'') as user" );
                $this -> db -> from( "article p" );
                //$this->db->join("article_category pc", "pc.id = p.category_id", "INNER");
                $this -> db -> join( "users u", "u.id = p.user_id", "LEFT" );
                $this -> db -> where( "p.id = '$article_id'" );
                $article_data = $this -> db -> get() -> row_array();

                $this -> db -> select( "ta.*,t.topic" );
                $this -> db -> from( "topic_association ta" );
                $this -> db -> where( "post_id = '$article_id'" );
                $this -> db -> join( "topics t", "t.id = ta.topic_id", "INNER" );
                $topic_associated = $this -> db -> get() -> result_array();
                if(!empty($topic_associated)){
                    $article_data[ 'topic_associated' ] = $topic_associated;
                }else{
                    $article_data[ 'topic_associated' ] = array();
                }
                $this -> db -> select( "pc.*" );
                $this -> db -> from( "article_choices pc" );
                $this -> db -> where( "article_id = '$article_id'" );
                $article_data[ 'choices' ] = $this -> db -> get() -> result_array();

                return $article_data;

        }

//    function get_article_category() {
//        $this->db->select("*");
//        $this->db->from("article_category");
//        $this->db->where("is_active = '1'");
//        return $this->db->get()->result_array();
//    }

        function add_update_article( $inputs ) {

                $uid = $inputs[ 'user_id' ];
                $article_id = $inputs[ 'article_id' ];
                $article_title = $inputs[ 'article_title' ];
                $article_desc = $inputs[ 'article_desc' ];
                $preview = htmlspecialchars( $inputs[ 'previewdata' ] );
                $meta_description = $inputs[ 'meta_description' ];
                $meta_keywords = $inputs[ 'meta_keywords' ];

                $topics = array();
                if(isset($inputs[ 'topics' ])){
                    $topics = $inputs[ 'topics' ];
                }


                //$article_category_id = $inputs['article_category'];
                $choices = $inputs[ 'choice' ];
                //$end_date = date("Y-m-d", strtotime($inputs['end_date']));

                if ( $article_id == 0 ) {
                        //insert Polls
                        $insert_article = array (
                            "user_id" => $uid,
                            "category_id" => 0,
                            "raised_by_admin" => "1",
                            "question" => $article_title,
                            "description" => $article_desc,
                            "is_approved" => "1",
                            "approved_by" => $uid,
                            "is_active" => "1",
                            "preview" => $preview,
                            "meta_keywords" => $meta_keywords,
                            "meta_description" => $meta_description
                        );
                        if ( $inputs[ 'json_data' ] != "" ) {
                                $insert_article[ 'data' ] = $inputs[ 'json_data' ];
                        }
                        $this -> db -> insert( 'article', $insert_article );
                        $articleid = $this -> db -> insert_id();

                        //insert Choices
                        foreach ( $choices as $key => $ch ) {

                                if($ch == "Click to see Rating"){
                                    $ctype = 0;
                                } else {
                                    $ctype = 1;
                                }
                                
                                $insert_choices[] = array (
                                    "article_id" => $articleid,
                                    "choice" => $ch,
                                    "type" => $ctype,
                                    "is_active" => "1"
                                );
                        }

                        $this -> db -> insert_batch( 'article_choices', $insert_choices );

                        //insert Topics
                        foreach ( $topics as $key => $ch ) {
                                $insert_topics[] = array (
                                    "topic_id" => $ch,
                                    "post_id" => $articleid,
                                    "type" => "Article"
                                );
                        }

                        $this -> db -> insert_batch( 'topic_association', $insert_topics );
                } else {

                        /* Update Poll details */
                        $update_article = array (
                            "category_id" => 0,
                            //"raised_by_admin" => "1",
                            "question" => $article_title,
                            "description" => $article_desc,
                            "is_approved" => "1",
                            "approved_by" => $uid,
                            "preview" => $preview,
                            "is_active" => "1",
                            "total_votes" => 0,
                            "total_comments" => 0
                        );

                        if ( $inputs[ 'json_data' ] != "" ) {
                                $update_article[ 'data' ] = $inputs[ 'json_data' ];
                        }
                        $this -> db -> where( array ( "id" => $article_id ) );
                        $this -> db -> update( 'article', $update_article );
                        /* Update Poll details */

                        /* Delete old choices */
                        $this -> db -> where( "article_id = '$article_id'" );
                        $this -> db -> delete( 'article_choices' );
                        /* Delete old choices */

                        /* Delete old topic associations */
                        $this -> db -> where( "post_id = '$article_id'" );
                        $this -> db -> delete( 'topic_association' );
                        /* Delete old topic associations */

                        $this -> db -> where( 'article_id', $article_id );
                        $this -> db -> where( 'action', 'Vote' );
                        $this -> db -> delete( 'article_action' );

                        $this -> db -> where( 'article_id', $article_id );
                        $this -> db -> delete( 'article_comments' );

                        $this -> db -> where( 'article_id', $article_id );
                        $this -> db -> delete( 'article_comment_reply' );

                        //insert New Choices
                        foreach ( $choices as $key => $ch ) {

                                if($ch == "Click to see Rating"){
                                    $ctype = 0;
                                } else {
                                    $ctype = 1;
                                }

                                $insert_choices[] = array (
                                    "article_id" => $article_id,
                                    "choice" => $ch,
                                    "type" => $ctype,
                                    "is_active" => "1"
                                );
                        }
                        $this -> db -> insert_batch( 'article_choices', $insert_choices );

                        //insert New Topics
                        foreach ( $topics as $key => $ch ) {
                                $insert_topics[] = array (
                                    "topic_id" => $ch,
                                    "post_id" => $article_id,
                                    "type" => "Article"
                                );
                        }

                        $this -> db -> insert_batch( 'topic_association', $insert_topics );

                        /* Delete action of users when article update */
                        $this -> db -> where( "article_id = '$article_id' and action = 'Vote'" );
                        $this -> db -> delete( 'article_action' );
                        /* Delete action of users when article update */
                }

        }

        function approve_article( $inputs ) {
                $article_id = $inputs[ 'article_id' ];
                $user_id = $inputs[ 'user_id' ];

                $update = array (
                    "is_approved" => "1",
                    "approved_by" => $user_id
                );

                $this -> db -> where( "id = '$article_id'" );
                $this -> db -> update( "article", $update );

                return TRUE;

        }

        function active_inactive_article_mod( $inputs ) {
                $article_id = $inputs[ 'article_id' ];
                $type = $inputs[ 'type' ];
                $current = $inputs[ 'current' ];

                $current = ($current == "1") ? 0 : 1;

                $update = array (
                    "is_active" => $current
                );

                $this -> db -> where( "id = '$article_id'" );
                $this -> db -> update( "article", $update );

                return TRUE;

        }

}
