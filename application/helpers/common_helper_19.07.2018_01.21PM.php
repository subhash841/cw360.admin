<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function special_character($string) {
    $string = str_replace("'", "&#39;", $string); //convert single quote to html entity
    $string = str_replace('"', "&#34;", $string); //convert double quote to html entity
    $string = nl2br($string);  //convert enter to <br /> tag html entity
    return $string;
}

function br2nl($string) {
    return preg_replace('/\<br(\s*)?\/?\>/i', "\n", $string); //convert <br /> tag to new line
}

function createexcel($exceldata, $filename) {
    header('Content-Type: application/vnd.ms-excel'); //mime type
    header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
    header('Cache-Control: max-age=0'); //no cache
    $CI = & get_instance();
    $CI->load->library('excel');
    $objPHPExcel = new PHPExcel();
    $objPHPExcel->getProperties()->setCreator("Crowd Wisdom")
            ->setLastModifiedBy("Crowd Wisdom")
            ->setTitle("User_forecasting")
            ->setSubject("User_forecasting")
            ->setDescription("User_forecasting")
            ->setKeywords("User_forecasting")
            ->setCategory("User_forecasting");
    $objPHPExcel->getActiveSheet()->setTitle('User_forecasting');
    $row = 1;
    $col = 0;
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "ID");
    $col++;
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "USER_ID");
    $col++;
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "ELECTION_PERIOD_ID");
    $col++;
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "STATE_ID");
    $col++;
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "PARTY_ID");
    $col++;
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "SEAT_FORECAST");
    $col++;
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "VOTE_FORECAST");
    $col++;
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "CREATED_DATE");
    $col++;
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "MODIFIED_DATE");
    $col++;
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "NAME");
    $col++;
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "TWITTER_ID");
    $col++;
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "ABBREVATION");
    $col++;
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "LOCATION");
    $col++;
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "PARTY_AFFILIATION");
    $row++;
    foreach ($exceldata as $result) {
        $col = 0;
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $result['id']);
        $col++;
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $result['user_id']);
        $col++;
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $result['election_period_id']);
        $col++;
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $result['state_id']);
        $col++;
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $result['party_id']);
        $col++;
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $result['seat_forecast']);
        $col++;
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $result['vote_forcast']);
        $col++;
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $result['created_date']);
        $col++;
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $result['modified_date']);
        $col++;
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $result['name']);
        $col++;
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $result['twitter_id']);
        $col++;
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $result['abbreviation']);
        $col++;
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $result['location']);
        $col++;
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $result['party_affiliation']);
        $row++;
    }
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

    $objWriter->save('php://output');
}

function get_dashboard_counts() {
    $dashboard_counts = array();

    //Polls count
    $CI = & get_instance();
    $CI->db->select("count(1) as total_polls");
    $CI->db->from("poll");
    $CI->db->where("is_approved = '1' and is_active = '1'");
    $dashboard_counts['polls'] = $CI->db->get()->result_array();

    //Blogs count
    $CI = & get_instance();
    $CI->db->select("count(1) as total_blogs");
    $CI->db->from("blogs");
    $CI->db->where("is_active = '1'");
    $dashboard_counts['blogs'] = $CI->db->get()->result_array();

    //Visitor count
    $CI = & get_instance();
    $CI->db->select("count(1) as total_users");
    $CI->db->from("users");
    $CI->db->where("is_active = '1'");
    $dashboard_counts['users'] = $CI->db->get()->result_array();

    return $dashboard_counts;
}
