<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AccoutControl
 *
 * @author deamon
 */
use Nette\Application\UI;
use Nette\Diagnostics\Debugger;
use app\wot;





class AccountControl extends UI\Control{

    private $account_id;
    private $data;
    private $cas;
    private $cas2;
            
    function __construct($account_id) {
        $this->account_id = $account_id;
        $this->info();
        $this->PlayerVehicles();
        
    }
            
    function info(){
        
        $fields = "account_id,clan_id,client_language,created_at,global_rating,last_battle_time,"
                . "updated_at,nickname,logout_at,statistics";
        
        $extra = "statistics.globalmap_absolute,statistics.globalmap_champion,statistics.globalmap_middle";
        
        $data = new \account2();
        $data = $data->account_info_extra($fields,$extra,$this->account_id);    
        
        $this->data = $data;
        
        
    } 
    
    
    
    function ClanTag($clan_id)
    {
        
        $fields     = "tag";
        $post       = array('fields'=> $fields, 'clan_id'=>$clan_id );
        $data       = new \Clans4();
        $info       = $data->ClansDetails($post);
        
        
        $info = $info['data'][$clan_id]['tag'];
        
        return $info;
    }
    
    
    function info_data_basic(){
        $account_id = $this->account_id;
        
        $i['account_id']        = $this->data['data'][$account_id]['account_id'];
        $i['last_battle_time']  = $this->data['data'][$account_id]['last_battle_time'];
        $i['created_at']        = $this->data['data'][$account_id]['created_at'];
        $i['updated_at']        = $this->data['data'][$account_id]['updated_at'];
        $i['global_rating']     = $this->data['data'][$account_id]['global_rating'];
        if($this->data['data'][$account_id]['clan_id'] > 1)
        {
        $i['clan_id']           = $this->ClanTag($this->data['data'][$account_id]['clan_id']);
        }
        else 
        {
          $i['clan_id']         ="Bez klanu"  ;
        }
        $i['nickname']          = $this->data['data'][$account_id]['nickname'];
        $i['logout_at']         = $this->data['data'][$account_id]['logout_at'];
        $i['client_language']   = $this->data['data'][$account_id]['client_language'];
        
        return $i; 
    }
    
    function info_stat_all(){
       
        $data = $this->data['data'][$this->account_id]['statistics']['all'];
        
        
        $i['spotted']                   = $data['spotted'];
        $i['hits']                      = $data['hits'];
        $i['battle_avg_xp']             = $data['battle_avg_xp'];
        $i['draws']                     = $data['draws'];
        $i['wins']                      = $data['wins'];
        $i['losses']                    = $data['losses'];
        $i['capture_points']            = $data['capture_points'];
        $i['battles']                   = $data['battles'];
        $i['damage_dealt']              = $data['damage_dealt'];
        $i['hits_percents']             = $data['hits_percents'];
        $i['damage_received']           = $data['damage_received'];
        $i['shots']                     = $data['shots'];
        $i['xp']                        = $data['xp'];
        $i['frags']                     = $data['frags'];
        $i['survived_battles']          = $data['survived_battles'];
        $i['dropped_capture_points']    = $data['dropped_capture_points'];
        
        
        return $i;
        
    }
    
    function globalmap_absolute()
    {
        
        $data = $this->data['data'][$this->account_id]['statistics']['globalmap_absolute']; 
       
        $i['spotted']                   = $data['spotted'];
        $i['hits']                      = $data['hits'];
        $i['battle_avg_xp']             = $data['battle_avg_xp'];
        $i['draws']                     = $data['draws'];
        $i['wins']                      = $data['wins'];
        $i['losses']                    = $data['losses'];
        $i['capture_points']            = $data['capture_points'];
        $i['battles']                   = $data['battles'];
        $i['damage_dealt']              = $data['damage_dealt'];
        $i['hits_percents']             = $data['hits_percents'];
        $i['damage_received']           = $data['damage_received'];
        $i['shots']                     = $data['shots'];
        $i['xp']                        = $data['xp'];
        $i['frags']                     = $data['frags'];
        $i['survived_battles']          = $data['survived_battles'];
        $i['dropped_capture_points']    = $data['dropped_capture_points'];
        
        
        return $i;
        
        
    }
    
    function globalmap_champion()
    {
        
        $data = $this->data['data'][$this->account_id]['statistics']['globalmap_champion']; 
       
        $i['spotted']                   = $data['spotted'];
        $i['hits']                      = $data['hits'];
        $i['battle_avg_xp']             = $data['battle_avg_xp'];
        $i['draws']                     = $data['draws'];
        $i['wins']                      = $data['wins'];
        $i['losses']                    = $data['losses'];
        $i['capture_points']            = $data['capture_points'];
        $i['battles']                   = $data['battles'];
        $i['damage_dealt']              = $data['damage_dealt'];
        $i['hits_percents']             = $data['hits_percents'];
        $i['damage_received']           = $data['damage_received'];
        $i['shots']                     = $data['shots'];
        $i['xp']                        = $data['xp'];
        $i['frags']                     = $data['frags'];
        $i['survived_battles']          = $data['survived_battles'];
        $i['dropped_capture_points']    = $data['dropped_capture_points'];
        
        
        return $i;
        
        
    }
    
    function globalmap_middle()
    {
        
        $data = $this->data['data'][$this->account_id]['statistics']['globalmap_middle']; 
       
        $i['spotted']                   = $data['spotted'];
        $i['hits']                      = $data['hits'];
        $i['battle_avg_xp']             = $data['battle_avg_xp'];
        $i['draws']                     = $data['draws'];
        $i['wins']                      = $data['wins'];
        $i['losses']                    = $data['losses'];
        $i['capture_points']            = $data['capture_points'];
        $i['battles']                   = $data['battles'];
        $i['damage_dealt']              = $data['damage_dealt'];
        $i['hits_percents']             = $data['hits_percents'];
        $i['damage_received']           = $data['damage_received'];
        $i['shots']                     = $data['shots'];
        $i['xp']                        = $data['xp'];
        $i['frags']                     = $data['frags'];
        $i['survived_battles']          = $data['survived_battles'];
        $i['dropped_capture_points']    = $data['dropped_capture_points'];
        
        
        return $i;
        
        
    }
    
    function info_stat_clan(){
       
        $data = $this->data['data'][$this->account_id]['statistics']['clan'];
        
        
        $i['spotted']                   = $data['spotted'];
        $i['hits']                      = $data['hits'];
        $i['battle_avg_xp']             = $data['battle_avg_xp'];
        $i['draws']                     = $data['draws'];
        $i['wins']                      = $data['wins'];
        $i['losses']                    = $data['losses'];
        $i['capture_points']            = $data['capture_points'];
        $i['battles']                   = $data['battles'];
        $i['damage_dealt']              = $data['damage_dealt'];
        $i['hits_percents']             = $data['hits_percents'];
        $i['damage_received']           = $data['damage_received'];
        $i['shots']                     = $data['shots'];
        $i['xp']                        = $data['xp'];
        $i['frags']                     = $data['frags'];
        $i['survived_battles']          = $data['survived_battles'];
        $i['dropped_capture_points']    = $data['dropped_capture_points'];
        
        if($i['battles'] < 1){$i['battles'] = 0.0000000001;$i['damage_received'] = 0.0000000001;}
        return $i;
        
    }
    
    function info_stat_stronghold_defense(){
       
        $data = $this->data['data'][$this->account_id]['statistics']['stronghold_defense'];
        
        
        $i['spotted']                   = $data['spotted'];
        $i['hits']                      = $data['hits'];
        $i['battle_avg_xp']             = $data['battle_avg_xp'];
        $i['draws']                     = $data['draws'];
        $i['wins']                      = $data['wins'];
        $i['losses']                    = $data['losses'];
        $i['capture_points']            = $data['capture_points'];
        $i['battles']                   = $data['battles'];
        $i['damage_dealt']              = $data['damage_dealt'];
        $i['hits_percents']             = $data['hits_percents'];
        $i['damage_received']           = $data['damage_received'];
        $i['shots']                     = $data['shots'];
        $i['xp']                        = $data['xp'];
        $i['frags']                     = $data['frags'];
        $i['survived_battles']          = $data['survived_battles'];
        $i['dropped_capture_points']    = $data['dropped_capture_points'];
        
        if($i['battles'] < 1){$i['battles'] = 0.0000000001;$i['damage_received'] = 0.0000000001;}
        return $i;
        
    }
    
    function info_stat_skirmish(){
       
        $data = $this->data['data'][$this->account_id]['statistics']['stronghold_skirmish'];
        
        
        $i['spotted']                   = $data['spotted'];
        $i['hits']                      = $data['hits'];
        $i['battle_avg_xp']             = $data['battle_avg_xp'];
        $i['draws']                     = $data['draws'];
        $i['wins']                      = $data['wins'];
        $i['losses']                    = $data['losses'];
        $i['capture_points']            = $data['capture_points'];
        $i['battles']                   = $data['battles'];
        $i['damage_dealt']              = $data['damage_dealt'];
        $i['hits_percents']             = $data['hits_percents'];
        $i['damage_received']           = $data['damage_received'];
        $i['shots']                     = $data['shots'];
        $i['xp']                        = $data['xp'];
        $i['frags']                     = $data['frags'];
        $i['survived_battles']          = $data['survived_battles'];
        $i['dropped_capture_points']    = $data['dropped_capture_points'];
        
        if($i['battles'] < 1){$i['battles'] = 0.0000000001;$i['damage_received'] = 0.0000000001;}
        return $i;
        
    }
    
    function info_stat_company(){
       
        $data = $this->data['data'][$this->account_id]['statistics']['company'];
        
        
        $i['spotted']                   = $data['spotted'];
        $i['hits']                      = $data['hits'];
        $i['battle_avg_xp']             = $data['battle_avg_xp'];
        $i['draws']                     = $data['draws'];
        $i['wins']                      = $data['wins'];
        $i['losses']                    = $data['losses'];
        $i['capture_points']            = $data['capture_points'];
        $i['battles']                   = $data['battles'];
        $i['damage_dealt']              = $data['damage_dealt'];
        $i['hits_percents']             = $data['hits_percents'];
        $i['damage_received']           = $data['damage_received'];
        $i['shots']                     = $data['shots'];
        $i['xp']                        = $data['xp'];
        $i['frags']                     = $data['frags'];
        $i['survived_battles']          = $data['survived_battles'];
        $i['dropped_capture_points']    = $data['dropped_capture_points'];
        
        if($i['battles'] < 1){$i['battles'] = 0.0000000001;$i['damage_received'] = 0.0000000001;}
        return $i;
        
    }
    
    function GetUserDataWN8()
    {
        $data = $this->data['data'][$this->account_id]['statistics']['all'];
        
        $i['spotted']                   = $data['spotted'];
        $i['wins']                      = $data['wins'];
        $i['battles']                   = $data['battles'];
        $i['damage_dealt']              = $data['damage_dealt'];
        $i['frags']                     = $data['frags'];
        $i['dropped_capture_points']    = $data['dropped_capture_points'];
        
        
        return $i;
    }
    
    function PlayerVehicles()
    {
        $fields = "tank_id,all.battles";
        $data   = new \vehicles2();
        $data   = $data->VehiclesAll($this->account_id, $fields);
        
        $data = $data[$this->account_id];
        
        foreach($data as $k=> $v)
        {
            $i[$v['tank_id']] = $v['all']['battles'];
        }
        return $i;
        
        
        
    }
    
    function GetWN8()
    {
        $player_data        = $this->GetUserDataWN8();
        $player_vehicles    = $this->PlayerVehicles();
        
        $data   = new \wn8player($player_data, $player_vehicles);
        $wn8    = $data->Step3();
        
        $color  = new \ColorScheme();
        $bc     = $color->wn8color($wn8);
        
        $result['color']    = $bc;
        $result['wn8']      = $wn8;
        
        return $result;
    }
    
    
    function render(){
        $this->template->info       = $this->info_data_basic();
        $this->template->all        = $this->info_stat_all();  
        $this->template->clan       = $this->info_stat_clan();
        $this->template->company    = $this->info_stat_company();
        $this->template->shdefense  = $this->info_stat_stronghold_defense();
        $this->template->absolute   = $this->globalmap_absolute();
        $this->template->champion   = $this->globalmap_champion();
        $this->template->middle     = $this->globalmap_middle();
        $this->template->skirmish   = $this->info_stat_skirmish();
        $this->template->wn8        = $this->GetWN8();
        $this->template->setFile(__DIR__.'/account_basic.latte');
        $this->template->render();        
        
    }
    
    
    
    
    
}
