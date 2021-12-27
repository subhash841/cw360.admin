<?php
if (!defined('BASEPATH'))exit('No direct script access allowed');

$config['Game'] = array(
    array(
        'field' => 'title',
        'label' => 'title',
        'rules' => 'trim|required|max_length[40]',
        'errors'=> array('required'=>"Title can not be blank.",'max_length'=>"Only 40 words allowed"),
        
    ),array(
        'field' => 'description',
        'label' => 'description',
        'rules' => 'trim|required',
        'errors'=> array('required'=>"Rules and Updates can not be blank."),
        
    ),array(
        'field' => 'meta_keywords',
        'label' => 'meta_keywords',
        'rules' => 'trim|required',
        'errors'=> array('required'=>"Meta Keywords can not be blank."),
        
    ),array(
        'field' => 'meta_description',
        'label' => 'meta_description',
        'rules' => 'trim|required',
        'errors'=> array('required'=>"Meta Description can not be blank."),
        
    ),array(
        'field' => 'max_players',
        'label' => 'Max Players',
        'rules' => 'trim|required|greater_than[0]',
        'errors'=> array('required'=>"Maximum Players can not be blank.",'greater_than'=>"Maximum Players Should be greater than 0."),
        
    ),array(
        'field' => 'change_prediction_time',
        'label' => 'Change Prediction Time',
        'rules' => 'trim|required|greater_than[0]',
        'errors'=> array('required'=>"Change prediction time can not be blank.",'greater_than'=>"change prediction time Should be greater than 0."),
    ),array(
        'field' => 'point_value_per_coin',
        'label' => 'point value per coin',
        'rules' => 'trim|required|greater_than[0]',
        'errors'=> array('required'=>"Maximum Players can not be blank.",'greater_than'=>"point value per coin Should be greater than 0."),
        
    ),
);


$config['Prediction'] = array(
    array(
        'field' => 'title',
        'label' => 'title',
        'rules' => 'trim|required|max_length[40]',
        'errors'=> array('required'=>"Title name can not be blank.",'max_length'=>"Only 30 words allowed"),
        
    ),array(
        'field' => 'price',
        'label' => 'price',
        'rules' => 'trim|required|regex_match[/^(?!0+$)[0-9]/]',                    //REGEX MATCH FOR NOT ACCEPTING SINGLE 0  AND CAN ACCEPT 1 TO 9 DIGIT.
        'errors'=> array('required'=>"Price can not be blank."),
        
    ),array(
        'field' => 'meta_keywords',
        'label' => 'meta_keywords',
        'rules' => 'trim|required',
        'errors'=> array('required'=>"Meta Keywords can not be blank."),
        
    ),array(
        'field' => 'meta_description',
        'label' => 'meta_description',
        'rules' => 'trim|required',
        'errors'=> array('required'=>"Meta Description can not be blank."),
        
    )
);

$config['Quiz'] = array(
    array(
        'field' => 'name',
        'label' => 'Name',
        'rules' => 'trim|required|max_length[40]',
        'errors'=> array('required'=>"Quiz name can not be blank.",'max_length'=>"Only 40 words allowed"),
        
    ),array(
        'field' => 'meta_keywords',
        'label' => 'meta_keywords',
        'rules' => 'trim|required',
        'errors'=> array('required'=>"Meta Keywords can not be blank."),
        
    ),array(
        'field' => 'meta_description',
        'label' => 'meta_description',
        'rules' => 'trim|required',
        'errors'=> array('required'=>"Meta Description can not be blank."),
        
    ),array(
        'field' => 'description',
        'label' => 'Description',
        'rules' => 'trim|required',
        'errors'=> array('required'=>"Description can not be blank."),
        
    )
);


$config['Blog'] = array(
    array(
        'field' => 'blog_title',
        'label' => 'Title',
        'rules' => 'trim|required',
        'errors'=> array('required'=>"Blog Title can not be blank."),
        
    ),array(
        'field' => 'blog_date',
        'label' => 'Blog Date',
        'rules' => 'trim|required',
        'errors'=> array('required'=>"Date can not be blank."),
        
    ),array(
        'field' => 'meta_keywords',
        'label' => 'meta_keywords',
        'rules' => 'trim|required',
        'errors'=> array('required'=>"Meta Keywords can not be blank."),
        
    ),array(
        'field' => 'meta_description',
        'label' => 'meta_description',
        'rules' => 'trim|required',
        'errors'=> array('required'=>"Meta Description can not be blank."),
        
    ),array(
        'field' => 'description',
        'label' => 'Description',
        'rules' => 'trim|required',
        'errors'=> array('required'=>"Description can not be blank."),
        
    )
);





$config['Question'] = array(
    array(
        'field' => 'question',
        'label' => 'question',
        'rules' => 'trim|required',
        'errors'=> array('required'=>"Meta Keywords can not be blank."),
        
    ),array(
        'field' => 'question_meta_keywords',
        'label' => 'meta_keywords',
        'rules' => 'trim|required',
        'errors'=> array('required'=>"Meta Keywords can not be blank."),
        
    ),array(
        'field' => 'question_meta_description',
        'label' => 'meta_description',
        'rules' => 'trim|required',
        'errors'=> array('required'=>"Meta Description can not be blank."),
        
    )
);



$config['Reward'] = array(
    array(
        'field' => 'title',
        'label' => 'title',
        'rules' => 'trim|required|max_length[40]',
        'errors'=> array('required'=>"Reward name can not be blank.",'max_length'=>"Only 40 words allowed"),
        
    ),array(
        'field' => 'req_coins',
        'label' => 'Coins Required',
        'rules' => 'trim|required|regex_match[/^(?!0+$)[0-9]/]',                    //REGEX MATCH FOR NOT ACCEPTING SINGLE 0  AND CAN ACCEPT 1 TO 9 DIGIT.
        'errors'=> array('required'=>"Coins Required can not be blank."),
        
    ),
);


$config['User'] = array(
    array(
        'field' => 'admin_email',
        'label' => 'Email',
        'rules' => 'trim|required|valid_email|is_unique[admin.email]',
        'errors'=> array('required'=>"User Email can not be blank.",'is_unique' => "Email Already Registered"),
        
    ),array(
        'field' => 'admin_password',
        'label' => 'Password',
        'rules' => 'trim|required|regex_match[/^\S*$/]',                //REGEX MATCH FOR NOT ACCEPTING SINGLE 0  AND CAN ACCEPT 1 TO 9 DIGIT.
        'errors'=> array('required'=>"Password can not be blank."),
        
    )
);



$config['walletcoin'] = array(
    array(
        'field' => 'coins',
        'label' => 'Coins Required',
        'rules' => 'trim|required|regex_match[/^(?!0+$)[0-9]/]',                    //REGEX MATCH FOR NOT ACCEPTING SINGLE 0  AND CAN ACCEPT 1 TO 9 DIGIT.
        'errors'=> array('required'=>"Coins Required can not be blank."),
        
    ),
);
$config['add_deduct_points'] = array(
    array(
        'field' => 'game_id',
        'label' => 'Game Required',
        'rules' => 'trim|required',           
        'errors'=> array('required'=>"Please select game"),        
    ),
    array(
        'field' => 'prediction_id',
        'label' => 'Prediction Required',
        'rules' => 'trim|required',           
        'errors'=> array('required'=>"Please select prediction can not be blank."),        
    ),
    array(
        'field' => 'action',
        'label' => 'Action Required',
        'rules' => 'trim|required',           
        'errors'=> array('required'=>"Please select action can not be blank."),        
    ),
    array(
        'field' => 'points',
        'label' => 'Points Required',
        'rules' => 'trim|required|greater_than[0]|regex_match[/^(?!0+$)[0-9]/]',                    //REGEX MATCH FOR NOT ACCEPTING SINGLE 0  AND CAN ACCEPT 1 TO 9 DIGIT.
        'errors'=> array('required'=>"Points Required can not be blank."),
        
    ),
);
?>
