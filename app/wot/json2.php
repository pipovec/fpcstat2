<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of json2
 *
 * @author deamon
 */


class json2 {
    
    public $url;
    public $api_id        = "c428e2923f3d626de8cbcb3938bb68f8&language=cs";

    public $api_id_sa     = "883ff6ceefb13177357ffea34d6fb06f&language=cs";
    public $api_server    = "https://api.worldoftanks.eu";
     
     
   private function json(){
       $k = 0;
       $c = 0;
       
       
       do
       {
        
           $json = @file_get_contents($this->url);

           if($json === false)
           {$c++; echo $c."\n";  sleep(5); $json = false;}
           else 
           {$k = 2;}
           
           sleep(0.5);     
           
       }while($k < 1);
       
       return $json;
   } 
   
   public function data($url){

        $this->url = $url;
        
        $json = $this->json();
        $data = json_decode($json, true);
       
       return $data;
   }
   
   public function status(){
       $stat = $this->data();
       $status = $stat['status'];
       return $status;
   }
   
   public function count(){
       $stat = $this->data();
       $status = $stat['count'];
       return $status;
   }
   
   
 
}
