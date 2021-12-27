<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Master extends Base_Controller {

        function __construct() {
                parent::__construct();
                $this->load->config('validation_rules', TRUE);
                $this -> load -> model(array('Master_model','Election_model','Topics_model','Blog_model','User_model'));
               
        }

        function states() {
                $page_title[ 'page_title' ] = "Master";
                $data[ 'states' ] = $this -> Election_model -> get_states_list();
                $this -> load -> view( 'template/header', $page_title );
                $this -> load -> view( 'states', $data );
                $this -> load -> view( 'template/footer' );
        }

        function parties() {
                $page_title[ 'page_title' ] = "Master";
                $data[ 'parties' ] = $this -> Election_model -> get_parties_list();
                $this -> load -> view( 'template/header', $page_title );
                $this -> load -> view( 'parties', $data );
                $this -> load -> view( 'template/footer' );
        }

        function addUpdateState() {
                $inputs = $this -> input -> post();
                $this -> Master_model -> addUpdateState_Mod( $inputs );
                $msg = ($inputs[ 'stateid' ] == "0") ? "State added successfully" : "State updated successfully";
                echo json_encode( array ( "status" => TRUE, "message" => $msg ) );
        }

        function addUpdateParty() {
                $inputs = $this -> input -> post();
                $this -> Master_model -> addUpdateParty_Mod( $inputs );
                $msg = ($inputs[ 'party_id' ] == "0") ? "Party added successfully" : "Party updated successfully";
                echo json_encode( array ( "status" => TRUE, "message" => $msg ) );
        }

        function topics() {
                $data = array ();
                $header_data[ 'page_title' ] = "Topics";
                $data[ 'topics' ] = $this -> Topics_model -> get_topics_list();
                $data[ 'blog_category' ] = $this -> Topics_model -> get_blog_category();
                $this -> load -> view( 'template/header', $header_data );
                $this -> load -> view( 'topics', $data );
                $this -> load -> view( 'template/footer' );
        }     

        function category() {
        $data = array();
        $page_title['page_title'] = "Blogs";
        $data['category_list'] = $this->Blog_model->get_blog_category_detail_mod();
        $this->load->view('template/header', $page_title);
        $this->load->view('category', $data);
        $this->load->view('template/footer');
        }

        function addUpdateTopic() {
                $inputs = $this -> input -> post();
                $this -> Topics_model -> add_update_topic( $inputs );
                $msg = ($inputs[ 'topicid' ] == "0") ? "Topic added successfully" : "Topic updated successfully";
                echo json_encode( array ( "status" => TRUE, "message" => $msg ) );
        }

        function changeActiveTopic() {
                $id = $this -> input -> post( 'id' );
                //$type = $this -> input -> post( 'type' );
                $current = $this -> input -> post( 'current' );
                $newstatus = ($current == "1") ? 0 : 1;

                $status = $this -> Topics_model -> changeActiveStatus( $id, $newstatus );
                $msg = "Action performed successfully";
                echo json_encode( array ( "status" => $status, "message" => $msg ) );
        }

        function user_list() {
                $data = array ();
                $header_data[ 'page_title' ] = "User list";
                $data[ 'users' ] = $this -> User_model -> get_user_list();
                $data[ 'menu_list' ] = $this -> User_model -> get_user_menulist();
                $this -> load -> view( 'template/header', $header_data );
                $this -> load -> view( 'user_list', $data );
                $this -> load -> view( 'template/footer' );
        }


       function addUpdateUser() {

                $inputs = $this -> input -> post();
                //print_r($inputs);die;
                $user_id = $inputs['user_id'];


                if($user_id){

                        $this -> User_model -> add_update_user( $inputs );
                        $msg = ($inputs[ 'userid' ] == "0") ? "User added successfully" : "User updated successfully";
                        $data['status'] = 'success';
                        $data['message'] = $msg;


                }else{

                    $validationResult = $this->User_model->validate_user();
                    if(empty($validationResult)){   

                                $data['status']= 'failure';
                                $data['error'] = array(
                                    'admin_email' =>strip_tags(form_error('admin_email')),            
                                    'admin_password' =>strip_tags(form_error('admin_password')),            
                                              
                                );


                }else{

                                $this -> User_model -> add_update_user( $inputs );
                                $msg = ($inputs[ 'userid' ] == "0") ? "User added successfully" : "User updated successfully";
                                $data['status'] = 'success';
                                $data['message'] = $msg;
                                //echo json_encode( array ( "status" => TRUE, "message" => $msg ) );   

                }
            }

            echo json_encode($data);
                
        }
        

        function changeActiveUser() {
                $id = $this -> input -> post( 'id' );
                //$type = $this -> input -> post( 'type' );
                $current = $this -> input -> post( 'current' );
                $newstatus = ($current == "1") ? 0 : 1;

                $status = $this -> User_model -> changeActiveStatus( $id, $newstatus );
                $msg = "Action performed successfully";
                echo json_encode( array ( "status" => $status, "message" => $msg ) );
        }


        
        function changeTrendingTopic() {
                $id = $this -> input -> post( 'id' );
                //$type = $this -> input -> post( 'type' );
                $current = $this -> input -> post( 'current' );
                $newstatus = ($current == "1") ? 0 : 1;

                $status = $this -> Topics_model -> changeTrendingStatus( $id, $newstatus );
                $msg = "Action performed successfully";
                echo json_encode( array ( "status" => $status, "message" => $msg ) );
        }

}
