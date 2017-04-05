<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use Nette\Application\UI;
use Nette\Database\Connection;
use Nette\Database\Context;
use app\cron;

/**
 * Description of PlayerGRHistory
 *
 * @author deamon
 */
class PlayerGRHistory extends UI\Control{
    
    private $grmin;
    public  $placemin;
    private $data;
    private $database;
            
    
    
    
    public function setDatasourceCallback($callback)
    {
        $this->database = $callback;
        
    }
    
    function Mesiac()
    {
        $now   = date('Y-m-d',time());
        $date = new DateTime($now);
        $date->modify('-1 month');
        $date = $date->format('Y-m-d');
        
        return $date;
    }
    
    function data()
    {
        $this->data = $this->database;
                //->query("select poradie,global_rating,date from topplayers_history where account_id = ".  $this->account_id." order by date");
    }
    
    function gr()
    {
        $this->data();
        $gr = $this->data->fetchAll(); 
        
        $grmin = 11000;
        foreach($gr as $v)
        {
            
                $datum = $v['date'];
                $rok   = date('Y', strtotime($datum));
                $mesiac = date('m', strtotime($datum));
                $mesiac = $mesiac-1;
                $den    = date('d', strtotime($datum));
                $gr    = $v['global_rating'];
                
                if($gr < $grmin){$grmin = $gr;}
                
                $batt[] = "[Date.UTC($rok ,$mesiac , $den), ".$gr."]";
            
            
            
            $this->grmin = $grmin-5;
            
        }
       
       return $batt; 
        
        
    }
    
    function place()
    {
        $place = $this->data->fetchAll();
        
        $place_min = 100000;
        foreach($place as $v)
        {
            
                $datum = $v['date'];
                $rok   = date('Y', strtotime($datum));
                $mesiac = date('m', strtotime($datum));
                $mesiac = $mesiac-1;
                $den    = date('d', strtotime($datum));
                $place    = $v['poradie'];
                
                if($place < $place_min){$place_min = $place;}
                
                $batt[] = "[Date.UTC($rok ,$mesiac , $den), ".$place."]";
                
                $this->placemin = $place_min - 10;
                
                if($this->placemin < 0){$this->placemin = 0;}
           
            
             
        }
       
       return $batt; 
        
        
    }
    
    function render(){
    
        $this->template->gr             = $this->gr();
        $this->template->place          = $this->place();
        $this->template->grmin          = $this->grmin; 
        $this->template->plmin          = $this->placemin;
        $this->template->setFile(__DIR__.'/PlayerGRHistoryGraf.latte');
        $this->template->render();        
        
    }
    
}
