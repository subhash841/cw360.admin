<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Wall extends Base_Controller {

        function __construct() {
                parent::__construct();

                $this -> load -> model( 'Wall_model' );
                $this -> userdata = $this -> session -> userdata( 'loggedin' );
        }

        function index() {
                $data = array ();
                $data[ 'wall_data' ] = array ();

                $wall_id = $this -> input -> get( 'id' );
                if ( $wall_id != 0 ) {
                        $data[ 'data' ] = $this -> Wall_model -> get_wall_details( $wall_id );
                }

                $page_title[ 'page_title' ] = "Wall";

                $this -> load -> view( 'template/header', $page_title );
                $this -> load -> view( 'add_update_wall', $data );
                $this -> load -> view( 'template/footer' );
        }

        function filteredList() {
                $inputs = $this -> input -> post();
                $offset = $inputs[ 'offSet' ];

                $walls = $this -> Wall_model -> get_wall_list( $offset );


                $output = '';
                $num = $inputs[ 'offSet' ];

                foreach ( $walls as $key => $p ):
                        $ischecked = ($p[ 'is_active' ] == 1) ? "checked" : "";
                        $num = $num + 1;
                        echo '<tr>'
                        . '<td>' . $num . '</td>'
                        . '<td><p class="multiline-ellipsis" data-lines="1">' . $p[ 'title' ] . '</p></td>'
                        . '<td class="text-center">' . date( "d-m-Y", strtotime( $p[ 'created_date' ] ) ) . '</td>'
                        . '<td class="text-center">
                                            <a class="switch changeactivewall" data-id="' . $p[ 'id' ] . '" data-type="surveys" data-status=' . $p[ 'is_active' ] . '>
                                                <label><input type="checkbox" ' . $ischecked . '><span class="lever switch-col-bluenew"></span></label>
                                            </a>
                                        </td>'
                        . '<td class="text-center">
                                            <a href="' . base_url() . 'Wall/index?id=' . $p[ 'id' ] . '" data-id="' . $p[ 'id' ] . '" data-editjson=\'' . json_encode( $p ) . '\'><i class="material-icons">&#xE254;</i></a>
                                            <a href="' . base_url() . 'Wall/wall_details?id=' . $p[ 'id' ] . '"  data-id="' . $p[ 'id' ] . '"><i class="material-icons">remove_red_eye</i></a>
                                        </td>';


                endforeach;
                echo $output;
        }

        function lists() {
                $data = array ();

                $page_title[ 'page_title' ] = 'Wall List';
                $data[ 'wall_details' ] = $this -> Wall_model -> get_wall_list();

                $this -> load -> view( 'template/header', $page_title );
                $this -> load -> view( 'list_wall', $data );
                $this -> load -> view( 'template/footer' );
        }

        function active_inactive_wall() {
                $inputs = $this -> input -> post();

                $this -> Wall_model -> active_inactive_wall_mod( $inputs );

                $message = ($inputs[ 'current' ] == "1") ? "Wall deactivated successfully" : "Wall activated successfully";
                echo json_encode( array ( "status" => TRUE, "message" => $message ) );
        }

        function wall_details() {
                $page_title [ 'page_title' ] = 'Wall Detail';
                $wall_id = $this -> input -> get( 'id' );
                $data[ 'wall_detail' ] = $this -> Wall_model -> wall_detail( $wall_id );

                $this -> load -> view( 'template/header', $page_title );
                $this -> load -> view( 'wall_details', $data );
                $this -> load -> view( 'template/footer' );
        }

        function add_update_wall() {
                $inputs = $this -> input -> post();
                return $this -> Wall_model -> add_update_wall( $inputs );
        }

        function export_wall() {
                $data = "";
                $walls = $this -> Wall_model -> get_wall_list( -1 );

                $data = '<tr>'
                        . '<td><strong>Sr. No.</strong></td>'
                        . '<td><strong>Title</strong></td>'
                        . '<td><strong>Created Date</strong></td>'
                        . '<td><strong>Is Active</strong></td>'
                        . '</tr>';

                foreach ( $walls as $key => $wall_data ) {
                        $num = $key + 1;
                        $is_active = ($wall_data[ 'is_active' ] == 1) ? "Yes" : "No";

                        $data .= '<tr>'
                                . '<td>' . $num . '</td>'
                                . '<td>' . $wall_data[ 'title' ] . '</td>'
                                . '<td>' . date( "d-m-Y", strtotime( $wall_data[ 'created_date' ] ) ) . '</td>'
                                . '<td>' . $is_active . '</td>'
                                . '</tr>';
                }
                $file = "wall.xls";
                $test = "<table border='1'>" . $data . "</table>";
                header( "Content-type: application/vnd.ms-excel" );
                header( "Content-Disposition: attachment; filename=$file" );
                echo $test;
        }

        function wall_filter() {
                $inputs = $this -> input -> post();
                $walls = $this -> Wall_model -> wall_mod_filter( $inputs );

                $output = '';
                $num = $inputs[ 'offSet' ];

                foreach ( $walls as $key => $p ):
                        $ischecked = ($p[ 'is_active' ] == 1) ? "checked" : "";
                        $num = $num + 1;
                        echo '<tr>'
                        . '<td>' . $num . '</td>'
                        . '<td><p class="multiline-ellipsis" data-lines="1">' . $p[ 'title' ] . '</p></td>'
                        . '<td class="text-center">' . date( "d-m-Y", strtotime( $p[ 'created_date' ] ) ) . '</td>'
                        . '<td class="text-center">
                                            <a class="switch changeactivewall" data-id="' . $p[ 'id' ] . '" data-type="surveys" data-status=' . $p[ 'is_active' ] . '>
                                                <label><input type="checkbox" ' . $ischecked . '><span class="lever switch-col-bluenew"></span></label>
                                            </a>
                                        </td>'
                        . '<td class="text-center">
                                            <a href="' . base_url() . 'Wall/index?id=' . $p[ 'id' ] . '" data-id="' . $p[ 'id' ] . '" data-editjson=\'' . json_encode( $p ) . '\'><i class="material-icons">&#xE254;</i></a>
                                            <a href="' . base_url() . 'Wall/wall_details?id=' . $p[ 'id' ] . '"  data-id="' . $p[ 'id' ] . '"><i class="material-icons">remove_red_eye</i></a>
                                        </td>';


                endforeach;
                echo $output;
        }

}
