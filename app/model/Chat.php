<?php
namespace App\Model;
use Nette;

class Chat
{
    use Nette\SmartObject;
  
    /** @var Nette\Database\Connection */
    protected $pgsql;

    public function __construct(Nette\Database\Context $db)
    {
        $this->pgsql = $db;
    }

    /** Verejna cast kodu */

    private function Chat()
  	{
  		return $this->pgsql->table('chat');
  	}

    public function ReadChat()
    {
      $chat = $this->Chat()->order('time DESC');
      
      

      foreach($chat as $v)
      {
          $id = 0;
          $time = strftime('%Y/%m/%d %H:%M:%S',strtotime($v->time));
          $nick = $v->nick;
          $text = $v->text;

          //$dotaz = $this->FindAbbreviation($nick);

          $pole[]=array('time' => $time, 'nick' => $nick, 'text' => $text);
      }




      return $pole;
    }

    public function SpracujFormular($form)
    {
        $nick = $form->values->nick;
        $text = $form->values->text;


        $data = array('nick'=>$nick, 'text'=>$text);

        $this->Chat()->insert($data);
        $clan = $this->FindAbbreviation($nick);

        echo $clan;

    }

    private function FindClan($clan_id)
    {
      return $this->pgsql->table('clan_all')->select('abbreviation')->where('clan_id', $clan_id)->fetch();
    }

    // Hlada skratky klanu podla nicku, ak nenajde tak vrati "bez klanu"
    private function FindAbbreviation($nick)
    {
      $dotaz = $this->pgsql->table('players_all')->where('nickname', $nick);
       
      $count = $dotaz->count('*');  
      if($count == 1)
      {
        $clan_id = $dotaz->fetch();
        $clan_id = $clan_id->clan_id;

        $dotaz2 = $this->FindClan($clan_id);

        $return = $dotaz2->abbreviation;

      }
      else
      {
        $return = "bez klanu";
      }


      return $return;
    }

}
