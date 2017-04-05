<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Zobrazenie hracovych tankov
 *
 * @author deamon
 */

use Nette\Application\UI;
use Nette\Database\Connection;
use Nette\Database\Context;
use Nette\Diagnostics\Debugger;

use app\wot;
use app\cron;


class PlayerVehiclesControl extends UI\Control {
   
    protected $tank;
    protected $account_id;
    public $database;
    protected $wn8tanks;
    public $cas;
   
    function setConnection($conn){
        return $this->database = $conn;
    }        
    
    
    function array_orderby()
    {
        $args = func_get_args();
        $data = array_shift($args);
        foreach ($args as $n => $field) {
            if (is_string($field)) {
                $tmp = array();
                foreach ($data as $key => $row)
                    $tmp[$key] = $row[$field];
                $args[$n] = $tmp;
                }
        }
        $args[] = &$data;
        call_user_func_array('array_multisort', $args);
        return array_pop($args);
    }
    
    
    
    function SetAccountId($account_id)
    {
        $this->account_id = $account_id;
    }
    
    protected function TankId()
    {
        $tank_id = '';
        foreach( $this->tank as $v)
        {
            $tank_id .= $v->tank_id.",";
        }
        
        return $tank_id;
    }
    
    
            
    
    function GetData()
    {
        $fields = "tank_id,mark_of_mastery,max_frags,all.frags,all.damage_dealt,all.spotted,all.dropped_capture_points,all.battles,all.wins";
        $data = new \vehicles2();
        $data = $data->VehiclesAll($this->account_id,$fields);         
        $data = $data[$this->account_id];
        return $data;
        
    }
    
    function PrepareData()
    {
        $data = $this->GetData();
        foreach ($data as $value) {
            
            if($value['all']['battles'] > 0)
            {
            $tanks[] = array(   'tank_id'               => $value['tank_id'],
                                'frags'                 => $value['all']['frags'],
                                'spotted'               => $value['all']['spotted'],
                                'wins'                  => $value['all']['wins'],
                                'battles'               => $value['all']['battles'],
                                'damage_dealt'          => $value['all']['damage_dealt'],
                                'dropped_capture_points'=> $value['all']['dropped_capture_points'],
                                'mark_of_mastery'       => $value['mark_of_mastery'],
                                'max_frags'             => $value['max_frags']
                            );
            }
            
        }
        
        return $tanks;
    }
    
    function AddWN8()
    {
        $this->cas      = Debugger::timer();
        $data           = $this->PrepareData();
        $wn8            = new \wn8();
        $color          = new \ColorScheme();
        $pocet_tankov   = 0;
        
        foreach ($data as $value)
        {
            $wn8->SetData($value);
            $vys = $wn8->Step3();
            $tanks[] = array(   'tank_id'               => $value['tank_id'],
                                'frags'                 => $value['frags'],
                                'spotted'               => $value['spotted'],
                                'wins'                  => $value['wins']/$value['battles']*100,
                                'colorw'                => $color->winrate($value['wins']/$value['battles']*100),
                                'battles'               => $value['battles'],
                                'damage_dealt'          => $value['damage_dealt'],
                                'dropped_capture_points'=> $value['dropped_capture_points'],
                                'mark_of_mastery'       => $value['mark_of_mastery'],
                                'max_frags'             => $value['max_frags'],
                                'wn8'                   => $vys,
                                'color'                 => $color->wn8color($vys)
                            );
            $pocet_tankov++;
            
            
        }
        $this->cas = Debugger::timer();
        
        $data = array('account_id'=> $this->account_id, 'pocet_tankov'=>$pocet_tankov,'cas_vypoctu'=>  $this->cas);
        $this->CasVypoctuTankov($data);
        
        return $tanks;
        
    }
    /* Pridanie nazvu tanku podla encyklopedie */
    function AddName()
    {
        
        $data = $this->AddWN8();
        
        foreach ($data as $k => $value)
        {
            $i = $this->database->table('encyclopedia_vehicles')->where('tank_id', $value['tank_id'])->fetch();
            
            $tanks[]
                     = array(   'tank_id'               => $value['tank_id'],
                                'name'                  => $i->name_i18n,
                                'level'                 => $i->level,
                                'frags'                 => $value['frags'],
                                'spotted'               => $value['spotted'],
                                'wins'                  => $value['wins'],
                                'colorw'                => $value['colorw'],
                                'battles'               => $value['battles'],
                                'damage_dealt'          => $value['damage_dealt'],
                                'dropped_capture_points'=> $value['dropped_capture_points'],
                                'mark_of_mastery'       => $value['mark_of_mastery'],
                                'max_frags'             => $value['max_frags'],
                                'wn8'                   => $value['wn8'],
                                'color'                 => $value['color']
                            );
            
        }
        
        /*Zotriedenie podla WN8*/
        $tanks = $this->array_orderby($tanks, 'level', SORT_DESC);
        
        
        $this->wn8tanks = $tanks;
        return $tanks;
        
    }
    
    private function CasVypoctuTankov($data)
    {
        $this->database->table('wn8cas')->insert($data);
    }
            
    function render(){
        $this->template->data       = $this->AddName();
        $this->template->cas        = $this->cas;
        $this->template->setFile(__DIR__.'/PlayerVehicles.latte');
        $this->template->render();        
        
    }
    
    
}
