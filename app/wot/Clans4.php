<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Nova metoda dotazujuca sa pomoucou JSON4.PHP a Wargaming.NET
 *
 * @author deamon
 */

require_once(__DIR__.'/SendCurl.php');

class Clans4 extends SendCurl
{
    function Clans($post)
    {
        /*
         * Informacie o vsetkych klanoc zrejme len aktivnych rozdelenych po 100 na jeden dotaz
         */
        
        $method = '/clans/list/';
        $data = parent::SendWGN($method, $post);
        $result = json_decode($data, true);
        return $result;
           
    }
    
    function ClansDetails($post)
    {
        $method = '/clans/info/';
        $data = parent::SendWGN($method, $post);
        $result = json_decode($data, true);
        return $result;
           
    }
    
    function ClansMember($fields, $account_id)
    {
        $method = '/clans/membersinfo/';
        $fields = array('fields'=> $fields, 'account_id'=>$account_id);
        
        $data = parent::SendWGN($method, $fields);
        $result = json_decode($data, true);
        return $result;
           
    }
    
    function ClansGlossary($fields)
    {
        $method = '/clans/glossary/';
        $fields = array('fields'=> $fields);
        
        $data = parent::SendWGN($method, $fields);
        $result = json_decode($data, true);
        return $result;
           
    }
    
    function ClansRating($fields, $clan_id)
    {
        $method = '/clanratings/clans/';
        $fields = array('fields'=> $fields, 'clan_id'=>$clan_id);
        
        $data = parent::SendWot($method, $fields);
        $result = json_decode($data, true);
        return $result;
        
    }
}
