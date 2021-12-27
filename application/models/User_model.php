<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class User_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->library('MY_Form_validation');
    }

    function authenticate_user($username, $password="") {
        $this->db->select("id, email, password, role, menu_list, is_active, created_date");
        $this->db->from("admin");
        if($password !=""){
            $this->db->where("password" , md5($password));
        }
        $this->db->where(array("email" => $username,"is_active" => 1));
        return $this->db->get()->row_array();
    }

    
     function authenticate_user_menu_list($menu_list) {
        // echo $menu_list; die;
        $this->db->select("group_concat(name SEPARATOR',') as menu_list_data");
        $this->db->from("menu_list");
        $this->db->where_in("id" , str_replace("'"," ",$menu_list));
        $this->db->where("is_active" , 1);
        $res=$this->db->get()->row_array();
        // echo $this->db->last_query();
        return $res['menu_list_data']; 
    }

     function update_user_password($username , $password)
    {
        $data = array (
                        "email" => $username,
                        "password" => md5($password),
                        "modified_date"=>date('Y-m-d h:i:s')
                        );
                        $this -> db -> where( "email = '$username'" );
                        $this -> db -> update( "admin", $data );
    }

    function get_order_list($offset=0) {
        $this -> db -> select("u.id,case when u.name IS NULL or u.name = '' then 'NA' else u.name END as name,case when u.email IS NULL or u.email = '' then 'NA' else u.email END as email,ep.id,ep.game_id,ep.id as orderid,ep.user_id,ep.prediction_id,(CASE WHEN ep.sell_points='0.00' THEN ep.buy_points ELSE  ep.sell_points END) AS points,ep.created_date,ep.swipe_status,g.title as game_title,p.title as prediction_title,p.current_price");
        $this -> db -> from("users u");
        $this -> db -> join("summary_history ep","u.id = ep.user_id","RIGHT");
        $this -> db -> join("games g","ep.game_id = g.id","LEFT");  
        $this -> db -> join("predictions p","ep.prediction_id = p.id","LEFT");
        $this -> db -> order_by( "ep.id DESC" );
        $this -> db -> limit(500, $offset);

        return  $this -> db -> get() -> result_array();
       
    }


     function validate_user(){

        $this->form_validation->set_rules($this->config->item('User','validation_rules'));
        if($this->form_validation->run() == FALSE){

                return FALSE;
            } else {
                return TRUE;
              }
        } 


        




  /*  function validate_coins($user_id,$coins){

        $this -> db -> select( "*" );
        $this -> db -> from( "coins" );
        $this -> db -> where("coins >", $coins);
        $this -> db -> where("user_id =", $user_id);
        $query = $this -> db -> get() -> result_array();
        

        if($num = 0){
            return TRUE;
        }else{
            return FALSE;
        }

    }*/

    function validate_coins($user_id,$coins){

        $this -> db -> select( "*" );
        $this -> db -> from( "coins" );
        $this -> db -> where("user_id =", $user_id);
        $this -> db -> where("coins >", $coins);
        $this -> db -> or_where('coins = ',$coins,TRUE);
     
        $query = $this -> db -> get() -> result_array();   
        if(!empty($query)){
            return 1;
        }else{
            return 2;                           //No Result
        }

    }


     function add_update_user( $inputs ) {

                 //print_r($inputs);die;
                $userid = $inputs[ 'user_id' ];
                $menu_list = implode(',',$inputs['menu_list']);
                $role ='user';
                $password = $inputs[ 'admin_password' ];
                $password = md5($password);
                 if(isset($inputs[ 'is_active' ])){
                    $is_active = 1;
                } else {
                    $is_active = 0;
                }
               
                if ( $userid == 0 ) {   

                    $data = array (
                    "email" => $inputs[ 'admin_email' ],
                    "password" => $password,
                    "role" => $role,
                    "menu_list" => $menu_list,
                    "is_active" => $is_active,
                    );

                    $data['created_date']=date('Y-m-d h:i:s');
                    if($this -> db -> insert( "admin", $data )){
                        if($is_active=='1'){
                            
                            $title="New User Registration Email";
                            $message ="";
                            $message .= "Dear User, <br /><br />";
                            $message .= "Welcome to crowdwisdom360.com admin console.";
                            $message .="Below are your login credentials :<br />";
                            $message .="Email : ".$_POST['admin_email']."<br />";
                            $message .="Password : ".$_POST['admin_password']."<br />";
                            $message .= "Please click on below URL to access crowdwisdom360.com admin console : <br />";          
                            $message .=  base_url()."<br />";
                            $message .= "Thank you and have a great day ahead !!, <br /><br />Regards,<br />CrowdWisdom Team";
                            $res=send_email( $inputs['admin_email'], '', $title, $message );
                        }
                    }


                } else {

                        $data = array (
                        "role" => $role,
                        "menu_list" => $menu_list,
                        "is_active" => $is_active,
                        );

                        $data['modified_date']=date('Y-m-d h:i:s');
                        $this -> db -> where( "id = '$userid'" );
                        $this -> db -> update( "admin", $data );

                }
                return TRUE;
        }        
	
    function get_list($offset = 0) {
        $this -> db -> select( "u.*,loc.name as location,p.name as party" );
        $this -> db -> from( "users u" );
        $this -> db -> join( "states loc", "loc.id = u.location", "INNER" );
        $this -> db -> join( "parties p", "p.id = u.party_affiliation", "INNER" );
        $this -> db -> group_by( "u.id" );
        $this -> db -> order_by( "u.is_active ASC, u.id DESC" );
        $this -> db ->limit(10, $offset);
        return $this -> db -> get() -> result_array();

    }

    function get_export_list() {
        $this -> db -> select( "u.*,loc.name as location,p.name as party" );
        $this -> db -> from( "users u" );
        $this -> db -> join( "states loc", "loc.id = u.location", "INNER" );
        $this -> db -> join( "parties p", "p.id = u.party_affiliation", "INNER" );
        $this -> db -> group_by( "u.id" );
        $this -> db -> order_by( "u.is_active ASC, u.id DESC" );
        return $this -> db -> get() -> result_array();

    }

    function get_user_list(){
        $this -> db -> select("*");
        $this -> db -> from("admin");
        $this -> db -> order_by("id",DESC);
        return $this -> db -> get() -> result_array(); 

    }

    function get_users(){
        $this -> db -> select("id, name, email, login_type, alise, location, party_affiliation, is_active, dob, gender, phone");
        $this -> db -> from("users");
        return  $this -> db -> get() -> result_array(); 
    }

    function get_username(){
        $this -> db -> select("id, name, email, login_type, alise, location, party_affiliation, is_active, dob, gender, phone");
        $this -> db -> from("users");
        $this -> db -> where("name IS NOT NULL");
        return $this -> db -> get() -> result_array(); 
    }
    
    function get_user_menulist(){

        $this -> db ->select("id,name");
        $this -> db -> from("menu_list");
        $this -> db -> where("is_active","1");
        return $this -> db -> get() -> result_array(); 

    }


    function get_filtered_list( $inputs ) {

        $offset = 0;
        $alias = $inputs[ 'user_alias' ];
        $mail = $inputs[ 'user_mail' ];
        $startdate = $inputs[ 'start_date' ];
        $enddate = $inputs[ 'end_date' ];
        $offset = $inputs[ 'offset' ];

        $start_date = date("y-m-d", strtotime($startdate));
        $end_date = date("y-m-d", strtotime($enddate));

        //$params = array('alise' => $alias, 'email' => $mail);
        //$this -> db -> where($params);

        $this -> db -> select( "u.*,loc.name as location,p.name as party" );
        $this -> db -> from( "users u" );
        if($alias != ""){
        $this -> db -> where('alise', $alias);
        }
        if($mail != ""){
        $this -> db -> where('email', $mail);
        }
        if($startdate != ""){
        $this -> db -> where('u.created_date >=', $start_date);
        }
        if($enddate != ""){
        $this -> db -> where('u.created_date <=', $end_date);
        }
        $this -> db -> join( "states loc", "loc.id = u.location", "INNER" );
        $this -> db -> join( "parties p", "p.id = u.party_affiliation", "INNER" );
        $this -> db -> group_by( "u.id" );
        $this -> db -> order_by( "u.is_active ASC, u.id DESC" );
        $this -> db ->limit(10, $offset);
        return $this -> db -> get() -> result_array();
        //echo  $this->db->last_query();exit;

    }


/*
    function search_pred( $title,$game_id ){
        $this -> db -> select( "id, topic as text" );
        $this -> db -> from( "topics" );
        $this -> db -> where("category", $category);
        $this -> db -> like( 'topic', $title, 'both' );
        if ( count( $ids ) > 0 ) {
            $this -> db -> where_not_in( 'id', $ids );
        }
        $result = $this -> db -> get() -> result_array();
        return $result;
    }
*/

    function search_pred($title,$game_id){

        $this ->db -> select("p.id as id,p.title as text");
        $this ->db -> from("predictions p");
        $this ->db -> where("game_id",$game_id);
        $this ->db -> where("p.agreed>",0);
        $this ->db ->like( 'title', $title, 'both' );
        $result = $this ->db ->get() -> result_array();
        return $result;

    }


    function filter_pred($title='',$game_id=0){
        $this ->db -> select("p.title as id,p.title as text");
        $this ->db -> from("predictions p");

        if(!empty($game_id)){
            $this ->db -> where("p.game_id",$game_id);
            $this ->db -> where("p.agreed>",0);
        }else{
            /* $this -> db -> join( "add_deduct_point_history ad", "ad.prediction_name = p.title");
            $this -> db -> group_by( "ad.prediction_name" ); */
            $this -> db -> join( "add_deduct_point_history ad", "ad.prediction_id = p.id");
            $this -> db -> group_by( "ad.prediction_id" );
        }

        if(!empty($title)){
            $this ->db ->like( 'p.title', $title, 'both' );
        }

        $result = $this ->db ->get() -> result_array();
        return $result;
    }


    function get_filtered_listorder( $inputs ){

        $offset = 0;
        if(!empty($inputs[ 'start_date' ])){
                     $start_date = date( "Y-m-d", strtotime( $inputs[ 'start_date' ] ) );
        }

        if(!empty($inputs[ 'end_date' ])){
                    $end_date = date( "Y-m-d", strtotime( $inputs[ 'end_date' ] ) );
        
        }

        $prediction_id = $inputs[ 'prediction_id' ];
        $game_id = $inputs[ 'game_id' ];
        $offset = $inputs[ 'offSet' ];
        $name = $inputs['name'];
        $email = $inputs['email'];


        $this -> db -> select("u.id,case when u.name IS NULL or u.name = '' then 'NA' else u.name END as name,case when u.email IS NULL or u.email = '' then 'NA' else u.email END as email,ep.id,ep.game_id,ep.id as orderid,ep.user_id,ep.prediction_id,(CASE WHEN ep.sell_points='0.00' THEN ep.buy_points ELSE  ep.sell_points END) AS points,ep.swipe_status,ep.created_date,g.title as game_title,p.title as prediction_title,p.current_price");
        $this -> db -> from("users u");
        $this -> db -> join("summary_history ep","u.id = ep.user_id","RIGHT");
        $this -> db -> join("games g","ep.game_id = g.id","LEFT");  
        $this -> db -> join("predictions p","ep.prediction_id = p.id","LEFT");

        if(!empty($prediction_id)){
             $this -> db -> where("ep.prediction_id=",$prediction_id);
        } 

        if(!empty($game_id)){
             $this -> db -> where("ep.game_id=",$game_id);
        }

        if ( $start_date != "" ) {
                        $this -> db -> where( 'DATE_FORMAT(ep.created_date, "%Y-%m-%d") >=', $start_date);
        }

        if ( $end_date != "" ) {
                        $this -> db -> where( 'DATE_FORMAT(ep.created_date, "%Y-%m-%d") <=', $end_date );
        }

        if( $name != "" ){
             $this -> db -> where( 'u.id =', $name );
        }

        if( $email != "" ){
                $this -> db -> where( 'u.id =', $email );

        }

          $this -> db -> order_by( "ep.id DESC" );
       /* $this -> db -> order_by( "p.title DESC" );*/
        $this -> db -> limit(500, $offset);
        $result=$this -> db -> get() -> result_array();
       /* echo $this->db->last_query(); die;*/
        return  $result;

    }


    function get_filtered_listorder_exported( $inputs ,$limit='' ) {
        $offset = 0;
        if(!empty($inputs[ 'start_date' ])){
                     $start_date = date( "Y-m-d", strtotime( $inputs[ 'start_date' ] ) );
        }

        if(!empty($inputs[ 'end_date' ])){
                    $end_date = date( "Y-m-d", strtotime( $inputs[ 'end_date' ] ) );
        
        }

        $prediction_id = $inputs[ 'prediction_id' ];
        $game_id = $inputs[ 'game_id' ];
        $offset = $inputs[ 'offSet' ];
        $name = $inputs['name'];
        $email = $inputs['email'];

        $this -> db -> select("u.id,(case when u.name IS NULL or u.name = '' then 'NA' else u.name END) as name,(case when u.email IS NULL or u.email = '' then 'NA' else u.email END) as email,ep.id,ep.game_id,ep.id as orderid,ep.user_id,ep.prediction_id,(CASE WHEN ep.sell_points='0.00' THEN ep.buy_points ELSE  ep.sell_points END) AS points,ep.swipe_status,ep.created_date,g.title as game_title,p.title as prediction_title,p.current_price");
        $this -> db -> from("users u");
        $this -> db -> join("summary_history ep","u.id = ep.user_id","RIGHT");
        $this -> db -> join("games g","ep.game_id = g.id","LEFT");  
        $this -> db -> join("predictions p","ep.prediction_id = p.id","LEFT");

        if(!empty($prediction_id)){
             $this -> db -> where("ep.prediction_id=",$prediction_id);
        } 

        if(!empty($game_id)){
             $this -> db -> where("ep.game_id=",$game_id);
        }

        if ( $start_date != "" ) {
                        $this -> db -> where( 'DATE_FORMAT(ep.created_date, "%Y-%m-%d") >=', $start_date);
        }

        if ( $end_date != "" ) {
                        $this -> db -> where( 'DATE_FORMAT(ep.created_date, "%Y-%m-%d") <=', $end_date );
        }

        if( $name != "" ){
             $this -> db -> where( 'u.id =', $name );
        }

        if( $email != "" ){
                $this -> db -> where( 'u.id =', $email );

        }

        $this -> db -> order_by( "ep.id DESC" );
        if(empty($limit)){
            $this -> db -> limit(10, $offset);
        }
        $res = $this -> db -> get() -> result_array();
        // echo $this->db->last_query();die;
        return $res;  
    }


    function get_user_points_filtered( $inputs ) {

        $offset = 0;
        $userid = $inputs[ 'user_id' ];
        $type = $inputs[ 'points_type' ];
        $point_type = $inputs[ 'points_pointType' ];
        $startdate = $inputs[ 'points_cstart_date' ];
        $enddate = $inputs[ 'points_cend_date' ];
        $offset = $inputs[ 'offset' ];

        $start_date = date("y-m-d", strtotime($startdate));
        $end_date = date("y-m-d", strtotime($enddate));

        $this -> db -> select( "*" );
        $this -> db -> from( "points_history" );
        $this -> db -> where( "user_id", $userid );
        if($type != ""){
        $this -> db -> where('type', $type);
        }
        if($point_type != ""){
        $this -> db -> where('point_type', $point_type);
        }
        if($startdate != ""){
        $this -> db -> where('created_date >=', $start_date);
        }
        if($enddate != ""){
        $this -> db -> where('created_date <=', $end_date);
        }
        $this -> db -> order_by( 'id', 'desc' );
        $this -> db ->limit(10, $offset);
        return $this -> db -> get() -> result_array();        

    }


    function get_user_points_filtered_exported( $inputs ) {

        //$offset = 0;
        $userid = $type = $point_type = $startdate = $enddate = "";

        if(isset($inputs[ 'user_id' ])){
            $userid = $inputs[ 'user_id' ];
        }
        if(isset($inputs[ 'points_type' ])){
            $type = $inputs[ 'points_type' ];
        }
        if(isset($inputs[ 'points_pointType' ])){
            $point_type = $inputs[ 'points_pointType' ];
        }
        if(isset($inputs[ 'points_cstart_date' ])){
            $startdate = $inputs[ 'points_cstart_date' ];
        }
        if(isset($inputs[ 'points_cend_date' ])){
            $enddate = $inputs[ 'points_cend_date' ];
        }
        //$offset = $inputs[ 'offset' ];

        $start_date = date("y-m-d", strtotime($startdate));
        $end_date = date("y-m-d", strtotime($enddate));

        $this -> db -> select( "*" );
        $this -> db -> from( "points_history" );
        $this -> db -> where( "user_id", $userid );
        if($type != ""){
        $this -> db -> where('type', $type);
        }
        if($point_type != ""){
        $this -> db -> where('point_type', $point_type);
        }
        if($startdate != ""){
        $this -> db -> where('created_date >=', $start_date);
        }
        if($enddate != ""){
        $this -> db -> where('created_date <=', $end_date);
        }
        $this -> db -> order_by( 'id', 'desc' );
        return $this -> db -> get() -> result_array();        

    }


    function get_user_details( $user_id ) {
        $this -> db -> select( "u.*,loc.name as location,p.name as party" );
        $this -> db -> from( "users u" );
        $this -> db -> join( "states loc", "loc.id = u.location", "INNER" );
        $this -> db -> join( "parties p", "p.id = u.party_affiliation", "INNER" );
        $this -> db -> where( "u.id = '$user_id'" );
        $user_data = $this -> db -> get() -> row_array();
        return $user_data;

    }

    
    function get_user_predictions( $user_id ) {
        $this -> db -> select( "p.*,pc.name as category,group_concat(pch.choice) as choices,right_choice" );
        $this -> db -> from( "poll p" );
        $this -> db -> join( "poll_category pc", "pc.id = p.category_id", "INNER" );
        $this -> db -> join( "poll_choices pch", "pch.poll_id = p.id", "INNER" );
        $this -> db -> where( "user_id = '$user_id'" );
        $this -> db -> group_by( "p.id" );
        $this -> db -> order_by( "p.is_approved ASC, p.id DESC" );
        return $this -> db -> get() -> result_array();

    }

    function get_usercoins_history(){
      $this->db->select('agc.*, u.name,u.email');
      $this->db->from('added_game_coins as agc');
      $this->db->join('users as u', 'agc.user_id = u.id','left');
      $this->db->order_by('agc.id','DESC');
      $result = $this->db->get()->result_array();
     /* echo $this->db->last_query(); die();*/
      return $result;
    }

    function get_user_surveys( $user_id ) {
        $this -> db -> select( "p.*,group_concat(pch.choice) as choices" );
        $this -> db -> from( "survey p" );
        //$this->db->join("survey_category pc", "pc.id = p.category_id", "INNER");
        $this -> db -> join( "survey_choices pch", "pch.survey_id = p.id", "INNER" );
        $this -> db -> where( "user_id = '$user_id'" );
        $this -> db -> group_by( "p.id" );
        $this -> db -> order_by( "p.is_approved ASC, p.id DESC" );
        return $this -> db -> get() -> result_array();

    }


    function get_user_blogs( $user_id ) {
        $this -> db -> select( "*" );
        $this -> db -> from( "blogs" );
        //$this -> db -> where( "is_approve = '0'" );
        $this -> db -> where( "user_id = '$user_id'" );
        //$this->db->order_by('blog_order', 'asc');
        //$this -> db -> order_by( 'created_date', 'DESC' );
        $this -> db -> order_by( 'id', 'desc' );
        $this -> db ->limit(10, 0);
        return $this -> db -> get() -> result_array();

    }


    function get_user_ratedArticles( $user_id ) {
        $this -> db -> select( "p.*,group_concat(pch.choice) as choices" );
        $this -> db -> from( "article p" );
        //$this->db->join("article_category pc", "pc.id = p.category_id", "INNER");
        $this -> db -> join( "article_choices pch", "pch.article_id = p.id", "INNER" );
        $this -> db -> where( "user_id = '$user_id'" );
        $this -> db -> group_by( "p.id" );
        $this -> db -> order_by( "p.is_approved ASC, p.id DESC" );
        return $this -> db -> get() -> result_array();

    }


    function get_user_points( $user_id ) {
        $this -> db -> select( "*" );
        $this -> db -> from( "points_history" );
        $this -> db -> where( "user_id = '$user_id'" );
        $this -> db -> order_by( 'id', 'desc' );
        $this -> db ->limit(10, 0);
        return $this -> db -> get() -> result_array();

    }


    function get_user_counts( $user_id ){
    	$this -> db -> select( "count(1) as total_polls" );
        $this -> db -> from( "poll" );
        $this -> db -> where( "user_id = '$user_id'" );
        $user_counts_data['prediction'] = $this -> db -> get() -> row_array();

        $this -> db -> select( "count(1) as total_surveys" );
        $this -> db -> from( "survey" );
        $this -> db -> where( "user_id = '$user_id'" );
        $user_counts_data['surveys'] = $this -> db -> get() -> row_array();

        $this -> db -> select( "count(1) as total_articles" );
        $this -> db -> from( "article" );
        $this -> db -> where( "user_id = '$user_id'" );
        $user_counts_data['articles'] = $this -> db -> get() -> row_array();

        $this -> db -> select( "count(1) as total_blogs" );
        $this -> db -> from( "blogs" );
        $this -> db -> where( "user_id = '$user_id'" );
        $user_counts_data['blogs'] = $this -> db -> get() -> row_array();

        $this -> db -> select( "count(1) as total_points" );
        $this -> db -> from( "points_history" );
        $this -> db -> where( "user_id = '$user_id'" );
        $user_counts_data['points'] = $this -> db -> get() -> row_array();


        return $user_counts_data;
    }

     function changeActiveStatus( $id, $newstatus ) {

                $this -> db -> where( 'id', $id );
                $this -> db -> update( "admin", array ( 'is_active' => $newstatus ) );
                if ( $newstatus == 0 ) {
                        return FALSE;
                } else {
                        return TRUE;
                }
        }


}
