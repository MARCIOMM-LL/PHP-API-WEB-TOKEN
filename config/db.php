<?php

/** START --------------------------------------------------------------------------- */
/** DATABASE CONNECTION */
$servername = 'localhost';
$username = 'root';
$password = 'P@ssWord';
$dbname = 'jwtapi';

$connect = mysqli_connect($servername, $username, $password, $dbname)or die('Não foi possível conectar ao banco MySQL');
var_dump($connect);

if (!$connect) {
    die('Connection failed: ' . mysqli_connect_error());
}
/** END ----------------------------------------------------------------------------- */



