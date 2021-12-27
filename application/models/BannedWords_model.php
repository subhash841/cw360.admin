<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class BannedWords_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get_banned_words() {
        $this->db->select("id,keywords");
        $this->db->from("banned_words");
        return $this->db->get()->result_array();
    }

    function add_update_banned_words_mod($inputs) {
        $word_id = $inputs['word_id'];
        $words = $inputs['words'];

        $update_words = array(
            "keywords" => $words
        );

        $this->db->where('id', $word_id);
        $this->db->update('banned_words', $update_words);

        return TRUE;
    }

}
