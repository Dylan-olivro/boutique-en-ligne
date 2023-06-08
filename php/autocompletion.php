<?php
require_once("./include/bdd.php");

if (isset($_GET['search'])) {
    $request = $bdd->prepare("SELECT * FROM products INNER JOIN images ON products.product_id = images.product_id WHERE products.product_name LIKE ? ORDER BY products.product_name ASC");
    $request->execute(['%' . $_GET['search'] . '%']);
    $result = $request->fetchAll(PDO::FETCH_ASSOC);
    $json = json_encode($result);
    echo $json;
}
