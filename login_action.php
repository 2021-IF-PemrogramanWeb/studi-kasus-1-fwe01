<?php

include 'DBConnection.php';

session_unset();
session_destroy();

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

$statement = $conn->prepare(
	"
	select *
	from users
	where BINARY username = '" . $username . "'
	limit 1;
"
);

$statement->execute();
$statement->setFetchMode(PDO::FETCH_ASSOC);
$results = $statement->fetchAll();

session_start();
if (md5($password) == $results[0]['password']) {
	$_SESSION['auth_username'] = $results[0]['username'];
	$_SESSION['auth_name'] = $results[0]['name'];
	header("Location: http://pweb.frederickwilliame.com/loggedin.php");
}
else {
	echo 'login failed';
}
exit();


