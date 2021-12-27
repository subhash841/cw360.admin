<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Forgot_password extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('User_model');
    }


	public function index() {
        $this->form_validation->set_rules('username', 'Username', 'trim|required|valid_email|callback_authenticate');

        if ($this->form_validation->run() === FALSE) {
            	$this->load->view('forgot_password');
        } else {
        		redirect('login');
        }
    }

    function authenticate() {
        $data = array();
        $username = $this->input->post('username');
        $password = "Cw360@".rand(10,100000);

        $data = $this->User_model->authenticate_user($username);
        // echo $this->db->last_query();
        // print_r($data);die;
        if (empty($data)) {
            $this->form_validation->set_message('authenticate', 'Invalid Email ID');
            return FALSE;
        }else{
        		$this->User_model->update_user_password($username , $password);
	     		$title="Password Reset Email ";
                $message ="";
                $message .= "Dear User, <br /><br />";
                $message .= "We have received password reset request for email id :  ( $username )<br />";
                $message .="Please use below password to login to crowdwisdom360.com admin console.<br />";
                $message .="Password : ".$password."<br />";
                $message .= "Please click on below URL to access crowdwisdom360.com admin console : <br />";
                $message .=  base_url()."<br />";
                $message .= "Thank you and have a great day ahead !!, <br /><br />Regards,<br />CrowdWisdom Team";
                $res=send_email( $username, '', $title, $message );
        		return TRUE;
        }

    }
}
?>