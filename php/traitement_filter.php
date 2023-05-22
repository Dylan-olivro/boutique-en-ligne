<?php
require_once("./include/bdd.php");

    $request = $bdd->prepare("SELECT * FROM category");
    $request->execute();
    $result = $request->fetchAll(PDO::FETCH_ASSOC);
    $json = json_encode($result);
    echo $json;

