<?php

/**
 * Description of RebricekKlany
 *
 * @author pipovec
 */

namespace App\Presenters;

use Nette,
    App\Model;

class InfoKlanPresenter extends BasePresenter
{
	

	/** @var \App\Model\Dsn @inject */
  	public $dsn;
    
    public function Data($clan_id)
    {
        $clan_id = 500019018;
        $method = "/clans/info/";
        $post = array("clan_id" => $clan_id);

        $json = $this->dsn->SendWGN($method, $post);

        $json = json_decode($json,true);

        $json = $json["data"][$clan_id];

        return $json;

    }
	
    
    

	

	public function renderDefault($clan_id)
	{
		$this->template->data = $this->Data($clan_id);
	}

}