<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Reward extends Base_Controller {
        
        private $userdata = array ();

        function __construct() {
                parent::__construct();
                $this->load->config('validation_rules', TRUE);
                $this -> load -> model( array('Games_model','Reward_model') );
                $this -> userdata = $this -> session -> userdata( 'loggedin' );
        }



        function index() {
                $data = array ();
                $reward_id = $this -> input -> get( 'id' );
                if ( $reward_id != 0 ) {
                    $data = $this -> Reward_model -> get_reward_details($reward_id);
                    /*$data['topic_name'] = $this->Games_model->get_topic_name($game_id);*/
                     /* echo '<pre>';print_r( $data );
                        exit();*/
                }
                $page_title[ 'page_title' ] = "Reward";
                $this -> load -> view( 'template/header', $page_title );
                $this -> load -> view( 'add_update_reward', $data );
                $this -> load -> view( 'template/footer' );
        }

        



        function filteredList() {
                $games = array ();
                $inputs = $this -> input -> post();
              /* echo'<pre>';print_r($inputs);exit();*/
                $reward = $this -> Reward_model -> get_filtered_list( $inputs );
            
                $output = '';
                $num = $inputs[ 'offSet' ];
                         foreach ( $reward as $key => $r ):
                                       /*  echo'<pre>'; print_r($p);*/
                                       $ischecked = ($r[ 'is_active' ] == 1) ? "checked" : "";
                                       $ispublished = ($r[ 'is_published' ] == 1) ? "checked" : "";

                                       echo '<tr>'
                                       . '<td>' . $r['id'] . '</td>'
                                        //. '<td>' . $p[ 'category' ] . '</td>'
                                       . '<td><p class="multiline-ellipsis" data-lines="1">' . $r[ 'title' ] . '</p></td>'
                                      

                                       . '<td class="text-center">' . $r[ 'req_coins' ] . '</td>'
                                        
                                       . '<td class="text-center"><div class="" style="height:68px; background:url(' . $r[ 'image' ] . ') center center no-repeat;background-size:contain;"></div></td>'
                                       . '<td class="text-center">
                                                <a class="switch changepublishreward" data-id="' . $r[ 'id' ] . '" data-type="rewards" data-status=' . $r[ 'is_published' ] . '>

                                                    <label><input type="checkbox" ' . $ispublished . '><span class="lever switch-col-bluenew"></span></label>
                                                </a>
                                                </td>' 

                                            /*. '<td class="text-center">
                                                <a class="switch changeactivegame" data-id="' . $p[ 'id' ] . '" data-type="games" data-status=' . $p[ 'is_active' ] . '>

                                                    <label><input type="checkbox" ' . $ischecked . '><span class="lever switch-col-bluenew"></span></label>
                                                </a>
                                                </td>'*/
                                                . '<td class="text-center">
                                                <a href="' . base_url() . 'Reward/index?id=' . $r[ 'id' ] . '" data-id="' . $r[ 'id' ] . '" ><i class="material-icons">&#xE254;</i></a>
                                                <a href="#" data-id="' . $r[ 'id' ] . '" data-type="reward" class="changeactivereward"><i class="material-icons">delete_forever</i></a>
                                                </td>
                                                </tr>';
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



        function create_update( $id = 0 ) {

                $data = array();
                $inputs = $this -> input -> post();
                $page_title[ 'page_title' ] = "Reward";
                $validationResult = $this-> Reward_model ->validate_reward();
                if(empty($validationResult)){
                $data['status']= 'failure';
                $data['error'] = array(
                    'title' =>strip_tags(form_error('title')),            
                    'req_coins' =>strip_tags(form_error('req_coins')),            
                 );
                
                }else{
                if(empty($this -> input -> post('reward_id'))){
                    $data['toast_message'] = "Reward Created Successfully";   
                }else{
                    $data['toast_message'] = "Reward Updated Successfully";
                }
                $data['status'] = "success";
                $inputs = $this -> input -> post();
                $inputs[ 'user_id' ] = $this -> userdata[ 'user_id' ];
                $this -> Reward_model -> add_update_reward( $inputs );
                /*$this -> load -> view( 'template/header', $page_title );
                $this -> load -> view( 'add_update_game');
                $this -> load -> view( 'template/footer' );*/
                /*redirect( 'Games/lists' );*/
            }
            echo json_encode($data);

        }

        function lists() {
                $data = array ();
                $page_title[ 'page_title' ] = "Reward";
                $data[ 'reward' ] = $this -> Reward_model -> get_list();

                $this -> load -> view( 'template/header', $page_title );
                $this -> load -> view( 'reward_list', $data );
                $this -> load -> view( 'template/footer' );
            }

        function approve_poll() {
                $inputs = $this -> input -> post();

                $inputs[ 'user_id' ] = $this -> userdata[ 'user_id' ];

                $this -> Poll_model -> approve_poll( $inputs );

                echo json_encode( array ( "status" => TRUE, "message" => "Poll approved successfully" ) );

        }

        function active_inactive_subscription() {
                $inputs = $this -> input -> post();
                $this -> Subscription_model -> active_inactive_subscription_mod( $inputs );
                $message = "Subscription deleted successfully";
                echo json_encode( array ( "status" => TRUE, "message" => $message ) );

        }

         function active_inactive_reward() {
                $inputs = $this -> input -> post();
                $this -> Reward_model -> active_inactive_reward_mod( $inputs );
                $message = "Reward deleted successfully";
                echo json_encode( array ( "status" => TRUE, "message" => $message ) );

        }

        function changepublishreward() {

                $id = $this -> input -> post( 'id' );
                $type = $this -> input -> post( 'type' );
                $current = $this -> input -> post( 'current' );
                $newstatus = ($current == 1) ? 0 : 1;
                $status = $this -> Reward_model -> changepublishreward( $id, $newstatus );

                $msg = "Action performed successfully";
                echo json_encode( array ( "status" => $status, "message" => $msg ) );
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





        /*SUBSCRIPTION TRANSACTION HISTORY*/

        public function Subscription_trans_history(){

            $data = array ();
            $page_title[ 'page_title' ] = "Subscription History";
            $data[ 'subsc_trans' ] = $this -> Subscription_model -> get_transaction_list();
            $this -> load -> view( 'template/header', $page_title );
            $this -> load -> view( 'subscription_trans_history', $data );
            $this -> load -> view( 'template/footer' );
        }



        function filteredList_trans() {
                $games = array ();
                $inputs = $this -> input -> post();
              /* echo'<pre>';print_r($inputs);exit();*/
                $subsc_trans = $this -> Subscription_model -> get_filtered_listtrans( $inputs );
            
                $output = '';
                $num = $inputs[ 'offSet' ];
                        foreach ( $subsc_trans as $key => $s ):
                                    /*  echo'<pre>'; print_r($p);*/
                                    /* $num = $key + 1;*/
                                            echo '<tr>'
                                            . '<td>' . $s['user_id'] . '</td>'
                                            . '<td>' . $s['user_email'] . '</td>'
                                            . '<td>' . $s['user_mobile'] . '</td>'
                                            . '<td>' . $s['transaction_amount'] . '</td>'
                                            . '<td><p class="multiline-ellipsis" data-lines="1">' . $s[ 'coins' ] . '</p></td>'      
                                            . '<td><p class="multiline-ellipsis" data-lines="1">' . $s[ 'unique_ref_number' ] . '</p></td>'       
                                            . '<td><p class="multiline-ellipsis" data-lines="3">' . $s['transaction_date'] . '</p></td></tr>';
                                    endforeach;
                echo $output;
            }








}
