<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClansRatingsClass
 *
 * @author deamon
 */
include(__DIR__.'/SendCurl.php');

class ClansRatingsClass extends SendCurl 
{
    
    function ClansRatings($post)
    {
        $method = '/clanratings/clans/';
        $data = parent::SendWot($method, $post);
        $result = json_decode($data, true);
        return $result;
        
    }
    
    
    
    
    
    
    
}
