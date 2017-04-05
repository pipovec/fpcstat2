<?php
use Nette\Object;
use Nette\Database;
use Nette\Database\Connection;
use Nette\Database\Context;
//include ".\cron\dsn.php";

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of colors
 *
 * @author deamon
 */
class colors {
    
   public $max ;
    
   public function __construct($table, $column, $value, Nette\Database\Connection $db)
   {
       $this->pgsql = $db;
       $this->table = "clan.".$table;
       $this->column = "max(".$column.")";
       $this->value = $value;
       $this->max = $this->selectMax();
   }
  

   function selectTable()
   {
       return $this->pgsql->context->table($this->table);
   }
   
   function selectMax()
   {
       $maxValue = $this->selectTable()->select($this->column)->fetch();
       $max = $maxValue['max'];
       return $max;
   }
   
  
   
   function percent()
   {
       $percent = $this->max * 0.1111;
       return $percent;
   }
   
   function selectColors()
   {
       if       ($this->value <  $this->percent()*1.1111){$background = "000000";}
       elseif   ($this->value <= $this->percent()*2.2222){$background = "5e0000";}
       elseif   ($this->value <= $this->percent()*3.3333){$background = "cd3333";}
       elseif   ($this->value <= $this->percent()*4.4444){$background = "d7b600";}
       elseif   ($this->value <= $this->percent()*5.5555){$background = "6d9521";}
       elseif   ($this->value <= $this->percent()*6.6666){$background = "4c762e";}
       elseif   ($this->value <= $this->percent()*7.7777){$background = "4a92b7";}
       elseif   ($this->value <= $this->percent()*8.8888){$background = "83579d";}
       elseif   ($this->value > $this->percent()*8.8888){$background = "5a3175";}
       
    return $background ;
   }
   
}
