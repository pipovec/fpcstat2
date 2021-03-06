<?php
declare(strict_types=1);

namespace App\Presenters;

use Nette,
    \App\Model,
    Nette\Caching\IStorage,
    Nette\Caching\Cache,
    Nette\Utils\Json;



class SeasonPresenter extends BasePresenter
{

    // https://api.worldoftanks.eu/wot/globalmap/seasonrating/?application_id=883ff6ceefb13177357ffea34d6fb06f&season_id=season_09&limit=100&vehicle_level=8
    private $repo;
    private $URL       = 'https://api.worldoftanks.eu/wot/globalmap/seasonrating/?application_id=c428e2923f3d626de8cbcb3938bb68f8&limit=100&season_id=';
    private $SEASON_ID = 'season_09';
    private $clan_ids = array();
    private $cache;
    private $storage;


    function  __construct(\App\Model\Repository $repo)
    {
        $this->repo = $repo;
        $this->storage = new Nette\Caching\Storages\FileStorage('temp');
        $this->cache = new Cache($this->storage);
        $this->ClansCzSK();
    }

    /** @return object of CZ/SK clans */
    private function ClansCzSK()
    {
      $value = $this->cache->load('clansczsk');
      if($value === null) {

        $clan_ids =  $this->repo->ClanAll()->select('clan_id')->where('language', 'cs');
        foreach($clan_ids as $value) {
          $this->clan_ids[] = $value->clan_id;
        }
        $this->cache->save('clansczsk', $this->clan_ids,[ Cache::EXPIRE => '24 hours',]);

      }
      else {
        $this->clan_ids = $value;
      }


    }

    /**  @Description  ziskanie dat zo server   */
    private function GetData(int $vehicle_level, int $page) : string
    {
      $vehicle_level = "&vehicle_level=".$vehicle_level;
      $page = "&page_no=".$page;

      return file_get_contents($this->URL.$this->SEASON_ID.$vehicle_level.$page);
    }

    public function DataForLevel(int $level)
    {
        $vehicle_level = $level;
        $result = array();

        if($this->cache->load($level) === null)
        {
            $pages = 1;
            for($i = 1; $i <= $pages; $i++)
            {
               $data = $this->GetData($vehicle_level, $i);
               $data = json_decode($data, TRUE);
               $pages = $data['meta']['page_total'];

               foreach($data['data'] as  $value) {
                 $tmp = array();
                 foreach($value as $k => $v) {
                    $tmp[$k] = $v;
                    if($k == "clan_id") {
                      if(in_array($v, $this->clan_ids)) {
                        $cz = 1;
                      }
                      else {
                        $cz = 0;
                      }
                    }
                 }
                 if($cz === 1) {
                    $result[] = $tmp;
                 }
                 unset($tmp, $cz);
               }

            }
            $this->cache->save($level, $result,[ Cache::EXPIRE => '24 hours',]);
        }
        else{
          $result = $this->cache->load($level);
        }


        return $result;
    }

    function renderDefault ()
    {
      $this->template->season_8 = $this->DataForLevel(8);
      $this->template->season_10 = $this->DataForLevel(10);

    }
}
