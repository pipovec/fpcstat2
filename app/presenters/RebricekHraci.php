<?php

namespace App\Presenters;

use Nette,
    App\Model;

class RebricekHraciPresenter extends BasePresenter
{
    
    function __construct()
    {
       
    }
    
    /** @var \App\Model\Repository @inject */
    public $Repository;

    function RebricekWn8()
    {
        return $this->Repository->HraciWn8All();
    }

    function RebricekGR()
    {
        return $this->Repository->HraciGrAll();
    }

    public function handleHraciGr()
    {
        $all_users = array();
        $all_users["aaData"] = $this->RebricekGR()->fetchAll();
        $this->sendResponse(new Nette\Application\Responses\JsonResponse($all_users));
    }

    public function handleHraciWn8()
    {
        $all_users = array();
        $all_users["aaData"] = $this->RebricekWn8()->fetchAll();
        $this->sendResponse(new Nette\Application\Responses\JsonResponse($all_users));
    }

    public function handleWn8Json()
	{
		$request 	= $this->getHttpRequest();
		$post 		= $request->getPost();

		//$count 		= $this->Repository->Wn8playersCount();

		$draw 			= $post["draw"];
		$iDisplayStart 	= $post["start"]; // offset
		$iDisplayLength = $post["length"]; // limit
		
        if($post["search"]["value"] != NULL) 
        {
            $search 		= $post["search"]["value"].'%';
        }
        else
        {
            $search = '%';
        }
        $count 		= $this->Repository->Wn8playersCount($search);
        

		$wn = array();
		$wn["draw"] 			= $draw; 
		$wn["recordsTotal"] 	= $count;
		$wn["recordsFiltered"]  = $count;
		$wn["aaData"] = $this->Repository->wn8players($iDisplayStart,$iDisplayLength,$search);
		$this->sendResponse(new Nette\Application\Responses\JsonResponse($wn) );
	}
    
}