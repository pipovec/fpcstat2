<?php

/*
* To change this license header, choose License Headers in Project Properties.
* To change this template file, choose Tools | Templates
* and open the template in the editor.
*/

/**
* Posielanie dotazov na WG metodou POST
*
* @author pipovec
*/

/*
* Oproti json3 sa len zmenila URL teraz $server2
*
* zatial by mali fungovat metody:
* CLANS
* api.worldoftanks.eu/wgn/clans/list
* api.worldoftanks.eu/wgn/clans/info
* pi.worldoftanks.eu/wgn/clans/membersinfo
* api.worldoftanks.eu/wgn/clans/glossary
*
*
*/

class json4 {
    
    
    private $server2        = "https://api.worldoftanks.eu/wgn";
    
    private $api_id         = 'c428e2923f3d626de8cbcb3938bb68f8';
    private $language       = 'cs';
    
    private function SendRequest($method, $fields_string)
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
        $result = $this->SendRequest($method, $fields_string);
        
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