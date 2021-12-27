<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Forum extends Base_Controller {

    function __construct() {
        parent::__construct();
    }

    function index() {
        $data = array();
        $page_title['page_title'] = "Dashboard";

        $this->load->view('template/header', $page_title);
        $this->load->view('dashboard');
        $this->load->view('template/footer');
    }

}