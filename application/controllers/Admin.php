<?php


class Admin extends Base_Controller {

        function __construct() {
                parent::__construct();
                $this -> load -> model( 'Admin_model' );
        }

        function lists() {
        	    $page_title[ 'page_title' ] = "Admin";
                $data[ 'admins' ] = $this -> Admin_model -> get_admin_list();
                $this -> load -> view( 'template/header', $page_title );
                $this -> load -> view( 'admin_list', $data );
                $this -> load -> view( 'template/footer' );
        }

        function addUpdateAdmin(){
        	$inputs = $this -> input -> post();
                $this -> Admin_model -> add_update_admin( $inputs );
                $msg = ($inputs[ 'adminid' ] == "0") ? "Admin added successfully" : "Admin updated successfully";
                echo json_encode( array ( "status" => TRUE, "message" => $msg ) );
        }

        function changeActiveAdmin() {
                $id = $this -> input -> post( 'id' );
                //$type = $this -> input -> post( 'type' );
                $current = $this -> input -> post( 'current' );
                $newstatus = ($current == "1") ? 0 : 1;

                $status = $this -> Admin_model -> changeActiveStatus( $id, $newstatus );
                $msg = "Action performed successfully";
                echo json_encode( array ( "status" => $status, "message" => $msg ) );
        }

}