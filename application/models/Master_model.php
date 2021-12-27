<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Master_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    function addUpdateState_Mod($inputs)
    {
        $stateid = $inputs['stateid'];
        $data = array(
            "name" => $inputs['state_name']
        );

        if ($stateid == 0) {
            $this->db->insert("states", $data);
        } else {
            $this->db->where("id = '$stateid'");
            $this->db->update("states", $data);
        }
        return TRUE;
    }

    function addUpdateParty_Mod($inputs)
    {
        $party_id = $inputs['party_id'];
        $party_name = $inputs['party_name'];
        $party_abbr = $inputs['party_abbr'];

        $filename = $_FILES['partyimg']['name'];
        $filetype = $_FILES['partyimg']['type'];
        $tmpname = $_FILES['partyimg']['tmp_name'];
        $filesize = $_FILES['partyimg']['size'];
        list($width, $height) = getimagesize($tmpname);

        if($width != "100" || $height != "100") {
            $msg="image size must be 100 x 100 pixels.";
            echo json_encode(array("status" => FALSE, "message" => $msg));
            exit;
        }
        
        if ($filename != "") {
            $get_ext = explode(".", $filename);
            $extension = end($get_ext);
            $newfilename = str_replace(" ", "_", $get_ext[0]) . time() . "." . $extension;
            move_uploaded_file($tmpname, "../webportal/images/party_logos/" . $newfilename); //for local system path in webportal section    
            //move_uploaded_file($tmpname, "../images/party_logos/" . $newfilename);// for live site path in website images folder
        } else {
            $newfilename = "no-logo.png";
        }
        

        if ($party_id == "0") {
            $insert = array(
                "name" => $party_name,
                "abbreviation" => $party_abbr,
                "icon" => $newfilename
            );

            $this->db->insert("parties", $insert);
            return TRUE;
        } else {
            $update = array(
                "name" => $party_name,
                "abbreviation" => $party_abbr,
            );

            if ($filename != "") {
                $update['icon'] = $newfilename;
            }

            $this->db->where("id = '$party_id'");
            $this->db->update("parties", $update);
            return TRUE;
        }
    }

}
