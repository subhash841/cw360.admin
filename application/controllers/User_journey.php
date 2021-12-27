<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class User_journey extends CI_Controller {

    function __construct() {
        parent::__construct();
	    $this->load->model(array('Games_model','predictions_model'));
	    $this->load->helper(array('prediction_helper'));
		$this->load->model('Common_model');
		
		$sessiondata = $this->session->userdata('data');
        if (!empty($sessiondata)) {
            $this->user_id = $sessiondata['uid'];
        } else {
            $this->user_id = 0;
        }
    }

    public function index() {
    	$this->load->view('overlay_screen');
    }




}