<?php

/*
 * Metoda na nacitenie tankov zo servera
 */

/**
 * Description of Tankopedia
 *
 * @author boris
 */

include(__DIR__.'/SendCurl.php');

class Tankopedia extends SendCurl
{
    function ListOfVehicles($post)
    {
        /*
         * Nacita data z metody /encyclopedia/tanks/
         */
        
        $method = '/encyclopedia/tanks/';
        $data = parent::SendWot($method, $post);
        $result = json_decode($data, true);
        return $result;
           
    }
    
    
    
}
