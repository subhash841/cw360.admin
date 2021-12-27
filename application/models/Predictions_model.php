<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Predictions_model extends CI_Model {

        function __construct() {
                parent::__construct();
                $this->load->library('MY_Form_validation');
                $this->load->helper('common');

        }

        function get_list( $offset = 0 ) {
                $this -> db -> select( "p.*,g.title as games");
                $this -> db -> from( "predictions p" );
                $this -> db -> join( "games g" ,"p.game_id = g.id");
                $this-> db ->where('p.is_active',1);
                $this -> db -> limit( 10, $offset );
                $this -> db -> order_by( "p.id DESC" );
                return $this -> db -> get() -> result_array();

        }


        function get_game_bonus($game_id){
            $this-> db ->select('id,bonus_point_yes_right, deduct_point_yes_wrong, bonus_point_no_wrong,deduct_point_no_right');
            $this-> db ->from('games');
            $this->db->where_in('id',$game_id);  
            $result = $this->db->get()->row_array();    
            //echo $this->db->last_query();die;  
            return $result;
        }



        function get_prediction_list(){
            $this-> db ->select('id,title');
            $this-> db ->from('predictions');
            $this-> db ->where('is_active','1');
            $this-> db ->where('is_published','1');
            $result = $this->db->get()->result_array();
            return $result;

        }


        public function validate_prediction(){
                
            $this->form_validation->set_rules($this->config->item('Prediction','validation_rules'));
           
            if($this->form_validation->run() == FALSE){
                    return FALSE;
                } else {
                    
                    return TRUE;
                  }
            } 
        

        function search( $name, $ids,$topic_id) {
            $res_array = array();
            $array2 = array();
            foreach ($topic_id as $key => $value) {
                  $sql = "select id,title FROM games where FIND_IN_SET('".$value."',topic_id)";
                   $query = $this->db->query($sql);
                    $res_array = $query->result_array();
                   //print_r($res_array);
                   $array2 = array_merge($res_array,$array2);
            }
                $final_list = array_map("unserialize", array_unique(array_map("serialize", $array2)));
                return $final_list;
            
        }
        

        // function get_prediction_topics( $postid ) {
        //     $this -> db -> select( "ta.topic_id,ta.type, t.topic" );
        //     $this -> db -> from( "topic_association ta" );
        //     $this -> db -> join( "topics t", "ta.topic_id = t.id", "INNER" );
        //     $this -> db -> where( "ta.post_id = '$postid' AND ta.type = 'poll'" );
        //     $result = $this -> db -> get() -> result_array();
        //     return $result;
        // }

        function get_topic_list() {
                $this -> db -> select( "*" );
                $this -> db -> from( "topics" );
                return $this -> db -> get() -> result_array();

        }

        function get_filtered_list( $inputs ) {

                //$offset = 0;
                $gamename = $inputs[ 'game_id' ];
                $title = $inputs[ 'title' ];
                //$description = $inputs[ 'description' ];
                // $start_time = $inputs[ 'start_time' ];
                // $end_time = $inputs[ 'end_time' ];
                //print_r($inputs);
                $offset = $inputs[ 'offSet' ];
                if(!empty($inputs[ 'fpt_start_time' ])){                
                    $start_time = date( "H:i:s", strtotime( $inputs[ 'fpt_start_time' ] ) );
                }

                if(!empty($inputs[ 'fpt_end_time' ])){
                    $end_time = date( "H:i:s", strtotime( $inputs[ 'fpt_end_time' ] ) );
                }

               //echo  $end_time;die;
                if(!empty($inputs[ 'start_date' ])){
                     $start_date = date( "Y-m-d", strtotime( $inputs[ 'start_date' ] ) );
                
                }

                if(!empty($inputs[ 'end_date' ])){
                    $end_date = date( "Y-m-d", strtotime( $inputs[ 'end_date' ] ) );
                }

                $this -> db -> select( "p.*,g.title as games" );
                $this -> db -> from( "predictions p" );
                $this -> db -> join( "games g","g.id = p.game_id" );
                $this-> db ->where('p.is_active','1');
                if ( $gamename != "" ) {
                        $this -> db -> where( 'p.game_id', $gamename );
                }
                if ( $title != "" ) {
                        $this -> db -> where( "p.title like '%$title%'" );
                }
                // if ( $description != "" ) {
                //         $this -> db -> where( 'description', $description );
                // }
                if ( $start_date != "" ) {
                        $this -> db -> where( 'DATE_FORMAT(p.start_date, "%Y-%m-%d") >=', $start_date );
                }

                if ( $end_date != "" ) {
                        $this -> db -> where( 'DATE_FORMAT(p.end_date, "%Y-%m-%d") <=', $end_date );
                }

                if ( $start_time != "" ) {
                        $this -> db -> where( 'p.fpt_start_time', $start_time);
                }

                if ( $end_time != "" ) {
                        $this -> db -> where( 'p.fpt_end_time', $end_time);
                }

              /*  $this -> db -> join( "poll_category pc", "pc.id = p.category_id", "LEFT" );
                $this -> db -> join( "poll_choices pch", "pch.poll_id = p.id", "INNER" );
                $this -> db -> group_by( "p.id" );*/
                $this -> db -> order_by( "p.id DESC" );
                $this -> db -> limit( 10, $offset );
                $res=$this -> db -> get() -> result_array();
                // echo $this->db->last_query();die;
                return $res;

        }

        function get_filtered_list_exported( $inputs ) {
                 //$offset = 0;
                $gamename = $inputs[ 'game_id' ];
                $title = $inputs[ 'title' ];
                //$description = $inputs[ 'description' ];
                // $start_time = $inputs[ 'start_time' ];
                // $end_time = $inputs[ 'end_time' ];
                //print_r($inputs);
                $offset = $inputs[ 'offSet' ];
                if(!empty($inputs[ 'fpt_start_time' ])){                
                    $start_time = date( "H:i:s", strtotime( $inputs[ 'fpt_start_time' ] ) );
                }

                if(!empty($inputs[ 'fpt_end_time' ])){
                    $end_time = date( "H:i:s", strtotime( $inputs[ 'fpt_end_time' ] ) );
                }

               //echo  $end_time;die;
                if(!empty($inputs[ 'start_date' ])){
                     $start_date = date( "Y-m-d", strtotime( $inputs[ 'start_date' ] ) );
                }

                if(!empty($inputs[ 'end_date' ])){
                    $end_date = date( "Y-m-d", strtotime( $inputs[ 'end_date' ] ) );
                }

                $this -> db -> select( "p.*,g.title as games" );
                $this -> db -> from( "predictions p" );
                $this -> db -> join( "games g","g.id = p.game_id" );
                $this-> db ->where('p.is_active','1');

                if ( $gamename != "" ) {
                        $this -> db -> where( 'p.game_id', $gamename );
                }
                if ( $title != "" ) {
                        $this -> db -> where( "p.title like '%$title%'" );
                }
                // if ( $description != "" ) {
                //         $this -> db -> where( 'description', $description );
                // }
                if ( $start_date != "" ) {
                        $this -> db -> where( 'p.start_date >=', $start_date );
                }

                if ( $end_date != "" ) {
                        $this -> db -> where( 'p.end_date <=', $end_date );
                }

                if ( $start_time != "" ) {
                        $this -> db -> where( 'p.fpt_start_time', $start_time);
                }

                if ( $end_time != "" ) {
                        $this -> db -> where( 'p.fpt_end_time', $end_time);
                }

              /*  $this -> db -> join( "poll_category pc", "pc.id = p.category_id", "LEFT" );
                $this -> db -> join( "poll_choices pch", "pch.poll_id = p.id", "INNER" );
                $this -> db -> group_by( "p.id" );*/
                $this -> db -> order_by( "p.id DESC" );
               
                $res=$this -> db -> get() -> result_array();
                // echo $this->db->last_query();die;
                return $res;

        }      

        function changepublishprediction( $id, $newstatus ){
                // echo "hi";
                $this -> db -> where( 'id', $id );
                $this -> db -> update( "predictions", array ( 'is_published' => $newstatus ) );
                if ($newstatus==1) {
                    $this->db->select('game_id,title,image');
                    $this->db->from('predictions');
                    $this->db->where('id',$id);
                    $prediction_result = $this->db->get()->row_array();
                    
                    $prediction_id = $id;
                    $game_id = $prediction_result['game_id'];
                    // print_r($game_id);
                    $this->db->select('id');
                    $this->db->from('notifications');
                    $this->db->where("game_id = $game_id AND prediction_id = $prediction_id");
                    $result = $this->db->get()->result_array();
                    // print_r($result);die;
                    if (empty($result)) {
                        $game_users = $this->get_games_user_id($game_id);       //get game's user ids 
                        if (!empty($game_users)) {
                            $user_id_set_array = array_map('trim',array_filter(explode(',',$game_users['user_id_set'])));
                            $user_id_set = implode(',',$user_id_set_array);
                        }else{
                            $user_id_set = '';
                        }
                        $prediction_notification = array('user_id_set'=>$user_id_set,
                        'game_id'=>$game_id,
                        'prediction_id'=>$prediction_id,
                        'prediction_title'=>$prediction_result['title'],
                        'prediction_image'=>$prediction_result['image']
                    );
                    $this->db->insert('notifications', $prediction_notification);
                    $this->db->select('user_id');
                    $this->db->from('points');
                    $this->db->where("game_id = $game_id");
                    $user_id = $this->db->get()->result_array();
                    // echo $this->db->last_query();
                    // print_r($user_id);die;
                        $this -> notification -> get_ids_and_fields($prediction_notification,$user_id);
                    }
                }
                if ( $newstatus == 0 ) {
                        return FALSE;
                } else {
                        return TRUE;
                }
            }



            function get_predictions_details( $prediction_id ) {
                        $this -> db -> select( "p.*" );
                        $this -> db -> from( "predictions p" );
                        $this -> db -> where( "id = '$prediction_id'" );
                        $prediction_data = $this -> db -> get() -> row_array();

                        $games_id = array();
                        $game_id = $prediction_data['game_id'];
                        $games = explode(',',$game_id);

                        if(!empty($games)){

                        $this -> db -> select( "g.title,g.id" );
                        $this -> db -> from( "games g" );
                        $this -> db -> where_in( 'id' , $games );
                        $games_data = $this -> db -> get() -> result_array();

                        }
                        $prediction_data['topics_associated'] = $games_data;
                       /* echo'<pre>';print_r($prediction_data);
                        exit();*/
                        return $prediction_data;

                }

    

        function add_update_predictions( $inputs ) {
                $uid = $inputs[ 'user_id' ];
                $predictions_id = $inputs[ 'predictions_id' ];
                $poll_desc = $inputs[ 'poll_desc' ];
                $game_id = $inputs[ 'game_id' ];
                $quantity = $inputs[ 'quantity' ];
                $per_qty_points = $inputs[ 'per_qty_points' ];
                $title = $inputs[ 'title' ];
                $description = $inputs[ 'description' ];
                $meta_description = $inputs[ 'meta_description' ];
                $meta_keywords = $inputs[ 'meta_keywords' ];
            
                if(!empty($inputs['is_published'])){
                  $is_published=1;
                }else{
                  $is_published=0;
                }

                $image_uploaded = $inputs[ 'uploaded_filename' ];
                $price = $inputs['price'];
                $start_date = date( "Y-m-d", strtotime( $inputs[ 'start_date' ] ) );
                $start_time = date("H:i:s", strtotime($inputs['start_time']));
                $start_datetime = $start_date.' '.$start_time;
                $end_date = date( "Y-m-d", strtotime( $inputs[ 'end_date' ] ) );
                $end_time = date("H:i:s", strtotime($inputs['end_time']));
                $end_datetime = $end_date.' '.$end_time;
                $fpt_end_date = date( "Y-m-d", strtotime( $inputs[ 'fpt_end_date' ] ) );
                // $start_time = $inputs[ 'start_time' ];
                // $end_time = $inputs[ 'end_time' ];
                //$fpt_start_time = $inputs[ 'fpt_start_time' ];
                // $fpt_start_time = date('H:i:s');
                //$fpt_end_time = $inputs[ 'fpt_end_time'];
                $fpt_end_time =date("H:i:s", strtotime($inputs['fpt_end_time']));


                $fpt_end_datetime = $fpt_end_date.' '.$fpt_end_time;




                if ( $predictions_id == 0 ) {
                        //insert Polls
                        $insert_prediction = array (
                            "game_id" => $game_id,
                            // "topic_id" => $topic_id,
                            "title" => $title,
                            //"description" => $description,
                            "image" => $image_uploaded,
                            "start_date" => $start_datetime,
                            /*"start_time" => $start_time,*/
                            "end_date" => $end_datetime,
                            /*"end_time" => $end_time,*/
                            /*"fpt_start_date" => $fpt_start_date,*/
                            "fpt_end_date" => $fpt_end_date,
                            // "fpt_start_time" => $fpt_start_time,
                            "fpt_end_time" => $fpt_end_time,
                            "fpt_end_datetime" => $fpt_end_datetime,
                            "meta_keywords" => $meta_keywords,
                            "meta_description" => $meta_description,
                            "price" => $price,
                            "current_price" => $price,
                            "quantity" => $quantity,
                            "per_qty_points" => $per_qty_points,
                            "is_published" => $is_published,
                            "is_active" => "1",
                            "created_date" =>date('Y-m-d H:i:s'),
                            "created_by" => $uid,
                        );

                        $this -> db -> insert( 'predictions', $insert_prediction);
                        $prediction_id = $this -> db -> insert_id();

                        if ($is_published==1) {
                            $game_users= $this->get_games_user_id($game_id);        //get game's user ids
                            if (!empty($game_users)) {
                                $user_id_set_array = array_map('trim',array_filter(explode(',',$game_users['user_id_set'])));
                                $user_id_set = implode(',',$user_id_set_array);
                            }else{
                                $user_id_set = '';
                            }
                            $prediction_notification = array('user_id_set'=>$user_id_set,'game_id' => $game_id,'prediction_id' => $prediction_id, 'prediction_title' => $title, 'prediction_image' => $image_uploaded);
                            $this->insert_prediction_notification($prediction_notification,'add_prediction',$user_id_set);     //insert new prediction notification
                        }
                    } else {
                            /* Update Poll details */
                            $update_prediction = array (
                            "game_id" => $game_id,
                            // "topic_id" => $topic_id,
                            "title" => $title,
                            //"description" => $description,
                            "image" => $image_uploaded,
                            "start_date" => $start_datetime,
                            /*"start_time" => $start_time,*/
                            "end_date" => $end_datetime,
                           /* "end_time" => $end_time,*/
                            /*"fpt_start_date" => $fpt_start_date,*/
                            "fpt_end_date" => $fpt_end_date,
                            // "fpt_start_time" => $fpt_start_time,
                            "fpt_end_time" => $fpt_end_time,
                            "fpt_end_datetime" => $fpt_end_datetime,
                            "meta_keywords" => $meta_keywords,
                            "meta_description" => $meta_description,
                            "price" => $price,
                            "quantity" => $quantity,
                            "per_qty_points" => $per_qty_points,
                            "is_published" => $is_published,
                            "is_active" => "1",
                            "modified_date" =>date('Y-m-d H:i:s'),
                            "modified_by" => $uid,
                            );

                            if ( $image_uploaded != "" ) {
                                        $update_poll[ 'image' ] = $image_uploaded;
                            }
                            $this -> db -> where( array ( "id" => $predictions_id ) );
                            $this -> db -> update( 'predictions', $update_prediction );

                            if ($is_published==1) {
                                $game_users= $this->get_games_user_id($game_id);    //get game's user ids
                                if (!empty($game_users)) {
                                    $user_id_set_array = array_map('trim',array_filter(explode(',',$game_users['user_id_set'])));
                                    $user_id_set = implode(',',$user_id_set_array);
                                }else{
                                    $user_id_set = '';
                                }
                                $prediction_notification = array('user_id_set'=>$user_id_set,'game_id' => $game_id,'prediction_id' => $predictions_id, 'prediction_title' => $title, 'prediction_image' => $image_uploaded);
                                $this->insert_prediction_notification($prediction_notification,'update_prediction',$user_id_set);     //insert new prediction notification
                            }

                 }

        }


         function get_poll_choice_count( $poll_id ) {
                $this -> db -> select( "count(1) as total_choices" );
                $this -> db -> from( "poll_choices" );
                $this -> db -> where( "poll_id = '$poll_id'" );
                $result = $this -> db -> get() -> row_array();
                return $result[ 'total_choices' ];

        }

        function approve_poll( $inputs ) {
                $poll_id = $inputs[ 'poll_id' ];
                $user_id = $inputs[ 'user_id' ];

                $update = array (
                    "is_approved" => "1",
                    "approved_by" => $user_id
                );

                $this -> db -> where( "id = '$poll_id'" );
                $this -> db -> update( "poll", $update );

                return TRUE;

        }

        function active_inactive_prediction_mod( $inputs ) {
                $prediction_id = $inputs[ 'prediction_id' ];
                $type = $inputs[ 'type' ];
                $update = array (
                    "is_active" => 0
                );
                $this -> db -> where( "id = '$prediction_id'" );
                $this -> db -> update( "predictions", $update );
                return TRUE;
        }
        
      //bouns point function strat
      
      public function action_prediction_result($game_id, $prediction_id,$type,$game_name){
        if($game_id <= 210){
            if($type =='wrong'){
                $flag='1';
                $bouns='0';
            }else{
                $bouns='25';
                $flag='0';
            }
            $this->db->set('wrong_prediction',$flag);  
            $this->db->set('prediction_executed','1');  
            $this->db->where('id',$prediction_id);
            $this->db->update('predictions'); 
        
            $this->db->set('wrong_prediction',$flag);  
            $this->db->where(array('game_id' => $game_id,'prediction_id' => $prediction_id)); 
            $this->db->update('executed_predictions');
            
            $this->db->select('user_id, swipe_status');
            $this->db->from('executed_predictions');
            $this->db->where(array('game_id' => $game_id,'prediction_id' => $prediction_id,'wrong_prediction' => $flag)); 
            $this->db->group_by('user_id'); 
            $result = $this->db->get()->result_array();
            // echo $this->db->last_query();
            // print_r($result);die;


            $update_prediction_qty = array();
            $insert_bonus_points_history = array();
            $notification_right_prediction = array();

            foreach ($result as $key => $value) {
                $this->db->select('title,price,IFNULL(current_price, 0) as current_price,(price-IFNULL(current_price, 0)) as profit');
                $this->db->from('predictions');  
                $this->db->where('id', $prediction_id); 
                $result_profit = $this->db->get()->row_array();
                    // echo $this->db->last_query();
                $update_executed_predictions[] = array('user_id' => $value['user_id'],
                                        'profit_point'=> $result_profit['profit'],
                                        'bonus_points'=>$bouns,
                                        'modified_date'=>date('Y-m-d H:i:s'),
                                        ); 

                $insert_bonus_points_history[] = array('user_id'=>$value['user_id'],
                                                    'game_id'=>$game_id,
                                                    'predictions_id'=>$prediction_id,
                                                    'previous_price'=>$result_profit['price'],
                                                    'current_price'=>$result_profit['current_price'],
                                                    'profit'=> $result_profit['profit'],
                                                    'bouns'=>$bouns,
                                                    'prediction_status'=>$type,
                                                    'created_date'=>date('Y-m-d H:i:s'),
                                        );
                if ($type=='right' && $value['swipe_status']=='agreed') {  
                    $notification_right_prediction[] = array('user_id'=>$value['user_id'],
                                                    'game_id'=>$game_id,
                                                    'game_title'=>$game_name,
                                                    'prediction_id'=>$prediction_id,
                                                    'prediction_title'=>$result_profit['title'],
                                                    'prediction_status'=>$type
                                        );
                    $notification_right_prediction_app = array('user_id'=>$value['user_id'],
                                                    'game_id'=>$game_id,
                                                    'game_title'=>$game_name,
                                                    'prediction_id'=>$prediction_id,
                                                    'prediction_title'=>$result_profit['title'],
                                                    'prediction_status'=>$type,
                                                    'title'=>"Congrats!! Your prediction is right."
                                        );
                    // $this -> notification -> get_ids_and_fields($notification_right_prediction_app,$value['user_id']);                    
                }


            }
            // print_r($update_executed_predictions);die;
            if (!empty($update_executed_predictions)) {
                    /* $update_executed_predictions_chunk = array_chunk($update_executed_predictions,89); // array_chunk('array of prdection', array divide by provide int value)
                    for($i=0;$i < count($update_executed_predictions_chunk);$i++) {
                        $this->update_executed_predictions_data($update_executed_predictions_chunk[$i],$prediction_id);
                    } */
                    
                    split_batch_array($update_executed_predictions,array('game_id' => $game_id,'prediction_id' => $prediction_id),'user_id','executed_predictions','update_batch');
                //update bonus point for wrong/right prediction
            }
                // echo $this->db->last_query();die;
                if (!empty($insert_bonus_points_history)) {
                    //$this->db->insert_batch('bonus_points_history', $insert_bonus_points_history); //insert bonus_point_history
                    split_batch_array($insert_bonus_points_history,'','','bonus_points_history','insert_batch');
                }
                if (!empty($notification_right_prediction)) {
                   // $this->db->insert_batch('notifications', $notification_right_prediction); //insert bonus_point_history
                   split_batch_array($notification_right_prediction,'','','notifications','insert_batch');
                    $this->db->select('user_id');
                    $this->db->from('points');
                    $this->db->where("game_id = $game_id");
                    $user_id = $this->db->get()->result_array();
                //   $this -> notification -> get_ids_and_fields($notification_right_prediction,$user_id);
                }
            return TRUE;      
        }else{

            $get_points=$this->get_game_bonus($game_id);
            $this->db->select('user_id, swipe_status');
            $this->db->from('executed_predictions');
            $this->db->where(array('game_id' => $game_id,'prediction_id' => $prediction_id)); 
            $this->db->group_by('user_id'); 
            $result = $this->db->get()->result_array();
            // print_r($result);die;
            foreach ($result as $key => $value) {

                if($type =='wrong' && $value['swipe_status']=='disagreed'){
                    // echo "1";
                    $flag='1';
                    $bonus_ex_flag='1';
                    $bonus_point=$get_points['bonus_point_no_wrong'];
                    $deduct_points='0';
                    $points_status='Add';
                    $point_update="1";
                }else if($type =='wrong' && $value['swipe_status']=='agreed'){
                    // echo "2";
                    $flag='1';
                    $bonus_ex_flag='0';
                    $bonus_point='0';
                    // $deduct_points=$get_points['deduct_point_no_right'];
                    $deduct_points="0";
                    $points_status='Add';
                    $point_update="1";
                }else if($type =='right' && $value['swipe_status']=='disagreed'){
                    // echo "3";
                    $flag='0';
                    $bonus_ex_flag='0';
                    $bonus_point='0';
                    $deduct_points=$get_points['deduct_point_no_right'];
                    $points_status='Deduct';
                    $point_update="1";
                }else if($type =='right' && $value['swipe_status']=='agreed'){
                    // echo "4";
                    $flag='0';
                    $bonus_ex_flag='1';
                    $bonus_point=$get_points['bonus_point_yes_right'];
                    $deduct_points='0';
                    $points_status='Add';
                    $point_update="0";
                }

                $this->db->select('title,price,IFNULL(current_price, 0) as current_price,(price-IFNULL(current_price, 0)) as profit');
                $this->db->from('predictions');  
                $this->db->where('id', $prediction_id); 
                $result_profit = $this->db->get()->row_array();

                $this->db->select('points');
                $this->db->from('points');  
                $this->db->where(array('game_id' => $game_id,'user_id' => $value['user_id'])); 
                $result_points = $this->db->get()->row_array();
                //print_r($update_game_points_deduct);
                // echo"<br>";
                // print_r("flag".$flag);
                // print_r("deduct_points".$deduct_points);
                // print_r("bouns_point".$bonus_point);
                // print_r("point_update".$point_update);
                if($point_update !=0){
                        $update_game_points_deduct[] = array('user_id' => $value['user_id'],
                        'points'=>$result_points['points'] - $deduct_points,
                        'update_type'=>'4',
                        'modified_date'=>date('Y-m-d H:i:s'),
                        );  
                        
                        $insert_wallet_points_history[] = array('user_id'=>$value['user_id'],
                                                'game_id'=>$game_id,
                                                'prediction_id'=>$prediction_id,
                                                'points'=>$deduct_points,                       
                                                'type'=>'8',//deduct point prediction wrong 
                                                'created_date'=>date('Y-m-d H:i:s'),           
                                            );
                }
                // echo $result_points['points'] ; 
                // echo $deduct_points ; 
            // print_r($update_game_points_deduct);die;
                    // echo $this->db->last_query();
                $update_executed_predictions[] = array('user_id' => $value['user_id'],
                                        'profit_point'=> $result_profit['profit'],
                                        'bonus_points'=>$bonus_point,
                                        'wrong_prediction'=>$flag,
                                        'bonus_ex_flag'=>$bonus_ex_flag,
                                        'modified_date'=>date('Y-m-d H:i:s'),
                                        ); 
                                   
                $insert_bonus_points_history[] = array('user_id'=>$value['user_id'],
                                                    'game_id'=>$game_id,
                                                    'predictions_id'=>$prediction_id,
                                                    'previous_price'=>$result_profit['price'],
                                                    'current_price'=>$result_profit['current_price'],
                                                    'profit'=> $result_profit['profit'],
                                                    'bouns'=>$bonus_point,
                                                    'points_status'=>$points_status,
                                                    'prediction_status'=>$type,
                                                    'created_date'=>date('Y-m-d H:i:s'),
                                        );
                if ($type=='right' && $value['swipe_status']=='agreed') {  
                    $notification_right_prediction[] = array('user_id'=>$value['user_id'],
                                                    'game_id'=>$game_id,
                                                    'game_title'=>$game_name,
                                                    'prediction_id'=>$prediction_id,
                                                    'prediction_title'=>$result_profit['title'],
                                                    'prediction_status'=>$type
                                        );
                                        $notification_right_prediction_app = array('user_id'=>$value['user_id'],
                                        'game_id'=>$game_id,
                                        'game_title'=>$game_name,
                                        'prediction_id'=>$prediction_id,
                                        'prediction_title'=>$result_profit['title'],
                                        'prediction_status'=>$type,
                                        'title'=>"Congrats!! Your prediction is right."
                            );    
                            // $this -> notification -> get_ids_and_fields($notification_right_prediction_app,$value['user_id']);
                }else if($type=='wrong' && $value['swipe_status']=='disagreed') {  
                    $notification_right_prediction[] = array('user_id'=>$value['user_id'],
                                                    'game_id'=>$game_id,
                                                    'game_title'=>$game_name,
                                                    'prediction_id'=>$prediction_id,
                                                    'prediction_title'=>$result_profit['title'],
                                                    'prediction_status'=>$type
                                        );
                                        $notification_right_prediction_app = array('user_id'=>$value['user_id'],
                                                    'game_id'=>$game_id,
                                                    'game_title'=>$game_name,
                                                    'prediction_id'=>$prediction_id,
                                                    'prediction_title'=>$result_profit['title'],
                                                    'prediction_status'=>$type,
                                                    'title'=>"Congrats!! Your prediction is right."
                                        );
            
                                        // $this -> notification -> get_ids_and_fields($notification_right_prediction_app,$value['user_id']);
             }

          
            }

        //            print_r($update_game_points_deduct);
        //            print_r($insert_wallet_points_history);
        //    die;
                    $this->db->set('wrong_prediction',$flag);  
                    $this->db->set('prediction_executed','1');  
                    $this->db->where('id',$prediction_id);
                    $this->db->update('predictions'); 
                
                    // $this->db->set('wrong_prediction',$flag);  
                    // $this->db->set('bonus_ex_flag',$bonus_ex_flag);  
                    // $this->db->where(array('game_id' => $game_id,'prediction_id' => $prediction_id)); 
                    // $this->db->update('executed_predictions');

                    if (!empty($update_game_points_deduct)) {
                        // echo "hi";
                        split_batch_array($update_game_points_deduct,array('game_id' => $game_id),'user_id','points','update_batch');
                    } 
              
                    if (!empty($update_executed_predictions)) {
                        split_batch_array($update_executed_predictions,array('game_id' => $game_id,'prediction_id' => $prediction_id),'user_id','executed_predictions','update_batch');
                    }
                        // echo $this->db->last_query();die;
                    if (!empty($insert_bonus_points_history)) {
                        //$this->db->insert_batch('bonus_points_history', $insert_bonus_points_history); //insert bonus_point_history
                        split_batch_array($insert_bonus_points_history,'','','bonus_points_history','insert_batch');
                    }
                    if (!empty($notification_right_prediction)) {
                       // $this->db->insert_batch('notifications', $notification_right_prediction); //insert bonus_point_history
                       split_batch_array($notification_right_prediction,'','','notifications','insert_batch');
                        $this->db->select('user_id');
                        $this->db->from('points');
                        $this->db->where("game_id = $game_id");
                        $user_id = $this->db->get()->result_array();
                       // $this -> notification -> get_ids_and_fields($notification_right_prediction,$user_id);    
                    }
          
                    if (!empty($insert_wallet_points_history)) {
                         //insert deduct point wallet history 
                       split_batch_array($insert_wallet_points_history,'','','wallet_history','insert_batch');
                    }
                    return TRUE;       
        }  
    }  

    // public function update_executed_predictions_data($data='',$prediction_id=''){
    //     $this->db->where('prediction_id',$prediction_id);
    //     $this->db->update_batch('executed_predictions', $data, 'user_id');
    // }
      //bouns point function end
    private function insert_prediction_notification($prediction_notification,$type,$user_id_set){
        // print_r($user_id_set);die;
        if ($type=='add_prediction') {
            $this->db->insert('notifications', $prediction_notification);
            if(!empty($user_id_set)){
                $this -> notification -> get_ids_and_fields($prediction_notification,$user_id_set);
            }
        }else if($type=='update_prediction'){
            $game_id = $prediction_notification['game_id'];
            $prediction_id = $prediction_notification['prediction_id'];
            $this->db->select('id');
            $this->db->from('notifications');
            $this->db->where("game_id = $game_id AND prediction_id = $prediction_id");
            $result = $this->db->get()->result_array();
            
                    if (empty($result)) {
                        $this->db->insert('notifications', $prediction_notification);
                        if(!empty($user_id_set)){
                            $this->notification-> get_ids_and_fields($prediction_notification,$user_id_set);
                        }
            }
        }
    }
    private function get_games_user_id($game_id){
            $this->db->select("GROUP_CONCAT(user_id SEPARATOR ',') as user_id_set");
            $this->db->from('points');
            $this->db->where('game_id',$game_id);
        return $this->db->get()->row_array();
    }
}
