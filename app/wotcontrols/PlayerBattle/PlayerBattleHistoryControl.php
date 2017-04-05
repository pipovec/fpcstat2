<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PlayerBattleHistory
 *
 * @author deamon
 */
use Nette,
    Nette\Application\UI,
    App\Model,
    app\cron;


class PlayerBattleHistoryControl extends UI\Control 
{
    
    protected $model;
    
    public function __construct($model)
    {
            parent::__construct();
            $this->model = $model;
    }

    
    function Mesiac()
    {
        $now   = date('Y-m-d',time());
        $date = new DateTime($now);
        $date->modify('-1 month');
        $date = $date->format('Y-m-d');
        
        return $date;
    }
    
    function setAccount_id($account_id)
    {
        $this->account_id = $account_id;
        
    }
    
    /* Graf denneho hodnotenia WN8 */
    
    private function modelwn8daily()
    {
        $mesiac = $this->Mesiac();
        return $this->model->wn8daily($this->account_id)->where('date >=', $mesiac)->order('date');
    }
    
    function wn8daily()
    {
        $data   = $this->modelwn8daily();
        $wn8d[]   = "['Datum', 'WN8 ', { role: 'style' }]";
        $color = new \ColorScheme();
        
        //['21.09.2015', 1570.45, '#b87333'],
        foreach ($data as $v)
        {
            // ziskanie farby pre wn8
            $c          = $color->wn8color($v->wn8);
            $datum      = date('Y-m-d', strtotime($v->date));
            $wn8di       = $v->wn8;
            
            
            $wn8d[] = "['$datum', $wn8di, '$c']";
            
           
            
        }
            
        return $wn8d;
        
    }
    
    private function modelwn8mesiac()
    {
        $mesiac = $this->Mesiac();
        return $this->model->wn8player($this->account_id)->where('date >=', $mesiac)->order('date');
    }
            
    function wn8mesiac()
    {
        $data   = $this->modelwn8mesiac();
        $wn8m[] = "['Datum', 'WN8' ]";
        foreach ($data as $value)
        {
            $datum      = date('Y-m-d', strtotime($value->date));
            $wn8m[]     = "['$datum',$value->wn8]";
        }
        return $wn8m;
    }
    
    
    
    
    
    
    
    function render(){
        
        $this->template->wn8daily      = $this->wn8daily();
        $this->template->wn8mesiac     = $this->wn8mesiac();
        $this->template->setFile(__DIR__.'/PlayerBattleGraf.latte');
        $this->template->render();        
        
    }
}
