<?php

use App\People;
use Src\Database\Connect;

include_once __DIR__."/vendor/autoload.php";
$wilton = new People("wilton Costa reis", "", true, "wiltonmeg4@gmail.com", "61841169323");

$listPeople = $wilton->listPeople();

echo "<pre>";
var_dump($listPeople);
echo "</pre>";