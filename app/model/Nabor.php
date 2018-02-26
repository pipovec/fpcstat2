<?php
namespace App\Model;
use Nette;

class Nabor 
{
    use Nette\SmartObject;
    
    /** @var Nette\Database\Connection */
    protected $pgsql;

    public function __construct(Nette\Database\Context $db)
    {
        $this->pgsql = $db;
    }

    public function nabor3()
    {
        return $this->pgsql->table('nabor_new');
    }

    public function celkom()
    {
        return $this->nabor3()->count('*');
    }

}