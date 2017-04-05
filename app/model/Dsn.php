<?php

namespace App\Model;
use Nette\Utils\Json,
    Nette;

class Dsn extends Nette\Object
{
	
    private $api_id     = 'application_id=c428e2923f3d626de8cbcb3938bb68f8';
    private $server_wgn = "https://api.worldoftanks.eu/wgn";
    private $server_wot = 'https://api.worldoftanks.eu/wot';
    

    private function SendRequest($server,$post)
    {
        
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,  $server);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$post);

        $result = curl_exec($ch);
        curl_close($ch);
        
        return $result;
    }
    
    private function PostData($post)
    {
        
        $post_data      = "";
        $post_data      = $this->api_id.$post_data;
        
        foreach($post as $key => $value)
            { 
                $post_data  .= '&'.$key.'='.$value;
            }
    
        return $post_data;    
    }
    
    public function SendWGN($method, $post)
    {
        $sm         = $this->server_wgn.$method.$this->api_id;
        
        $post_data  = $this->PostData($post);
        $result     = $this->SendRequest($sm, $post_data);
        
        return $result;    
            
    }
    
    public function SendWot($method, $post)
    {
        
        $sm         = $this->server_wot.$method.$this->api_id;
        
        $post_data  = $this->PostData($post);
        $result     = $this->SendRequest($sm, $post_data);
        
        return $result;    
            
    }

}