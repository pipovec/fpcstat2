<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GlobalMap
 *
 * @author deamon
 */

require_once (__DIR__.'/SendCurl.php');


class GlobalMap extends SendCurl
{
    function ClanBattles($fields, $clan_id)
    {
        $method = '/globalmap/clanbattles/';
        $fields = array('fields'=> $fields, 'clan_id'=>$clan_id);
        
        $data = parent::SendWot($method, $fields);
        $result = json_decode($data, true);
        return $result;
        
    }
    
    function ClanProvinces($fields, $clan_id)
    {
        $method = '/globalmap/clanprovinces/';
        $fields = array('fields'=> $fields, 'clan_id'=>$clan_id);
        
        $data = parent::SendWot($method, $fields);
        $result = json_decode($data, true);
        return $result;
        
    }
    
}
