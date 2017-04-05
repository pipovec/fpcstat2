<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PlayersVehicles
 *
 * @author deamon
 */

require_once 'json3.php';  

class PlayersVehicles  extends json3{
    
    
    function VehicleStatistics($fields, $account_id)
    {
        $method = '/tanks/stats/';
        $fields = array('fields'=> $fields,'account_id'=>$account_id);
        
        $data = parent::Send($method, $fields);
        $result = json_decode($data, true);
            if($result['status'] != 'ok' )
            {
                $result = 'chyba!';
            }
        
        return $result;
        
    }
    
    function JsonVehicleStatistics($fields, $account_id)
    {
        $method = '/tanks/stats/';
        $fields = array('fields'=> $fields,'account_id'=>$account_id);
        
        $data = parent::Send($method, $fields);
        $result = json_decode($data, true);
            if($result['status'] != 'ok' )
            {
                $result = 'chyba!';
            }
        
        return $data;
        
    }
    
}
