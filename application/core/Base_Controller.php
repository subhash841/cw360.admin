<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Base_Controller extends CI_Controller {

    function __construct() {
        parent::__construct();

        $session = $this->session->userdata('loggedin');
        if (empty($session)) {
            redirect('Login');
        }
    }

    function deliver_response($array) {
        echo json_encode($array);
        exit;
    }

}
