<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Dashboard extends Base_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Election_model');
    }

    function index() {
        $data = array();
        $page_title['page_title'] = "Dashboard";
        $this->load->view('template/header', $page_title);
        // $this->load->view('dashboard');
        $this->load->view('welcome_message', $data);
        $this->load->view('template/footer');
    }
    function get_date_time() {
        $data['dateTime'] = date('d, M Y h:i:s A');
        echo json_encode($data);
    }
   
}
