<?php

namespace App\Presenters;

use Nette,
    App\Model,
    Nette\Application\UI,
    Nette\Application\UI\Form;

class InfoHracPresenter extends BasePresenter
{
    
    public $request = 0;
    
    protected function createComponentChat()
   {
       $form = new UI\Form;
       $form->addText('nick', 'Nick:')->setRequired(FALSE)->addRule(Form::MIN_LENGTH,'Nick musí mať aspoň %d znaky', 3);
       $form->addSubmit('send', 'Odosli');
       $form->onSuccess[] = [$this, 'send'];
       return $form;

   }
function handleUrob($c,$d)
{
    
    $httpRequest = $this->getHttpRequest();
    $this->request = $httpRequest->getQuery();
    if ($this->isAjax()) 
              {$this->redrawControl('form');}
    
}

   public function Send($form)
  {
    //$this->model->SpracujFormular($form);
    
    // Rovno to potom cele prekresli
    if ($this->isAjax()) 
              {$this->redrawControl('form');}
  } 

  function renderDefault()
  {
      $this->template->data = $this->request;
  }
    
}
