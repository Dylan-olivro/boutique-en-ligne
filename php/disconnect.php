<?php
require_once('./include/required.php');

$user = new User(null, null, null, null, null, null);
$user->disconnect();
header('Location: ../index.php');
