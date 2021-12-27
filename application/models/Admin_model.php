<?php


class Admin_model extends CI_Model {

        function __construct() {
                parent::__construct();

        }

        function get_admin_list(){

                $this -> db -> select("a.id, a.email, a.is_active");
                $this -> db -> from("admin a");
                return $this -> db -> get() -> result_array();

        }

        function add_update_admin( $inputs ) {
                $adminid = $inputs[ 'adminid' ];
                $email = $inputs[ 'admin_email' ];
                $password = $inputs[ 'admin_password' ];

                if ( $password == "" ) {
                    $data = array (
                        "email" => $email,
                        "is_active" => '1',
                    );
                } else {
                	$password = md5($password);

                	$data = array (
                        "email" => $email,
                        "password" => $password,
                        "is_active" => '1',
                    );
                }

                if ( $adminid == 0 ) {
                        $this -> db -> insert( "admin", $data );
                } else {
                        $this -> db -> where( "id = '$adminid'" );
                        $this -> db -> update( "admin", $data );
                }
                return TRUE;
        }

        function changeActiveStatus( $id, $newstatus ) {

                $this -> db -> where( 'id', $id );
                $this -> db -> update( "admin", array ( 'is_active' => $newstatus ) );
                if ( $newstatus == 0 ) {
                        return FALSE;
                } else {
                        return TRUE;
                }
        }


    }