<?php

namespace App\Model;
use Nette;

class Rebricek extends Nette\Object
{
	/** @var Nette\Database\Connection */
    protected $pgsql;

    public function __construct(Nette\Database\Context $db)
    {
        $this->pgsql = $db;
    }

    public function Pokus()
    {
    	//return $this->pgsql->table('players');
    }

    function Clans(){
        return $this->pgsql->table('clans');
    }

    private function ClanAll()
    {
        return $this->pgsql->table('clan_all');
    }

    private function ClanCz()
    {
        return $this->pgsql->table('tmp_clans_cs');
    }

    private function ClanCzSk()
    {
        return $this->ClanAll()->where('clan_all.clan_id', $this->ClanCz());
    }

    function StatClans($table)
    {

        return $this->ClanCzSk()
                ->select($table.'.rank,'.$table.'.value,'.$table.'.rank_delta, name, clan_all.clan_id, abbreviation')
                ->where($table.".rank >",0 )
                ->order($table.".rank");
    }

    public function Wn8Clans($iDisplayStart,$iDisplayLength)
    {

        return $this->pgsql->query("SELECT rank() OVER (ORDER BY wn8 DESC) as rank ,wn.clan_id as clan_id , abbreviation as tag, wn8 , winrate ,name ,emblems_tank as emblem
         from wn8clan_random wn
         LEFT JOIN clan_all ca ON ca.clan_id = wn.clan_id
         WHERE wn.clan_id IN (SELECT clan_id FROM tmp_clans_cs)
         AND wn8 > 0

         OFFSET ".$iDisplayStart." LIMIT ".$iDisplayLength." ");

        /*return $this->ClanAll()
    			->select(':wn8clan_random.wn8,:wn8clan_random.winrate,clan_all.name, clan_all.clan_id,clan_all.abbreviation')
    			->where(':wn8clan_random.wn8 > ', 0)
                ->where('clan_all.clan_id', $this->ClanCz())
                    ->order(':wn8clan_random.wn8 DESC');
        */
    }

    public function Wn8ClansCount()
    {
       $tmp_clans_cs = $this->pgsql->table('tmp_clans_cs')->select('clan_id');

       return $this->pgsql->table('wn8clan_random')->where('clan_id IN', $tmp_clans_cs)->where('wn8 >', 0)->count('*');
    }

    public function wn8clan($iDisplayStart,$iDisplayLength)
    {
        $s =  $this->Wn8Clans($iDisplayStart,$iDisplayLength);

        foreach($s as $v)
        {
            $pole[] = array('id'=>$v->clan_id, 'rank' => $v->rank, 'znak' => $v->emblem,  'tag' => $v->tag, 'name'=>$v->name, 'wn8'=>$v->wn8,'winrate'=>$v->winrate);
        }

        return $pole;
    }
}
