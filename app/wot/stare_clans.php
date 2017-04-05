<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of clans
 *
 * @author deamon
 */

include 'json2.php';


class sclans extends json2{
    public $fields = "clan_id,abbreviation,created_at,owner_id,name,members_count,emblems.small,motto";
    
    
    function clan($clan_ids)
    {
        $result = array();$clan_ids;
        
        $url = $this->api_server."/wot/clan/info/?application_id=".$this->api_id."&fields=".$this->fields."&clan_id=".$clan_ids; 
        
        $data = parent::data($url);
        
        $result = $data;    
        unset($data); 
        
        return $result;
        
        
    }
    
    
    function clans_members($clan_ids)
    {
        $result = array();
        $fields = "abbreviation,members_count,members.account_name,members.created_at,members.role_i18n";
        $url = $this->api_server."/wot/clan/info/?application_id=".$this->api_id."&fields=".$fields."&clan_id=".$clan_ids;
        
        $data = parent::data($url);
        
            if($data === null){print_r($data);}
        
            $data = $data['data'];
            foreach ($data as $k => $v)
            {
                
                $clan_id        = $k;
                $name           = $v['abbreviation'];
                $members_count  = $v['members_count'];
                $members        = $v['members'];
                
                
                array_push($result, array(  
                                            'clan_id'       => $clan_id,
                                            'name'          => $name, 
                                            'members_count' => $members_count,
                                            'members'       => $members)
                                           );
                
                
            }
        
        
        unset($data);
            
        
        return $result;
    }
    
    function search_clan($clan)
    {
        
        $result = array();
        $fields = "clan_id,abbreviation,created_at,owner_id,name,emblems.small";
        
        $url    = $this->api_server."/wot/clan/list/?application_id=".$this->api_id."&fields=".$fields."&search=".$clan;
        
        $data   = parent::data($url);
        
        $data   = $data['data'];
        
        foreach($data as $v)
        {
            
            array_push($result, array('clan_id'=>$v['clan_id'],'abbreviation'=> $v['abbreviation'],'created_at'=>$v['created_at'],
                                      'owner_id'=>$v['owner_id'],'name'=>$v['name'],'emblems_small'=>$v['emblems']['small'] ));
            
           
        }
        
        return $result;
    }
    
}
