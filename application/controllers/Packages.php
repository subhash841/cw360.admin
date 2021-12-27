<?php


class Packages extends Base_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Packages_model');
        $this->load->model('Poll_model');
    }

    function index() {
        $data = array();

        $package_id = $this->input->get('id');
        if ($package_id != 0) {
            $data = $this->Packages_model->get_package_details($package_id);
            echo "<pre>"; print_r($data); exit;
        }

        $page_title['page_title'] = "Packages";

        $data['polls'] = $this->Poll_model->get_polls();
        
        $this->load->view('template/header', $page_title);
        $this->load->view('add_update_package', $data);
        $this->load->view('template/footer');
    }


    function lists(){
    	$data = array();
        $page_title['page_title'] = "Packages";

        $data['packages'] = $this->Packages_model->get_list();

        //$data['topics'] = $this->RatedArticle_model->get_topic_list();

        $this->load->view('template/header', $page_title);
        $this->load->view('package_list', $data);
        $this->load->view('template/footer');
    }




    function subscription(){
        $data = array();
        $page_title['page_title'] = "Subscription";
        $data = $this->Packages_model->get_subscription();
        /* echo '<pre>';print_r($data);
        exit();*/
        //$data['topics'] = $this->RatedArticle_model->get_topic_list();
        $this->load->view('template/header', $page_title);
        $this->load->view('subscription_list', $data);
        $this->load->view('template/footer');
    }


    function create_update($id = 0) {

        $data = array();
        $page_title['page_title'] = "Packages";
        $inputs = $this->input->post();
        $inputs['user_id'] = $this->userdata['user_id'];
        $this->Packages_model->add_update_package($inputs);
        $this->load->view('template/header', $page_title);
        $this->load->view('add_update_article', $data);
        $this->load->view('template/footer');

        redirect('Packages/lists');
    }

    function get_polls_list(){

    	$this -> db -> select( "p.*,pc.name as category,group_concat(pch.choice) as choices,right_choice" );
        $this -> db -> from( "poll p" );
        $this -> db -> join( "poll_category pc", "pc.id = p.category_id", "INNER" );
        $this -> db -> join( "poll_choices pch", "pch.poll_id = p.id", "INNER" );
        $this -> db -> group_by( "p.id" );
        $this -> db -> order_by( "p.is_approved ASC, p.id DESC" );
        $data = $this -> db -> get() -> result_array();
    	//$this -> apiresponse -> sendjson( $data );
    	echo json_encode($data);
    }


    function get_forecast_list(){

        $this -> db -> select( "ep.*, s.name as name" );
        $this -> db -> from( "election_period ep" );
        $this -> db -> where( "is_result_out", "1" );
        $this -> db -> join( "states s", "s.id = ep.state_id", "INNER" );

        $data = $this -> db -> get() -> result_array();
        echo json_encode($data);
    }

}