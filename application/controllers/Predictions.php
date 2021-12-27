<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Predictions extends Base_Controller{        
        
        private $userdata = array ();
        function __construct() {
                parent::__construct();
                $this->load->config('validation_rules', TRUE);
                $this -> load -> model( array('Games_model','Predictions_model') );
                $this -> userdata = $this -> session -> userdata( 'loggedin' );
        }


        function index() {
        
                $data = array ();
                $prediction_id = $this -> input -> get( 'id' );
                if ( $prediction_id != 0 ) {
                        $data['prediction_data'] = $this -> Predictions_model -> get_predictions_details( $prediction_id );
                }
                /*echo'<pre>';print_r($data['prediction_data']);exit();*/
                //$data['topics'] = $this->Games_model->get_topic_list(); 
                $data['games'] = $this->Games_model->get_games_list("1"); 
                 // echo'<pre>';print_r($data);exit();
                $page_title[ 'page_title' ] = "Predictions";
                $this -> load -> view( 'template/header', $page_title );
                $this -> load -> view( 'add_update_predictions', $data );
                $this -> load -> view( 'template/footer' );
        }




        public function get_games_list(){
            $postData = $this->input->post();
            //print_r($postData);die;
            $data = $this->Predictions_model->get_game_list($postData['game_id']);
            echo json_encode($data);
        }



        function fetchdata() {
                $arr_result = array ();
                $excludetopicids = array ();
                $ids = array ();
                $inputs = $this -> input -> post();

                $topic = $inputs[ 'p_category' ];
                $topic_id = $inputs[ 'topic_id' ];
                // print_r($topic_id);die;
                if ( isset( $inputs[ 'topics' ] ) ) {
                        $excludetopicids = json_decode( $inputs[ 'topics' ] );
                }

                if ( count( $excludetopicids ) > 0 ) {
                        //$ids = implode( ",", $excludetopicids );
                        $ids = $excludetopicids;
                        //$excludeCond = "AND id not in ($ids)";
                }

             
                if ( isset( $topic ) ) {
                        $arr_result = $this -> Predictions_model -> search( $topic,$ids,$topic_id);

                        if ( count( $arr_result ) > 0 ) {
                            echo json_encode( $arr_result );
                        }
                }

        }



        function filteredList() {


                $inputs = $this -> input -> post();
                $predictions = $this -> Predictions_model -> get_filtered_list( $inputs );
                $output = '';
                $num = $inputs[ 'offSet' ];


                   

                             foreach ($predictions as $key => $p ):
                                            $ischecked = ($p[ 'is_active' ] == 1) ? "checked" : "";
                                            $ispublished = ($p[ 'is_published' ] == 1) ? "checked" : "";
                                            $update_right_answer = '';
                                            if($p[ 'wrong_prediction' ] == "1" && $p['prediction_executed']=='1'){ 
                                                $status="Wrong"; 
                                            }else if($p[ 'wrong_prediction' ] == "0" && $p['prediction_executed']=='1'){
                                                $status="Right" ;
                                            }else{
                                                    $status="Pending";
                                            } 

                                            $prediction_id_exist = check_data_in_used('prediction_id',$p['id'],'executed_predictions');
                                            if($prediction_id_exist > 0){

                                                $disabled = "disabled =''";
                                                $class = "invalid";

                                            }else{

                                                $class = "changeactivepred";
                                                $disabled = "";

                                            }

                                            echo '<tr>'
                                            . '<td>' .  $p[ 'id' ] . '</td>'
                                            . '<td>' . $p[ 'games' ]  . '</td>'
                                            . '<td><p class="multiline-ellipsis" data-lines="1">' . $p[ 'title' ] . '</p></td>'
                                            . '<td><p class="multiline-ellipsis" data-lines="3">' . date( "d-m-Y", strtotime( $p[ 'start_date' ] ) ) . '</p></td>'
                                            . '<td class="text-center">' . date( "d-m-Y", strtotime( $p[ 'end_date' ] ) )   . '</td>'
                                            . '<td class="text-center">' . $p[ 'price' ]  . '</td>'
                                            . '<td class="text-center">' . $status . '</td>'
                                            . '<td class="text-center">' . $p[ 'agreed' ] . '</td>'
                                            . '<td class="text-center">' . $p[ 'disagreed' ] . '</td>'
                                            . '<td class="text-center"><a class="switch changepublishprediction" data-id="'.$p[ 'id' ] .'" data-type="games" data-status="'.$p[ 'is_published' ] .'" >
                                             <label><input type="checkbox" '.$ispublished.'><span class="lever switch-col-bluenew"></span></label>
                                            </a></td>'
                                            . '<td class="text-center">
                                                <a href="' . base_url() . 'Predictions/index?id=' . $p[ 'id' ] . '" data-id="' . $p[ 'id' ] . '"><i class="material-icons">&#xE254;</i></a>
                                                <a href="#" '.$disabled.' data-id="' . $p[ 'id' ] . '" data-type="prediction" class="'.$class.'"><i class="material-icons">delete_forever</i></a>';

                                                if($p['end_date'] < date('Y-m-d H:i:s') && $p['prediction_executed']=='0'):
                                                echo '<a href="#" id="hide_prediction'.$p['id'].'" data-id="'.$p['id'].'" data-togle="tooltip" title="Prediction YES/NO">
                                                <i class="material-icons" onclick="openmodal_prediction('.$p['id'].','.$p['game_id'].',&quot;'.$p['games'].'&quot;)">style</i></a>';
                                                endif;
                                                echo '</td>';
                                    endforeach;

                    
               
                echo $output;



        }

        

        function exportList_prediction() {
           
                $polls = array ();

                $data = "";

                $inputs = $this -> input -> get();

                $predictions = $this -> Predictions_model -> get_filtered_list_exported( $inputs );

                $output = '';
                // $num = $inputs['offSet'];

                $data .= '<th># Id</th>
                          <th class="text-center">Game</th>
                                        <th>Prediction</th>
                                        <th>Start Date</th>
                                        <th class="text-center">End Date</th>
                                        <th class="text-center">Price</th>
                                        <th class="text-center">Prediction Status</th>
                                        <th class="text-center">Agreed Count</th>
                                        <th class="text-center">Disagreed Count</th>';


              foreach ( $predictions as $key => $p ):
                                            $ischecked = ($p[ 'is_active' ] == 1) ? "checked" : "";
                                            $ispublished = ($p[ 'is_published' ] == 1) ? "checked" : "";
                                            $update_right_answer = '';
                                            if($p[ 'wrong_prediction' ] == "1" && $p['prediction_executed']=='1'){ 
                                                $status="Wrong"; 
                                            }else if($p[ 'wrong_prediction' ] == "0" && $p['prediction_executed']=='1'){
                                                $status="Right" ;
                                            }else{
                                                    $status="Pending";
                                            } 

                                            $data .= '<tr>'
                                            . '<td>' .  $p[ 'id' ] . '</td>'
                                            . '<td>' . $p[ 'games' ]  . '</td>'
                                            . '<td><p class="multiline-ellipsis" data-lines="1">' . $p[ 'title' ] . '</p></td>'
                                            . '<td><p class="multiline-ellipsis" data-lines="3">' . date( "d-m-Y", strtotime( $p[ 'start_date' ] ) ) . '</p></td>'
                                            . '<td class="text-center">' . date( "d-m-Y", strtotime( $p[ 'end_date' ] ) )   . '</td>'
                                            . '<td class="text-center">' . $p[ 'price' ]  . '</td>'
                                            . '<td class="text-center">' . $status . '</td>'
                                            . '<td class="text-center">' . $p[ 'agreed' ] . '</td>'
                                            . '<td class="text-center">' . $p[ 'disagreed' ] . '</td>'
                                            .'</tr>';
                endforeach;
                $file = "predictions.xls";
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
                $page_title[ 'page_title' ] = "Predictions";
                $validationResult = $this->Predictions_model->validate_prediction();
               
                if(empty($validationResult)){
                $data['status']= 'failure';
                $data['error'] = array(
                    'title' =>strip_tags(form_error('title')),            
                    'price' =>strip_tags(form_error('price')),            
                    'meta_keywords' =>strip_tags(form_error('meta_keywords')),            
                    'meta_description' =>strip_tags(form_error('meta_description')),            
                    );
                } else{
                if(empty($this -> input -> post('predictions_id'))){
                    $data['toast_message'] = "Prediction Created Successfully";
                }else{
                    $data['toast_message'] = "Prediction Updated Successfully";
                }
                $data['status'] = "success";
                $inputs = $this -> input -> post();
                $inputs[ 'user_id' ] = $this -> userdata[ 'user_id' ];
                $this -> Predictions_model -> add_update_predictions( $inputs );
                
            }
              echo json_encode($data);
        }


        function lists() {
                $data = array ();
                $page_title[ 'page_title' ] = "Predictions";
                // $data['topics'] = $this->Games_model->get_topic_list(); 
                $data['games'] = $this->Games_model->get_games_list(); 
                $data[ 'predictions' ] = $this -> Predictions_model -> get_list();
                $this -> load -> view( 'template/header', $page_title );
                $this -> load -> view( 'predictions_list', $data );
                $this -> load -> view( 'template/footer' );
            }



        function approve_poll() {
                $inputs = $this -> input -> post();
                $inputs[ 'user_id' ] = $this -> userdata[ 'user_id' ];

                $this -> Poll_model -> approve_poll( $inputs );

                echo json_encode( array ( "status" => TRUE, "message" => "Poll approved successfully" ) );

        }



        function changepublishprediction() {
                $id = $this -> input -> post( 'id' );
                $type = $this -> input -> post( 'type' );
                $current = $this -> input -> post( 'current' );

                $newstatus = ($current == "1") ? 0 : 1;
                $status = $this -> Predictions_model -> changepublishprediction( $id, $newstatus );
                $msg = "Action performed successfully";
                echo json_encode( array ( "status" => $status, "message" => $msg ) );
        }



        function active_inactive_prediction() {
                $inputs = $this -> input -> post();
                $this -> Predictions_model -> active_inactive_prediction_mod( $inputs );
                $message = "Prediction deleted successfully";
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

    public function prediction_result(){
        $postData = $this->input->post();
        if($postData['prediction_result'] === 'no') {
            $data['status'] = $this->Predictions_model->action_prediction_result($postData['game_id'],$postData['prediction_id'],'wrong',$postData['game_name']);
        }elseif($postData['prediction_result'] === 'yes'){
            $data['status'] = $this->Predictions_model->action_prediction_result($postData['game_id'],$postData['prediction_id'],'right',$postData['game_name']);
        }else{
            $data['status'] = 'Sorry! Could not proceed';
        }
        echo json_encode($data);
    }    

}
