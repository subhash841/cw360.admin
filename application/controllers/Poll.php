<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Poll extends Base_Controller {

        private $userdata = array ();

        function __construct() {
                parent::__construct();

                $this -> load -> model( 'Poll_model' );
                $this -> userdata = $this -> session -> userdata( 'loggedin' );

        }

        function index() {
                $data = array ();
                $data[ 'choices' ] = array ();
                $poll_id = $this -> input -> get( 'id' );
                if ( $poll_id != 0 ) {
                        $data = $this -> Poll_model -> get_poll_details( $poll_id );
                }

                $page_title[ 'page_title' ] = "Polls";
                $data[ 'poll_category' ] = $this -> Poll_model -> get_poll_category();

                $this -> load -> view( 'template/header', $page_title );
                $this -> load -> view( 'add_update_poll', $data );
                $this -> load -> view( 'template/footer' );

        }

        function fetchdata() {
                $arr_result = array ();
                $excludetopicids = array ();
                $ids = array ();

                $inputs = $this -> input -> post();
                $topic = $inputs[ 'p_category' ];

                if ( isset( $inputs[ 'topics' ] ) ) {
                        $excludetopicids = json_decode( $inputs[ 'topics' ] );
                }

                if ( count( $excludetopicids ) > 0 ) {
                        //$ids = implode( ",", $excludetopicids );
                        $ids = $excludetopicids;
                        //$excludeCond = "AND id not in ($ids)";
                }

                // $excludetopicids = json_decode( $this->input->post('excludetopic') );
                //     //echo count( $excludetopicids );
                //     $excludeCond = "";
                //     if ( count( $excludetopicids ) > 0 ) {
                //             $ids[] = implode( ",", $excludetopicids );
                //             //$excludeCond = "AND id not in ($ids)";
                //     }
                if ( isset( $topic ) ) {
                        $arr_result = $this -> Poll_model -> search( $topic, $ids );
                        if ( count( $arr_result ) > 0 ) {
                                /* foreach($result as $row) {
                                  array_push($arr_result, $row['name']);

                                  } */
                                echo json_encode( $arr_result );
                        }
                }

        }

        function filteredList() {
                $polls = array ();

                $inputs = $this -> input -> post();

                $polls = $this -> Poll_model -> get_filtered_list( $inputs );

                $output = '';
                $num = $inputs[ 'offSet' ];

                foreach ( $polls as $key => $p ) :
                        $ischecked = ($p[ 'is_active' ] == 1) ? "checked" : "";
                        $isapproved = ($p[ 'is_approved' ] == "1") ? "Yes" : "No";
                        $num = $num + 1;

                        $update_right_answer = '';

                        if ( strtotime( $p[ 'end_date' ] ) < strtotime( date( "Y-m-d" ) ) ) {
                                $update_right_answer = ($p[ 'right_choice' ] == "") ? '<a href="' . base_url() . 'Poll/details/' . $p[ 'id' ] . '"><i class="material-icons">info_outline</i></a>' : '';
                        }

                        echo '<tr>'
                        . '<td>' . $num . '</td>'
                        //. '<td>' . $p[ 'category' ] . '</td>'
                        . '<td><p class="multiline-ellipsis" data-lines="1">' . $p[ 'poll' ] . '</p></td>'
                        . '<td><p class="multiline-ellipsis" data-lines="3">' . $p[ 'description' ] . '</p></td>'
                        . '<td class="text-center">' . $isapproved . '</td>'
                        . '<td class="text-center">' . date( "d-m-Y", strtotime( $p[ 'created_date' ] ) ) . '</td>'
                        . '<td class="text-center">
                                        <a class="switch changeactivepoll" data-id="' . $p[ 'id' ] . '" data-type="polls" data-status=' . $p[ 'is_active' ] . '>
                                                <label><input type="checkbox" ' . $ischecked . '><span class="lever switch-col-bluenew"></span></label>
                                        </a>
                                </td>'
                        . '<td class="text-center">
                                        <a href="' . base_url() . 'Poll/index?id=' . $p[ 'id' ] . '" data-id="' . $p[ 'id' ] . '" data-editjson=\'' . json_encode( $p ) . '\'><i class="material-icons">&#xE254;</i></a>
                                        <a href="' . base_url() . 'Poll/poll_details?id=' . $p[ 'id' ] . '" data-id="' . $p[ 'id' ] . '"><i class="material-icons">remove_red_eye</i></a>
                                                ' . $update_right_answer . '
                                </td></tr>';

                endforeach;
                echo $output;

        }

        function exportList_polls() {
                $polls = array ();

                $data = "";

                $inputs = $this -> input -> get();

                $polls = $this -> Poll_model -> get_filtered_list_exported( $inputs );

                $output = '';
                // $num = $inputs['offSet'];

                $data .= '<tr>
                                        <th># Sr. No</th>
                                        <th>Poll</th>
                                        <th>Description</th>
                                        <th class="text-center">Is Approved</th>
                                        <th class="text-center">Created Date</th>
                                        <th class="text-right">Active</th>
                                        <th class="text-center">Action</th>
                                    </tr>';

                foreach ( $polls as $key => $p ) :
                        $ischecked = ($p[ 'is_active' ] == 1) ? "checked" : "";
                        $isapproved = ($p[ 'is_approved' ] == "1") ? "Yes" : "No";
                        $num = $key + 1;

                        $answer = '';

                        $data .= '<tr>'
                                . '<td>' . $num . '</td>'
                                . '<td><p class="multiline-ellipsis" data-lines="1">' . $p[ 'poll' ] . '</p></td>'
                                . '<td><p class="multiline-ellipsis" data-lines="3">' . $p[ 'description' ] . '</p></td>'
                                . '<td class="text-center">' . $isapproved . '</td>'
                                . '<td class="text-center">' . date( "d-m-Y", strtotime( $p[ 'created_date' ] ) ) . '</td>'
                                . '<td class="text-center">
                                        <a class="switch changeactivepoll" data-id="' . $p[ 'id' ] . '" data-type="polls" data-status=' . $p[ 'is_active' ] . '>
                                                <label><input type="checkbox" ' . $ischecked . '><span class="lever switch-col-bluenew"></span></label>
                                        </a>
                                </td>'
                                . '<td class="text-center">
                                        <a href="' . base_url() . 'Poll/index?id=' . $p[ 'id' ] . '" data-id="' . $p[ 'id' ] . '" data-editjson=\'' . json_encode( $p ) . '\'><i class="material-icons">&#xE254;</i></a>
                                        <a href="' . base_url() . 'Poll/poll_details?id=' . $p[ 'id' ] . '" data-id="' . $p[ 'id' ] . '"><i class="material-icons">remove_red_eye</i></a>
                                                ' . $answer . '
                                </td></tr>';

                endforeach;


                $file = "polls.xls";
                $test = "<table border='1'>" . $data . "</table>";
                header( "Content-type: application/vnd.ms-excel" );
                header( "Content-Disposition: attachment; filename=$file" );
                echo $test;

        }

        function poll_details() {
                $poll_data = array ();
                $page_title[ 'page_title' ] = "Polls Details";
                $poll_id = $this -> input -> get( 'id' );
                // $data[ 'poll' ] = $this -> Poll_model -> get_list();
                // $poll_id = $this -> input -> post( 'pollid' );
                $poll_data = $this -> Poll_model -> get_details_poll( $poll_id );

                $poll_data[ 'polls' ] = $this -> Poll_model -> get_poll_count( $poll_id );

                $poll_data[ 'replies' ] = $this -> Poll_model -> get_poll_replies( $poll_id );

                $this -> load -> view( 'template/header', $page_title );
                $this -> load -> view( 'poll_details', $poll_data );
                $this -> load -> view( 'template/footer' );
                echo $poll_id;

        }

        function poll_detail() {
                $poll_id = $this -> input -> post( 'pollid' );
                $poll_data = $this -> Poll_model -> get_poll_details( $poll_id );
                echo json_encode( $poll_data );

        }

        function details( $id ) {
                $header_data[ 'page_title' ] = "Details";
                $data[ 'poll_detail' ] = $this -> Poll_model -> get_poll_details( $id );
                //$data[ 'poll_detail' ] = $this -> Poll_model -> get_poll_detail( $id );
                ///$data[ 'poll_detail' ][ 'options' ] = $this -> Poll_model -> get_poll_options( $id );

                $this -> load -> view( 'template/header', $header_data );
                $this -> load -> view( 'details', $data );
                $this -> load -> view( 'template/footer' );

        }

        function update_answer() {
                $inputs = $this -> input -> post();
                $this -> Poll_model -> update_answer_mod( $inputs );
                redirect( "Poll/lists" );

        }

        function create_update( $id = 0 ) {

                $data = array ();
                $page_title[ 'page_title' ] = "Polls";
                $data[ 'poll_category' ] = $this -> Poll_model -> get_poll_category();

                $inputs = $this -> input -> post();
                $inputs[ 'user_id' ] = $this -> userdata[ 'user_id' ];

                $this -> Poll_model -> add_update_poll( $inputs );

                $this -> load -> view( 'template/header', $page_title );
                $this -> load -> view( 'add_update_poll', $data );
                $this -> load -> view( 'template/footer' );

                redirect( 'Poll/lists' );

        }

        function lists() {
                $data = array ();
                $page_title[ 'page_title' ] = "Polls";

                $data[ 'polls' ] = $this -> Poll_model -> get_list();

                $data[ 'topics' ] = $this -> Poll_model -> get_topic_list();

                $this -> load -> view( 'template/header', $page_title );
                $this -> load -> view( 'poll_list', $data );
                $this -> load -> view( 'template/footer' );

        }

        function approve_poll() {
                $inputs = $this -> input -> post();

                $inputs[ 'user_id' ] = $this -> userdata[ 'user_id' ];

                $this -> Poll_model -> approve_poll( $inputs );

                echo json_encode( array ( "status" => TRUE, "message" => "Poll approved successfully" ) );

        }

        function active_inactive_poll() {
                $inputs = $this -> input -> post();

                $this -> Poll_model -> active_inactive_poll_mod( $inputs );

                $message = ($inputs[ 'current' ] == "1") ? "Poll deactivated successfully" : "Poll activated successfully";
                echo json_encode( array ( "status" => TRUE, "message" => $message ) );

        }

        function export_polls() {
                $data = "";
                $polls = $this -> Poll_model -> get_list();

                $data = '<tr>'
                        . '<td><strong>Sr. No.</strong></td>'
                        . '<td><strong>Category</strong></td>'
                        . '<td><strong>Poll</strong></td>'
                        . '<td><strong>Description</strong></td>'
                        . '<td><strong>Choices</strong></td>'
                        . '<td><strong>Approved</strong></td>'
                        . '<td><strong>Created Date</strong></td>'
                        . '<td><strong>Is Active</strong></td>'
                        . '</tr>';

                foreach ( $polls as $key => $poll_data ) {
                        $num = $key + 1;
                        $is_approved = ($poll_data[ 'is_approved' ] == 1) ? "Yes" : "No";
                        $is_active = ($poll_data[ 'is_active' ] == 1) ? "Yes" : "No";

                        $data .= '<tr>'
                                . '<td>' . $num . '</td>'
                                . '<td>' . $poll_data[ 'category' ] . '</td>'
                                . '<td>' . $poll_data[ 'poll' ] . '</td>'
                                . '<td>' . $poll_data[ 'description' ] . '</td>'
                                . '<td>' . $poll_data[ 'choices' ] . '</td>'
                                . '<td>' . $is_approved . '</td>'
                                . '<td>' . $poll_data[ 'created_date' ] . '</td>'
                                . '<td>' . $is_active . '</td>'
                                . '</tr>';
                }
                $file = "polls.xls";
                $test = "<table border='1'>" . $data . "</table>";
                header( "Content-type: application/vnd.ms-excel" );
                header( "Content-Disposition: attachment; filename=$file" );
                echo $test;

        }

}
