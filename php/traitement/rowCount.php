<?php require_once("../include/bdd.php");
session_start();
$request = $bdd->prepare("SELECT * FROM users WHERE email = :email");
$request->execute(['email' => $_SESSION['traitement']['email']]);
$result = $request->fetchAll(PDO::FETCH_ASSOC);
$json = json_encode($result);
echo $json;
