<?php

use Source\Models\User;

include_once __DIR__."/Source/autoload.php";

$user = new User();

$wilton = $user->find("wiltonmeg4@gmail.com");

echo "<pre>";
var_dump($wilton->data());
echo "</pre>";