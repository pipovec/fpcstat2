<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of rating2
 *
 * @author pipovec
 */

include 'json2.php';
class rating2 extends json2{
    
    function types()
    {
        $url = $this->api_server."/wot/ratings/types/?application_id=".$this->api_id;
        $data = parent::data($url);
        $data = $data['data'];
        
        return $data;
    }
    
   function battles_delta($account_id, $type)
   {    
       $field = 'battles_count.value';

       $url = $this->api_server."/wot/ratings/accounts/?application_id=".$this->api_id."&fields=".$field."&account_id=".$account_id."&type=".$type;
          $data = parent::data($url);
            
            return $data;
   }
    
  function players_ratings($account_id,$type)
  {
      $field =  
               'battles_count.rank,battles_count.value,'
              . 'damage_avg.rank,damage_avg.value,'
              . 'damage_dealt.rank,damage_dealt.value,'
              . 'frags_avg.rank,frags_avg.value,'
              . 'frags_count.rank,frags_count.value,'
              . 'hits_ratio.rank,hits_ratio.value,'
              . 'spotted_avg.rank,spotted_avg.value,'
              . 'spotted_count.rank,spotted_count.value,'
              . 'survived_ratio.rank,survived_ratio.value,'
              . 'wins_ratio.rank,wins_ratio.value,'
              . 'xp_amount.rank,xp_amount.value,'
              . 'xp_avg.rank,xp_avg.value,'
              . 'xp_max.rank,xp_max.value';
              
      
      
      $url = $this->api_server."/wot/ratings/accounts/?application_id=".$this->api_id."&fields=".$field."&account_id=".$account_id."&type=".$type;
      $data = parent::data($url);
      
      return $data;
  }
   
}
