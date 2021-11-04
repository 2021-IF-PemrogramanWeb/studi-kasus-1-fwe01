<?php

session_destroy();

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

session_start();
if ($username === 'fred' && $password === '1234') {
	$_SESSION['auth_username'] = 'fred';
	$_SESSION['auth_name'] = 'Frederick';
}
header("Location: http://pweb.frederickwilliame.com/loggedin.php");

