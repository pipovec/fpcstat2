<?php

namespace App\Presenters;

use Nette,
    App\Model,
    Nette\Application\UI,
    Nette\Application\UI\Form;

class InfoHracPresenter extends BasePresenter
{

    /** @var \App\Model\Repository @inject */
    public $model;

    public $request = 0;
    public $wn8player ;

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

   function handlewn8player($nickname)
   {
        $this->wn8player = $this->model->wn8player_history($nickname)->fetchAll();
        $this->sendResponse(new Nette\Application\Responses\JsonResponse($this->wn8player));
   }

   function handleFindId($nickname)
   {
        $player = $this->model->FindPlayer($nickname)->fetchAll();
        
        $this->sendResponse(new Nette\Application\Responses\JsonResponse($player));
   }


   function renderDefault()
   {
      $this->template->data = $this->request;
      $this->template->w8pl = $this->wn8player;

   }

}
