<?php

namespace App\Presenters;

use Nette,
    //App\Model,
    Nette\Application\UI,
    Nette\Application\UI\Form;

class ChatPresenter extends BasePresenter
{

  function __construct()
  {
        
  }

  /** @var \App\Model\Chat @inject */
  public $chat;

  public function Pokus()
  {
    return $this->chat->ReadChat();
  }

  protected function createComponentChat()
   {
       $form = new UI\Form;
       $form->addText('nick', 'Nick:')->setRequired(FALSE)->addRule(Form::MIN_LENGTH,'Nick musí mať aspoň %d znaky', 3);
       $form->addText('text', 'Text:')->setRequired(FALSE)->addRule(Form::MIN_LENGTH,'Text musí mať aspoň %d znaky', 5);
       $form->addSubmit('send', 'Odosli');
       $form->onSuccess[] = [$this, 'send'];
       return $form;

   }

public function handleChatJson()
{
  $chat = array();
  $chat["aaData"] = $this->Pokus();
  $this->sendResponse(new Nette\Application\Responses\JsonResponse($chat) );
}

  public function Send($form)
  {
    $this->chat->SpracujFormular($form);

    // Rovno to potom cele prekresli
    if ($this->isAjax()) 
              {$this->invalidateControl('chat');}
  } 

  public function renderDefault()
  {
    $this->SaveRequest();
    $this->template->pokus = $this->Pokus();
  }

}
