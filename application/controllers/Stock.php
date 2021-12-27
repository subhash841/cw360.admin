<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Stock extends Base_Controller {

    protected $stock_period_id = 0;

    function __construct() {
        parent::__construct();
        $this->load->model('Stock_model');

        $this->stock_period_id = '1';
    }

    function stock_list() {
        $data = array();
        $page_title['page_title'] = "Stocks";
        $data['stock_list'] = $this->Stock_model->stock_list_mod();

        $this->load->view('template/header', $page_title);
        $this->load->view('stock', $data);
        $this->load->view('template/footer');
    }

    function add_update_stock() {
        $inputs = $this->input->post();
        if ($inputs['stock_name'] == "") {
            $this->deliver_response(array("status" => FALSE, "message" => "Please enter stock name", "data" => array()));
        }
        if ($inputs['stock_code'] == "") {
            $this->deliver_response(array("status" => FALSE, "message" => "Please enter stock code", "data" => array()));
        }

        $this->Stock_model->add_update_stock_mod($inputs);
        $msg = ($inputs['stockid'] == "0") ? "Stock added successfully" : "Stock updated successfully";

        $this->deliver_response(array("status" => TRUE, "message" => $msg, "data" => array()));
    }

    function period() {
        $data = array();
        $page_title['page_title'] = "Stocks";
        $data['stock_list'] = $this->Stock_model->stock_list_mod();
        $data['stock_period_list'] = $this->Stock_model->stock_period_list();
        //var_dump($data);exit;
        $this->load->view('template/header', $page_title);
        $this->load->view('stock_period', $data);
        $this->load->view('template/footer');
    }

    function add_update_stock_period() {
        $inputs = $this->input->post();

        $response = $this->Stock_model->add_update_stock_period_mod($inputs);

        if ($response) {
            $this->deliver_response(array("status" => TRUE, "message" => "Stock added successfully", "data" => array()));
        } else {
            $this->deliver_response(array("status" => FALSE, "message" => "Date already exist", "data" => array()));
        }
    }

    function define_experts() {
        $data = array();
        $page_title['page_title'] = "Define Stock Experts";
        $data['users_forecasting'] = $this->Stock_model->users_forecastings_mod($this->stock_period_id);

        //var_dump($data);exit;
        $this->load->view('template/header', $page_title);
        $this->load->view('define_expert', $data);
        $this->load->view('template/footer');
    }

    function make_expert() {
        $inputs = $this->input->post();
        $inputs['userid'];
        $inputs['isexpert'];
        $inputs['stock_period_id'] = $this->stock_period_id;

        $result = $this->Stock_model->make_expert_mod($inputs);
        $this->deliver_response($result);
    }

    function getUserStockForecastDetail() {
        $inputs = $this->input->post();
        $userid = $inputs['userid'];

        $result = $this->Stock_model->users_forecastings_mod($this->stock_period_id, $userid);
        //echo json_encode($result);
        $this->deliver_response($result);
    }

    function updateStockResultOut() {
        $inputs = $this->input->post();
        $stock_period_id = $inputs['stock_period_id'];
        $is_result_out = $inputs['is_result_out'];

        $result = $this->Stock_model->update_stock_result_out_mod($inputs);
        redirect('Stock/period');
    }

    function updateEndOnDate() {
        $inputs = $this->input->post();

        $result = $this->Stock_model->update_stock_end_on_date($inputs);
        redirect('Stock/period');
    }

    function export_stock_forecast() {
        $file = "demo.xls";
        $test = "<table><tr><td>Cell 1</td><td>Cell 2</td></tr></table>";
        header("Content-type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=$file");
        echo $test;
    }

}
