<?php
use Nette\Object;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Spracovanie data zo server Wargaming pre hracov rating
 *
 * @author pipovec
 */
class rating {
    public $data;
    public $id;


    public function __construct($data, $id)
            {
                $this->data = $data;
                $this->id   = $id;
            }
   
   public function rating()
           {
                $data   = $this->data;
                $id     = $this->id;
                
                $battles_place              = $data['data'][$id]['battles']['place'];
                $battles_value              = $data['data'][$id]['battles']['value'];
                $battle_avg_xp_place        = $data['data'][$id]['battle_avg_xp']['place'];
                $battle_avg_xp_value        = $data['data'][$id]['battle_avg_xp']['value'];
                $battle_wins_place          = $data['data'][$id]['battle_wins']['place'];
                $battle_wins_value          = $data['data'][$id]['battle_wins']['value'];
                //Percento vyhier a celkove miesto 
                $battle_avg_performance_place   = $data['data'][$id]['battle_avg_performance']['place'];
                $battle_avg_performance_value   = $data['data'][$id]['battle_avg_performance']['value'];
                $frags_place                = $data['data'][$id]['frags']['place']; 
                $frags_value                = $data['data'][$id]['frags']['value'];
                $spotted_place              = $data['data'][$id]['spotted']['place']; 
                $spotted_value              = $data['data'][$id]['spotted']['value'];
                $dropped_ctf_points_place   = $data['data'][$id]['dropped_ctf_points']['place'];
                $dropped_ctf_points_value   = $data['data'][$id]['dropped_ctf_points']['value'];
                $ctf_points_place           = $data['data'][$id]['ctf_points']['place'];
                $ctf_points_value           = $data['data'][$id]['ctf_points']['value'];
                $damage_dealt_place         = $data['data'][$id]['damage_dealt']['place'];
                $damage_dealt_value         = $data['data'][$id]['damage_dealt']['value'];
                $xp_place                   = $data['data'][$id]['xp']['place']; 
                $xp_value                   = $data['data'][$id]['xp']['value'];
                
                $rating =  array(   'battles_place' =>  $battles_place, 'battles_value' => $battles_value, 
                                    'battle_avg_xp_place'=>$battle_avg_xp_place, 'battle_avg_xp_value'=>$battle_avg_xp_value,
                                    'battle_wins_place'=>$battle_wins_place,'battle_wins_value'=>$battle_wins_value,
                                    'battle_avg_performance_place'=>$battle_avg_performance_place,'battle_avg_performance_value'=>$battle_avg_performance_value,
                                    'spotted_place'=>$spotted_place,'spotted_value'=>$spotted_value,
                                    'dropped_ctf_points_place'=>$dropped_ctf_points_place, 'dropped_ctf_points_value'=>$dropped_ctf_points_value,
                                    'ctf_points_place'=>$ctf_points_place,'ctf_points_value'=>$ctf_points_value,
                                    'damage_dealt_place'=>$damage_dealt_place,'damage_dealt_value'=>$damage_dealt_value,
                                    'xp_place'=>$xp_place, 'xp_value'=>$xp_value, 
                                    'frags_place'=>$frags_place, 'frags_value'=>$frags_value);
                
               return $rating;
           }
    
           
    
    
                
}
