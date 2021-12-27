<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class BannedWords extends Base_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('BannedWords_model');
    }

    function index() {
        $data = array();
        $header_data['page_title'] = "Banned Words";

        $data['banned_words'] = $this->BannedWords_model->get_banned_words();

        $this->load->view('template/header', $header_data);
        $this->load->view('banned_words', $data);
        $this->load->view('template/footer');
    }

    function add_update_banned_words() {
        $inputs = $this->input->post();
        $word_id = $inputs['word_id'];
        $words = $inputs['words'];

        $result = $this->BannedWords_model->add_update_banned_words_mod($inputs);

        if ($result) {
            echo json_encode(array("status" => TRUE, "message" => "words updated successfully"));
        }
    }

}
