<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Election extends Base_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('Election_model');
    }

    function index()
    {
        $data = array();
        $page_title['page_title'] = "Dashboard";
        $data['states'] = $this->Election_model->get_states_list();
        $data['parties'] = $this->Election_model->get_parties_list();
        $data['election_period']= $this->Election_model->get_election_periods_list();
        $this->load->view('template/header', $page_title);
        //$this->load->view('dashboard');
        //echo '<pre>';
        //print_r($data);exit;

        $this->load->view('elections_list', $data);
        $this->load->view('template/footer');
    }

    function addUpdateElectionPeriod()
    {
        $inputs = $this->input->post();

        $response = $this->Election_model->add_update_election_period_mod($inputs);

        if ($response) {
            $this->deliver_response(array("status" => TRUE, "message" => "Election Period added successfully", "data" => array()));
        } else {
            $this->deliver_response(array("status" => FALSE, "message" => "Date already exist", "data" => array()));
        }
    }

//    function forecast(){
//    //var_dump("hello");exit;
//        $data = array();
//        $page_title['page_title'] = "Dashboard";
//
//        $this->load->view('template/header', $page_title);
//        $this->load->view('dashboard');
////        $this->load->view('template/footer');
//    }
}
