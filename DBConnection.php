<?php
//Setting untuk di server
$servername = "127.0.0.1";
$username = "u939538109_pweb";
$password = "!x=Oi8Uy";
$DBName = "u939538109_pweb";

//Setting untuk di local
//$servername = "127.0.0.1";
//$username = "root";
//$password = "";
//$DBName = "pweb";

$conn = new PDO("mysql:host=$servername;dbname=$DBName", $username, $password);
// set the PDO error mode to exception
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
