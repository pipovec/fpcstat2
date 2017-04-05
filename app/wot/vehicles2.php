<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of vehicles2
 *
 * @author deamon
 */

require_once (__DIR__.'/json3.php');


class vehicles2 extends json3 {
   
    /* Ziska informacie o hracovych tankoch, ale len tie ktore ta zaujimaju */
    function Vehicles($account_id, $fields, $tank_ids)
    {
        
        $method = "/tanks/stats/";
        $field = array('fields'=>$fields, 'account_id'=>$account_id, 'tank_id' => $tank_ids);

        $data = parent::GetJson($method, $field);
        $data = $data['data'];
        
        return $data;
    }
    
    /* Ziska informacie o vsetkych hracovych tankoch */
    function VehiclesAll($account_id, $fields)
    {
        
        $method = "/tanks/stats/";
        $field = array('fields'=>$fields, 'account_id'=>$account_id);

        $data = parent::GetJson($method, $field);
        $data = $data['data'];
        
        return $data;
    }
}
