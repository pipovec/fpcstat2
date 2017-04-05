<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of heavy
 *
 * @author deamon
 */
use Nette\Database\Connection;
use Nette\Database\Context;


class Tanks {
    
    
    
    
    private function Conn()
    {
        $user = "deamon";
        $password = "sedemtri";
        $dsn = 'pgsql:host=127.0.0.1; dbname=clan'; 
        
        $connection = new Connection($dsn, $user, $password);
        return $connection;
    }
    
    private function Database()
    {
        $database = new Context($this->Conn());
        return $database;
    }
    
    public function tanks($clan_id, $type)
    {
        return $this->Database()->query("select ev.name_i18n as name, count(ev.name_i18n) as pocet from players p join player_vehicles pv ON p.account_id = pv.account_id join encyclopedia_vehicles ev "
                            . " ON pv.tank_id = ev.tank_id WHERE p.clan_id = ".$clan_id." and ev.level = 10 and ev.type = '".$type."' GROUP BY ev.name_i18n ORDER BY pocet DESC");
    }
    
    
    
}
    
    require __DIR__ . '/../../../vendor/autoload.php';
    
    $clan_id = 500000665;
    $type = "heavyTank";
    
    $t = new Tanks($clan_id, $type);
    $res  = $t->tanks($clan_id, $type);
//    print_r(__DIR__);
    
    $latte = new Latte\Engine;
    $data['blbost'] = $res;
    $latte->setTempDirectory(__DIR__.'/temp');
    $latte->render('tanks.latte', $data);