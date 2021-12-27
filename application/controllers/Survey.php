<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Survey extends Base_Controller {

    private $userdata = array();

    function __construct() {
        parent::__construct();

        $this->load->model('Survey_model');
        $this->userdata = $this->session->userdata('loggedin');
    }

    function index() {
        $data = array();
        $data[ 'choices' ] = array ();
        
        $survey_id = $this->input->get('id');
        if ($survey_id != 0) {
            $data = $this->Survey_model->get_survey_details($survey_id);
        }

        $page_title['page_title'] = "Surveys";
        //$data['survey_category'] = $this->Survey_model->get_survey_category();

        $this->load->view('template/header', $page_title);
        $this->load->view('add_update_survey', $data);
        $this->load->view('template/footer');
    }

    function filteredList() {
                $surveys = array();

                $inputs = $this->input->post();

                $surveys = $this->Survey_model->get_filtered_list($inputs);

                $output = '';
                $num = $inputs['offSet'];

                foreach ($surveys as $key => $p):
                            $ischecked = ($p['is_active'] == 1) ? "checked" : "";
                                        $isapproved = ($p['is_approved'] == "1") ? "Yes" : "No";
                                        $num = $num + 1;
                                        echo '<tr>'
                                        . '<td>' . $num . '</td>'
                                        . '<td><p class="multiline-ellipsis" data-lines="1">' . $p['question'] . '</p></td>'
                                        . '<td><p class="multiline-ellipsis" data-lines="3">' . $p['description'] . '</p></td>'
                                        //. '<td class="text-center">' . $isapproved . '</td>'
                                        . '<td class="text-center">' . date("d-m-Y", strtotime($p['created_date'])) . '</td>'
                                        . '<td class="text-center">
                                            <a class="switch changeactivesurvey" data-id="' . $p['id'] . '" data-type="surveys" data-status=' . $p['is_active'] . '>
                                                <label><input type="checkbox" ' . $ischecked . '><span class="lever switch-col-bluenew"></span></label>
                                            </a>
                                        </td>'
                                        . '<td class="text-center">
                                            <a href="' . base_url() . 'Survey/index?id=' . $p['id'] . '" data-id="' . $p['id'] . '" data-editjson=\'' . json_encode($p) . '\'><i class="material-icons">&#xE254;</i></a>
                                            <a href="' . base_url() . 'Survey/survey_details?id=' .$p['id'] .'"  data-id="' . $p['id'] . '"><i class="material-icons">remove_red_eye</i></a>
                                        </td>';
                                    
                        
                        endforeach;
                echo $output;
                
        }

        function exportList_surveys() {
            $surveys = array();

            $data = '';

                $inputs = $this->input->get();

                $surveys = $this->Survey_model->get_filtered_list_exported($inputs);

                $output = '';
                //$num = $inputs['offSet'];

                $data .= '<tr>
                            <th># Sr. No</th>                                        
                                <th>Survey</th>
                                <th>Description</th>
                                <th class="text-center">Is Approved</th>
                                <th class="text-center">Created Date</th>
                                <th class="text-right">Active</th>
                                <th class="text-center">Action</th>
                            </tr>';

                foreach ($surveys as $key => $p):
                            $ischecked = ($p['is_active'] == 1) ? "checked" : "";
                                        $isapproved = ($p['is_approved'] == "1") ? "Yes" : "No";
                                        $num = $key + 1;
                                        $data .= '<tr>'
                                        . '<td>' . $num . '</td>'
                                        . '<td><p class="multiline-ellipsis" data-lines="1">' . $p['question'] . '</p></td>'
                                        . '<td><p class="multiline-ellipsis" data-lines="3">' . $p['description'] . '</p></td>'
                                        //. '<td class="text-center">' . $isapproved . '</td>'
                                        . '<td class="text-center">' . date("d-m-Y", strtotime($p['created_date'])) . '</td>'
                                        . '<td class="text-center">
                                            <a class="switch changeactivesurvey" data-id="' . $p['id'] . '" data-type="surveys" data-status=' . $p['is_active'] . '>
                                                <label><input type="checkbox" ' . $ischecked . '><span class="lever switch-col-bluenew"></span></label>
                                            </a>
                                        </td>'
                                        . '<td class="text-center">
                                            <a href="' . base_url() . 'Survey/index?id=' . $p['id'] . '" data-id="' . $p['id'] . '" data-editjson=\'' . json_encode($p) . '\'><i class="material-icons">&#xE254;</i></a>
                                            <a href="' . base_url() . 'Survey/survey_details?id=' .$p['id'] .'"  data-id="' . $p['id'] . '"><i class="material-icons">remove_red_eye</i></a>
                                        </td>';
                                    
                        
                        endforeach;
                    $file = "surveys.xls";
                    $test = "<table border='1'>" . $data . "</table>";
                    header("Content-type: application/vnd.ms-excel");
                    header("Content-Disposition: attachment; filename=$file");
                    echo $test;
        }

        function survey_details() {
            $survey_data = array();
            $survey_title['page_title'] = "Survey Details";
            $survey_id = $this-> input -> get( 'id' );
            $survey_data = $this -> Survey_model -> get_details_survey( $survey_id );

            $survey_data['surveys'] = $this -> Survey_model -> get_survey_count( $survey_id );

            $survey_data['replies'] = $this -> Survey_model -> get_survey_replies ( $survey_id );

            $this -> load -> view( 'template/header', $survey_title );
            $this -> load -> view( 'survey_details', $survey_data );
            $this -> load -> view( 'template/footer' );
            echo $survey_id; 
        }

    function survey_detail() {
        $survey_id = $this->input->post('surveyid');
        $survey_data = $this->Survey_model->get_survey_details($survey_id);
        echo json_encode($survey_data);
    }

    function create_update($id = 0) {

        $data = array();
        $page_title['page_title'] = "Surveys";
        //$data['survey_category'] = $this->Survey_model->get_survey_category();

        $inputs = $this->input->post();
        $inputs['user_id'] = $this->userdata['user_id'];

        $this->Survey_model->add_update_survey($inputs);

        $this->load->view('template/header', $page_title);
        $this->load->view('add_update_survey', $data);
        $this->load->view('template/footer');

        redirect('Survey/lists');
    }

    function lists() {
        $data = array();
        $page_title['page_title'] = "Surveys";

        $data['surveys'] = $this->Survey_model->get_list();

        $data['topics'] = $this->Survey_model->get_topic_list();

        $this->load->view('template/header', $page_title);
        $this->load->view('survey_list', $data);
        $this->load->view('template/footer');
    }

    function approve_survey() {
        $inputs = $this->input->post();

        $inputs['user_id'] = $this->userdata['user_id'];

        $this->Survey_model->approve_survey($inputs);

        echo json_encode(array("status" => TRUE, "message" => "Survey approved successfully"));
    }

    function active_inactive_survey() {
        $inputs = $this->input->post();

        $this->Survey_model->active_inactive_survey_mod($inputs);

        $message = ($inputs['current'] == "1") ? "Survey deactivated successfully" : "Survey activated successfully";
        echo json_encode(array("status" => TRUE, "message" => $message));
    }
    function stop_active_survey() {
                $inputs = $this -> input -> post();

                $this -> Survey_model -> stop_active_survey_mod( $inputs );

                $message = ($inputs[ 'current' ] == "1") ? "Survey unstopped successfully" : "Survey stopped successfully ";
                echo json_encode( array ( "status" => TRUE, "message" => $message ) );
        }

    function export_surveys() {
        $data = "";
        $surveys = $this->Survey_model->get_list();
        
        $data = '<tr>'
                . '<td><strong>Sr. No.</strong></td>'
                //. '<td><strong>Category</strong></td>'
                . '<td><strong>Survey</strong></td>'
                . '<td><strong>Description</strong></td>'
                . '<td><strong>Choices</strong></td>'
                //. '<td><strong>Approved</strong></td>'
                . '<td><strong>Created Date</strong></td>'
                . '<td><strong>Is Active</strong></td>'
                . '</tr>';

        foreach ($surveys as $key => $survey_data) {
            $num = $key + 1;
            $is_approved = ($survey_data['is_approved'] == 1) ? "Yes" : "No";
            $is_active = ($survey_data['is_active'] == 1) ? "Yes" : "No";

            $data .= '<tr>'
                    . '<td>' . $num . '</td>'
                    //. '<td>' . $survey_data['category'] . '</td>'
                    . '<td>' . $survey_data['question'] . '</td>'
                    . '<td>' . $survey_data['description'] . '</td>'
                    . '<td>' . $survey_data['choices'] . '</td>'
                    //. '<td>' . $is_approved . '</td>'
                    . '<td>' . date("d-m-Y", strtotime($survey_data['created_date'])) . '</td>'
                    . '<td>' . $is_active . '</td>'
                    . '</tr>';
        }
        $file = "surveys.xls";
        $test = "<table border='1'>" . $data . "</table>";
        header("Content-type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=$file");
        echo $test;
    }

}
