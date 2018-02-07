<?php

namespace App\Presenters;

use Nette,
    App\Model;

class OdchodyPresenter extends BasePresenter
{
    function __construct()
    {
        
    }
    
    
    /** @var \App\Model\Repository @inject */
    public $Repository;

    function AktualneOdchody()
    {
        
        return $this->Repository->AktualneOdchody2();
    }


    public function renderDefault()
    {
        $this->SaveRequest();
        $this->template->odchody = $this->AktualneOdchody();
    }
}