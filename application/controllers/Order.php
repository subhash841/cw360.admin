<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Order extends Base_Controller {
        
        private $userdata = array ();

        function __construct() {
                parent::__construct();
                $this->load->config('validation_rules', TRUE);
                $this -> load -> model( array('Games_model','Reward_model','User_model','Predictions_model') );
                $this -> userdata = $this -> session -> userdata( 'loggedin' );
                ini_set('memory_limit', '-1');
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
                 // echo'<pre>';print_r($inputs);exit();

                $orders = $this -> User_model -> get_filtered_listorder( $inputs );
                
                $output = '';

                $num = $inputs[ 'offSet' ];
                    if(!empty($orders)){
                        foreach ( $orders as $key => $o ):
                                       $swipe_status =  $o[ 'swipe_status' ] == 'agreed' ?'YES':'NO';
                                        echo '<tr>'
                                        
                                        . '<td>' . $o['orderid'] . '</td>'
                                        .'<td><p class="multiline-ellipsis" data-lines="1">' . $o[ 'game_title' ] . '</p></td>'
                                        . '<td>' . $o['prediction_title'] . '</td>'
                                        //. '<td>' . $p[ 'category' ] . '</td>'
                                        .'<td><p class="multiline-ellipsis" data-lines="1">' . $o[ 'name' ] . '</p></td>'
                                        .'<td><p class="multiline-ellipsis" data-lines="1">' . $o[ 'email' ] . '</p></td>'
                                        .'<td><p class="multiline-ellipsis" data-lines="1">' . $o[ 'created_date' ] . '</p></td>'
                                        /*.'<td><p class="multiline-ellipsis" data-lines="1">' . $o[ 'email' ] . '</p></td>'*/
                                        .'<td class="text-center">' . $o[ 'points' ] . '</td>'
                                        .'<td class="text-center">' . $swipe_status . '</td>'
                                         /*.'<td><p class="multiline-ellipsis" data-lines="1">' .($o[ 'points' ] - $o[ 'current_price' ]) . '</p></td>'
                                        .'<td><p class="multiline-ellipsis" data-lines="1">' . $o[ 'current_price' ] . '</p></td>'*/
                                        .'</tr>';
                            endforeach;
                        } else {
                            echo '<tr><td colspan="8"><b>No records found</b></td></tr>';
                        }
                echo $output;
            }


         function exportList_order() {
                $polls = array ();

                $data = "";

                $inputs = $this -> input -> get();
               /* print_r($inputs);
                exit();*/
               
                $orders = $this -> User_model -> get_filtered_listorder_exported( $inputs,true );
               
                $output = '';
                // $num = $inputs['offSet'];

                $data .= '<tr>          <th># ORDER ID </th>
                                        <th>Game Name</th>
                                        <th>Prediction name</th>
                                        <th class="text-center">Buyers Name</th>
                                        <th class="text-center">Email</th>

                                        <th class="text-center">Trade Date and Time</th>
                                        <th style="width:8%" class="text-center">(Buy/Sell) value</th>
                                        <th style="width:10%" class="text-center">Type of Trade(Yes/No)</th>
                                        
                                    </tr>';
                                        // <th style="width:10%" class="text-center">Profit Value </th>
                                        // <th style="width:10%" class="text-center">Current Value</th>

                foreach ( $orders as $key => $o ) :
                        
                        $num = $key + 1;

                        $swipe_status =  $o[ 'swipe_status' ] == "agreed" ?'YES':'NO';

                        $data .='<tr>'
                                        . '<td>' . $o['orderid'] . '</td>'
                                        .'<td><p class="multiline-ellipsis" data-lines="1">' . $o[ 'game_title' ] . '</p></td>'
                                        . '<td>' . $o['prediction_title'] . '</td>'
                                        //. '<td>' . $p[ 'category' ] . '</td>'
                                        .'<td><p class="multiline-ellipsis" data-lines="1">' . $o[ 'name' ] . '</p></td>'
                                        .'<td><p class="multiline-ellipsis" data-lines="1">' . $o[ 'email' ] . '</p></td>'
                                        .'<td><p class="multiline-ellipsis" data-lines="1">' . $o[ 'created_date' ] . '</p></td>'
                                        /*.'<td><p class="multiline-ellipsis" data-lines="1">' . $o[ 'email' ] . '</p></td>'*/
                                        .'<td class="text-center">' . $o[ 'points' ] . '</td>'
                                        .'<td class="text-center">' . $swipe_status . '</td>'
                                        /* .'<td><p class="multiline-ellipsis" data-lines="1">' .($o[ 'points' ] - $o[ 'current_price' ]) . '</p></td>'
                                        .'<td><p class="multiline-ellipsis" data-lines="1">' . $o[ 'current_price' ] . '</p></td>'*/
                                        .'</tr>';
                endforeach;

                
                $file = "order.xls";
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
                $page_title[ 'page_title' ] = "Order list";
                $data['games'] = $this-> Games_model ->get_games_list();
                $data[ 'orders' ] = $this -> User_model -> get_order_list();
                $data['predictions'] = $this-> Predictions_model ->get_prediction_list();
                $data['users'] = $this-> User_model ->get_users();
                $data['u_name'] = $this->User_model->get_username();
                /*echo '<pre>';print_r($data['users']);
                exit();*/
                $this -> load -> view( 'template/header', $page_title );
                $this -> load -> view( 'order_list', $data );
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

        function changepublishreward() {

                $id = $this -> input -> post( 'id' );
                $type = $this -> input -> post( 'type' );
                $current = $this -> input -> post( 'current' );
                $newstatus = ($current == 1) ? 0 : 1;
                $status = $this -> Reward_model -> changepublishreward( $id, $newstatus );
                $msg = "Action performed successfully";
                echo json_encode( array ( "status" => $status, "message" => $msg ) );
        }


         function fetchPrediction(){

                    $arr_result = array ();
                    $excludetopicids = array ();
                    $ids = array ();

                    $inputs = $this -> input -> post();
                    
                    $title = $inputs[ 'searchTerm'];
                    $game_id = $inputs[ 'game_id' ];

                     if ( isset( $inputs[ 'topic_id' ] ) ) {
                        $excludetopicids = json_decode( $inputs[ 'topic_id' ] );
                    }

                    if ( count( $excludetopicids ) > 0 ) {
                        $ids = $excludetopicids;                        
                    }
                    
                    $arr_result = $this -> User_model -> search_pred( $title,$game_id );
                      
                    if ( count( $arr_result ) > 0 ) {                                
                            echo json_encode( $arr_result );

                        }
                      
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
