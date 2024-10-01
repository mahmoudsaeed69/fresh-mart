<?php

$dsn = "mysql:host=localhost; dbname=courses";
$user = "root";
$pass = "";
$option = array(

    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET Names utf8'
);

try {
    $con = new PDO($dsn, $user, $pass, $option);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


} catch (PDOEXCEPTION $m) {


    echo "you are filed to connect " . $m->getmessage();

}




?>