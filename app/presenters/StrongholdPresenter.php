<?php

namespace App\Presenters;

use Nette,
    \App\Model,
    Nette\Utils\Json;

    

class StrongholdPresenter extends BasePresenter
{
    
    function  __construct()
    {                      
        
    }

    public $str8BattlesLabel;    
    public $str8BattlesData;

    public $strXBattlesLabel;
    public $strXBattlesData;

    
    /** @var \App\Model\Stronghold @inject */
    public $strong;
    
    /* Pocet bitiek level 6 rozsah vcera*/
    function Str6battles() {
        
        $i = 0;
        $result = $this->strong->Skirmish6battles()->fetchAll();
        foreach($result as $res) {
            $pole[$i] = array($res->name, $res->battles);
            $i++;
        }
        $pole = json_encode($pole);     
        return $pole;
    }

    /* Pocet damege level 6 rozsah vcera*/
    function Str6damage() {
        
        $i = 0;
        $result = $this->strong->Skirmish6damage()->fetchAll();
        foreach($result as $res) {
            $pole[$i] = array($res->name, $res->damage);
            $i++;
        }
        $pole = json_encode($pole);     
        return $pole;
    }

    function Str8battles() {
        
        $i = 0;
        $result = $this->strong->Skirmish8battles()->fetchAll();
        foreach($result as $res) {

            $this->str8BattlesLabel[$i] = $res->name;
            $this->str8BattlesData[$i] = $res->battles;            
            
            $i++;
        }
    }

    function StrXbattles() {
        
        $i = 0;
        $result = $this->strong->SkirmishXbattles()->fetchAll();
        foreach($result as $res) {

            $this->strXBattlesLabel[$i] = $res->name;
            $this->strXBattlesData[$i] = $res->battles;            
            
            $i++;
        }
    }
    
    function renderDefault () {
        $this->Str8battles();
        $this->StrXbattles();
        $this->SaveRequest();
        
        $this->template->data6bat = $this->Str6battles();
        $this->template->data6dmg = $this->Str6damage();

        $this->template->data8batL = $this->str8BattlesLabel;
        $this->template->data8batD = $this->str8BattlesData;

        $this->template->dataXbatL = $this->strXBattlesLabel;
        $this->template->dataXbatD = $this->strXBattlesData;

    }
}