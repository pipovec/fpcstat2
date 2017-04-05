<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Posielanie dotazov na WG metodou POST
 *
 * @author deamon
 */
class json3 {
    
private $server         = "https://api.worldoftanks.eu/wot";
private $server2        = "https://api.worldoftanks.eu/wgn";

private $api_id         = 'c428e2923f3d626de8cbcb3938bb68f8';
private $language       = 'cs';

    private function SendRequest($method, $fields_string)
    {

        $server = $this->server.$method;
        $sleep = 0;
        
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,  $server);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$fields_string);

        do{
        sleep($sleep);    
        $result = curl_exec($ch);
        if($result === false)
            {echo 'Curl error: ' . curl_error($ch)." cas je nastaveny na ".$sleep." \n";}
        $sleep = $sleep + 2;
        if($sleep > 20){die('Vyplo sa to po casovom limite na SendRequest');}
        }
        while($result === false);
        
            
        curl_close($ch);

        return $result;
    }
    
    
    /* Poslanie CURL cez http://api.worldoftanks.eu/wgn */
    private function SendRequest2($method, $fields_string)
    {

        
        $server = $this->server2.$method;
        $sleep = 0;
        
        
        
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,  $server);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$fields_string);

        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }
    
    private function BasicFields()
    {
        $fields = array(
                    'application_id'=>  $this->api_id,
                    'language'=>        $this->language,
                     );

        return $fields;

    }

    private function Fields_string($fields)
    {
        $fields_string = null;
        $basic = $this->BasicFields();

        foreach($fields as $k=>$v){$basic[$k] = $v;}
        
        
        foreach($basic as $key=>$value){ $fields_string .= $key.'='.$value.'&'; }
    
        $fields_string = rtrim($fields_string,'&');
        
        
    return $fields_string;    
    }
    
    function Send($method, $fields){
        
        $fields_string = $this->Fields_string($fields);
        $k = 0;
        
        do{
            $result = $this->SendRequest($method, $fields_string);
            
            $json = json_decode($result, true);
            $status = $json['status'];
            
            
            switch($status){
                case "ok": 
                    $k = 1; break;
                case "error":
                    $k = 0; echo 'Chyba: '.$json['error']['message'].' field: '.$json['error']['field']."\n";break;
            }
        }
        while($k === 0);
            
        return $result;    
            
        }
    
    function Send2($method, $fields){
        
        $fields_string = $this->Fields_string($fields);
        $k = 0;
        
        do{
            $result = $this->SendRequest2($method, $fields_string);
            
            $json = json_decode($result, true);
            $status = $json['status'];
            
            
            switch($status){
                case "ok": 
                    $k = 1; break;
                case "error":
                    $k = 0; echo 'Chyba: '.$json['error']['message'].' field: '.$json['error']['field']."\n";break;
            }
        }
        while($k === 0);
            
        return $result;    
            
        }    
        
    function GetJson($method, $fields){
        
        $fields_string = $this->Fields_string($fields);
        $k = 0;
        $sleep = 0;
        
        do{
            sleep($sleep);
            $result = $this->SendRequest($method, $fields_string);
            
            if($sleep > 60){die('Vyplo sa to po casovom limite na GetJson');}
            $json = json_decode($result, true);
            
            $status = $json['status'];
            if($status != 'ok')
            {echo "Chyba json: ".$json['error']['message']." pole ".$json['error']['field']."\n";}
            $sleep = $sleep + 2;
            switch($status){
                case "ok": 
                    $k = 1; break;
                case "error":
                    $k = 0; break;
            }
        }
        while($k === 0);
            
        return $json; 
        
        
        
    }    
        
        
        
        
    
        
        
    
}
