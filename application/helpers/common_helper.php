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




if(!function_exists('game_name')){
    function game_name($game_id=""){   
            
            //Polls count
            $CI = & get_instance();
            $CI->db->select("title");
            $CI->db->from("games");

            $CI->db->where("id",$game_id);
            $data = $CI->db->get()->row_array();
            return $data['title'];
      }
}

if(!function_exists('get_game_id')){
    function get_game_id($game_name=""){   
            
            //Polls count
            $CI = & get_instance();
            $CI->db->select("id");
            $CI->db->from("games");
            $CI-> db ->like( 'title', $game_name, 'both' );
            $data = $CI->db->get()->row_array();
            return $data['id'];
      }
}


if(!function_exists('check_data_in_used')){
    
    function check_data_in_used($field_name,$id,$table_name)
      {
            $ci = &get_instance();
            $ci->db->select('count(*) as cnt');
            $ci->db->from($table_name);
            $ci->db->where($field_name,$id);
            $result = $ci->db->get()->row_array();
            //echo $ci->db->last_query(); exit();
            return $result['cnt'];
      }

}




if(!function_exists('blank_value')){
    function blank_value($value=""){   
         if (!empty($value)){
            return $value;
         }else{
            return $value='NA';
         }
      }
}

if(!function_exists('clean')){
    function clean($string=""){ 
             return preg_replace('/[^A-Za-z0-9\-]/', '', $string);         // Removes special chars.
        }
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

function getKeywords() {
    $CI = & get_instance();
    $getwords = "select keywords from banned_words";
    $result = $CI->db->query($getwords);
    $words = $result->get()->row_array();

    return explode(',', $words['keywords']);
}

function is_contain_badwords($string) {

    $keywords = getKeywords();

    foreach ($keywords as $bad) {
        $bad = trim($bad);
        if (stripos($string, $bad) !== false) {
            $badwordfound = FALSE;
            break;
        } else {
            $badwordfound = TRUE;
        }
    }

    if ($badwordfound) {
        return TRUE;
    } else {
        return FALSE;
    }
}

function getmetatags()
    {
        $CI = & get_instance();
        $url=$CI->input->post('url');
        $data = file_get_contents($url);
        $dom = new DomDocument;
        @$dom->loadHTML($data);

        $xpath = new DOMXPath($dom);
        # query metatags with og prefix
        $metas = $xpath->query('//*/meta[starts-with(@property, \'og:\')]');

        $og = array();

        foreach ($metas as $meta) {
            # get property name without og: prefix
            $property = str_replace('og:', '', $meta->getAttribute('property'));
            # get content
            $content = $meta->getAttribute('content');
            $og[$property] = $content;
        }
        //var_dump($og);exit;
        if(!isset($og['image'])){
            $og['image']=base_url().'images/common/no-image.png';
        }
        if(!isset($og['description'])){
            $og['description']="";
        }
        if(!isset($og['url'])){
            $og['url']="";
        }
        $og['url']=parse_url($url)['host'];
        if(!isset($og['title'])){
            $res = preg_match("/<title>(.*)<\/title>/siU", $data, $title_matches);
            if (!$res) 
                return null; 

            // Clean up title: remove EOL's and excessive whitespace.
            $title = preg_replace('/\s+/', ' ', $title_matches[1]);
            $title = trim($title);
            $og['title']=$title;
        }
        echo json_encode(array("status" => TRUE, "data" => $og)); 
        
    }

function send_email( $to, $from, $subject, $msg ) {
                $config = array ();

                $config[ 'api_key' ] = "8aa5eea08abe60782f6fb7a9ddc36a3f-52cbfb43-35bf5489";
                $config[ 'api_url' ] = "https://api.mailgun.net/v3/notifications.crowdwisdom.co.in/messages";

                $message = array ();
                $message[ 'to' ] = $to;
                $message[ 'bcc' ] ='crowdwisdom360@gmail.com';
                $message[ 'from' ]="Crowdwisdom Team <notifications@crowdwisdom.co.in>";
                $message[ 'subject' ] = $subject;
                $message[ 'html' ] = $msg;
                $message = http_build_query( $message );

                $ch = curl_init();
                curl_setopt( $ch, CURLOPT_URL, $config[ 'api_url' ] );
                curl_setopt( $ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC );
                curl_setopt( $ch, CURLOPT_USERPWD, "api:{$config[ 'api_key' ]}" );
                curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
                curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, 20 );
                curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, 0 );
                curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, 0 );
                curl_setopt( $ch, CURLOPT_POST, true );
                curl_setopt( $ch, CURLOPT_POSTFIELDS, $message );

                $result = curl_exec( $ch );
                curl_close( $ch );
                return $result;
}

if (!function_exists('game_history_update')) {

    function game_history_update($postdata) {
            $ci = &get_instance();
            $game_history_data[]=$postdata;
            // print_r($game_history_data);die;
            $insert_array=array();
            $arr_key=0;
            $ci->load->helper('common');
           
            foreach ($game_history_data as $key => $value) {
                $game_id=$value['game_id'];
                $table_name=$value['table_name'];
                $user_id=$value['user_id'];
                unset($value['game_id']);
                unset($value['user_id']);
                unset($value['table_name']);
                unset($value['end_time']);
                unset($value['modified_date']);
                // print_r($value);
                if(!empty($value)){
                    foreach ($value as $key_o => $value_o) {                 
                     $insert_array[$arr_key]['table_name']=$table_name;
                     $insert_array[$arr_key]['colunm_name']=$key_o;
                     $insert_array[$arr_key]['old_value']=get_old_value($table_name,$key_o,array('id'=>$game_id));
                     $insert_array[$arr_key]['new_value']=$value_o;
                     $insert_array[$arr_key]['game_id']=$game_id;
                     $insert_array[$arr_key]['user_id']=$user_id;
                     $insert_array[$arr_key]['created_date']=date('Y-m-d H:i:s');
                     $arr_key++;
                    }
                }
            }
            if(!empty($insert_array)){
                $ci->db->insert_batch('log_data',$insert_array);
                return true;
                }else{
                  return false;
                }    
    }
}

if (!function_exists('get_old_value')) {

    function get_old_value($table,$colunm,$where) {
        
        $CI = & get_instance();
        $CI->db->select($colunm);
        $CI->db->from($table);
        $CI->db->where($where);
        $result=$CI->db->get()->row_array();
        if(empty($result)){
            $res=0;
        }else{
            $res=$result[$colunm];
        }
        //echo $CI->db->last_query();
        // echo $res;
        // die;
        return $res;
    }
}


if (!function_exists('split_batch_array')) {
    function split_batch_array($batch_array,$where_array="",$update_id="",$table_name,$type_batch){
        // print_r($where_array);die;
        $CI = & get_instance();
        $CI->load->helper('common');
        $data_chunk = array_chunk($batch_array,89); // array_chunk('array of prdection', array divide by provide int value)
        for($i=0;$i < count($data_chunk);$i++) {
            update_batch_data_array($data_chunk[$i],$where_array,$update_id,$table_name,$type_batch);
        }
    }
} 
if (!function_exists('update_batch_data_array')) { 
    function update_batch_data_array($data_chunk,$where_array,$update_id,$table_name,$type_batch){
        // echo $where_array;die;
        $CI = & get_instance();
        if($type_batch == 'insert_batch'){
            
            $CI->db->insert_batch($table_name, $data_chunk, $update_id);
        }else{            
            if(!empty($where_array)){
                $CI->db->where($where_array);
            }
            $CI->db->update_batch($table_name, $data_chunk, $update_id);
        }
       
    }
}
/**
 * sudhir 
 * 
 * Get Device type and device token
 */
function get_device_token( $userid) {
    $CI = & get_instance();
    $get_devicetoken = "";

    // print_r($userid);die;
    if ( $userid != 'All') {
            $get_devicetoken = "select id, device_type, device_token from users where id in ($userid) and ifnull(device_token,'') <> ''";
    }else{
        $get_devicetoken = "select id, device_type, device_token from users where ifnull(device_token,'') <> ''";
    }

    if ( $get_devicetoken != "" ) {
            $resultset = $CI -> db -> query( $get_devicetoken ) -> result_array();
            return $resultset;
    } else {
            return array ();
    }

}


 function RemoveSpecialChapr($value){
    $title = str_replace( array( '\'', '"', ',' , ';', '<', '>' ), ' ', $value);
    
return $title;
}
if(!function_exists('get_email_user')){
    
    function get_email_user($user_id)
      {
            $ci = &get_instance();
            $ci->db->select('ifnull(email,"Admin") as email');
            $ci->db->from('users');
            $ci->db->where('id',$user_id);
            $result = $ci->db->get()->row_array();
            //echo $ci->db->last_query(); exit();
            if(empty($result['email'])){
                $res="Admin";
            }else{
                $res=$result['email'];
            }
            return $res;
      }

}
