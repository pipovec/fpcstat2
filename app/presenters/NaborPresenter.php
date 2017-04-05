<?php

namespace App\Presenters;

use Nette,
    Nette\Utils\Json,
    Nette\Utils\Paginator,
    Nette\Application\UI\Form,
	
    App\Model;
    

class NaborPresenter extends BasePresenter
{
    /** @var \App\Model\Nabor @inject */
    public $model;

    public $celkom;
    public $table;

    
    function nabor()
    {
        return $this->model->nabor3();
    }
   
    function Celkom()
    {
        return $this->model->celkom();
    }

    function createComponentForm()
    {
        $form = new Form();
        $form->addText('wn8menej', ' ')->setRequired('zadaj minimalnu hodnotu');
        $form->addText('wn8viac', ' ')->setRequired('zadaj maximalny hodnotu');;
        $form->getElementPrototype()->class('form-horizontal');
        
        $form->onValidate[] = [$this, 'kontrolaCelkom'];
        $form->addSubmit('odosli', 'Odosli');
        
        $form->onSuccess[] = [$this, 'table'];
        return $form;

    }

    public function kontrolaCelkom($form)
    {
        $values = $form->getValues();
        $this->celkom = $this->model->nabor3()->where('wn8 < ',$values->wn8viac)->where('wn8 >', $values->wn8menej)->count('*');
        
        if ($this->celkom > 500) 
        { // validační podmínka
           
           $form->addError('Pocet hracov je vela '.$this->celkom);
        }

        if ($this->isAjax()) 
        {
            $this->invalidateControl('celkom');
        }

    }

    public function table($form)
    {
        $values = $form->getValues();
        $this->table = $this->model->nabor3()->where('wn8 < ',$values->wn8viac)->where('wn8 >', $values->wn8menej);

        if ($this->isAjax()) 
              {$this->invalidateControl('tabulka');}
    }


    public function renderDefault()
    {
       $this->template->celkom  = $this->Celkom();
       $this->template->sum     = $this->celkom;
       $this->template->table   = $this->table;
    }
}