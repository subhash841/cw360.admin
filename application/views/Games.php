<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Games extends CI_Controller {      
        function __construct() {
                parent::__construct();
                $this->load->config('validation_rules', TRUE);
                $this -> load -> model( 'Games_model' );
                $this -> load -> model( 'User_model' );                
                $this -> userdata = $this -> session -> userdata( 'loggedin' );
                
        }
        private $userdata = array ();

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
                $data['topics'] = $this->Games_model->get_topic_list();
                $page_title[ 'page_title' ] = "Games";
                $this -> load -> view( 'template/header', $page_title );
                $this -> load -> view( 'add_update_game', $data );
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


        

        //array_walk_recursive($array, 'html_escape');



        function filteredList() {


                $games = array ();
                $inputs = $this -> input -> post();
                $games = $this -> Games_model -> get_filtered_list( $inputs );
                $output = '';
                $num = $inputs[ 'offSet' ];

                    foreach ( $games as $key => $p ):
                                     /*  echo'<pre>'; print_r($p);*/

                                    $ischecked = ($p[ 'is_active' ] == 1) ? "checked" : "";
                                    $ispublished = ($p[ 'is_published' ] == 1) ? "checked" : "";
                                    $num = $num + 1;

                                    $game_id_exist=check_data_in_used('game_id',$p['id'],'points');

                                    if($game_id_exist > 0){
                                        $disabled = "disabled =''";
                                        $class = "invalid";
                                        }else{
                                        $class = "changeactivegame";
                                        $disabled = "";

                                       }
                                           /* $num = $key + 1;*/
                                           echo '<tr>'
                                       . '<td>' . $p['id'] . '</td>'
                                            //. '<td>' . $p[ 'category' ] . '</td>'
                                       . '<td><p class="multiline-ellipsis" data-lines="1">' . $p[ 'title' ] . '</p></td>'
                                       . '<td><p class="multiline-ellipsis" data-lines="3">' . date( "d-m-Y H:i:s", strtotime( $p[ 'start_date' ] ) ) . '</p></td>'

                                       . '<td class="text-center">' . date( "d-m-Y H:i:s", strtotime( $p[ 'end_date' ] ) ) . '</td>'

                                       /*. '<td class="text-center">' . $ispublished . '</td>'*/

                                        . '<td class="text-center">
                                                <a class="switch changepublishgame" data-id="' . $p[ 'id' ] . '" data-type="games" data-status=' . $p[ 'is_published' ] . '>

                                                    <label><input type="checkbox" ' . $ispublished . '><span class="lever switch-col-bluenew"></span></label>
                                                </a>
                                                </td>'


                                        . '<td class="text-center">
                                                <a href="' . base_url() . 'Games/index?id=' . $p[ 'id' ] . '" data-id="' . $p[ 'id' ] . '" ><i class="material-icons">&#xE254;</i></a>
                                                <a href="#" '.$disabled .' data-id="' . $p[ 'id' ] . '" data-type="games" class="'.$class.'"><i class="material-icons">delete_forever</i></a>
                                                </td>
                                                </tr>';
                endforeach;               
                    
                 echo $output;

        }


        function exportList_games() {
                $games = array ();

                $data = "";

                $inputs = $this -> input -> get();
                // print_r($inputs);die;
                $games = $this -> Games_model -> get_filtered_list_exported( $inputs );
                
                $output = '';
                // $num = $inputs['offSet'];

                $data .= '<tr>
                                        <th class="text-center"># Game ID</th>
                                        <th class="text-center">Game Title</th>
                                        <th class="text-center">Start Date</th>
                                        <th class="text-center">End Date</th>
                        </tr>';

                  foreach ( $games as $key => $p ):
                                     /*  echo'<pre>'; print_r($p);*/

                                    $num = $num + 1;
                                           /* $num = $key + 1;*/
                    $data .='<tr>'
                                       . '<td>' . $p['id'] . '</td>'
                                            //. '<td>' . $p[ 'category' ] . '</td>'
                                       . '<td><p class="multiline-ellipsis" data-lines="1">' . $p[ 'title' ] . '</p></td>'
                                       . '<td><p class="multiline-ellipsis" data-lines="3">' . date( "d-m-Y", strtotime( $p[ 'start_date' ] ) ) . '</p></td>'
                                       . '<td class="text-center">' . date( "d-m-Y", strtotime( $p[ 'end_date' ] ) ) . '</td>
                                        </tr>';
                endforeach;
                $file = date('Y-m-d h:i:sA') .'_'."Games.xls";
                $test = "<table border='1'>" . $data . "</table>";
                header( "Content-type: application/vnd.ms-excel" );
                header( "Content-Disposition: attachment; filename=$file" );
                echo $test;

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
                    'change_prediction_time' =>strip_tags(form_error('change_prediction_time')),            
                    'point_value_per_coin' =>strip_tags(form_error('point_value_per_coin')),            
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
                print_r($inputs);die;
                $this -> Games_model -> add_update_game( $inputs );
                /*$this -> load -> view( 'template/header', $page_title );
                $this -> load -> view( 'add_update_game');
                $this -> load -> view( 'template/footer' );*/
                /*redirect( 'Games/lists' );*/
            }
            
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



        function changepublishgame() {
                $id = $this -> input -> post( 'id' );
                $type = $this -> input -> post( 'type' );
                $current = $this -> input -> post( 'current' );
                $newstatus = ($current == "1") ? 0 : 1;

                $status = $this -> Games_model -> changepublishgame( $id, $newstatus );
                $msg = "Action performed successfully";
                echo json_encode( array ( "status" => $status, "message" => $msg ) );
        }





        /*TRANSFER DEDUCT POINTS*/
         function Add_deduct_points() {
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

                $data['games'] = $this -> Games_model -> get_all_games_list("1");
                // print_r($data);die;
                $data['filter_games'] = $this -> Games_model -> get_all_games_list();
               
                // $data['user'] = $this -> Games_model ->get_user_list();
                $data['orders'] = $this -> Games_model ->get_userpoints_history();
                //$data['filter_pred'] = $this -> User_model ->filter_pred();
                //echo'<pre>';print_r($data['filter_pred']);exit();
                $page_title[ 'page_title' ] = "Transfer Deduct Coins";
                $this -> load -> view( 'template/header', $page_title );
                $this -> load -> view( 'add_deduct_points', $data );
                $this -> load -> view( 'template/footer' );
        }


        function update_points() {
            
                $data = array();
                $inputs = $this -> input -> post();
                $page_title[ 'page_title' ] = "Update Coins";
                /*$validationResult = $this->Games_model->validate_game();*/
                $game_id = $this->input->post('game_id');
                $prediction_id = $this->input->post('prediction_id');
                $action = $this->input->post('action');
                $points = $this->input->post('points');
                $validationResult = $this->Games_model->validate_add_deduct_points();
                
                if(empty($validationResult)){
                    $data['status']= 'failure';
                    $data['error'] = array(
                        'game_id' =>strip_tags(form_error('game_id')),            
                        'prediction_id' =>strip_tags(form_error('prediction_id')),            
                        'action' =>strip_tags(form_error('action')),            
                        'points' =>strip_tags(form_error('points')),            
                    );                
                }else{
                    $swipe_status="agreed";
                       
                    // print_r( $list_user_ids);die;
                if($action == 'Add'){
                        $data['status'] = "success";                    
                        $data['toast_message'] = $this->input->post('action');
                        $this->Games_model->add_deduct_points($game_id,$prediction_id,$swipe_status,$points,$action);                    
                }else{  
                    $data['status'] = "success";
                    $data['toast_message'] = $this->input->post('action');
                    $this -> Games_model -> add_deduct_points($game_id,$prediction_id,$swipe_status,$points,$action);

                }
            }   

                /*$this -> load -> view( 'template/header', $page_title );
                $this -> load -> view( 'add_update_game');
                $this -> load -> view( 'template/footer' );*/
                /*redirect( 'Games/lists' );*/
                echo json_encode($data);
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

        function fetchPrediction2(){
                    $arr_result = array ();
                    $excludetopicids = array ();
                    $ids = array ();

                    $inputs = $this -> input -> post();
                    
                    $title = $inputs[ 'searchTerm'];
                    $game_name = $inputs[ 'game_name' ];
                    if(!empty($game_name)){
                        $game_id = get_game_id($game_name);
                    }
                    $arr_result = $this -> User_model -> filter_pred( $title,$game_id );
                    if ( count( $arr_result ) > 0 ) {                                
                            echo json_encode( $arr_result );

                        }

        }

           

        function PointsfilteredList() {
                $games = array ();
                $inputs = $this -> input -> post();
                //  echo'<pre>';print_r($inputs);exit();

                $orders = $this -> Games_model -> get_filtered_userpoints_history($inputs);
                $num = $inputs[ 'offSet' ];
                // $orders = $this -> Games_model -> get_userpoints_history($num);
                // echo $this->db->last_query();die;
                
                $output = '';

                    if(!empty($orders)){
                       foreach( $orders as $key => $o):
                                        
                                
                                    echo '<tr id="myTable">'
                                       . '<td class="text-center">' . $o['game_name'] . '</td>'
                                       . '<td class="text-center">' . $o['prediction_name'] . '</td>'
                                       . '<td class="text-center">' . $o['type']. '</td>'
                                       . '<td class="text-center">' . $o['points'] . '</td>'
                                       . '<td class="text-center">' . date( "d-m-Y", strtotime( $o[ 'created_date' ] ) ) . '</td></tr>';
                                        endforeach;
                        } /* else {
                            echo '<tr style="text-align:center;"><td colspan="6"><b>No records found</b></td></tr>';
                        } */
                echo $output;
            }

            function export_Pointsfiltered() {
                $add_deduct_points = array ();

                $data = "";

                $inputs = $this -> input -> get();

                // $add_deduct_points = $this -> Games_model -> get_filtered_userpoints_history($inputs,'1');
                // $num = $inputs[ 'offSet' ];
                // echo $num;
                $add_deduct_points = $this -> Games_model -> get_filtered_userpoints_history($inputs,"1");
                // echo $this->db->last_query();die;
                // print_r($add_deduct_points);die;
                $output = '';
                // $num = $inputs['offSet'];

                $data .= '<tr>
                                        <th class="text-center">Game</th>
                                        <th class="text-center">Prediction</th>
                                        <th class="text-center">Type</th>
                                        <th class="text-center">Updated Coins</th>
                                        <th class="text-center">Date</th>
                        </tr>';

                  foreach ( $add_deduct_points as $key => $p ):
                                     /*  echo'<pre>'; print_r($p);*/

                                //     $num = $num + 1;
                                           /* $num = $key + 1;*/
                    $data .='<tr>'
                                       . '<td>' . $p['game_name'] . '</td>'
                                       . '<td>' . $p[ 'prediction_name' ] . '</td>'
                                       . '<td><p class="multiline-ellipsis" data-lines="3">' . $p['type'] . '</p></td>'
                                       . '<td><p class="multiline-ellipsis" data-lines="1">' . $p[ 'points' ] . '</p></td>'
                                       . '<td class="text-center">' . date( "d-m-Y", strtotime( $p[ 'created_date' ] ) ) . '</td>
                             </tr>';
                endforeach;
                $file = date('Y-m-d h:i:sA') .'_'."add_deduct_coins.xls";
                $test = "<table border='1'>" . $data . "</table>";
                header( "Content-type: application/vnd.ms-excel" );
                header( "Content-Disposition: attachment; filename=$file" );
                echo $test;

        }

}
