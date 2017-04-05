<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of player_vehicles
 *
 * @author deamon
 */

include(__DIR__.'/json3.php');

class player_vehicles extends json3

{

    function  vehicle_statistics($account_ids)
    {
        $method = "/tanks/stats/";
        $fields = "tank_id,all.damage_dealt,all.spotted,all.frags,all.dropped_capture_points,all.wins,all.battles";
        $field = array('fields'=>$fields, 'account_id'=>$account_ids);
        
        $data = parent::GetJson($method, $field);
       
       return $data;
        
        
    }
    
    function  StatVehiclesClan($account_ids)
    {
        $method = "/tanks/stats/";
        $fields = "tank_id,clan";
        $field = array('fields'=>$fields, 'account_id'=>$account_ids);
        
        $data = parent::GetJson($method, $field);
       
       return $data;
        
        
    }




}
