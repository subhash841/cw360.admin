<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Forecast extends Base_Controller
{

    function __construct()
    {
        parent::__construct();
        //$this->load->model('Blog_model');
        $this->load->model('Forecast_model');
    }

//    function index()
//    {
//        $this->load->view('template/header', $page_title);
//        $this->load->view('blogs', $data);
//        $this->load->view('template/footer');
//    }
    
    function reasons(){
        $page_title['page_title'] = "Gujrat/reasons";
        $data['reasons']= $this->Forecast_model->get_forecast_reasons(1);
        $this->load->view('template/header', $page_title);
        $this->load->view('Gujrat/reasons', $data);
        $this->load->view('template/footer');
    }
    
    function deleteforecastreason(){
        $id= $this->input->post('forecastreasonid');
        
    }
}
