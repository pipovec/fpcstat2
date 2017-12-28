<?php

namespace App\Presenters;

use Nette,
    \App\Model,
    Nette\Utils\Json;

    

class StrongholdPresenter extends BasePresenter
{
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

    
    function renderDefault () {
        $this->template->data6bat = $this->Str6battles();
        $this->template->data6dmg = $this->Str6damage();
    }
}