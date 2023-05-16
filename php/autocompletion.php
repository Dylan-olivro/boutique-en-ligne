<?php
require_once("./class/userJS.php");

if (isset($_GET['searchBarBurger'])) {
    $request = $bdd->prepare("SELECT * FROM items WHERE name LIKE ? ORDER BY name ASC");
    $request->execute([$_GET['searchBarBurger'] . '%']);
    $result = $request->fetchAll(PDO::FETCH_ASSOC);
    $json = json_encode($result);
    echo $json;
}
?>