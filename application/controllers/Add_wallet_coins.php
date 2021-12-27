<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Add_wallet_coins extends Base_Controller {
        

        private $userdata = array ();

        function __construct() {
                parent::__construct();
                $this->load->config('validation_rules', TRUE);
                $this -> load -> model( 'Games_model' );
                $this -> load -> model( 'User_model' );
                
                $this -> userdata = $this -> session -> userdata( 'loggedin' );

        }

        function index() {
                $data = array ();
                $game_id = $this -> input -> get( 'id' );
                if ( $game_id != 0 ) {
                    $data = $this -> Games_model -> get_games_details( $game_id );
                    /*echo'<pre>';print_r($data);
                    exit();*/
                    /*$data['topic_name'] = $this->Games_model->get_topic_name($game_id);*/
                    /*  echo '<pre>';print_r( $data );
                        exit();*/
                }

                $data['games'] = $this -> Games_model -> get_games_list();
                $data['user'] = $this -> Games_model ->get_user_list();
                $data['orders'] = $this -> User_model ->get_usercoins_history();
                

                $page_title[ 'page_title' ] = "Add Wallet Coins";
                $this -> load -> view( 'template/header', $page_title );
                $this -> load -> view( 'add_wallet_coins', $data );
                $this -> load -> view( 'template/footer' );
        }

        function fetchUser() {
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
                $games = $this -> Games_model -> get_filtered_list( $inputs );
                $output = '';
                $num = $inputs[ 'offSet' ];
                
                    foreach ( $games as $key => $p ):
                                     /*  echo'<pre>'; print_r($p);*/

                                            $ischecked = ($p[ 'is_active' ] == 1) ? "checked" : "";
                                            $ispublished = ($p[ 'is_published' ] == "1") ? "Yes" : "No";
                                            $num = $num + 1;
                                           /* $num = $key + 1;*/
                                           echo '<tr>'
                                            . '<td>' . $p['id'] . '</td>'
                                            //. '<td>' . $p[ 'category' ] . '</td>'
                                            . '<td><p class="multiline-ellipsis" data-lines="1">' . $p[ 'title' ] . '</p></td>'
                                            . '<td><p class="multiline-ellipsis" data-lines="3">' . date( "d-m-Y", strtotime( $p[ 'start_date' ] ) ) . '</p></td>'
                                          
                                            . '<td class="text-center">' . date( "d-m-Y", strtotime( $p[ 'end_date' ] ) ) . '</td>'
                                            . '<td class="text-center">' . $ispublished . '</td>'
                                            /*. '<td class="text-center">
                                                <a class="switch changeactivegame" data-id="' . $p[ 'id' ] . '" data-type="games" data-status=' . $p[ 'is_active' ] . '>

                                                    <label><input type="checkbox" ' . $ischecked . '><span class="lever switch-col-bluenew"></span></label>
                                                </a>
                                            </td>'*/
                                            . '<td class="text-center">
                                                <a href="' . base_url() . 'Games/index?id=' . $p[ 'id' ] . '" data-id="' . $p[ 'id' ] . '"><i class="material-icons">&#xE254;</i></a>
                                                <a href="#" data-id="' . $p[ 'id' ] . '" data-type="games" class="changeactivegame"><i class="material-icons">delete_forever</i></a>
                                                </td></tr>';
                endforeach;
                echo $output;
        }




        function exportList_wallet() {
                $polls = array ();

                $data = "";
                $inputs = $this -> input -> get();
                $orders = $this -> User_model ->get_usercoins_history();
                $output = '';
                // $num = $inputs['offSet'];

                $data .= '<th class="text-center">User Name</th>
                                        <th class="text-center">User Email</th>
                                        <th class="text-center">Updated Coins</th>
                                        <th class="text-center">Type</th>
                                        <th class="text-center">Previous Coins</th>
                                        <th class="text-center">New Coins</th>
                                        <th class="text-center">Date</th>';

                foreach ( $orders as $key => $o):
                                        
                                    $type = ($o[ 'type' ] == 'add') ? "Add" : "Deduct";
                                    $data .= '<tr>'
                                       . '<td class="text-center">' . blank_value($o['name']) . '</td>'
                                       . '<td class="text-center">' . $o['email'] . '</td>'
                                       . '<td class="text-center">' . $o['coins'] . '</td>'
                                       . '<td class="text-center">' . $type . '</td>'
                                       . '<td class="text-center">' . $o['previous_coins'] . '</td>'
                                       . '<td class="text-center">' . $o['new_game_coins'] . '</td>'
                                       . '<td class="text-center">' . date( "d-m-Y H:i a", strtotime( $o[ 'created_date' ] ) ) . '</td></tr>';
                endforeach;


                $file = "wallet.xls";
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
                $data = array();
                $inputs = $this -> input -> post();
                $page_title[ 'page_title' ] = "Games";
                $validationResult = $this->Games_model->validate_game();
                if(empty($validationResult)){
                $data['status']= 'failure';
                $data['error'] = array(
                    'title' =>strip_tags(form_error('title')),            
                    'description' =>strip_tags(form_error('description')),            
                    'meta_keywords' =>strip_tags(form_error('meta_keywords')),            
                    'meta_description' =>strip_tags(form_error('meta_description')),            
                    'topics' =>strip_tags(form_error('topics')),            
                    'max_players' =>strip_tags(form_error('max_players')),            
                 );
                
                }else{
                if(empty($this -> input -> post('game_id'))){
                    $data['toast_message'] = "Game Created Successfully";   
                }else{
                    $data['toast_message'] = "Game Updated Successfully";
                }
                $data['status'] = "success";
                $inputs = $this -> input -> post();
                $inputs[ 'user_id' ] = $this -> userdata[ 'user_id' ];
                $this -> Games_model -> add_update_game( $inputs );
                /*$this -> load -> view( 'template/header', $page_title );
                $this -> load -> view( 'add_update_game');
                $this -> load -> view( 'template/footer' );*/
                /*redirect( 'Games/lists' );*/
            }
            echo json_encode($data);
        }




        function update_coins() {
            
                $data = array();
                $inputs = $this -> input -> post();
                $page_title[ 'page_title' ] = "Update Coins";
                /*$validationResult = $this->Games_model->validate_game();*/
                $coins = $this->input->post('coins');
                $action = $this->input->post('action');
                $user_id = $this->input->post('user_id');
                $game_id = $this->input->post('game_id');

                $validationResult = $this->Games_model->validate_walletcoin();
                
                if(empty($validationResult)){
                $data['status']= 'failure';
                $data['error'] = array(
                    'coins' =>strip_tags(form_error('coins')),            
                );
                
                }else{

                if($action == 'deduct'){

                    $validate_coins = $this -> User_model -> validate_coins($user_id,$coins);    // TO CHECK WHETHER THE USER HAVE LESS COINS FROM DEDUCTED COINS
                    if($validate_coins == 2){
                              $data['status'] = "failure";
                              $data['error'] = array(
                                'coins' =>strip_tags(form_error('coins'))         
                );                                       // IF
                    }else{
                            $data['status'] = "success";                                         // ELSE
                            $data['toast_message'] = $this->input->post('action');
                            $this -> Games_model -> add_update_coins($user_id,$coins,$action);
                    }

                }else{  

                    $data['status'] = "success";
                    $data['toast_message'] = $this->input->post('action');
                    $this -> Games_model -> add_update_coins($user_id,$coins,$action);

                }
            }   

                /*$this -> load -> view( 'template/header', $page_title );
                $this -> load -> view( 'add_update_game');
                $this -> load -> view( 'template/footer' );*/
                /*redirect( 'Games/lists' );*/
                echo json_encode($data);
        }


         function lists() {
                $data = array ();
                $page_title[ 'page_title' ] = "Games";
                $data[ 'games' ] = $this -> Games_model -> get_list();
                $this -> load -> view( 'template/header', $page_title );
                $this -> load -> view( 'game_list', $data );
                $this -> load -> view( 'template/footer' );
            }

        function approve_poll() {
                $inputs = $this -> input -> post();
                $inputs[ 'user_id' ] = $this -> userdata[ 'user_id' ];
                $this -> Poll_model -> approve_poll( $inputs );
                echo json_encode( array ( "status" => TRUE, "message" => "Poll approved successfully" ) );

        }

        function active_inactive_game() {
                $inputs = $this -> input -> post();
                $this -> Games_model -> active_inactive_game_mod( $inputs );
                $message = "Game deleted successfully";
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
