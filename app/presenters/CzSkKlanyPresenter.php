<?php

namespace App\Presenters;

use Nette,
    Nette\Utils\Json,
    App\Model;

class CzSkKlanyPresenter extends BasePresenter
{
    
    function  __construct()
    {                      
       
    }
    
    /** @var \App\Model\Klany @inject */
  	public $model;

    public function KlanyCz()
    {
        return $this->model->KlanyCz();
    }

   
    public function renderDefault()
    {        
        $this->SaveRequest();
        $this->template->klany = $this->KlanyCz();
    }
}