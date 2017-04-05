<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * 
 * Trieda ktora by sa mala volat zo skriptov a mala by posielat dotazy na server 
 * 
 * @author pipovec
 */
namespace cron;
require_once(__DIR__.'/Accounts.php');

class PlayersStats extends Accounts
{
	
	private $account_ids_txt;
	private $fields	=	"-statistics.all,-statistics.clan,-statistics.company,-statistics.fallout,-statistics.team,-statistics.historical,-statistics.random,-statistics.regular_team,-statistics.stronghold_defense,-statistics.stronghold_skirmish";
	private $extra 	= 	"statistics.globalmap_absolute,statistics.globalmap_champion,statistics.globalmap_middle";
	private $lang	=	"cs";

	/* Prijme account_id ktore sa maju spracovat */
	function SetAccountIds($account_ids)
	{
		$data = "";

		foreach($account_ids as $id)
		 {
		 	$data .= $id->account_id.",";
		 }
    	
    	$this->account_ids_txt = rtrim($data,",");
    	$data = null;

	}

	/* Posle account_id na server a prijme data o hracoch */
	private function SendData()
	{
		$post = array('account_id' => $this->account_ids_txt, 'fields' => $this->fields, 'extra'=> $this->extra, 'language' => $this->lang);	
		$this->account_ids = null;

		$data = parent::PlayersPersonalData($post);

		return $data;

	}
	
	function SaveData()
	{
		$data = $this->SendData();

		$result = $data['data'];
    	$account_keys = array_keys($result);

    	foreach($account_keys as $keys)
    	{
    		/* Hracske statistiky CW absolute 10*/
	        $stat_all = $result[$keys]['statistics']['globalmap_absolute'];
		        if(count($stat_all) > 0)
		        {
		            $query[]  = "SELECT function_players_stat_gm_absolute(".$keys.",".$stat_all['spotted'].",".$stat_all['hits'].",".$stat_all['battle_avg_xp'].",".$stat_all['draws'].",".$stat_all['wins'].",".$stat_all['losses'].",".$stat_all['capture_points'].",".$stat_all['battles'].",".$stat_all['damage_dealt'].",".$stat_all['hits_percents'].",".$stat_all['damage_received'].",".$stat_all['shots'].",".$stat_all['xp'].",".$stat_all['frags'].",".$stat_all['survived_battles'].",".$stat_all['dropped_capture_points'].")";
		         	    
		        }
		        unset($stat_all);

		    /* Hracske statistiky CW champion 8*/
	        $stat_all = $result[$keys]['statistics']['globalmap_champion'];
		        if(count($stat_all) > 0)
		        {
		            $query[]  = "SELECT function_players_stat_gm_champion(".$keys.",".$stat_all['spotted'].",".$stat_all['hits'].",".$stat_all['battle_avg_xp'].",".$stat_all['draws'].",".$stat_all['wins'].",".$stat_all['losses'].",".$stat_all['capture_points'].",".$stat_all['battles'].",".$stat_all['damage_dealt'].",".$stat_all['hits_percents'].",".$stat_all['damage_received'].",".$stat_all['shots'].",".$stat_all['xp'].",".$stat_all['frags'].",".$stat_all['survived_battles'].",".$stat_all['dropped_capture_points'].")";
		         	    
		        }
		        unset($stat_all);  
		        
		    /* Hracske statistiky CW  middle 6*/
	        $stat_all = $result[$keys]['statistics']['globalmap_middle'];
		        if(count($stat_all) > 0)
		        {
		            $query[]  = "SELECT function_players_stat_gm_middle(".$keys.",".$stat_all['spotted'].",".$stat_all['hits'].",".$stat_all['battle_avg_xp'].",".$stat_all['draws'].",".$stat_all['wins'].",".$stat_all['losses'].",".$stat_all['capture_points'].",".$stat_all['battles'].",".$stat_all['damage_dealt'].",".$stat_all['hits_percents'].",".$stat_all['damage_received'].",".$stat_all['shots'].",".$stat_all['xp'].",".$stat_all['frags'].",".$stat_all['survived_battles'].",".$stat_all['dropped_capture_points'].")";
		         	    
		        }
		        unset($stat_all);        

    	}

    return $query;

	}





}  