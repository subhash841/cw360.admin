<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Stock_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function stock_list_mod() {
        $this->db->select('s.*');
        $this->db->from('stocks s');
        $result = $this->db->get()->result_array();
        return $result;
    }

    function stock_period_list() {
        //$this->db->select('*, GROUP_CONCAT(s.id SEPARATOR ",") as stock_id,GROUP_CONCAT(s.name SEPARATOR ",") as stock_name,GROUP_CONCAT(s.name SEPARATOR ",") as stock_code');
        $this->db->select("sip.stock_period_id,GROUP_CONCAT(sip.stock_id) as stock_id, GROUP_CONCAT(sip.actual_weekly_result) as actual_weekly_result, "
                . "GROUP_CONCAT(sip.actual_monthly_result) as actual_monthly_result, GROUP_CONCAT(sip.actual_yearly_result) as actual_yearly_result, "
                . "GROUP_CONCAT(s.name) as name ,GROUP_CONCAT(s.code) as code, sp.from_date, sp.to_date, sp.is_result_out, "
                . "sp.is_weekly_stop, sp.is_monthly_stop, sp.is_yearly_stop, sp.weekly_endon_date, sp.monthly_endon_date, sp.yearly_endon_date");
        $this->db->from('stock_into_period sip');
        $this->db->join('stock_period sp', 'sp.id = sip.stock_period_id', "INNER");
        $this->db->join('stocks s', 's.id = sip.stock_id', "INNER");
        //$this->db->group_by('sp.id');
        $this->db->group_by('sip.stock_period_id');
        $this->db->order_by('sip.id');
        $getsplist = $this->db->get();
        $result = $getsplist->result_array();
        return $result;
    }

    function add_update_stock_mod($inputs) {
        if ($inputs['stockid'] == "0") {
            $insert_array = array(
                "name" => $inputs['stock_name'],
                "code" => $inputs['stock_code']
            );
            $this->db->insert('stocks', $insert_array);
        } else {
            $update_array = array(
                "name" => $inputs['stock_name'],
                "code" => $inputs['stock_code']
            );
            $this->db->where("id", $inputs['stockid']);
            $this->db->update('stocks', $update_array);
        }

        return TRUE;
    }

    function add_update_stock_period_mod($inputs) {

        $stock_period_id = $inputs['stock_period_id'];
        $from_date = date("Y-m-d", strtotime($inputs['from_date']));
        $to_date = date("Y-m-d", strtotime($inputs['to_date']));

        $stocks = $inputs['stocks'];

        if ($stock_period_id == "0") {
            $this->db->select('1');
            $this->db->from('stock_period');
            $this->db->where('from_date="' . $from_date . '" AND to_date="' . $to_date . '"');
            $getalreadydate = $this->db->get();
            if ($getalreadydate->num_rows() > 0) {
                return FALSE;
            }
            $insert = array(
                "from_date" => $from_date,
                "to_date" => $to_date
            );
            $this->db->insert('stock_period', $insert);
            $lastid = $this->db->insert_id();

            foreach ($stocks as $key => $list) {
                $stock_with_period[] = array(
                    "stock_period_id" => $lastid,
                    "stock_id" => $list
                );
            }

            if (!empty($stock_with_period)) {
                $this->db->insert_batch('stock_into_period', $stock_with_period);
            }
            return TRUE;
        }
    }

    function users_forecastings_mod($stock_period_id, $userid = 0) {
        $this->db->select("sf.id, sf.user_id, sf.is_expert, sf.stock_period_id, sf.stock_id, sf.weekly_forecast, sf.monthly_forecast, sf.yearly_forecast,"
                . "u.name, s.name as stock_name");
        $this->db->from("stock_forecasting sf");
        $this->db->join("users u", "u.id = sf.user_id", "INNER");
        $this->db->join("stocks s", "s.id = sf.stock_id", "INNER");
        $this->db->where("sf.stock_period_id = '$stock_period_id'");
        if ($userid != 0) {
            $this->db->where("sf.user_id = '$userid'");
        }
        $this->db->order_by("sf.user_id, sf.stock_id");
        $result = $this->db->get();
        $data = $result->result_array();
        //echo $this->db->last_query();exit;
        return $data;
    }

    function make_expert_mod($inputs) {
        $data = array();
        $userid = $inputs['userid'];
        $isexpert = ($inputs['isexpert'] == "0") ? "1" : "0";
        $stock_period_id = $inputs['stock_period_id'];

        $data = array(
            "is_expert" => $isexpert
        );

        $this->db->where("user_id = '$userid' AND stock_period_id = '$stock_period_id'");
        $this->db->update("stock_forecasting", $data);

        return array("status" => TRUE, "message" => "This user becomes an expert", "data" => $data);
    }

    function update_stock_result_out_mod($inputs) {
        $stock_period_id = $inputs['stock_period_id'];
        $is_result_out = ($inputs['is_result_out'] == "0") ? "1" : "0";
        $result_type = $inputs['result_type'];

        if (!in_array($result_type, array("stopweekly", "stopmonthly", "stopyearly", "stopfull"))) {
            return false;
        }

        if ($result_type == "stopweekly") {
            $data = array(
                "is_weekly_stop" => $is_result_out
            );
        }
        if ($result_type == "stopmonthly") {
            $data = array(
                "is_monthly_stop" => $is_result_out
            );
        }
        if ($result_type == "stopyearly") {
            $data = array(
                "is_yearly_stop" => $is_result_out
            );
        }
        if ($result_type == "stopfull") {
            $data = array(
                "is_result_out" => $is_result_out
            );
        }

        $this->db->where("id = '$stock_period_id'");
        $this->db->update("stock_period", $data);
        return true;
    }

    function update_stock_end_on_date($inputs) {
        $stock_period_id = $inputs['endon_date_stock_period_id'];

        $update = array(
            "weekly_endon_date" => date("Y-m-d", strtotime($inputs['weekly_end_date'])),
            "monthly_endon_date" => date("Y-m-d", strtotime($inputs['monthly_end_date'])),
            "yearly_endon_date" => date("Y-m-d", strtotime($inputs['yearly_end_date']))
        );

        $this->db->where("id = '$stock_period_id'");
        $this->db->update("stock_period", $update);

        return TRUE;
    }

}
