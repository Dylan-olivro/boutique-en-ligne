<?php
require_once("./include/bdd.php");

if (isset($_GET['search'])) {
    $request = $bdd->prepare("SELECT * FROM items INNER JOIN image ON items.id = image.id_item WHERE items.name LIKE ? ORDER BY items.name ASC");
    $request->execute(['%' . $_GET['search'] . '%']);
    $result = $request->fetchAll(PDO::FETCH_ASSOC);
    $json = json_encode($result);
    echo $json;
}
