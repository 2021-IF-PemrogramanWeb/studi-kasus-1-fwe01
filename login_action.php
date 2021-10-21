<?php

print_r($_POST);

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';


if ($username === 'fred' && $password === '1234') {
	echo 'Login Berhasil';
} else {
	echo 'Login Gagal';
}

