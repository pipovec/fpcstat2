<?php

include 'json2.php';

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
 */
class account extends json2 {
    
    function list_of_players($data)
    {
                
        
                $pole = array();
                $c          = $data['count'];
                for ($i = 0; $i < $c; $i++)
                {
                    $nickname   = $data['data'][$i]['nickname'];
                    $id         = $data['data'][$i]['id'];
                    

                    array_push($pole, array( 'id' =>$id, 'account_name' => $nickname)) ;
                }
                return $pole;
    }
            
    function search_players($account_id)
    {
        $pole = array();
        $fields  = "account_id,nickname";
        $url = $this->api_server."/wot/account/list/?application_id=".$this->api_id."&fields=".$fields."&search=".$account_id;
        
        $data = parent::data($url);
        $data = $data['data'];
        
        foreach($data as $k =>  $v)
        {
          array_push($pole, array('account_id'=> $v['account_id'],'nickname' => $v['nickname']));
        }
          
       return $pole;
        
    }
    
    function account_info($fields, $account_id)
    {
        
        $url = $this->api_server."/wot/account/list/?application_id=".$this->api_id."&fields=".$fields."&search=".$account_id;
        $data = parent::data($url);
        $data = $data['data'];
        
        return $data;
    }
    
    
    function logout($account_id)
    {
        
        $fields = "account_id,logout_at,last_battle_time";
        
        $url = $this->api_server."/wot/account/info/?application_id=".$this->api_id."&fields=".$fields."&account_id=".$account_id;
        $data = parent::data($url);
        
        return $data;
        
        
    }
}
