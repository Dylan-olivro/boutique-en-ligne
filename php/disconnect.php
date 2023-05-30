<?php
require_once('./class/user.php');

$user = new User(null, null, null, null, null, null);
$user->disconnect();
header('Location: ../index.php');
