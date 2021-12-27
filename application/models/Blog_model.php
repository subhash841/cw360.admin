<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Blog_model extends CI_Model {

        function __construct() {
                parent::__construct();


        }

        function get_blog_detail_mod() {
                $this -> db -> select( "*" );
                $this -> db -> from( "blogs" );
                $this -> db -> where( "is_approve = '1'" );
                //$this->db->order_by('blog_order', 'asc');
                $this -> db -> order_by( 'is_active', 'desc' );
                //$this -> db -> order_by( 'blog_order', 'asc' );
                $this -> db -> order_by( 'id', 'desc' );
                return $this -> db -> get() -> result_array();

        }

        function get_pending_blog_detail_mod() {
                $this -> db -> select( "*" );
                $this -> db -> from( "blogs" );
                $this -> db -> where( "is_approve = '0'" );
                //$this->db->order_by('blog_order', 'asc');
                //$this -> db -> order_by( 'created_date', 'DESC' );
                $this -> db -> order_by( 'id', 'desc' );
                return $this -> db -> get() -> result_array();

        }


        function get_blog_list() {
                $this -> db -> select( "*" );
                $this -> db -> from( "blogs" );
                //$this -> db -> where( "is_approve = '0'" );
                //$this->db->order_by('blog_order', 'asc');
                //$this -> db -> order_by( 'created_date', 'DESC' );
                $this -> db -> order_by( 'id', 'desc' );
                $this -> db -> limit(10, 0);
                return $this -> db -> get() -> result_array();

        }


        function get_user_blogs_filtered($inputs) {

                $offset = 0;
                $userid = $inputs[ 'user_id' ];
                $status = $inputs[ 'blog_status' ];
                $title = $inputs[ 'blog_title' ];
                $description = $inputs[ 'blog_desc' ];
                $type = $inputs[ 'blog_type' ];
                $startdate = $inputs[ 'blog_cstart_date' ];
                $enddate = $inputs[ 'blog_cend_date' ];
                $offset = $inputs[ 'offset' ];

                $start_date = date("y-m-d", strtotime($startdate));
                $end_date = date("y-m-d", strtotime($enddate));

                $this -> db -> select( "*" );
                $this -> db -> from( "blogs" );
                //$this -> db -> where( "is_approve = '0'" );
                if($userid != ""){
                $this -> db -> where('user_id', $userid);
                }
                if($status != ""){
                $this -> db -> where('is_approve', $status);
                }
                if($title != ""){
                $this -> db -> where('title', $title);
                }
                if($description != ""){
                $this -> db -> where('description', $description);
                }
                if($type != ""){
                $this -> db -> where('type', $type);
                }
                if($startdate != ""){
                $this -> db -> where('created_date >=', $start_date);
                }
                if($enddate != ""){
                $this -> db -> where('created_date <=', $end_date);
                }
                //$this->db->order_by('blog_order', 'asc');
                //$this -> db -> order_by( 'created_date', 'DESC' );
                $this -> db -> order_by( 'id', 'desc' );
                $this -> db ->limit(10, $offset);
                return $this -> db -> get() -> result_array();

        }


        function get_filtered_list($inputs) {

                $offset = 0;
                $topic = $inputs[ 'blog_topic' ];
                $status = $inputs[ 'blog_status' ];
                $title = $inputs[ 'blog_title' ];
                $description = $inputs[ 'blog_desc' ];
                $type = $inputs[ 'blog_type' ];
                $startdate = $inputs[ 'blog_cstart_date' ];
                $enddate = $inputs[ 'blog_cend_date' ];
                $offset = $inputs[ 'offset' ];

                $start_date = date("y-m-d", strtotime($startdate));
                $end_date = date("y-m-d", strtotime($enddate));

                $this -> db -> select( "*" );
                $this -> db -> from( "blogs" );
                //$this -> db -> where( "is_approve = '0'" );
                if($topic != ""){
                $this -> db -> where('topic_id', $topic);
                }
                if($status != ""){
                $this -> db -> where('is_approve', $status);
                }
                if($title != ""){
                $this -> db -> where('title', $title);
                }
                if($description != ""){
                $this -> db -> where('description', $description);
                }
                if($type != ""){
                $this -> db -> where('type', $type);
                }
                if($startdate != ""){
                $this -> db -> where('created_date >=', $start_date);
                }
                if($enddate != ""){
                $this -> db -> where('created_date <=', $end_date);
                }
                //$this->db->order_by('blog_order', 'asc');
                //$this -> db -> order_by( 'created_date', 'DESC' );
                $this -> db -> order_by( 'id', 'desc' );
                $this -> db ->limit(10, $offset);
                return $this -> db -> get() -> result_array();

        }


        function export_filter_user_blogs($inputs) {

                //$offset = 0;
                $userid = $topic = $status = $title = $description = $type = $startdate = $enddate = "";

                if(isset($inputs[ 'user_id' ])){
                    $userid = $inputs[ 'user_id' ];
                }
                if(isset($inputs[ 'blog_topic' ])){
                    $topic = $inputs[ 'blog_topic' ];
                }
                if(isset($inputs[ 'blog_status' ])){
                    $status = $inputs[ 'blog_status' ];
                }
                if(isset($inputs[ 'blog_title' ])){
                    $title = $inputs[ 'blog_title' ];
                }
                if(isset($inputs[ 'blog_desc' ])){
                    $description = $inputs[ 'blog_desc' ];
                }
                if(isset($inputs[ 'blog_type' ])){
                    $type = $inputs[ 'blog_type' ];
                }
                if(isset($inputs[ 'blog_cstart_date' ])){
                    $startdate = $inputs[ 'blog_cstart_date' ];
                }
                if(isset($inputs[ 'blog_cend_date' ])){
                    $enddate = $inputs[ 'blog_cend_date' ];
                }
                //$offset = $inputs[ 'offset' ];

                $start_date = date("y-m-d", strtotime($startdate));
                $end_date = date("y-m-d", strtotime($enddate));

                $this -> db -> select( "*" );
                $this -> db -> from( "blogs" );
                //$this -> db -> where( "is_approve = '0'" );
                if($userid != ""){
                $this -> db -> where('user_id', $userid);
                }
                if($topic != ""){
                $this -> db -> where('topic_id', $topic);
                }
                if($status != ""){
                $this -> db -> where('is_approve', $status);
                }
                if($title != ""){
                $this -> db -> where('title', $title);
                }
                if($description != ""){
                $this -> db -> where('description', $description);
                }
                if($type != ""){
                $this -> db -> where('type', $type);
                }
                if($startdate != ""){
                $this -> db -> where('created_date >=', $start_date);
                }
                if($enddate != ""){
                $this -> db -> where('created_date <=', $end_date);
                }
                //$this->db->order_by('blog_order', 'asc');
                //$this -> db -> order_by( 'created_date', 'DESC' );
                $this -> db -> order_by( 'id', 'desc' );
                //$this -> db ->limit(10, $offset);
                return $this -> db -> get() -> result_array();

        }



       /* function get_blog_detail_byid_mod( $id ) {
                if ( is_numeric( $id ) ) {
                        $this -> db -> select( "b.*" ); //,bs.name as sub_category,bc.name as category
                        $this -> db -> from( "blogs b" );
                        //$this -> db -> join( "blog_subcategory bs", 'bs.id=b.sub_category_id', 'LEFT' );
                        //$this -> db -> join( 'blog_category bc', 'bc.id=b.category_id' );
                        if ( ! empty( $id ) ) {
                                $this -> db -> where( "b.id", $id );
                        }
                        $this -> db -> order_by( 'id', 'desc' );
                        $result = $this -> db -> get();
                        if ( $result -> num_rows() > 0 ) {
                                $data = $result -> row_array();
                                $data[ 'image' ] = $this -> config -> item( 'cdn_url' ) . "/images/blogs/" . $data[ 'image' ];

                                $this -> db -> select( "ta.*,t.topic" );
                                $this -> db -> from( "topic_association ta" );
                                $this -> db -> where( "post_id = '$id'" );
                                $this -> db -> join( "topics t", "t.id = ta.topic_id", "INNER" );
                                $topic_associated = $this -> db -> get() -> result_array();
                                return $data;
                        }
                        redirect( 'Blogs' );
                }
                redirect( 'Blogs' );

        } */


        function get_blog_detail_byid_mod( $id ) {
                $this -> db -> select('id,topic_id, title, description, image, blog_date, description, meta_keywords, meta_description, is_approve,is_active,created_date');
                $this -> db -> from('blogs');
                $this -> db -> where('id',$id);
                $blog_data =  $this -> db -> get() -> row_array();

                $topics_id = array();
                $topic_id  = $blog_data['topic_id'];
                $topics    = explode(',',$topic_id); 

                if(!empty($topics)){
                    $this -> db -> select( "t.topic,t.id" );
                    $this -> db -> from( "topics t" );
                    $this -> db -> where_in( 'id' , $topics );
                    $topics_data = $this -> db -> get() -> result_array();
                    $blog_data['topics_associated'] = $topics_data;
                }

                return $blog_data;
                
            }

        function get_blog_category_detail_mod() {
                $this -> db -> select( "*" );
                $this -> db -> from( "blog_category" );
                $this -> db -> where( "is_active = '1'" );
                $this -> db -> order_by( 'id','DESC');
                return $this -> db -> get() -> result_array();

        }


        function validate_blog(){
                
            $this->form_validation->set_rules($this->config->item('Blog','validation_rules'));
            if($this->form_validation->run() == FALSE){
                    return FALSE;
                } else {
                    return TRUE;
                  }
            } 

        function add_update_blog_mod( $input ) {

                if(empty($input[ 'blogid' ])){
                    $blogid = '0';
                }else{
                    $blogid = $input[ 'blogid' ];
                }

                $title = special_character( $input[ 'blog_title' ] );
                //$description = special_character($input['blog_description']);
                $topics = implode(",",$input['topics']);
                $description = $input[ 'description' ];
                $blog_date = date( "Y-m-d", strtotime( $input[ 'blog_date' ] ) );
                //$blog_category_id = $input[ 'blog_category' ];
                //$blog_subcategory_id = $input[ 'blog_subcategory' ];
                $blog_type = $input[ 'blog_type' ];
                $meta_keywords = $input[ 'meta_keywords' ];
                $meta_description = $input[ 'meta_description' ];
                $image = $input[ 'uploaded_filename' ];

                $filename = $_FILES[ 'uploaded_filename' ][ 'name' ];
                $filetype = $_FILES[ 'uploaded_filename' ][ 'type' ];
                $tmpname = $_FILES[ 'uploaded_filename' ][ 'tmp_name' ];
                $filesize = $_FILES[ 'uploaded_filename' ][ 'size' ];

                if ( $filename != "" ) {
                        list($width, $height, $type, $attr) = getimagesize( $tmpname );
                        if ( $width < 200 || $height < 200 ) {
                                return array ( "status" => FALSE, "message" => "Image size should be minimum 200*200" );
                                exit;
                        }

                        if ( $filesize > 1000000 ) {
                                return array ( "status" => FALSE, "message" => "Filesize should not be more than 1 MB" );
                                exit;
                        }

                        $get_ext = explode( ".", $filename );
                        $extension = end( $get_ext );
                        $newfilename = str_replace( " ", "_", $get_ext[ 0 ] ) . time() . "." . $extension;
                        //move_uploaded_file( $tmpname, "../crowdwisdom.co.in/images/blogs/" . $newfilename ); // local
                        //move_uploaded_file( $tmpname, "../cwtest/images/blogs/" . $newfilename ); //Test
                        move_uploaded_file( $tmpname, "../cw/images/blogs/" . $newfilename ); //Live
                } else {
                        $newfilename = "default_blog.png";
                }
                //var_dump($description);exit;
                if ( $blogid == "0" ) {
                        $insert = array (
                            "topic_id" => $topics,
                            "title" => $title,
                            "description" => $description,
                            "image" => $image,
                            "blog_date" => $blog_date,
                            "is_active" => "1",
                            //"category_id" => $blog_category_id,
                            //"sub_category_id" => $blog_subcategory_id,
                            //"category_id" => 0,
                            //"sub_category_id" => 0,
                            //"type" => $blog_type,
                            "meta_keywords" => $meta_keywords,
                            "meta_description" => $meta_description,
                            "blog_order" => 1,
                            "is_approve" => 0,
                            "created_date" => date('Y-m-d H:i:s'),
                        );
                        $this -> db -> set( 'blog_order', 'blog_order+1', FALSE );
                        $this -> db -> update( 'blogs' );
                        $this -> db -> insert( "blogs", $insert );
                        $blogid = $this -> db -> insert_id();
                        return array ( "status" => TRUE, "message" => "Blog added successfully" );
                        exit;
                } else {
                        $update = array (
                            "topic_id" => $topics,
                            "title" => $title,
                            "description" => $description,
                            "blog_date" => $blog_date,
                            //"category_id" => $blog_category_id,
                            //"sub_category_id" => $blog_subcategory_id,
                            //"category_id" => 0,
                            //"sub_category_id" => 0,
                            /*"type" => $blog_type,*/
                            "meta_keywords" => $meta_keywords,
                            "meta_description" => $meta_description,
                            "modified_date" =>date('Y-m-d H:i:s')
                        );

                        if ( $image != "" ) {
                                $update[ 'image' ] = $image;
                        }

                        $this -> db -> where( "id = '$blogid'" );
                        $this -> db -> update( "blogs", $update );
                        return array ( "status" => TRUE, "message" => "Blog updated successfully" );
                        exit;
                }

        }

        function addCategory( $inputs ) {
                $insert = array (
                    "name" => $inputs[ 'category_name' ]
                );
                $this -> db -> insert( "blog_category", $insert );
                //echo $this->db->insert_id();exit;
                return TRUE;

        }

        function updateCategory( $inputs ) {
                $id = $inputs[ 'categoryid' ];
                $update = array (
                    "name" => $inputs[ 'category_name' ]
                );
                $this -> db -> where( "id = '$id'" );
                $this -> db -> update( "blog_category", $update );
                return TRUE;

        }

        function get_blog_sub_category_detail_mod() {
                $this -> db -> select( "bs.*,bc.name as category" );
                $this -> db -> from( "blog_subcategory bs" );
                $this -> db -> join( 'blog_category bc', 'bc.id=bs.category_id' );
                //$this->db->where("bs.is_active = '1'");
                return $this -> db -> get() -> result_array();

        }

        function addSubCategory( $inputs ) {
                $insert = array (
                    "category_id" => $inputs[ 'category_id' ],
                    "name" => $inputs[ 'sub_category_name' ]
                );
                $this -> db -> insert( "blog_subcategory", $insert );
                //echo $this->db->insert_id();exit;
                return TRUE;

        }

        function updateSubCategory( $inputs ) {
                $id = $inputs[ 'subcategoryid' ];
                $update = array (
                    "category_id" => $inputs[ 'category_id' ],
                    "name" => $inputs[ 'sub_category_name' ]
                );
                $this -> db -> where( "id = '$id'" );
                $this -> db -> update( "blog_subcategory", $update );
                return TRUE;

        }

        function changeActiveStatus( $id, $newstatus, $type ) {
               

                $this -> db -> where( 'id', $id );
                $this -> db -> update( 'blogs', array ( 'is_active' => $newstatus,'modified_date' => date('Y-m-d H:i:s') ) );
                if ( $newstatus == 0 ) {
                        return FALSE;
                } else {
                        return TRUE;
                }

        }

        function blogstatus( $id, $status ) {

                if ( ( int ) $id <= 0 )
                        return false;
                $this -> db -> where( 'id', ( int ) $id );
                $this -> db -> update( 'blogs', array ( 'is_approve' => $status ) );

                return TRUE;

        }

        function changeBlogOrder( $id, $neworder ) {
                //echo $id." ".$neworder;exit;
                $this -> db -> select( 'blog_order' );
                $this -> db -> where( 'id', $id );
                $this -> db -> from( 'blogs' );
                $result = $this -> db -> get() -> row_array();
                $currentorder = $result[ 'blog_order' ];

                $this -> db -> set( 'blog_order', $currentorder );
                $this -> db -> where( 'blog_order', $neworder );
                $this -> db -> update( 'blogs' );

                $this -> db -> set( 'blog_order', $neworder );
                $this -> db -> where( 'id', $id );
                $this -> db -> update( 'blogs' );

                return TRUE;

//        $this->db->select('blog_order');
//        $this->db->where('id', $id);
//        $this->db->from('blogs');
//        $result = $this->db->get()->row_array();
//        $currentorder = $result['blog_order'];
//        $this->db->select('*');
//        if ($currentorder > $neworder) {
//            $currentorder=$currentorder-1;
//            $this->db->where("blog_order BETWEEN $neworder AND $currentorder");
//            $this->db->set('blog_order', 'blog_order+1', FALSE);
//            
//        } else if ($currentorder < $neworder) {
//            $currentorder=$currentorder+1;
//            $this->db->where("blog_order BETWEEN $currentorder AND $neworder");
//            $this->db->set('blog_order', 'blog_order-1', FALSE);
//            
//        }
//        $this->db->update('blogs');
//        
//        $this->db->set('blog_order',$neworder);
//        $this->db->where('id',$id);
//        $this->db->update('blogs');

        }

        function checkBlogOrderExist_mod( $order ) {
                $this -> db -> where( 'blog_order', $order );
                $this -> db -> select( 'id' );
                $this -> db -> from( 'blogs' );
                $result = $this -> db -> get();
                $count = $result -> num_rows();
                if ( $count > 0 ) {
                        return TRUE;
                } else {
                        return FALSE;
                }

        }

}
