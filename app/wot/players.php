<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Porovnanie tabulky players z udajmi zo serevera
 *
 * @author deamon
 */
class players {
    
    private $data;      /* data zo servera */
    private $baza;      /* data z databazy */
    private $clan_id;   /* clan_id */ 
    
    
    
    
    function SetData($data){
        $c = count($data);
        if($c === 0){$data = array();}
        
        $this->data = $data;
    }
    
    function SetBaza($baza){
        $c = count($baza);
        if($c === 0){$baza = array();}
        
        $this->baza = $baza; 
        
        
    }
    
    function IDbazy(){
        
        $c = count($this->baza); 
        if($c === 0)
            {return $this->baza;}
        else
            {foreach($this->baza as $c)  {$id_baza[] = $c['account_id'];}}
           
        return $id_baza;
    }
    
    function IDservera(){
        
        $id_server = array_keys($this->data['members']);
        return $id_server;
    }
    
    
    function Niejevklane(){
        $id_baza        = $this->IDbazy();
        $id_server      = $this->IDservera();
        
        /* kontrola kto uz nie je v klane */
        $nenivklane = array_diff($id_baza, $id_server);
        

        return $nenivklane;
    }
    
    function Novyvklane(){
        $id_baza        = $this->IDbazy();
        $id_server      = $this->IDservera();
        
        $novyvklane = array_diff($id_server, $id_baza);
        return $novyvklane;
    }
    
    
    function Novynick(){
        
        $novynick = array();
        $server = array();
        
        foreach($this->baza as $v)
        {
            $baza[$v['account_id']] = $v['nickname'] ;
        }   
        
        foreach ($this->data['members'] as $k => $v)
        {
            $server[$k] = $v['account_name'];
        }
            

        foreach($baza as $k => $v)
        {
            
            if($v !== $server[$k])
                {
                $novynick[] = array( 'account_name'  => $this->data['members'][$k]['account_name'],
                'account_id'    => $k);
                } 
            
        }
            
            
        return $novynick;
        
        
        
    }
    
    
    
    
    
    
    
    
    
    
    
    
}
