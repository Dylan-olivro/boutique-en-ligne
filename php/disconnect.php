<?php
// var_dump('ddd');
require_once('./class/user.php');

$user = new User('', '', '', '', '');
$user->disconnect();
header('Location: ../index.php');
