<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Subscription extends Base_Controller {
        
        private $userdata = array ();

        function __construct() {
                parent::__construct();
                $this->load->config('validation_rules', TRUE);
                $this -> load -> model( array('Subscription_model','Games_model') );
                $this -> userdata = $this -> session -> userdata( 'loggedin' );

        }



        function index() {
                $data = array ();
                $subscription_id = $this -> input -> get( 'id' );
                if ( $subscription_id != 0 ) {
                    $data = $this -> Subscription_model -> get_subscription_details($subscription_id);
                    /*$data['topic_name'] = $this->Games_model->get_topic_name($game_id);*/
                     /* echo '<pre>';print_r( $data );
                        exit();*/
                }

                $data['games'] = $this->Games_model->get_games_list();
               /* echo '<pre>';print_r($data['games']);
                exit();*/
                $page_title[ 'page_title' ] = "Subscription";
                $this -> load -> view( 'template/header', $page_title );
                $this -> load -> view( 'add_update_subscription', $data );
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
                        $ids = $excludetopicids;
                }

                if ( isset( $topic ) ) {
                        $arr_result = $this -> Games_model -> search( $topic, $ids );
                        if ( count( $arr_result ) > 0 ) {                                
                            echo json_encode( $arr_result );
                        }
                }
        }



        function filteredList() {
                $games = array ();
                $inputs = $this -> input -> post();
              /* echo'<pre>';print_r($inputs);exit();*/
                $subscription = $this -> Subscription_model -> get_filtered_list( $inputs );
            
                $output = '';
                $num = $inputs[ 'offSet' ];
                        foreach ( $subscription as $key => $s ):
                                    /* echo'<pre>'; print_r($p);*/
                                    $ischecked = ($s[ 'is_active' ] == 1) ? "checked" : "";
                                    /* $num = $key + 1;*/
                                            echo '<tr>'
                                            . '<td>' . $s['id'] . '</td>'
                                            . '<td><p class="multiline-ellipsis" data-lines="1">' . $s[ 'package_name' ] . '</p></td>'      
                                            . '<td><p class="multiline-ellipsis" data-lines="1">' . $s[ 'price' ] . '</p></td>'       
                                            . '<td><p class="multiline-ellipsis" data-lines="3">' . date( "d-m-Y", strtotime( $s[ 'created_date' ] ) ) . '</p></td>'
                                            . '<td class="text-center">
                                                <a href="' . base_url() . 'Subscription/index?id=' . $s[ 'id' ] . '" data-id="' . $s[ 'id' ] . '" ><i class="material-icons">&#xE254;</i></a>
                                                <a href="#" data-id="' . $s[ 'id' ] . '" data-type="games" class="changeactivesubscription"><i class="material-icons">delete_forever</i></a>
                                                </td>
                                            </tr>';
                        endforeach;
                echo $output;
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
                $data = array();
                $page_title[ 'page_title' ] = "Subscription";
                /*$validationResult = $this->Subscription_model->validate_subscription();
               
                if(empty($validationResult)){
                $data['status']= 'failure';
                $data['error'] = array(
                    'game_id' =>strip_tags(form_error('game_id')),            
                    'package_name' =>strip_tags(form_error('package_name')),            
                    'price' =>strip_tags(form_error('price')),            
                    'points' =>strip_tags(form_error('points')),            
                    'description' =>strip_tags(form_error('description')),            
                );
            } else{*/

                if(empty($this -> input -> post('subscription_id'))){
                    $data['toast_message'] = "Subscription Created Successfully";
                }else{
                    $data['toast_message'] = "Subscription Updated Successfully";
                }
                $data['status'] = "success";
                $inputs = $this -> input -> post();
                $inputs[ 'user_id' ] = $this -> userdata[ 'user_id' ];
                $this -> Subscription_model -> add_update_subscription( $inputs );
                /*$this -> load -> view( 'template/header', $page_title );
                $this -> load -> view( 'add_update_game');
                $this -> load -> view( 'template/footer' );*/
                /*redirect( 'Games/lists' );*/
          /*  }*/
            echo json_encode($data);

        }

        function lists() {
                $data = array ();
                $page_title[ 'page_title' ] = "Subscription";
                $data[ 'subscription' ] = $this -> Subscription_model -> get_list();

                $this -> load -> view( 'template/header', $page_title );
                $this -> load -> view( 'subscription_list', $data );
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
        //       echo'<pre>';print_r($inputs);exit();
                $subsc_trans = $this -> Subscription_model -> get_filtered_listtrans( $inputs );
            
                $output = '';
                $num = $inputs[ 'offSet' ];
                  foreach ( $subsc_trans as $key => $s ):
                                    /*  echo'<pre>'; print_r($p);*/
                                    $num = $num + 1;
                                            echo '<tr>'
                                            . '<td>' . $num . '</td>'
                                            . '<td>' . $s['user_id'] . '</td>'
                                            . '<td>' . $s['user_email'] . '</td>'
                                            . '<td>' . $s['user_mobile'] . '</td>'
                                            . '<td>' . $s['package_name'] . '</td>'
                                            . '<td>' . $s['transaction_amount'] . '</td>'
                                            . '<td><p class="multiline-ellipsis" data-lines="1">' . $s[ 'coins' ] . '</p></td>'      
                                            . '<td><p class="multiline-ellipsis" data-lines="1">' . $s[ 'unique_ref_number' ] . '</p></td>'       
                                            . '<td><p data-lines="1">' . $s[ 'trans_response' ] . '</p></td>'       
                                            . '<td><p class="multiline-ellipsis" data-lines="3">' . $s['transaction_date'] . '</p></td></tr>';
                                    endforeach;
                echo $output;
            }

            function exportTransaction() {
                $polls = array ();

                $data = "";

                $inputs = $this -> input -> get();

                $subsc_trans = $this -> Subscription_model -> get_filtered_list_exported( $inputs );

                $output = '';
                // $num = $inputs['offSet'];

                $data .= '<th>#Sr.No</th>
                                        <th>#User ID</th>
                                        <th class="text-center">User Email</th>
                                        <th class="text-center">User Mobile</th>
                                        <th class="text-center">Subscription Name</th>
                                        <th class="text-center">Transaction Amount</th>
                                        <th class="text-center">Game Coins</th>
                                        <th class="text-center">Reference Number</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Transaction Date</th>';

                foreach ( $subsc_trans as $key => $s ):
                                    /*  echo'<pre>'; print_r($p);*/
                                    $num = $num + 1;
                                            $data .= '<tr>'
                                            . '<td>' . $num . '</td>'
                                            . '<td>' . $s['user_id'] . '</td>'
                                            . '<td>' . $s['user_email'] . '</td>'
                                            . '<td>' . $s['user_mobile'] . '</td>'
                                            . '<td>' . $s['package_name'] . '</td>'
                                            . '<td>' . $s['transaction_amount'] . '</td>'
                                            . '<td><p class="multiline-ellipsis" data-lines="1">' . $s[ 'coins' ] . '</p></td>'      
                                            . '<td><p class="multiline-ellipsis" data-lines="1">' . $s[ 'unique_ref_number' ] . '</p></td>'       
                                            . '<td><p data-lines="1">' . $s[ 'trans_response' ] . '</p></td>'       
                                            . '<td><p class="multiline-ellipsis" data-lines="3">' . $s['transaction_date'] . '</p></td></tr>';
                endforeach;


                $file = "Subscription_trans.xls";
                $test = "<table border='1'>" . $data . "</table>";
                header( "Content-type: application/vnd.ms-excel" );
                header( "Content-Disposition: attachment; filename=$file" );
                echo $test;

        }
}