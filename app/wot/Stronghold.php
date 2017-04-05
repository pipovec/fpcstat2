<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Stronghold
 *
 * @author deamon
 */

require_once (__DIR__.'/json3.php');

class Stronghold extends json3{
    
    function Accountstats($player_id, $fields)
    {
        $method = '/stronghold/accountstats/';
        $fields = array(
                        'fields'=>  $fields,
                        'account_id'=> $player_id
                        );
        
        $data = parent::Send($method, $fields);
        $result=json_decode($data, true);
        unset($data); 
        
        return $result;
        
    }
    
    
    
}
