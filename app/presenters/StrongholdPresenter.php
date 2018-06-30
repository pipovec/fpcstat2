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

    public $str6BattlesLabel;    
    public $str6BattlesData;
    public $str6BattlesLabel7;    
    public $str6BattlesData7;

    public $str8BattlesLabel;    
    public $str8BattlesData;
    public $str8BattlesLabel7;    
    public $str8BattlesData7;

    public $strXBattlesLabel;
    public $strXBattlesData;
    public $strXBattlesLabel7;
    public $strXBattlesData7;



    private $skirmish   = "pvs_skirmish_history";
    private $globalmap  = "pvs_globalmap_history";
    private $all        = "pvs_all_history";


    
    /** @var \App\Model\Stronghold @inject */
    public $strong;    
    
    function Str6battles() {
        
        $i = 0;
        $result = $this->strong->TanksBattles($this->skirmish, 6, 10);
        foreach($result as $res) {

            $this->str6BattlesLabel[$i] = $res->name;
            $this->str6BattlesData[$i] = $res->battles;            
            
            $i++;
        }
    }
    
    function Str6battles7() {
        
        $i = 0;
        $result = $this->strong->TanksBattles7($this->skirmish, 6, 10);
        foreach($result as $res) {

            $this->str6BattlesLabel7[$i] = $res->name;
            $this->str6BattlesData7[$i] = $res->battles;            
            
            $i++;
        }
    }

    function Str8battles() {
        
        $i = 0;
        $result = $this->strong->TanksBattles($this->skirmish, 8, 10);

        foreach($result as $res) {

            $this->str8BattlesLabel[$i] = $res->name;
            $this->str8BattlesData[$i] = $res->battles;            
            
            $i++;
        }
    }

    function Str8battles7() {
        
        $i = 0;
        $result = $this->strong->TanksBattles7($this->skirmish, 8, 10);

        foreach($result as $res) {

            $this->str8BattlesLabel7[$i] = $res->name;
            $this->str8BattlesData7[$i] = $res->battles;            
            
            $i++;
        }
    }

    function StrXbattles() {
        
        $i = 0;
        $result = $this->strong->TanksBattles($this->skirmish, 10, 10);
        foreach($result as $res) {

            $this->strXBattlesLabel[$i] = $res->name;
            $this->strXBattlesData[$i] = $res->battles;            
            
            $i++;
        }
    }
    
    function StrXbattles7() {
        
        $i = 0;
        $result = $this->strong->TanksBattles7($this->skirmish, 10, 10);
        foreach($result as $res) {

            $this->strXBattlesLabel7[$i] = $res->name;
            $this->strXBattlesData7[$i] = $res->battles;            
            
            $i++;
        }
    }    
    
    function renderDefault () {

        $this->Str6battles();
        $this->Str6battles7();

        $this->Str8battles();
        $this->Str8battles7();

        $this->StrXbattles();
        $this->StrXbattles7();

        $this->SaveRequest();
        
        $this->template->data6batL  = $this->str6BattlesLabel;
        $this->template->data6batD  = $this->str6BattlesData;
        $this->template->data6batL7 = $this->str6BattlesLabel7;
        $this->template->data6batD7 = $this->str6BattlesData7;


        $this->template->data8batL  = $this->str8BattlesLabel;
        $this->template->data8batD  = $this->str8BattlesData;
        $this->template->data8batL7 = $this->str8BattlesLabel7;
        $this->template->data8batD7 = $this->str8BattlesData7;

        $this->template->dataXbatL  = $this->strXBattlesLabel;
        $this->template->dataXbatD  = $this->strXBattlesData;      
        $this->template->dataXbatL7 = $this->strXBattlesLabel7;
        $this->template->dataXbatD7 = $this->strXBattlesData7;      

    }
}