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
include(__DIR__.'/json3.php');



class clans2 extends json3{
    
    
    
    function clan($clan_ids)
    {
        $fields = "clan_id,tag,created_at,leader_id,name,members_count,emblems,motto";
        $method = '/clans/info/';
        
        
        $fields = array(
                
                'fields'=>  $fields,
                'clan_id'=>$clan_ids
                );
        $result = array();
        
        $data = parent::Send2($method, $fields);
        $result = $data;  
        $result=json_decode($result, true);
        unset($data); 
        
        return $result;
        
        
    }
    
    
    function clans_members($clan_ids)
    {
        
        $fields = "abbreviation,members_count,members.account_name,members.created_at,members.role_i18n";
        $method = '/clan/info/';
        $fields = array('fields'=>$fields, 'clan_id'=>$clan_ids);
        
    
        $result = parent::Send($method, $fields);
        
        if(!$result){ print_r($result); print_r($fields); die("Zdochlo to na result ");}
        unset($method, $fields);
        
        $json = json_decode($result, true);
        $error = json_last_error();
        unset($result);
        if(!$json){var_dump($json);var_dump($error);die('Zdochlo to na json');}
            
        if($json['status'] == 'ok')
        {
            $data = $json['data'];
            unset($json);
            
            $result = array();
            
            foreach ($data as $k => $v)
            {
                
                $clan_id        = $k;
                $name           = $v['abbreviation'];
                $members_count  = $v['members_count'];
                $members        = $v['members'];
                
//                echo "Spracovavam klan: ".$k." ktory ma skratku: ".$name." a ma clenov: ".$members_count."\n";
                
                array_push($result, array(  
                                            'clan_id'       => $clan_id,
                                            'name'          => $name, 
                                            'members_count' => $members_count,
                                            'members'       => $members
                                          )
                            );
                
                
            }
        }
        
        else
        {
          print_r($json); die('Zdochlo to na kontrolu statusu');
        }
        
        unset($data);
            
        
        return $result;
    }
    
    function search_clan($clan)
    {
        $method = '/clan/list/';
        $fields = "clan_id,abbreviation,created_at,owner_id,name,emblems.small";
        
        $fields = array('fields'=>$fields, 'clan_id'=>$clan);
        $result = array();
        
        
        
        
        $data   = parent::Send($method, $fields);
        
        $data   = $data['data'];
        
        foreach($data as $v)
        {
            
            array_push($result, array('clan_id'=>$v['clan_id'],'abbreviation'=> $v['abbreviation'],'created_at'=>$v['created_at'],
                                      'owner_id'=>$v['owner_id'],'name'=>$v['name'],'emblems_small'=>$v['emblems']['small'] ));
            
           
        }
        
        return $result;
    }
    
    function ClansMembers($clan_ids){
        
        $fields = "abbreviation,members_count,members.account_name,members.created_at,members.role_i18n";
        $method = '/clan/info/';
        $fields = array('fields'=>$fields, 'clan_id'=>$clan_ids);
        $result = array();
    
        $data = parent::GetJson($method, $fields);
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
                                            'members'       => $members
                                          )
                            );
                
                
            }
        return $result;
        }
    
    function ClanRatings($clan_ids)
    {
        $fields = "battles_count_avg.value,global_rating_avg.value,efficiency.value,gm_elo_rating.value";
        $method = '/clanratings/clans/';
        $fields = array('fields'=>$fields, 'clan_id'=>$clan_ids);
        
        $data = parent::GetJson($method, $fields);
        
        return $data;
    }
        
    function Vklane($clan_id)
    {
        $fields = "members.created_at,members.role";
        $method = '/clan/info/';
        $fields = array('fields'=>$fields, 'clan_id'=>$clan_id);
        
        $data = parent::GetJson($method, $fields);
        return $data;
        
    }
    
    function AoF($account_ids,$fields,$map_id)
    {
        $method = '';
        $fields = array('fields'=>$fields, 'account_id'=>$account_ids, 'map_id' => $map_id);
        
        $data = parent::GetJson($method, $fields);
        return $data;
        
    }
    
    function ClanMember($fields, $account_id)
    {
        $method = '/clan/membersinfo/';
        $fields = array('fields'=> $fields, 'account_id'=>$account_id);
        
        $data = parent::Send($method, $fields);
        $result = json_decode($data, true);
        return $result;
           
    }
}
