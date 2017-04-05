<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of HistoryControl
 *
 * @author deamon
 * 
 * 
 * 
 * 
 */

use Nette\Application\UI;
use Nette\Database\Connection;
use Nette\Database\Context;

class HistoryControl  extends UI\Control {

    private $pgsql;
    private $account_id;
    
    
    
    function Role(){
        return $this->pgsql->table('members_role');
    }
    
    function setAccount_id($account_id){
        $this->account_id = $account_id;
    }
    
    function setConnection($conn){
        return $this->pgsql = $conn;
    }

    function History_Role(){
        
        return $this->pgsql->query("select c.abbreviation as abbre, c.emblems_medium, m.clan_id as id, m.role as role, m.odkedy, m.dokedy from members_role as m left join clan_all as c on m.clan_id = c.clan_id where account_id = ".$this->account_id);
                
    }
            
    
    
    
    
    
    
    function render(){
        $this->template->history_role       = $this->History_Role();
        $this->template->setFile(__DIR__.'/history.latte');
        $this->template->render();        
        
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
}
