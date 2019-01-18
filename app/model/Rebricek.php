<?php

namespace App\Model;
use Nette;

class Rebricek
{

    use Nette\SmartObject;

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

    public function ClanCzSk()
    {
        return $this->ClanAll()->where('language', 'cs');
    }

    function StatClans($table)
    {
      $query = 'SELECT '.$table.'.rank, '.$table.'.value, '.$table.'.rank_delta, name, clan_all.clan_id, abbreviation FROM clan_all
                LEFT JOIN '.$table.' ON clan_all.clan_id = '.$table.'.clan_id WHERE value > 0 ORDER BY value DESC limit 250';

      return $this->pgsql->query($query);
      /*
        return $this->ClanCzSk()
                ->select($table.'.rank,'.$table.'.value,'.$table.'.rank_delta, name, clan_all.clan_id, abbreviation')
                ->where($table.".value >",0 )
                ->order($table.".value DESC")
                ->limit(500);

            */
    }


    public function Kampan() {
        return $this->pgsql->query("SELECT clan_id FROM clan_all WHERE language = 'cs'");
    }

    public function Wn8Clans($iDisplayStart,$iDisplayLength)
    {

        return $this->pgsql->query("SELECT rank() OVER (ORDER BY wn8 DESC) AS rank ,wn.clan_id AS clan_id , abbreviation AS tag, wn8 , winrate ,name ,emblems_large AS emblem
         FROM wn8clan_random wn
         LEFT JOIN clan_all ca ON ca.clan_id = wn.clan_id
         WHERE ca.language = 'cs'
         AND wn8 > 0
         OFFSET ".$iDisplayStart." LIMIT ".$iDisplayLength." ");
    }

    public function Wn8ClansCount()
    {
       return $this->pgsql->query("SELECT count(*) FROM clan_all ca LEFT JOIN wn8clan_random wn ON ca.clan_id = wn.clan_id WHERE language = 'cs' AND wn8 > 0");
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

    public function StrongholdTanks($level)
    {
        return $this->pgsql->table('skirmish')->where('level',$level)->order('battles DESC')->limit(10);
        /*
        return $this->pgsql->query("SELECT ev.name,stat.tank_id,stat.battles FROM
(SELECT tank_id, sum(battles) as battles
FROM pvs_skirmish_history
WHERE date = current_date - interval '1 day' and tank_id IN (SELECT tank_id FROM encyclopedia_vehicles WHERE level = ".$level.")
GROUP BY tank_id) AS stat
LEFT JOIN encyclopedia_vehicles ev ON stat.tank_id = ev.tank_id
ORDER BY battles DESC LIMIT 9");
*/
    }

    /** Data pre History */

    /** Zistim ci je skratka v databaze */
    function IsClan($skratka): int
    {
        $result = $this->ClanAll()->where('abbreviation ?',$skratka)->count('*');
        return $result;
    }

    function GetId($skratka): int
    {
        $id = $this->ClanAll()->select('clan_id')->where('abbreviation ?',$skratka)->fetch();
        $id = $id->clan_id;
        return $id;
    }

    function GetHistoryData($table, $clan_id)
    {
        $i = 0;
        $result = $this->pgsql->query("SELECT date,value,rank FROM ".$table." WHERE clan_id = ".$clan_id." AND date > current_date - interval '60 days' ");
        //$result = $this->pgsql->table($table)->select("date::date")->select("value")->where('clan_id ?',$clan_id)->limit(60);

        foreach($result as $res) {

            $datum  = date('Y-m-d', strtotime($res->date));
            $data[] =  array($datum,$res->value,$res->rank);
            $i ++;
        }

        return json_encode($data);
    }


}
