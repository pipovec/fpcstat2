<?php
namespace App\Model;
use Nette;

/**
 * Provádí operace nad databázovou tabulkou.
 */
class Stronghold extends Nette\Object
{
    /** @var Nette\Database\Connection */
    protected $pgsql;

    public function __construct(Nette\Database\Context $db) {
        $this->pgsql = $db;
    }

    private function Skirmish () {
        return $this->pgsql->table("skirmish");
    }

    function Skirmish6battles() {
        return $this->Skirmish()->where('level',6)->order('battles DESC')->limit(10);            
    }

    function Skirmish6damage() {
        return $this->Skirmish()->where('level',6)->order('damage DESC')->limit(10);            
    }

    function Skirmish8battles() {
        return $this->Skirmish()->where('level',8)->order('battles DESC')->limit(10);            
    }

    function Skirmish8damage() {
        return $this->Skirmish()->where('level',8)->order('damage DESC')->limit(10);            
    }
    
}