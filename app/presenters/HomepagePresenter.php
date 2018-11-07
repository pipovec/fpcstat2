<?php

namespace App\Presenters;

use Nette,
    App\Model;

class HomepagePresenter extends BasePresenter
{

    function  __construct()
    {

    }

    /** @var \App\Model\Repository @inject */
    public $Repository;

  /** @var \App\Model\Rebricek @inject */
    public $Rebricek;

    /** @var \App\Model\Stronghold @inject */
    public $strong;


    function ChangedNicks()
    {
        return $this->Repository->ChangeNick();

    }

    
    function StrongholdTanks($level)
    {
        return $this->Rebricek->StrongholdTanks($level);
    }
    
    function Stronghold6()
    {
        return $this->StrongholdTanks(6);
    }

    function Stronghold8()
    {
        return $this->StrongholdTanks(8);
    }
    
    private $str6BattlesLabel;
    private $str6BattlesData;

    function Str6battles() {

        $i = 0;
        $result = $this->strong->TanksBattles("pvs_skirmish_history", 6, 10);
        foreach($result as $res) {

            $this->str6BattlesLabel[$i] = $res->name;
            $this->str6BattlesData[$i] = $res->battles;

            $i++;
        }
    }


    public function renderDefault()
    {

        $this->SaveRequest();
        $this->Str6battles();


        $this->template->chnick     = $this->ChangedNicks();

        $this->template->s6         = $this->Stronghold6();
        $this->template->s8         = $this->Stronghold8();
        
        $this->template->data6batL = $this->str6BattlesLabel;
        $this->template->data6batD = $this->str6BattlesData;
    }
}
