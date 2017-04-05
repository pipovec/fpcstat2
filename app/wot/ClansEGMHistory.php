<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClansHistory
 *
 * @author deamon
 * 
 */

use Nette\Application\UI;
use Nette\Database\Connection;
use Nette\Database\Context;

class ClansEGMHistory extends UI\Control{
    
    private $clan_id;
    private $data;
    private $egmmin;
    private $egmminplace;
   
    private function Database()
    {
        include(__DIR__.'/../cron/dsn.php') ;
        $database = $clan;
        
        return $database;
    }
    
    private function Mesiac()
    {
        $now   = date('Y-m-d',time());
        $date = new DateTime($now);
        $date->modify('-1 month');
        $date = $date->format('Y-m-d');
        
        return $date;
    }
    
    function setClan_id($clan_id)
    {
        $this->clan_id = $clan_id;
        
    }
    
    function Data()
    {
       $this->data =  $this->Database()->query("select * from clan_rating_cs_history where clan_id = ".  $this->clan_id." order by date"); 
    }
    
    function Clan()
    {
        $name =  $this->Database()->query("select name from clan_all where clan_id =".$this->clan_id)->fetch();
        $name = $name['name'];
        return $name;
    }
    
    function egm()
    {
        $this->data();
        $egm = $this->data->fetchAll(); 
        
        $egmmin = 11000;
        foreach($egm as $v)
        {
            
                $datum = $v['date'];
                $rok   = date('Y', strtotime($datum));
                $mesiac = date('m', strtotime($datum));
                $mesiac = $mesiac-1;
                $den    = date('d', strtotime($datum));
                $egm    = $v['elo_rating_gm'];
                
                if($egm < $egmmin){$egmmin = $egm;}
                
                $batt[] = "[Date.UTC($rok ,$mesiac , $den), ".$egm."]";
            
            
            
            $this->egmmin = $egmmin-5;
            
        }
        
       return $batt; 
        
    }
    
    function egm_place()
    {
        $egm = $this->data->fetchAll(); 
        
        $egmmin = 11000;
        foreach($egm as $v)
        {
            
                $datum = $v['date'];
                $rok   = date('Y', strtotime($datum));
                $mesiac = date('m', strtotime($datum));
                $mesiac = $mesiac-1;
                $den    = date('d', strtotime($datum));
                $egm    = $v['poradie_egm'];
                
                if($egm < $egmmin){$egmmin = $egm;}
                
                $batt[] = "[Date.UTC($rok ,$mesiac , $den), ".$egm."]";
            
            
            
            $this->egmminplace = $egmmin-5;
            
        }
        
       return $batt; 
        
    }
            
    
    
    function render(){
    
        $this->template->egm             = $this->egm();
        $this->template->egmmin          = $this->egmmin;
        $this->template->egmplace        = $this->egm_place();
        $this->template->egmminplace     = $this->egmminplace;
        $this->template->data            = $this->data;
        $this->template->name            = $this->Clan();
        $this->template->setFile(__DIR__.'/ClansEGMHistory.latte');
        $this->template->render();        
        
    } 
    
    
}
