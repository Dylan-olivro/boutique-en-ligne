<?php require_once("./include/bdd.php");

$request = $bdd->prepare("SELECT * FROM items WHERE id = ?");
$request->execute([$_GET['id']]);
$result = $request->fetchAll(PDO::FETCH_ASSOC);
$json = json_encode($result);
echo $json;
