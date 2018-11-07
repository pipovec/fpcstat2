<?php

namespace App\Presenters;

use Nette,
    Nette\Utils\Json,
    Nette\Caching\Cache,
    App\Model;

class CzSkKlanyPresenter extends BasePresenter
{
    private $clan_ids;
    private $cache;
    private $conn;

    function  __construct(\App\Model\Repository $repo)
    {
        $this->conn = $repo;

        $storage = new Nette\Caching\Storages\FileStorage('temp');
        $this->cache = new Cache($storage);

        $this->ClansCzSK();
    }

    /** @var \App\Model\Klany @inject */
  	public $model;

    public function KlanyCz()
    {
        return $this->model->KlanyCz();
    }


    public function renderCzklany()
    {
        $this->SaveRequest();
        $this->template->klany = $this->KlanyCz();
    }


    /** @return object of CZ/SK clans */
    private function ClansCzSK()
    {
      $value = $this->cache->load('clans-info');

    if($value === null) {

        $clan_ids =  $this->conn->ClanAll()->where('language', 'cs')->where('members_count >', 0)->limit(20)->fetchAll();
        foreach($clan_ids as $value) {
          $this->clan_ids[] = array('clan_id' => $value->clan_id, 'abbreviation'=> $value->abbreviation, 'created_at'=> date('Y-m-d H:m:s',$value->created_at), 'name'=> $value->name, 'emblem' =>  "/images/emblems32/".$value->clan_id."_emblem_conv.png", 'members_count'=> $value->members_count);
        }
        $this->cache->save('clans-info', $this->clan_ids);

      }
      else {
        $this->clan_ids = $value;
      }
    }



   function renderDefault()
   {
     
   }
}
