<?php

class Quiz extends Base_Controller{

	private $userdata = array();

    function __construct() {
        parent::__construct();
        $this->load->config('validation_rules', TRUE);
        $this->load->model('Quiz_model');
        $this->userdata = $this->session->userdata('loggedin');
    }

    function index(){

    	$page_title['page_title'] = "Quiz";

    	 $quiz_id = $this->input->get('id');
        if ($quiz_id != 0) {
            $data['quiz'] = $this->Quiz_model->get_quiz_details($quiz_id);
            /*echo'<pre>';print_r($data['quiz']);
            exit();*/
        }

        $this->load->model('Blog_model');
        //$this->load->model('Topics_model');
        $data['categories'] = $this->Blog_model->get_blog_category_detail_mod();
        $data['topics'] = $this->Quiz_model->get_topic_list(); 
        /*echo'<pre>';print_r($data['quiz']);
        exit();*/
    	$this->load->view('template/header', $page_title);
        $this->load->view('add_update_quiz', $data);
        $this->load->view('template/footer');
    }

    function create_update($id = 0){  
        $inputs = $this->input->post();
        $data = array();
        $page_title[ 'page_title' ] = "Quiz";
        $validationResult = $this->Quiz_model->validate_quiz();
        if(empty($validationResult)){
                $data['status']= 'failure';
                $data['error'] = array(
                    'name' =>strip_tags(form_error('name')),            
                    'meta_keywords' =>strip_tags(form_error('meta_keywords')),            
                    'meta_description' =>strip_tags(form_error('meta_description')),            
                    'description' =>strip_tags(form_error('description')),            
                    /*'total_questions' =>strip_tags(form_error('total_questions')),*/            
                  );
                
                }else{


                if(empty($this -> input -> post('quiz_id'))){
                    $data['toast_message'] = "Quiz Created Successfully";   
                }else{
                    $data['toast_message'] = "Quiz Updated Successfully";
                }
                $data['status'] = "success";
                $inputs = $this -> input -> post();
                $inputs[ 'user_id' ] = $this -> userdata[ 'user_id' ];
                $quiz_id = $this->Quiz_model->add_update_quiz($inputs); 

            }

            echo json_encode($data);
        }


    function lists() { 
        $data = array();
        $page_title['page_title'] = "Quiz";
        $data['quiz_list'] = $this->Quiz_model->get_list();
        $data['topics'] = $this->Quiz_model->get_topic_list();
        $this->load->view('template/header', $page_title);
        $this->load->view('quiz_list', $data);
        $this->load->view('template/footer');
    }

    function filteredList(){
        $inputs  = $this->input->post();
       
        $quiz_list = $this->Quiz_model->get_filtered_list($inputs);
        $output = '';
        $num = $inputs['offSet'];

         foreach ($quiz_list as $key => $p):

                $quiz_id_exist = check_data_in_used('quiz_id',$p['quiz_id'],'quiz_attempted');
                if($quiz_id_exist > 0){
                    $disabled = "disabled =''";
                    $class = "invalid";
                }else{
                    $class = "changeactivequiz";
                    $disabled = "";
                }

                $ischecked = ($p[ 'is_active' ] == 1) ? "checked" : "";
                $ispublished = ($p[ 'is_published' ] == 1) ? "checked" : "";
                $p=str_replace(array( '\'' ), "&#8217;", $p);
                $num = $num + 1;
                echo '<tr>'
                . '<td>' . $num . '</td>'
                . '<td><p class="multiline-ellipsis" data-lines="1">' . $p[ 'name' ] . '</p></td>'
                . '<td><p class="multiline-ellipsis" data-lines="3">' . blank_value($p[ 'description' ]). '</p></td>'
                . '<td class="text-center">' . date( "d-m-Y", strtotime( $p[ 'end_date' ] ) ) . '</td>'
                . '<td class="text-center">
                                                <a class="switch changepublishquiz" data-id="' . $p[ 'quiz_id' ] . '" data-type="quiz" data-status=' . $p[ 'is_published' ] . '>

                                                    <label><input type="checkbox" ' . $ispublished . '><span class="lever switch-col-bluenew"></span></label>
                                                </a>
                                                </td>'
                
                .'<td class="text-center">
                    <a href="' . base_url() . 'Quiz/index?id=' . $p[ 'quiz_id' ] . '" data-id="' . $p[ 'quiz_id' ] . '" data-editjson=\'' . json_encode( $p ) . '\'><i class="material-icons">&#xE254;</i></a>

                    <a href="#" '.$disabled .' data-id="' . $p[ 'quiz_id' ] . '" data-type="quiz" class="'.$class.'"><i class="material-icons">delete_forever</i></a>
                  </td>';
                                    
                   
        endforeach;
        echo $output;
    }


    function exportList_quizquestion() {
                $games = array ();
                $data = "";
                $inputs = $this -> input -> get();
                $quiz_list = $this -> Quiz_model -> get_filtered_list_exported_qq( $inputs );
                $output = '';
                // $num = $inputs['offSet'];

                $data .= '<tr>
                                        <th># Sr. No</th>
                                        <th>Question</th>
                                        <th>Description</th>
                                        <th class="text-center">Created Date</th>
                        </tr>';


                    foreach ($quiz_list as $key => $p):

                        $num = $num + 1;
                        $data .= '<tr>'
                        . '<td>' . $num . '</td>'
                        . '<td><p class="multiline-ellipsis" data-lines="1">' . $p[ 'question' ] . '</p></td>'
                        . '<td><p class="multiline-ellipsis" data-lines="3">' . blank_value($p[ 'description' ]). '</p></td>'
                        . '<td class="text-center">' . $p['created_date'] . '</td>'
                        . '</tr>';

                    endforeach;


                $file = date('Y-m-d h:i:sA') .'_'."quizquestion.xls";
                $test = "<table border='1'>" . $data . "</table>";
                header( "Content-type: application/vnd.ms-excel" );
                header( "Content-Disposition: attachment; filename=$file" );
                echo $test;

    }    



    function exportList_quiz() {
                $games = array ();
                $data = "";
                $inputs = $this -> input -> get();
                $quiz_list = $this -> Quiz_model -> get_filtered_list_exported_q( $inputs );
                
                $output = '';
                // $num = $inputs['offSet'];

                $data .= '<th># Sr. No</th>
                        <th>Quiz Name</th>
                        <th>Quiz Description</th>
                        <th class="text-center">End Date</th>';
                    foreach ($quiz_list as $key => $p):
                        $num = $num + 1;
                        $data .= '<tr>'
                        . '<td>' . $num . '</td>'
                        . '<td><p class="multiline-ellipsis" data-lines="1">' . $p[ 'name' ] . '</p></td>'
                        . '<td><p class="multiline-ellipsis" data-lines="3">' . blank_value($p[ 'description' ]). '</p></td>'
                        . '<td class="text-center">' . $p['created_date'] . '</td>'
                        . '</tr>';

                    endforeach;

                $file = date('Y-m-d h:i:sA') .'_'."quiz.xls";
                $test = "<table border='1'>" . $data . "</table>";
                header( "Content-type: application/vnd.ms-excel" );
                header( "Content-Disposition: attachment; filename=$file" );
                echo $test;

    }


    function active_inactive_quiz(){
        $inputs = $this->input->post();
        $this->Quiz_model->active_inactive_quiz_mod($inputs);
        $message = "Quiz deleted successfully";
        echo json_encode(array("status" => TRUE, "message" => $message));
    }

     function changepublishquiz() {
                $id = $this -> input -> post( 'id' );
                $type = $this -> input -> post( 'type' );
                $current = $this -> input -> post( 'current' );
                $newstatus = ($current == "1") ? 0 : 1;
                $status = $this -> Quiz_model -> changepublishquiz( $id, $newstatus );
                $msg = "Action performed successfully";
                echo json_encode( array ( "status" => $status, "message" => $msg ) );
    }

    function changepublishquestion() {

                $id = $this -> input -> post( 'id' );
                $type = $this -> input -> post( 'type' );
                $current = $this -> input -> post( 'current' );
                $newstatus = ($current == "1") ? 0 : 1;
                $status = $this -> Quiz_model -> changepublishquestion( $id, $newstatus );
                $msg = "Action performed successfully";
                echo json_encode( array ( "status" => $status, "message" => $msg ) );
    }



    function question(){
        $page_title['page_title'] = "Question";
        $this->load->model('Blog_model');
        $this->load->model('Topics_model');
        $data['categories'] = $this->Blog_model->get_blog_category_detail_mod();
        $question_id = $this->input->get('id');
        if ($question_id != 0) {
            $data['question']        = $this->Quiz_model->get_question_details($question_id);
            $data['choices']         = $this->Quiz_model->get_question_choices($question_id);
            $data['quiz_associated'] = $this->Quiz_model->get_question_quiz($data['question']);
            //$data['topics']          = $this->Topics_model->get_topic_list();
            /*echo "<pre>";
            print_r($data);
            die;*/
        }
        $data['topics'] = $this->Quiz_model->get_topic_list(); 
        $this->load->view('template/header', $page_title);
        $this->load->view('add_update_question', $data);
        $this->load->view('template/footer');   
    }

    function addUpdateQuestion(){

        $inputs            = $this->input->post();
        $inputs['user_id'] = $this->userdata['user_id'];
        $validationResult = $this->Quiz_model->validate_quizquestion();

        if(empty($validationResult)){   
                $data['status']= 'failure';
                $data['error'] = array(
                    'question' =>strip_tags(form_error('question')),            
                    'meta_keywords' =>strip_tags(form_error('meta_keywords')),            
                    'meta_description' =>strip_tags(form_error('meta_description')),            
                             
                  );
                
                }else{

                if(empty($this -> input -> post('question_id'))){
                    $data['toast_message'] = "Question Created Successfully";   
                } else {
                    $data['toast_message'] = "Question Updated Successfully";
                }
                $question_id  = $this->Quiz_model->add_update_question($inputs);

        }
        echo json_encode($data);

    }

    function quest_list(){

        $data = array();
        $page_title['page_title'] = "Question";
        $data['question_list'] = $this->Quiz_model->get_question_list();  
        $this->load->view('template/header', $page_title);
        $this->load->view('question_list', $data);
        $this->load->view('template/footer');
    }


    function filteredQuestionList(){
        
        $inputs    = $this->input->post();
        $question_list = $this->Quiz_model->get_filtered_question_list($inputs);
        $output = '';
        $num = $inputs['offSet'];

        foreach ( $question_list as $key => $p ):    
                                        $question_id_exist = check_data_in_used('question_id',$p['id'],'quiz_action');
        
                                        if($question_id_exist > 0){
                                            $disabled = "disabled =''";
                                            $class = "invalid";
                                        }else{
                                            $class = "changeactivequestion";
                                            $disabled = "";
                                        }

                                        $ischecked = ($p[ 'is_active' ] == 1) ? "checked" : "";
                                            $ispublished = ($p[ 'is_published' ] == 1) ? "checked" : "";
                                            $num = $num + 1;
                                            echo '<tr>'
                                            . '<td>' . $num . '</td>'
                                            . '<td><p class="multiline-ellipsis" data-lines="1">' . $p[ 'question' ] . '</p></td>'
                                            . '<td><p class="multiline-ellipsis" data-lines="3">' . blank_value($p[ 'description' ]) . '</p></td>'
                                            . '<td class="text-center">' . date( "d-m-Y", strtotime( $p[ 'created_date' ] ) ) . '</td>'
                                            . '<td class="text-center">
                                                <a class="switch changepublishquestion" data-id="' . $p[ 'id' ] . '" data-type="question" data-status=' . $p[ 'is_published' ] . '>

                                                    <label><input type="checkbox" ' . $ispublished . '><span class="lever switch-col-bluenew"></span></label>
                                                </a>
                                                </td>'
                                            .'<td class="text-center">
                                                <a href="' . base_url() . 'Quiz/question?id=' . $p[ 'id' ] . '" data-id="' . $p[ 'id' ] . '" data-editjson=\'' . json_encode( $p ) . '\'><i class="material-icons">&#xE254;</i></a>
                                                <a href="#" '.$disabled.' data-id="' . $p[ 'id' ] . '" data-type="question" class="'.$class.'"><i class="material-icons">delete_forever</i></a>
                                              </td>';

                                        endforeach;
        

        echo $output;
    }

    function active_inactive_question(){
        $inputs = $this->input->post();
        $this->Quiz_model->active_inactive_question($inputs);
        $message = "Question deleted successfully";
        echo json_encode(array("status" => TRUE, "message" => $message));   
    }



   /* function fetchQuiz() {
                $arr_result = array ();
                $excludetopicids = array ();
                $ids = array ();

                $inputs = $this -> input -> post();
                
                $quiz = $inputs[ 'quiz' ];

                if ( isset( $inputs[ 'quiz_id' ] ) ) {
                        $excludetopicids = json_decode( $inputs[ 'quiz_id' ] );
                }

                if ( count( $excludetopicids ) > 0 ) {
                    $ids = $excludetopicids;                        
                }
                
                if ( isset( $quiz ) ) {
                        $arr_result = $this -> Quiz_model -> search( $quiz, $ids );
                        if ( count( $arr_result ) > 0 ) {                                
                            echo json_encode( $arr_result );
                        }
                }

        }*/


        function fetchQuiz() {
                $arr_result = array ();
                $excludetopicids = array ();
                $ids = array ();
                $inputs = $this -> input -> post();
                /*print_r($inputs);exit();*/
               

                if ( isset( $inputs[ 'quiz_id' ] ) ) {
                        $excludetopicids = json_decode( $inputs[ 'quiz_id' ] ); 
                }

                if ( count( $excludetopicids ) > 0 ) {
                    $ids = $excludetopicids;                        
                }
                
                if(!empty($cat_id)){
                    $arr_result = $this -> Quiz_model -> search($quiz,$cat_id);

                    if ( count( $arr_result ) > 0 ) {                                
                            echo json_encode( $arr_result );
                    }

                }
                
            }


    function fetchTopic(){
        $arr_result = array ();
        $excludetopicids = array ();
        $ids = array ();

        $inputs = $this -> input -> post();
        
        $topic = $inputs[ 'searchTerm'];
        $category = $inputs[ 'cat_id' ];


        if ( isset( $inputs[ 'topic_id' ] ) ) {
            $excludetopicids = json_decode( $inputs[ 'topic_id' ] );
        }

        if ( count( $excludetopicids ) > 0 ) {
            $ids = $excludetopicids;                        
        }
                
        $arr_result = $this -> Quiz_model -> search_topic( $topic,$category );
        if ( count( $arr_result ) > 0 ) {                                
                echo json_encode( $arr_result );

            }   
        
    }



    function fetchTopicList(){
        $inputs = $this -> input -> post();
        $category = $inputs[ 'category' ];

        $arr_result = $this -> Quiz_model -> get_topic_list_by_category( $category );
            if ( count( $arr_result ) > 0 ) {                                
                echo json_encode( $arr_result );
            }
    }
}