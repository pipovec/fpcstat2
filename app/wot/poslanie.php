<?php
require_once (__DIR__.'/wn8player.php');

$data = new wn8player(504279883);
$wn8  = $data->Step3();

echo "\n WN8 === ".$wn8."\n";
