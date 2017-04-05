<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of roles
 *
 * @author deamon
 */
class roles {
    
    private $data;      /* data zo servera */
    private $baza;      /* data z databazy */
    
    function SetData($data){
        $c = count($data);
        if($c === 0){$data = array();}
        $this->data = $data['members'];
    }
    
    function SetBaza($baza){
         $c = count($baza);
        if($c === 0){$baza = array();}
        
        $this->baza = $baza; 
        
    }
    
    function Pozostatok(){
       $pozostatok = array(); 
        foreach($this->baza as $v)
        {
            $baza[$v['account_id']] = $v['role'];
        }
        
        foreach($this->data as $k => $v)
        {
            $ser[$k] = $v['role_i18n'];
        }
        
        $pozostatok = array_diff_key($baza, $ser);
        
       
       return $pozostatok;
    }
    
    function ZmenaRoly(){
        
        $zmenaroly = array();
        
        foreach($this->baza as $v)
        {
            $baza[$v['account_id']] = $v['role'];
        }
        
        foreach($this->data as $k => $v)
        {
            $ser[$k] = $v['role_i18n'];
        }
        
        
        foreach ($baza as $k => $v)
        {
            if($v !== $ser[$k]){ $zmenaroly[] = array(':account_id' => $k, ':role' => $ser[$k]);}
        }
       
        return $zmenaroly;
    }
    
}
