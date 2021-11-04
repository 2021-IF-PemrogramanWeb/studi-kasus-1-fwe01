<?php

include 'DBConnection.php';

session_start();
session_unset();

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

$statement = $conn->prepare(
	"
	select *
	from users
	where BINARY username = '". $username . "'
	limit 1;
"
);

$statement->execute();
$statement->setFetchMode(PDO::FETCH_ASSOC);
$results = $statement->fetchAll();

if (md5($password) === $results['password']){
	$_SESSION['auth_username'] = $results['username'];
	$_SESSION['auth_name'] = $results['name'];
	print_r($_SESSION);
}
//header("Location: http://pweb.frederickwilliame.com/loggedin.php");
//exit();


