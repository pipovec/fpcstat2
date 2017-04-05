<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Nova metoda dotazujuca sa pomoucou JSON4.PHP a Wargaming.NET
 *
 * @author pipovec
 */

require_once(__DIR__.'/SendCurl.php');

class Accounts extends SendCurl
{

	function PlayersPersonalData($post)
	{	
		$method = '/account/info/';
        $data = parent::SendWot($method, $post);
        $result = json_decode($data, true);

        return $result;

	}


}