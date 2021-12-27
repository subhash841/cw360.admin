<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Forecast_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    function get_forecast_reasons($id)
    {
        $this->db->select('*');
        $this->db->from('forecast_reason');
        $this->db->where('period_id', $id);
        $result = $this->db->get();
        return $result->result_array();
    }

    function deletereason_mod($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('forecast_reason');
        echo json_encode(array("status" => TRUE, "message" => "Reason deleted successfully"));
        exit;
    }

}
