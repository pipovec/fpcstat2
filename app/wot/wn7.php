<?php


/**
 * Description of wn7
 *  Ocakava pole s hodnotami avgtier, avgfrags, avgdmg, avgdmg, avgwin, avgtier, battles
 *  A vrati pole s hodnotami 
 * @author pipovec
 */


class wn7 {
   
    public $data;
      
   public function __construct($data) {
       $this->data = $data;
   }
   
   function wn7frags()
   {
          $avgtier  = $this->data['avgtier'];
          $avgfrags = $this->data['avgfrags'];
                if($avgtier >=6){$normtier = 6;}
                    else {$normtier = $avgtier;}

                    $mocnina = pow($normtier,0.164);
                    $wn7frags = (1240-(1040/$mocnina))*$avgfrags;

          return $wn7frags;
      }
   
   function wn7dmg()
      {
          $avgtier      = $this->data['avgtier'];
          $avgdamage    = $this->data['avgdmg'];
          
          $exp          = pow(exp(1),($avgtier*0.24));

          $wn7dmg = $avgdamage*530/(184*$exp + 130);

          return $wn7dmg;
      }
   
  function wn7spot()
      {
          $avgtier      = $this->data['avgtier'];
          $avgspot      = $this->data['avgspot'];
            if($avgtier < 3 ){$normtier = $avgtier ;}
                    else {$normtier = 3;}
                    
          $wn7spot = $avgspot * 125 * $normtier / 3; 
      
          return $wn7spot;
      }
  
   function wn7def()
      {

          $avgdef       = $this->data['avgdef'] ;
          
            if($avgdef >=2.2){$normdef = 2.2;}
                    else {$normdef = $avgdef;}
            $avgdef = $normdef * 100;
           
            return $avgdef;

      }   
      
   function wn7wr()
      {
     
            $avgwin       = $this->data['avgwin'] ;
            $exp          = pow(exp(1),($avgwin-35)*(-0.134));
            $wn7wr = ((185/(0.17 + $exp )) - 500)* 0.45;      
    
            return $wn7wr; 
     }
     
    function wn7malus()
     {
         $avgtier      = $this->data['avgtier'];
         $battles      = $this->data['battles']; 
         
         if($avgtier < 5){$normtier = $avgtier;}
        else{
            $normtier = 5;
            }
            $e1 = ($avgtier - (pow(($battles / 200),(3/$avgtier)))*1.5);
            $exp = (1 + pow(exp(1), $e1));
            $malus   =   ((5 - $normtier)*125)/$exp;
    
        return $malus;
     
    }
    function wn7()
    {
        $wn7 = $this->wn7def() +$this->wn7dmg()+ $this->wn7frags() + $this->wn7malus() + $this->wn7spot() +$this->wn7wr();
        return $wn7;
        
    }
    
    function background()
    {
        if    ($this->wn7()<=500)   {$background = "000000";}
        elseif($this->wn7()<=699)   {$background = "5e0000";}
        elseif($this->wn7()<=899)   {$background = "cd3333";}
        elseif($this->wn7()<=1099)  {$background = "d7b600";}
        elseif($this->wn7()<=1349)  {$background = "6d9521";}
        elseif($this->wn7()<=1499)  {$background = "4c762e" ;}
        elseif($this->wn7()<=1699)  {$background = "4a92b7";}
        elseif($this->wn7()<=1999)  {$background = "83579d";}
        elseif($this->wn7()>=2000)  {$background = "5a3175";}
        
        return $background;
    }
    
    function formulawn7()
    {
        $formulawn7 = array(    'wn7frags' => $this->wn7frags(),
                                'wn7dmg' => $this->wn7dmg(),
                                'wn7spot' => $this->wn7spot(),
                                'wn7def'=> $this->wn7def(),
                                'wn7winrate' => $this->wn7wr(), 
                                'wn7malus'=>$this->wn7malus(),
                                'wn7' => $this->wn7(),
                                
                            );
        
        return $formulawn7;
    }
    
    
}
