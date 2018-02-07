<?php

/**
 * Description of RebricekKlany
 *
 * @author pipovec
 */

namespace App\Presenters;

use Nette,
	Nette\Application\UI,
	
    App\Model;

class RebricekKlanyPresenter extends BasePresenter
{
	
	public $table;
    public $top;  
	public static $draw = 1;
	public $data;
	public $isKlan ;

	function  __construct()
    {                      
       
    }
    
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

	public function handlekampan() {		
		
		$clans = $this->model->Kampan()->fetchAll();	

		$this->sendResponse(new Nette\Application\Responses\JsonResponse($clans));
	}


	public function handleWnJson()
	{
		$request 	= $this->getHttpRequest();
		$post 		= $request->getPost();

		$count 		= $this->model->Wn8ClansCount()->fetchAll();
		
		$draw 			= $post["draw"];
		$iDisplayStart 	= $post["start"]; // offset
		$iDisplayLength = $post["length"]; // limit
		$search 		= $post["search"]["value"];

		$wn = array();
		$wn["draw"] 			= $draw; 
		$wn["recordsTotal"] 	= $count[0]['count'];
		$wn["recordsFiltered"]  = $count[0]['count'];
		$wn["aaData"] = $this->model->wn8clan($iDisplayStart,$iDisplayLength);

		$this->sendResponse(new Nette\Application\Responses\JsonResponse($wn) );
	}
	
	
	public function renderDefault($table)
	{
		$this->SaveRequest();
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


	/** Historia - grafy klanov */
	private $cr_efficiency_history;
	private $cr_fb_elo_rating_10_history ;
	private $cr_fb_elo_rating_8_history;
	private $cr_fb_elo_rating_history;
	private $cr_global_rating_avg_history;
	private $cr_global_rating_weighted_avg_history;
	private $cr_battles_count_avg_history;
	private $cr_gm_elo_rating_10_history;
	private $cr_gm_elo_rating_8_history;
	private $cr_gm_elo_rating_6_history;
	private $cr_gm_elo_rating_history;
	private $cr_wins_ratio_avg_history;
	private $cr_v10l_avg_history;
	private $clan_id;

	protected function createComponentForm()
	{
		$form = new UI\Form;
		$form->addText('klan','');
		$form->addSubmit('send','Odosli');
		$form->onSuccess[] = [$this, 'handleHistory'];

		return $form;
	}

	public function handleHistory($form)
	{
		$this->data = $form->values->klan;
		$this->IsKlan($this->data);

		if($this->isKlan == 1)
		{
			$id = $this->model->GetId($this->data);
			$this->clan_id = $id; 
			$this->getHistoryData($id);
		}
	
		if ($this->isAjax()) 
              {$this->invalidateControl('grafy');}
	}

	function IsKlan()
	{
		$this->isKlan = $this->model->IsClan($this->data);
		if($this->isKlan == 0)
			{$this->isKlan = 'Klan nie je v databaze';}

		if ($this->isAjax()) 
			{$this->invalidateControl('isklan');}
	}


	function getHistoryData($clan_id)
	{
		$this->cr_efficiency_history = $this->model->getHistoryData("cr_efficiency_history",$clan_id);
		$this->cr_fb_elo_rating_history = $this->model->getHistoryData("cr_fb_elo_rating_history",$clan_id);
		$this->cr_global_rating_avg_history = $this->model->getHistoryData("cr_global_rating_avg_history",$clan_id);
		$this->cr_global_rating_weighted_avg_history = $this->model->getHistoryData("cr_global_rating_weighted_avg_history",$clan_id);


	}


	public function renderWn8random()
	{
		
	}

	function renderHistory()
	{
		$this->template->clan_id = $this->clan_id;
		$this->template->isklan = $this->isKlan;
		$this->template->cr_efficiency_history = $this->cr_efficiency_history;
		$this->template->cr_fb_elo_rating_history = $this->cr_fb_elo_rating_history;
		$this->template->cr_global_rating_avg_history = $this->cr_global_rating_avg_history;
		$this->template->cr_global_rating_weighted_avg_history = $this->cr_global_rating_weighted_avg_history;


	}
}
