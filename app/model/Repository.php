<?php
namespace App\Model;
use Nette;

/**
 * Provádí operace nad databázovou tabulkou.
 */
class Repository
{
  use Nette\SmartObject;

  /** @var Nette\Database\Connection */
    protected $pgsql;

    public function __construct(Nette\Database\Context $db)
    {
        $this->pgsql = $db;
    }

  	function PlayersAll()
  	{
  		return $this->pgsql->table('players_all');
  	}

    function AktualneOdchody2()
    {
      return $this->pgsql->query("SELECT * FROM aktualne_odchody");
    }

    function AktualneOdchody()
    {
      return $this->pgsql->query("SELECT * FROM aktualne_odchody LIMIT 6");
    }

    function CountOdchody()
    {
      return $this->pgsql->query("SELECT count(*) FROM aktualne_odchody");
    }

    function HraciWn8()
    {
      return $this->pgsql->query("SELECT * FROM rebricek_wn8_players LIMIT 6");
    }

    function HraciWn8All()
    {
      return $this->pgsql->query("SELECT * FROM rebricek_wn8_players");
    }

    function CountHraciWn8()
    {
      return $this->pgsql->query("SELECT count(*) FROM rebricek_wn8_players");
    }


    function HraciGr()
    {
      return $this->pgsql->query("SELECT * FROM rebricek_gr_players LIMIT 5");
    }

    function HraciGrAll()
    {
      return $this->pgsql->query("SELECT * FROM rebricek_gr_players");
    }

    function CountHraciGr()
    {
      return $this->pgsql->query("SELECT count(*) FROM rebricek_gr_players");
    }

    function ClanAll()
    {
      return $this->pgsql->table('clan_all');
    }

    private function ClanCz()
    {
      return $this->pgsql->table('tmp_clans_cs');
    }
    private function CrEffe()
    {
      return $this->pgsql->table('cr_efficiency');
    }

    function ClanCz5()
    {
      return $this->ClanAll()->where('clan_id', $this->ClanCz())->order('created_at DESC')->limit(5);
    }

    function ClansEffe()
    {

      return $this->pgsql->query("select c.clan_id, c.abbreviation,c.emblems_small,cr.value, cr.rank, cr.rank_delta from cr_efficiency cr
                                  left join clan_all c on c.clan_id = cr.clan_id
                                  where c.clan_id in (select clan_id from tmp_clans_cs)
                                  order by cr.value DESC
                                  limit 5");
    }
    function CzAccount_id()
    {
      return $this->pgsql->table('cz_players')->select('account_id');
    }

    function Wn8playersCount($search)
    {
      return $this->pgsql->table("players_wn8_cs")->where('nickname LIKE ?', $search)->count('*');
    }

    function wn8players($iDisplayStart,$iDisplayLength,$search)
    {
      /*
      $result = $this->pgsql->query(" SELECT pod.rank, pa.nickname, pod.account_id, pod.wn8::numeric(8,2), ca.abbreviation, ca.emblems_tank
                                      FROM players_all pa
                                      RIGHT JOIN
                                      (SELECT rank() OVER (ORDER BY wn.wn8 DESC) as rank, account_id,  wn.wn8
                                      FROM wn8player wn
                                      WHERE wn.account_id IN (SELECT account_id FROM cz_players)
                                      LIMIT ".$iDisplayLength." OFFSET ".$iDisplayStart.") as pod
                                      ON pa.account_id = pod.account_id
                                      LEFT JOIN clan_all ca ON ca.clan_id = pa.clan_id
                                    ");
      */
      $result = $this->pgsql->table("players_wn8_cs")->where('nickname LIKE ?', $search)->limit($iDisplayLength,$iDisplayStart);

      foreach($result as $v)
      {
        $pole[] = array('rank'=>$v->rank,'nick'=>$v->nickname,'id'=>$v->account_id,'wn8' => $v->wn8,'tag'=>$v->abbreviation);
      }

      return $pole;
    }

    function wn8player_history($nickname)
    {
      return $this->pgsql->query("SELECT w.date, w.wn8 FROM players_all pa LEFT JOIN wn8player_history w ON w.account_id = pa.account_id WHERE nickname='".$nickname."' ORDER BY date DESC");
    }

    function ChangeNick()
    {
      return $this->pgsql->query("SELECT timestamp, nick, nickname FROM changed_players_nick ORDER BY timestamp DESC LIMIT 10");
    }

    function FindPlayer($nick)
    {
      return $this->pgsql->query("SELECT * FROM players_all WHERE nickname = '".$nick."'");
    }

    function PlayersPass()
    {
      return $this->pgsql->table('players_pass');
    }

    function Stats()
    {
      return $this->pgsql->table('stats');
    }
}
