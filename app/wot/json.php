<?php
use Nette\Object;


class json {
    public $url;
    
   
   public function __construct($url) {
       $this->url = $url;
   } 
   
   protected function json(){
       $json = file_get_contents($this->url);
       return $json;
   } 
   
   public function data(){
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
