<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of cw_sutaz
 *
 * @author deamon
 */
include(__DIR__.'/./json2.php') ;

/* include '/home/deamon/www/app/wot/json.php'; */
date_default_timezone_set('Europe/Bratislava');
 




class cw_sutaz extends json2 {
    
    
    public $pdo_pgdsn     = "pgsql:host=37.205.11.183 port=5432 dbname=clan user=deamon password=sedemtri"; 
    /* public $api_server = "http://api.worldoftanks.eu"; */
    /* public $api_id     = "c226f10395fdfcde08e0dc5c71926eac&language=cs";   */
    


    public function pripojenie()
    {
        
        $conn = new PDO($this->pdo_pgdsn);
        if ($conn->errorCode()) {
            print_r($conn->errorInfo());
        }
        
        return $conn;
    }
    
    
    
    
    function vyber_hracov_klanu($klan) {
       
        $conn = $this->pripojenie();
        $account_ids = NULL;
        
        $accounts = $conn->query("SELECT account_id FROM members WHERE klan= '" . $klan . "'");
        if ($accounts == FALSE) {
            die('Neprisli udaje z tabulky clan.tmp_members');
        }


        foreach ($accounts as $id) {
            $account_ids .= $id['account_id'] . ",";
        }

        return $account_ids;
    }
    
    function vyber_pociatok($account_id)
    {
        $conn   = $this->pripojenie();
        $result = $conn->query("select * from tmp_cw_jun where account_id =".$account_id."");
        
        return $result;
        
        
        
    }

    function poslanie_json($account_ids) {
        $url = $this->api_server."/wot/account/info/?application_id=" . $this->api_id . "&account_id=" . $account_ids;

        //      poslanie Json na server
        $result = parent::data($url);
	
	

        //  Kontrola ci prisli data v poriadku
        if ($result['status'] != "ok")
            die('Neprisli udaje z API');

        return $result;
    }

    function zaciatok() {

        /* Nacitanie pociatocnych hodnot 13.5.2014 cca o 18.00 hod pre istotu som tam dal aj S-FPC*/
        $conn = $this->pripojenie();
        
        $insert_stat_clan = 'INSERT INTO tmp_cw_jun'
                . '(spotted,hits,battle_avg_xp,draws,wins,losses,capture_points,battles,damage_dealt,'
                . 'hits_percents,damage_received,shots,xp,frags,survived_battles,dropped_capture_points,'
                . 'account_id,date)'
                . ' VALUES '
                . '(:spotted,:hits,:battle_avg_xp,:draws,:wins,:losses,:capture_points,:battles,:damage_dealt,'
                . ':hits_percents,:damage_received,:shots,:xp,:frags,:survived_battles,:dropped_capture_points,'
                . ':account_id,:date)';
        
        


        $ins_stat_clan = $conn->prepare($insert_stat_clan);
        if ($ins_stat_clan == FALSE) {
            die('Nespravne definovany prepared statment');
        }

        $account_ids = $this->vyber_hracov_klanu("FPC");
        $data = $this->poslanie_json($account_ids);

        $data = $data['data']; 
        $date = date('Y-m-d',time());;
        
        foreach($data as $v )
        {
            
            $insert_clan = array(
            ':spotted' => $v['statistics']['clan']['spotted'],
            ':hits' => $v['statistics']['clan']['hits'],
            ':battle_avg_xp' => $v['statistics']['clan']['battle_avg_xp'],
            ':draws' => $v['statistics']['clan']['draws'],
            ':wins' => $v['statistics']['clan']['wins'],
            ':losses' => $v['statistics']['clan']['losses'],
            ':capture_points' => $v['statistics']['clan']['capture_points'],
            ':battles' => $v['statistics']['clan']['battles'],
            ':damage_dealt' => $v['statistics']['clan']['damage_dealt'],
            ':hits_percents' => $v['statistics']['clan']['hits_percents'],
            ':damage_received' => $v['statistics']['clan']['damage_received'],
            ':shots' => $v['statistics']['clan']['shots'],
            ':xp' => $v['statistics']['clan']['xp'],
            ':frags' => $v['statistics']['clan']['frags'],
            ':survived_battles' => $v['statistics']['clan']['survived_battles'],
            ':dropped_capture_points' => $v['statistics']['clan']['dropped_capture_points'],
            ':account_id' => $v['account_id'],
            ':date' => $date
        );
            /* Vlozenie dat do databazy */
            
            
            $newbie = $conn->query("SELECT account_id FROM tmp_cw_jun where account_id=".$v['account_id']."");
            if($newbie->rowCount() == 0)
            {
                $ins_stat_clan->execute($insert_clan);
                echo 'Pridany novacik account_id : '.$v['account_id'];
            }
            
            
            
            
        }
        
        


        
        
    }
    
    
    function priebeh()
    {
        
        $conn = $this->pripojenie();
        
        $insert_stat_clan = 'INSERT INTO tmp_cw_priebeh_jun'
                . '(spotted,hits,battle_avg_xp,draws,wins,losses,capture_points,battles,damage_dealt,'
                . 'hits_percents,damage_received,shots,xp,frags,survived_battles,dropped_capture_points,'
                . 'account_id,date)'
                . ' VALUES '
                . '(:spotted,:hits,:battle_avg_xp,:draws,:wins,:losses,:capture_points,:battles,:damage_dealt,'
                . ':hits_percents,:damage_received,:shots,:xp,:frags,:survived_battles,:dropped_capture_points,'
                . ':account_id,:date)';
        
        
        $update = "UPDATE tmp_cw_priebeh_jun"
                . " SET spotted = :spotted,hits = :hits, battle_avg_xp = :battle_avg_xp, draws = :draws, wins = :wins, losses = :losses, capture_points =:capture_points, battles=:battles,"
                . " damage_dealt= :damage_dealt, hits_percents = :hits_percents, damage_received = :damage_received, shots = :shots, xp = :xp, frags = :frags, survived_battles = :survived_battles,"
                . " dropped_capture_points = :dropped_capture_points, date = :date "
                . " WHERE account_id = :account_id";

        $ins_stat_clan = $conn->prepare($insert_stat_clan);
        if ($ins_stat_clan == FALSE) {
            die('Nespravne definovany prepared statment');
        }
        
        $update_clan = $conn->prepare($update);
        if ($update_clan == FALSE) {
            die('Nespravne definovany prepared statment');
        }

        $account_ids = $this->vyber_hracov_klanu("FPC");
        $data = $this->poslanie_json($account_ids);

        $data = $data['data']; 
        $date = date('Y-m-d H:i:s',time());;
        
       
        foreach($data as $v )
        {
            
            
            
            /* Ake mal hrac pociatocne hodnoty */
            $account_id = $v['account_id'];
           
            $pociatok = $this->vyber_pociatok($account_id)->fetch();
            
            
                
                
                $spotted            = $v['statistics']['clan']['spotted'] - $pociatok['spotted'];
                $hits               = $v['statistics']['clan']['hits'] - $pociatok['hits'];
                $battle_avg_xp      = $v['statistics']['clan']['battle_avg_xp'] - $pociatok['battle_avg_xp'];
                $draws              = $v['statistics']['clan']['draws'] - $pociatok['draws'];
                $wins               = $v['statistics']['clan']['wins'] - $pociatok['wins'];
                $losses             = $v['statistics']['clan']['losses'] - $pociatok['losses'];
                $capture_points     = $v['statistics']['clan']['capture_points'] - $pociatok['capture_points'];
                $battles            = $v['statistics']['clan']['battles'] - $pociatok['battles'];
                $damage_dealt       = $v['statistics']['clan']['damage_dealt'] - $pociatok['damage_dealt'];
                $hits_percents      = $v['statistics']['clan']['hits_percents'] - $pociatok['hits_percents'];
                $damage_received    = $v['statistics']['clan']['damage_received'] - $pociatok['damage_received'];
                $shots                      = $v['statistics']['clan']['shots'] - $pociatok['shots'];
                $xp                         = $v['statistics']['clan']['xp'] - $pociatok['xp'];
                $frags                      = $v['statistics']['clan']['frags'] - $pociatok['frags'];
                $survived_battles           = $v['statistics']['clan']['survived_battles'] - $pociatok['survived_battles'];
                $dropped_capture_points     = $v['statistics']['clan']['dropped_capture_points'] - $pociatok['dropped_capture_points'];
                
                
                
                
           
            
            
            $insert_clan = array(
            ':spotted' => $spotted,
            ':hits' => $hits,
            ':battle_avg_xp' => $battle_avg_xp,
            ':draws' => $draws,
            ':wins' => $wins,
            ':losses' => $losses,
            ':capture_points' => $capture_points,
            ':battles' => $battles,
            ':damage_dealt' => $damage_dealt,
            ':hits_percents' => $hits_percents,
            ':damage_received' => $damage_received,
            ':shots' => $shots,
            ':xp' => $xp,
            ':frags' => $frags,
            ':survived_battles' => $survived_battles,
            ':dropped_capture_points' => $dropped_capture_points,
            ':account_id' => $v['account_id'],
            ':date' => date('Y-m-d H:i:s',time())
        );
            /* Vlozenie dat do databazy */
            
            
            $newbie = $conn->query("SELECT account_id FROM tmp_cw_priebeh_jun where account_id=".$v['account_id']."");
            if($newbie->rowCount() == 0)
            {
                $ins_stat_clan->execute($insert_clan);
                echo 'Pridany novacik account_id : '.$v['account_id'];
            }
            else
            {
                $update_clan->execute($insert_clan);
                
                               
            }
            
            
            
        }    
           
        
        
    }
    

}
