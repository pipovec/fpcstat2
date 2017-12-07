<?php

namespace App\Presenters;

use Nette,
    App\Model;

class HomepagePresenter extends BasePresenter
{
	/** @var \App\Model\Repository @inject */
    public $Repository;

  /** @var \App\Model\Rebricek @inject */
    public $Rebricek;

    function Odchody()
    {
    	return $this->Repository->AktualneOdchody();

    }

    function CountOdchody()
    {
        $count = $this->Repository->CountOdchody()->fetchAll();
        $count = $count[0];

        return $count;
    }

    function Wn8()
    {
        return $this->Repository->HraciWn8();
    }

    function CountWn8()
    {
        $count = $this->Repository->CountHraciWn8()->fetchAll();
        $count = $count[0];

        return $count;
    }

    function Gr()
    {
        return $this->Repository->HraciGr();
    }

    function CountGr()
    {
        $count = $this->Repository->CountHraciGr()->fetchAll();
        $count = $count[0];

        return $count;
    }

    function CzSkKlans()
    {
        return $this->Repository->ClanCz5();
    }

    function ClansCsTop()
    {
        return $this->Repository->ClansEffe();
    }

    function ChangedNicks()
    {
        return $this->Repository->ChangeNick();
    }

    function Wn8clan()
    {

        return $this->Rebricek->Wn8Clans(0,5);

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




    public function renderDefault()
    {
    	$this->template->odchody    = $this->Odchody();
        $this->template->wn8        = $this->Wn8();
        $this->template->gr         = $this->Gr();

        $this->template->codchody    = $this->CountOdchody();
        $this->template->cwn8        = $this->CountWn8();
        $this->template->cgr         = $this->CountGr();

        $this->template->clans      = $this->CzSkKlans();
        $this->template->clanseff   = $this->ClansCsTop();

        $this->template->chnick     = $this->ChangedNicks();

        $this->template->clanWn8    = $this->Wn8clan();

        $this->template->s6         = $this->Stronghold6();
        $this->template->s8         = $this->Stronghold8();
    }
}
