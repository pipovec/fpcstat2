<?php

/**
 * Description of wn8
 *  Ocakava pole s nazvami klucov damage_dealt,spotted,frags,dropped_capture_points,wins,tank_id
 *  a hodnoty z tabulky expected_tank_value 
 *  A vrati pole s hodnotami 
 * @author pipovec
 */






class wn8 {
   
  public  $data;
  private $database;
  public  $etv_table;
  
    
    function __construct() {
      $this->GetETVtable();
      
    }
    
    function SetData($data)
    {
        $this->data = $data;
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
        
        $this->etv_table = $table;
    }
    
    private function Step1()
    {
        $tank_id = $this->data['tank_id'];
        /* Ak ma nula bitiek */
        if($this->data['battles'] === 0){$this->data['battles'] = 0.00000000001;}
        
        /* Urobim si priemery na jednu bitku */
        $avgDMG  = $this->data['damage_dealt']/$this->data['battles'];
        $avgSPOT = $this->data['spotted']/$this->data['battles'];
        $avgFRAG = $this->data['frags']/$this->data['battles'];
        $avgDEF  = $this->data['dropped_capture_points']/$this->data['battles'];
        $avgWIN  = $this->data['wins']/$this->data['battles'] * 100;
        
        
        /* Vytiahnem si udaje z tabulky "Expected Tank Values" */
        $expData = $this->etv_table[$tank_id];
        $expDMG  = $expData['dmg'];
        $expSpot = $expData['spot'];
        $expFrag = $expData['frag'];
        $expDef  = $expData['def'];
        $expWin  = $expData['win'];
        
        /* Vypocitam si hodnoty */
        $rDAMAGE = $avgDMG / $expDMG;
        $rSPOT   = $avgSPOT / $expSpot;
        $rFRAG   = $avgFRAG / $expFrag;
        $rDEF    = $avgDEF / $expDef;
        $rWIN    = $avgWIN / $expWin;
        
        
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
        
        return $wn8;
        
    }
}
