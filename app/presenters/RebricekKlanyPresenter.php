<?php

/**
 * Description of RebricekKlany
 *
 * @author pipovec
 */

namespace App\Presenters;

use Nette,
    App\Model;

class RebricekKlanyPresenter extends BasePresenter
{
	
	public $table;
    public $top;  
	public static $draw = 1;

	/** @var \App\Model\Rebricek @inject */
  	public $model;

	public function Pokus()
	{
		return $this->model->Pokus();
	}

	
	public function Top()
    {
        $table = ':cr_efficiency';
        return $this->model->StatClans($table);
    }

	public function handleAjaxTop($table)
    {
	    $table = ":".$table;
	    
	    $this->top = $this->model->StatClans($table);
	    
	    if ($this->isAjax()) 
	    {
	        $this->redrawControl('topclans');
	    }
    
    }

   

	public function handleWnJson()
	{
		$request 	= $this->getHttpRequest();
		$post 		= $request->getPost();

		$count 		= $this->model->Wn8ClansCount();

		$draw 			= $post["draw"];
		$iDisplayStart 	= $post["start"]; // offset
		$iDisplayLength = $post["length"]; // limit
		$search 		= $post["search"]["value"];

		$wn = array();
		$wn["draw"] 			= $draw; 
		$wn["recordsTotal"] 	= $count;
		$wn["recordsFiltered"]  = $count;
		$wn["aaData"] = $this->model->wn8clan($iDisplayStart,$iDisplayLength);
		$this->sendResponse(new Nette\Application\Responses\JsonResponse($wn) );
	}
	
	
	public function renderDefault($table)
	{

		$this->template->pokus 		= $this->Pokus();
		$this->template->data       = $this->Top();
		

		if ($table === NULL) 
		{
            $this->template->topgr 	= $this->Top();
        }
        else
        {
        	$this->template->topgr 	= $this->top;
        }
	}

	public function renderWn8random()
	{
		
	}

}