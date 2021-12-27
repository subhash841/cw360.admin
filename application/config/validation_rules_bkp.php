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
        
    )
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
        'rules' => 'trim|required|alpha_numeric_spaces|max_length[40]',
        'errors'=> array('required'=>"Quiz name can not be blank.",'max_length'=>"Only 40 words allowed"),
        
    ),array(
        'field' => 'req_coins',
        'label' => 'Coins Required',
        'rules' => 'trim|required|regex_match[/^(?!0+$)[0-9]/]',                    //REGEX MATCH FOR NOT ACCEPTING SINGLE 0  AND CAN ACCEPT 1 TO 9 DIGIT.
        'errors'=> array('required'=>"Coins Required can not be blank."),
        
    ),
);

$config['walletcoin'] = array(
    array(
        'field' => 'coins',
        'label' => 'Coins Required',
        'rules' => 'trim|required|regex_match[/^(?!0+$)[0-9]/]',                    //REGEX MATCH FOR NOT ACCEPTING SINGLE 0  AND CAN ACCEPT 1 TO 9 DIGIT.
        'errors'=> array('required'=>"Coins Required can not be blank."),
        
    ),
);



?>