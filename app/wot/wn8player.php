<?php

/**
 * Description of wn8player
 * Ocakava $player_data ako array so 6 klucmi: battles,wins,spotted,frags,damage_dealt,dropped_capture_points
 * Ocakava $player_vehicles ako array s klucmi tank_id a  hodnotu pocet bitiek
 * Vrati hodnotu WN8 zaokruhlenu na dve desatinne miesta
 *  
 * @author pipovec
 */






class wn8player {
   
  public  $vehicles;
  public  $user_data;
  public  $etv_table;
  
    
    function __construct($player_data,$player_vehicles) {
      $this->GetETVtable();
      $this->GetVehicles($player_vehicles);
      $this->GetPlayerData($player_data);
      
    }
    
    function GetVehicles($player_vehicles)
    {
        $this->vehicles = $player_vehicles;
    }
    
    function GetPlayerData($player_data)
    {
        $this->user_data = $player_data;
    }
    
    private function GetETVtable()
    {
        include(__DIR__.'/../cron/dsn.php') ;
        $data = $clan->table('expected_tank_value')->fetchAll();
        
        foreach($data as $v)
        {
            $table[$v['tank_id']] = array(  'dmg'   => $v->dmg, 
                                            'spot'  => $v->spot,
                                            'frag'  => $v->frag,
                                            'def'   => $v->def,
                                            'win'   => $v->win);
        }
        
        $conn->disconnect();
        $this->etv_table = $table;
    }
    
    private function Step1()
    {
//        $tank_id = $this->data['tank_id'];
        /* Ak ma nula bitiek */
            
        error_reporting(!E_NOTICE);
        /* Urobim si priemery na jednu bitku */
        $avgDMG  = $this->user_data['damage_dealt'];//$this->user_data['battles'];
        $avgSPOT = $this->user_data['spotted'];//$this->user_data['battles'];
        $avgFRAG = $this->user_data['frags'];//$this->user_data['battles'];
        $avgDEF  = $this->user_data['dropped_capture_points'];//$this->user_data['battles'];
        $avgWIN  = $this->user_data['wins'];//$this->user_data['battles'] * 100;
        
        $expDMG = $expSpot = $expFrag = $expDef = $expWin =0;
        /* Vytiahnem si udaje z tabulky "Expected Tank Values" */
        foreach($this->vehicles as $k=>$v)
        {
            
            $expDMG  += $this->etv_table[$k]['dmg']     * $v;
            $expSpot += $this->etv_table[$k]['spot']    * $v;
            $expFrag += $this->etv_table[$k]['frag']    * $v;
            $expDef  += $this->etv_table[$k]['def']     * $v;
            $expWin  += 0.01 * $this->etv_table[$k]['win']     * $v;
        }
        
       
        /* Vypocitam si hodnoty */
        $rDAMAGE = $avgDMG  / $expDMG;
        $rSPOT   = $avgSPOT / $expSpot;
        $rFRAG   = $avgFRAG / $expFrag;
        $rDEF    = $avgDEF  / $expDef;
        $rWIN    = $avgWIN  / $expWin;
        
        round($rDAMAGE, 4);
        
        $data = array('rDAMAGE' => $rDAMAGE, 'rSPOT' => $rSPOT, 'rFRAG' => $rFRAG, 'rDEF' => $rDEF, 'rWIN' => $rWIN);
       
        
        return $data; 
    }
            
    private function Step2()
    {
        $data = $this->Step1();
        
        $rWINc      = max(0,                                ($data['rWIN']    -0.71)  / (1 - 0.71) );
        $rDAMAGEc   = max(0,                                ($data['rDAMAGE'] -0.22)  / (1 - 0.22) );
        $rFRAGc     = max(0, min($rDAMAGEc + 0.2,           ($data['rFRAG']   -0.12)  / (1 - 0.12)));  
        $rSPOTc     = max(0, min($rDAMAGEc + 0.1,           ($data['rSPOT']   -0.38)  / (1 - 0.38)));
        $rDEFc      = max(0, min($rDAMAGEc + 0.1,           ($data['rDEF']    -0.10)  / (1 - 0.10)));
        
        
        
        $data = array('rWINc' => $rWINc,'rDAMAGEc' => $rDAMAGEc,'rFRAGc' => $rFRAGc,'rSPOTc' => $rSPOTc,'rDEFc' =>$rDEFc );
        
        return $data;
    }
    
    
    public function Step3()
    {
        
        
        
        $data = $this->Step2();
        
        $wn8 =      980*$data['rDAMAGEc'] 
                +   210*$data['rDAMAGEc']*$data['rFRAGc']
                +   155*$data['rFRAGc']* $data['rSPOTc']
                +   75*$data['rDEFc']*$data['rFRAGc']
                +   145*MIN(1.8,$data['rWINc']);
        
        return round($wn8,2);
        
    }
    
    function __destruct() {
        
    }

    
}
