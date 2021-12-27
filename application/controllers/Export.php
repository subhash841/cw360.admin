<?php
    /*
     * To change this license header, choose License Headers in Project Properties.
     * To change this template file, choose Tools | Templates
     * and open the template in the editor.
     */

    class Export extends Base_Controller {

        private $userdata = array();

        function __construct() {
            parent::__construct();
            $this->load->model(array('Games_model','Export_model','Quiz_model'));
            $this->userdata = $this->session->userdata('loggedin');
        }

        function index() {
            $data = array();
            $page_title['page_title'] = "Export Forecast";
            $data['state'] = $this->Export_model->get_state();
            $this->load->view('template/header', $page_title);
            $this->load->view('export_forecast', $data);
            $this->load->view('template/footer');
        }

        public function exportCSV(){
            $id = $this->input->post('id');
            $usersData = $this->Export_model->ExportDetails($id);
            $filename = 'forecast_'.date('Ymd').'.csv'; 
            header("Pragma: public");
            header("Expires: 0");
            header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
            header("Content-Type: application/force-download");
            header("Content-Type: application/octet-stream");
            header("Content-Type: application/download");;
            header("Content-Disposition: attachment;filename=$filename");
           // get data 
           // file creation 
           $file = fopen('php://output', 'w');  
           $header = array("User id","Login type","Party id","name","email","Abbrevation","seat forecast","vote forecast","Location","Party Affiliation","Modified Date"); 
           fputcsv($file, $header);
           foreach ($usersData as $key=>$line){ 
             fputcsv($file,$line); 
           }
           fclose($file); 
           exit; 
          
        }

        
        public function User_history(){

          $page_title[ 'page_title' ] = "Export Details";
          $data['games'] = $this->Games_model->get_games_list();
          $data['quiz'] = $this->Quiz_model->get_quiz_list();
          $this -> load -> view( 'template/header', $page_title );
          $this-> load -> view('user_history', $data);
          $this -> load -> view( 'template/footer' );

        }



      function portfolio_data(){

          $game_id = $this ->input->post('game_id');
          $game_name = game_name($game_id);
          if (empty($game_id)) {
            $data = array('status' => 'failure','message' => 'redirect_to_home');         //if game id is empty then redirect to home screen
          }else{

              $all_prediction_price = $this->Games_model->all_prediction_price($game_id);   //get all predictions current price
              $leaderboard_details = $this->Games_model->leaderboard_details($game_id);     //get executed predictions,users and points data
              $all_users = $this->Games_model->all_users_details($game_id);                //get users and points data
              $prediction_ids = array_column($all_prediction_price, 'id');                   //separate all ids
              $prediction_price = array_column($all_prediction_price, 'current_price');      //separate current price
              $predictionData = array_combine($prediction_ids, $prediction_price);           //assign current price to ids
              $leaderBoard = array();
              $user_points = '';
              foreach ($all_users as $key => $value) {
                $predDataKey =  array_search($value['user_id'],array_column($leaderboard_details, 'user_id'));
                if (!empty($predDataKey) || $predDataKey===0) {
                  $leaderBoardPredData = $leaderboard_details[$predDataKey];  //get executed prediction data from leaderboard_details array
                  $prediction_id_set = $leaderBoardPredData['predictions'];                                 //user's executed predictions
                  $prediction_id_array  = explode(", ",$prediction_id_set);                   //executed predictions converted to array
                  $bonus_points_set = $leaderBoardPredData['bonus_points'];                                 //user's bonus points
                  $bonus_points_array = explode(",",$bonus_points_set);                       //bonus points converted to array
                  $bonus_points_array = array_sum($bonus_points_array);
                  // $get_predictions= array_flip(array_intersect(array_flip($predictionData),$prediction_id_array)); //get current price of user's executed prediction from all predictions set
                  $get_predictions= array_intersect_key($predictionData,array_flip($prediction_id_array));  //get current price of user's executed prediction from all predictions set
                  $current_price_sum = array_sum($get_predictions);                                 //sum of all prediction's current price 
                  // print_r($current_price_sum);die;
                  $leaderboard_points = $bonus_points_array + $value['points'] + $current_price_sum; //calculation for leader board total points
                }else{
                  $leaderboard_points = $value['points'];
                }
                  $leaderboard_points =  number_format((float)$leaderboard_points, 2, '.', '');
                  $leaderBoard[$key] = array('id' => $value['id'],'user_id' => $value['user_id'],'name' => $value['name'],'image' => $value['image'],'total_points' => $leaderboard_points,'email' => $value['email'],'phone' => $value['phone']);                                                              //set final array for users one by one
                  // if ($this->user_id == $value['user_id']) {
                  //       $user_points = $leaderboard_points;
                  //   } 
              }

             


              if (!empty($leaderBoard)) {
                    $totalPoints = array_column($leaderBoard, 'total_points');
                    array_multisort($totalPoints, SORT_DESC, $leaderBoard);
                    
                  // $user_rank =  array_search($this->user_id, array_column($leaderBoard, 'user_id'));
                  // $is_user_exist = in_array($this->user_id, array_column($leaderBoard, 'user_id')); 
                  // if ($is_user_exist ==true) {
                  //   $user_rank = $user_rank + 1;
                  // }else{
                  //   $user_rank = '0';
                  // }
                  
                    // $data = array('status' => 'success','message' => '200','leaderboard_data' => $leaderBoard,'user_points' => $user_points,'user_rank' => $user_rank,'sess_user_id' => $this->user_id);
                }/*else{
                     $data = array('status' => 'failure','message' => 'empty_records');
                }*/

              }

              


              /*echo json_encode($data); */  
              /*echo'<pre>';print_r($data['leaderboard_data']);exit();*/

              $excel_data .='<tr>       
                                        <th>SR. No</th> 
                                        <th>User ID</th>
                                        <th>User Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Portfolio Coins</th>
                                        <th>Rank</th>
                            </tr>';

              foreach ( $leaderBoard as $key => $ld ) :
                        $num = $key + 1;
                        $excel_data .= '<tr>'
                                . '<td>' . $num . '</td>'
                                . '<td>' . $ld[ 'user_id' ] . '</td>'

                                . '<td><p class="multiline-ellipsis" data-lines="1">' . $ld[ 'name' ] . '</p></td>'
                                . '<td><p class="multiline-ellipsis" data-lines="3">' . $ld[ 'email' ] . '</p></td>'
                                . '<td><p class="multiline-ellipsis" data-lines="3">' . $ld[ 'phone' ] . '</p></td>'
                                . '<td><p class="multiline-ellipsis" data-lines="3">' . $ld[ 'total_points' ] . '</p></td>'
                                . '<td><p class="multiline-ellipsis" data-lines="3">' . $num . '</p></td>'

                                .'</tr>';

                endforeach;
                $file = clean($game_name) .'_'. date('Y-m-d h:i:sA') . "_portfolio_data.xls";
                $test = "<table border='1'>" . $excel_data . "</table>";
                header( "Content-type: application/vnd.ms-excel" );
                header( "Content-Disposition: attachment; filename=$file" );
                echo $test;


            }





      function export_quizans(){
                
                $data = "";
                $quiz_id = $this ->input->post('quiz_id');
                $quizans = $this -> Export_model -> get_quizanswer($quiz_id);
                $quiz_name = $this -> Export_model -> quiz_name($quiz_id);
                /*echo'<pre>';print_r($user_history);
                exit()*/;
                $output = '';
                // $num = $inputs['offSet'];
                $data .= '<tr>
                                        <th>User Id</th>
                                        <th>User Name</th>
                                        <th>Email</th>
                                        <th>Quiz Question</th>
                                        <th>Answer Status</th>
                                   

                        </tr>';

                foreach ( $quizans as $key => $q ) :
                        // $num = $key + 1;
                        $data .= '<tr>'
                                . '<td>' . $q[ 'user_id' ] . '</td>'

                                . '<td><p class="multiline-ellipsis" data-lines="1">' . $q[ 'name' ] . '</p></td>'
                                . '<td><p class="multiline-ellipsis" data-lines="1">' . $q[ 'email' ] . '</p></td>'
                                . '<td><p class="multiline-ellipsis" data-lines="1">' . $q[ 'question' ] . '</p></td>'
                                . '<td><p class="multiline-ellipsis" data-lines="1">' . $q[ 'ans_status' ] . '</p></td>'
                                .'</tr>';

                endforeach;
                $file = RemoveSpecialChapr($quiz_name).".xls";
                $test = "<table border='1'>" . $data . "</table>";
                header( "Content-type: application/vnd.ms-excel" );
                header( "Content-Disposition: attachment; filename=$file" );
                echo $test;

      }


      function exportcsv_userhistory() {
                $polls = array ();
                $data = "";
                $user_history = $this -> Export_model -> get_filtered_list_exported();
                /*echo'<pre>';print_r($user_history);
                exit()*/;
                $output = '';
                // $num = $inputs['offSet'];
                $data .= '<tr>
                                        <th>User ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>DOB</th>
                                        <th>Gender</th>
                                        <th>Mobile No</th>
                                        <th>Wallet Coins</th>
                                   

                        </tr>';

                foreach ( $user_history as $key => $p ) :
                        $num = $key + 1;
                        $data .= '<tr>'
                                . '<td>' . $p[ 'id' ] . '</td>'

                                . '<td><p class="multiline-ellipsis" data-lines="1">' . $p[ 'name' ] . '</p></td>'
                                . '<td><p class="multiline-ellipsis" data-lines="1">' . $p[ 'email' ] . '</p></td>'
                                . '<td><p class="multiline-ellipsis" data-lines="1">' . $p[ 'dob' ] . '</p></td>'
                                . '<td><p class="multiline-ellipsis" data-lines="1">' . $p[ 'gender' ] . '</p></td>'
                                . '<td><p class="multiline-ellipsis" data-lines="1">' . $p[ 'phone' ] . '</p></td>'
                                . '<td><p class="multiline-ellipsis" data-lines="3">' . $p[ 'wallet_coins' ] . '</p></td>'
                                .'</tr>';

                endforeach;
                $file = "user_history.xls";
                $test = "<table border='1'>" . $data . "</table>";
                header( "Content-type: application/vnd.ms-excel" );
                header( "Content-Disposition: attachment; filename=$file" );
                echo $test;

        }


        function exportcsv_usercoinhistory() {
                ini_set('display_errors', 1);
                ini_set('display_startup_errors', 1);
                error_reporting(E_ALL);
                $polls = array ();
                $data = "";
                $userscoin = $this -> Export_model -> get_user_coinshistory();
               /* echo'<pre>';print_r($user_history);
                exit()*/;
                $output = '';
                // $num = $inputs['offSet'];
                $data .= '<tr>
                                        <th>User ID</th>
                                        <th>User Name</th>
                                        <th>Email</th>
                                        <th>Quiz Played</th>
                                        <th>Coins Earned</th>
                                        <th>Coins Lost</th>
                                        
                       </tr>';

                foreach ( $userscoin as $key => $c) :
                        $num = $key + 1;
                        $data .= '<tr>'
                                . '<td>' . $c[ 'id' ] . '</td>'

                                . '<td><p class="multiline-ellipsis" data-lines="1">' . $c[ 'name' ] . '</p></td>'
                                . '<td><p class="multiline-ellipsis" data-lines="1">' . $c[ 'email' ] . '</p></td>'
                                . '<td><p class="multiline-ellipsis" data-lines="1">' . $c[ 'quiz_count' ] . '</p></td>'
                                . '<td><p class="multiline-ellipsis" data-lines="1">' . $c[ 'total_earn' ] . '</p></td>'
                                . '<td><p class="multiline-ellipsis" data-lines="1">' . $c[ 'total_lost' ] . '</p></td>'
                                .'</tr>';

                endforeach;
                $file = "user_history.xls";
                $test = "<table border='1'>" . $data . "</table>";
                header( "Content-type: application/vnd.ms-excel" );
                header( "Content-Disposition: attachment; filename=$file" );
                echo $test;

        }


        function export_portfolio() {
                $polls = array ();
                $data = "";
                $user_history = $this -> Export_model -> get_filtered_list_exported();

                /*echo'<pre>';print_r($user_history);exit();*/
                $output = '';
                // $num = $inputs['offSet'];
                $data .= '<tr>
                                        <th>User ID</th>
                                        <th>User Name</th>
                                        <th>User Email</th>
                                        <th>Portfolio Coins</th>
                        </tr>';

                foreach ( $user_history as $key => $p ) :
                        $num = $key + 1;
                        $data .= '<tr>'
                                . '<td>' . $p[ 'id' ] . '</td>'

                                . '<td><p class="multiline-ellipsis" data-lines="1">' . $p[ 'name' ] . '</p></td>'

                                . '<td><p class="multiline-ellipsis" data-lines="1">' . $p[ 'email' ] . '</p></td>'

                                . '<td><p class="multiline-ellipsis" data-lines="1">' . $p[ 'coins' ] . '</p></td>'
                                
                                . '<td><p class="multiline-ellipsis" data-lines="3">' . $p[ 'coins_earned' ] . '</p></td>'

                                .'</tr>';

                endforeach;
                $file = "user_history.xls";
                $test = "<table border='1'>" . $data . "</table>";
                header( "Content-type: application/vnd.ms-excel" );
                header( "Content-Disposition: attachment; filename=$file" );
                echo $test;

        }



        public function exportCSV_survey(){
            // get data 
            $usersData = $this->Export_model->SurveyDetails();
            //file name 
            $filename = 'survey_'.date('Ymd').'.csv'; 
            header("Pragma: public");
            header("Expires: 0");
            header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
            header("Content-Type: application/force-download");
            header("Content-Type: application/octet-stream");
            header("Content-Type: application/download");;
            header("Content-Disposition: attachment;filename=$filename");
          
           // file creation 
           $file = fopen('php://output', 'w');  
           $header = array(); 
           fputcsv($file, $header);
           foreach ($usersData as $key=>$line){ 
             fputcsv($file,$line); 
           }
           fclose($file); 
           exit; 
        }

         public function exportCSV_prediction(){ 

            // get data 
            ini_set('MAX_EXECUTION_TIME', '-1');
            $usersData = $this->Export_model->PredictionDetails();
            //file name 
            $filename = 'prediction_'.date('Ymd').'.csv'; 
            header("Pragma: public");
            header("Expires: 0");
            header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
            header("Content-Type: application/force-download");
            header("Content-Type: application/octet-stream");
            header("Content-Type: application/download");;
            header("Content-Disposition: attachment;filename=$filename");
            // file creation 
            $file = fopen('php://output', 'w');  
            $header = array("question id","User Name","Alias","Email","Category","Poll","Option Name","Total Votes","Created Date","Location","Party Affiliation"); 
           fputcsv($file, $header);
           foreach ($usersData as $key=>$line){ 
             fputcsv($file,$line); 
           }
           fclose($file); 
           exit; 
        }

          // Export data for  IPL  
          public function exportCSV_ipl(){ 
           //file name 
           $filename = 'ipl_'.date('Ymd').'.csv'; 
           header("Content-Description: File Transfer"); 
           header("Content-Disposition: attachment; filename=$filename"); 
           header("Content-Type: application/csv; ");
           // get data 
           $usersData = $this->Export_model->iplDetails();
           // file creation 
           $file = fopen('php://output', 'w');  
           $header = array("id","Name","Email","Team","Abbrevation","Score Forecast","Wicket Forecast","Location","Party Affiliation","Created Date","Modified Date"); 
           fputcsv($file, $header);
           foreach ($usersData as $key=>$line){ 
             fputcsv($file,$line); 
           }
           fclose($file); 
           exit; 
          }


         public function exportCSV_points(){
          
          $usersData = $this->Export_model->Exportpoints();
          $filename = 'gold_silver_'.date('Ymd').'.csv'; 
          header("Pragma: public");
          header("Expires: 0");
          header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
          header("Content-Type: application/force-download");
          header("Content-Type: application/octet-stream");
          header("Content-Type: application/download");;
          header("Content-Disposition: attachment;filename=$filename");
          // get data 
          // file creation 
          $file = fopen('php://output', 'w');  
          $header = array("id","name","Social Id","Twitter Id","Email","Rank","Points","Gold Points","Silver Points","Created Date","Location","Party"); 
          fputcsv($file, $header);
          foreach ($usersData as $key=>$line){ 
             fputcsv($file,$line); 
          }
          fclose($file); 
          exit; 

         }





    }
