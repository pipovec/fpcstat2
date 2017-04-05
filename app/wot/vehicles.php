<?php


include 'json2.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of vehicles
 *
 * @author deamon
 */



class vehicles extends json2 {
    
     public $simply_fields = "tank_id,mark_of_mastery,statistics.battles,statistics.wins";
     public $stat = "tank_id,statistics.battles,statistics.wins";
     
     

    function simply($account_id){
        $vysledok = array();        
        
        $url = $this->api_server."/wot/account/tanks/?application_id=".$this->api_id."&fields=".$this->simply_fields."&account_id=".$account_id;
        $data = parent::data($url);
        $data = $data['data'];

            foreach($data as $k => $v)
            {
                $account_id = $k;

                    foreach ($v as $value)
                    {
                        $mark_of_mastery    = $value['mark_of_mastery'];
                        $tank_id            = $value['tank_id'];
                        $battles            = $value['statistics']['battles'];
                        $wins               = $value['statistics']['wins'];
                        
                                
                        array_push($vysledok,array( 'account_id' => $account_id,
                                                    'tank_id' => $tank_id,
                                                    'battles' => $battles,
                                                    'wins' => $wins,
                                                    'mark_of_mastery' => $mark_of_mastery));   
                    }

            }
           return $vysledok;
        }
        
        function simply_sa($account_id){
        $vysledok = array();        
        
        $url = $this->api_server."/wot/account/tanks/?application_id=".$this->api_id_sa."&fields=".$this->simply_fields."&account_id=".$account_id;
        $data = parent::data($url);
        $data = $data['data'];

            foreach($data as $k => $v)
            {
                $account_id = $k;

                    foreach ($v as $value)
                    {
                        $mark_of_mastery    = $value['mark_of_mastery'];
                        $tank_id            = $value['tank_id'];
                        $battles            = $value['statistics']['battles'];
                        $wins               = $value['statistics']['wins'];

                        array_push($vysledok,array( 'account_id' => $account_id,
                                                    'tank_id' => $tank_id,
                                                    'battles' => $battles,
                                                    'wins' => $wins,
                                                    'mark_of_mastery' => $mark_of_mastery));   
                    }

            }
           return $vysledok;
        }
        
        function vehicles_stat($account_id){
        $vysledok = array();        
        
        $url = $this->api_server."/wot/account/tanks/?application_id=".$this->api_id."&fields=".$this->stat."&account_id=".$account_id;
        $data = parent::data($url);
        $data = $data['data'];

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
        
    
    function vehicles_stat_garage($account_id){
        $vysledok = array();        
        $fields = "tank_id,statistics.all.battles,statistics.all.wins,in_garage";
        
        $url = $this->api_server."/wot/account/tanks/?application_id=".$this->api_id."&fields=".$fields."&account_id=".$account_id;
        
        $data = parent::data($url);
        $data = $data['data'];

            foreach($data as $k => $v)
            {
                $account_id = $k;

                    foreach ($v as $value)
                    {
                        
                        $tank_id                = $value['tank_id'];
                        $all_battles            = $value['statistics']['all']['battles'];
                        $all_wins               = $value['statistics']['all']['wins'];
                        $in_garage              = $value['in_garage'];
                        
                        array_push($vysledok,array( 'account_id' => $account_id,
                                                    'tank_id' => $tank_id,
                                                    'all_battles' => $all_battles,
                                                    'all_wins' => $all_wins,
                                                    'in_garage'=>$in_garage    
                                                    ));   
                    }

            }
           return $vysledok;
        }    
        
        function vehicles_in_garage($account_id){
        $vysledok = array();        
        $fields = "tank_id,all.battles,all.wins";
        
        $url = $this->api_server."/wot/tanks/stats/?application_id=".$this->api_id."&fields=".$fields."&account_id=".$account_id."&in_garage=1";
        
        $data = parent::data($url);
        $data = $data['data'];

            foreach($data as $k => $v)
            {
                $account_id = $k;

                    foreach ($v as $value)
                    {
                        
                        $tank_id                = $value['tank_id'];
                        $all_battles            = $value['all']['battles'];
                        $all_wins               = $value['all']['wins'];
                        
                        
                        array_push($vysledok,array( 'account_id' => $account_id,
                                                    'tank_id' => $tank_id,
                                                    'all_battles' => $all_battles,
                                                    'all_wins' => $all_wins,
                                                        
                                                    ));   
                    }

            }
           return $vysledok;
        }    
}
