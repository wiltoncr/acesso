<?php

use App\Classes\Connect;
use App\Classes\People;
use Src\Database\Connect as DatabaseConnect;

include_once __DIR__."/vendor/autoload.php";

$wilton = new App\People("Wilton", "costa", true, "wilton@gmail.com", "61841169323");
$db = new DatabaseConnect();
echo "Teste de projeto {$wilton->getname()} </br>";
echo "<pre>";
var_dump($wilton);
echo "</pre>";
$db->connect();