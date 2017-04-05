<?php

namespace App\Presenters;

use Nette,
    Nette\Utils\Json,
    App\Model;

class CzSkKlanyPresenter extends BasePresenter
{
	/** @var \App\Model\Klany @inject */
  	public $model;

    public function KlanyCz()
    {
        return $this->model->KlanyCz();
    }

   
    public function renderDefault()
    {
       $this->template->klany = $this->KlanyCz();
    }
}