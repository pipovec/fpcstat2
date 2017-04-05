<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Metoda account
 * Ziskavanie informacii o hracoch
 *
 * @author deamon
 * 
 *  
 */
include(__DIR__.'/json3.php');


class account2 extends json3{
    
    
            
    function search_players($account_id)
    {
        $method = "/account/list/";
        $fields = "account_id,nickname";
        $fields = array('fields'=>  $fields,'clan_id'=>$clan_ids);
        
        $pole = array();
        
        $data = parent::Send($method, $fields);
        
        $data = $data['data'];
        
        foreach($data as $k =>  $v)
        {
          array_push($pole, array('account_id'=> $v['account_id'],'nickname' => $v['nickname']));
        }
          
       return $pole;
        
    }
    
    function account_info($fields, $account_id)
    {   
        $method = "/account/info/";
        
        $fields = array('fields'=> $fields, 'account_id'=>$account_id);
        
        $data = parent::Send($method, $fields);
        $result = json_decode($data, true);
        return $result;
    }
    
    function account_info_extra($fields,$extra,$account_id)
    {   
        $method = "/account/info/";
        $fields = array('fields'=> $fields,'extra'=>$extra,'account_id'=>$account_id);
        
        $data = parent::Send($method, $fields);
        $result = json_decode($data, true);
        return $result;
    }
    
    function logout($account_id)
    {
        $method = "/account/info/";
        $fields = "account_id,logout_at,last_battle_time";
        $fields = array('fields'=>  $fields,'account_id'=>$account_id);
        
        
//        $url = $this->api_server."/wot/account/info/?application_id=".$this->api_id."&fields=".$fields."&account_id=".$account_id;
        $data = parent::Send($method, $fields);
        $result=json_decode($data, true);
        return $result;
        
        
    }
    
    function players_info($account_id)
    {
       $method = "/account/info/"; 
       $fields = "client_language,global_rating,created_at,logout_at,last_battle_time"; 
       $fields = array('fields'=>$fields, 'account_id'=>$account_id);
       
       $data = parent::GetJson($method, $fields);
       
       return $data;
    }
    
    function vehicles($account_id)
    {
        $vysledok = array();    
        $method = "/account/tanks/";
        $fields = "tank_id,statistics";
        $fields = array('fields'=>  $fields,'account_id'=>$account_id);
        $data = parent::Send($method, $fields);
        
        $result=json_decode($data, true);
        
        
        $data = $result['data'];

            foreach($data as $k => $v)
            {
                $account_id = $k;

                    foreach ($v as $value)
                    {
                        
                        $tank_id                = $value['tank_id'];
                        $all_battles            = $value['statistics']['battles'];
                        $all_wins               = $value['statistics']['wins'];
                        
                        array_push($vysledok,array( 'account_id' => $account_id,
                                                    'tank_id' => $tank_id,
                                                    'all_battles' => $all_battles,
                                                    'all_wins' => $all_wins                                                    
                                                    ));   
                    }

            }
           return $vysledok;
        
        
    }
    
    function Vehicles2($fields,$account_ids)
    {
        $method = "/account/tanks/";
        $fields = array('fields'=>  $fields,'account_id'=>$account_ids);
        $data = parent::Send($method, $fields);
        $result=json_decode($data, true);
        
        return $result;
        
    }
}
