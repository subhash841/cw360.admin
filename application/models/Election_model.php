<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Election_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    function get_states_list()
    {
        $this->db->select('*');
        $this->db->from('states');
        $result = $this->db->get()->result_array();
        return $result;
    }

    function get_parties_list()
    {
        $this->db->select('*');
        $this->db->from('parties');
        $result = $this->db->get()->result_array();
        return $result;
    }

    function add_update_election_period_mod($inputs)
    {
        $election_period_id = $inputs['election_period_id'];
        $state_id = $inputs['state_id'];
        $total_seats = $inputs['total_seats'];
        $from_date = date("Y-m-d", strtotime($inputs['from_date']));
        $to_date = date("Y-m-d", strtotime($inputs['to_date']));
        $parties = $inputs['parties'];

        if ($election_period_id == "0") {
            $this->db->select('1');
            $this->db->from('election_period');
            $this->db->where('from_date="' . $from_date . '" AND to_date="' . $to_date . '"');
            $this->db->where('state_id="' . $state_id . '"');
            $getalreadydate = $this->db->get();
            if ($getalreadydate->num_rows() > 0) {
                return FALSE;
            }

            $insert = array(
                "from_date" => $from_date,
                "to_date" => $to_date,
                "state_id" => $state_id,
                "total_seats" => $total_seats
            );
            $this->db->insert('election_period', $insert);
            $lastid = $this->db->insert_id();

            foreach ($parties as $key => $p) {
                $state_party[] = array(
                    "election_period_id" => $lastid,
                    "state_id" => $state_id,
                    "party_id" => $p
                );
            }

            if (!empty($state_party)) {
                $this->db->insert_batch('state_party', $state_party);
            }
            return TRUE;
        } else {
            $update = array(
                "from_date" => $from_date,
                "to_date" => $to_date,
                "state_id" => $state_id,
                "total_seats" => $total_seats
            );
            $this->db->where('id', $election_period_id);
            $this->db->update('election_period', $update);

            $this->db->where('election_period_id', $election_period_id);
            $this->db->delete('state_party');

            foreach ($parties as $key => $p) {
                $state_party[] = array(
                    "election_period_id" => $election_period_id,
                    "state_id" => $state_id,
                    "party_id" => $p
                );
            }

            if (!empty($state_party)) {
                $this->db->insert_batch('state_party', $state_party);
            }
            return TRUE;
        }
    }

    function get_election_periods_list()
    {
        $this->db->select('epi.id,epi.from_date,epi.to_date,epi.total_seats,epi.is_result_out,s.id as state_id,s.name as state_name,GROUP_CONCAT(p.id) as party_id,GROUP_CONCAT(p.name) as party_names,GROUP_CONCAT(p.abbreviation) as party_abbrivation');
        $this->db->from('election_period as epi');
        $this->db->join('state_party sp', 'epi.id=sp.election_period_id');
        $this->db->join('states s', 'epi.state_id=s.id');
        $this->db->join('parties p', 'sp.party_id=p.id');
        $this->db->group_by('epi.id');
        $result = $this->db->get()->result_array();
        return $result;
    }

    function deleteForecastByMax_Mod($inputs)
    {
        $forecast_type = $inputs['forecast_type'];
        $election_period_id = $inputs['election_period_id'];
        //$myString = "9,admin@example.com,8";
        $myArray = explode(',', $election_period_id);
        
        $election_period_id=$myArray[0];
        $state_id=$myArray[1];
        
        $max_limit = $inputs['max_limit'];
        $party_id = $inputs['party_id'];
        if ($forecast_type == "seat") {
            $delete_forecast = 'seat_forecast';
        } else if ($forecast_type == "vote") {
            $delete_forecast = 'vote_forcast';
        } else {
            return false;
        }
        $this->db->select('id');
        $this->db->where('election_period_id', $election_period_id);
        $this->db->where("user_id in (SELECT user_id FROM  `user_forecasting` WHERE  `party_id` = " . $party_id . " AND  " . $delete_forecast . " > " . $max_limit . " and election_period_id = " . $election_period_id . ")");
        $this->db->from('user_forecasting');
        $result = $this->db->get();
        
        if($result->num_rows()>0) {
            $getids = $result->result_array();

            $newidarray = array();
            $newidarray = $this->associate_to_index($getids, 'id');

            $this->db->where_in('id', $newidarray);
            $this->db->delete('user_forecasting');

            $this->current_userforecasting($election_period_id,$state_id);
        } else {
            $this->session->set_flashdata('toast', "No record found !");
            redirect('Dashboard');
        }
    }

    function associate_to_index($array, $k)
    {
        $arrayTemp = array();
        $i = 0;
        foreach ($array as $key => $val) {
            $arrayTemp[$i] = $val[$k];
            $i++;
        }
        return $arrayTemp;
    }
    function current_userforecasting($election_period_id,$state_id){
        $this->db->select('uf.* , u.name, u.twitter_id, p.abbreviation, s.name as location, pr.name as party_affiliation');
            $this->db->from('user_forecasting uf');
            $this->db->join('users u', 'u.id = uf.user_id', 'INNER');
            $this->db->join('parties p', 'p.id = uf.party_id', 'INNER');
            $this->db->join('states s', 's.id = u.location', 'LEFT');
            $this->db->join('parties pr', 'pr.id = u.party_affiliation', 'LEFT');
            $this->db->where('election_period_id', $election_period_id);
            $this->db->where('state_id',$state_id);
            $this->db->order_by('uf.user_id, party_id');
            $userforecast = $this->db->get();

            $exceldata = $userforecast->result_array();
            $filename = "User_forecasting_" . date('Y-m-d') . '.xls';
            createexcel($exceldata, $filename);
    }
}
