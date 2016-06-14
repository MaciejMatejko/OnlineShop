<?php
session_start();
require_once __DIR__.'/src/connection.php';
function __autoload($classname) {
    $filename = "./src/". $classname .".php";
    require_once($filename);
}

$user=new User();
$user->loadUserFromDB($conn, 1);

var_dump($user);

$h=$user->getOrdersHistory($conn);
var_dump($h);

var_dump(User::login($conn, "kowalski@gmail.com", "admin"));