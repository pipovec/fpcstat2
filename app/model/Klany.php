<?php

namespace App\Model;
use Nette\Utils\Json,
    Nette;

class Klany extends Nette\Object
{
	/** @var Nette\Database\Connection */
    protected $pgsql;

    public function __construct(Nette\Database\Context $db)
    {
        $this->pgsql = $db;
    }

    
    private function ClanAll()
    {
        return $this->pgsql->table('clan_all');
    }
   
    public function KlanyCz()
    {
        
        return $this->ClanAll()->where('language', 'cs');
        

    }

}