<?php
require_once("./include/bdd.php");

if (isset($_GET['categoryParent'])) {
    $request = $bdd->prepare("SELECT * FROM products INNER JOIN liaison_items_category ON products.product_id = liaison_items_category.id_item INNER JOIN images ON products.product_id = images.product_id INNER JOIN category ON liaison_items_category.id_category = category.id WHERE category.id_parent = ? AND image_main = 1 ORDER BY products.product_price DESC");
    $request->execute([$_GET['categoryParent']]);
    $result = $request->fetchAll(PDO::FETCH_ASSOC);
    $json = json_encode($result);
    echo $json;
} elseif (isset($_GET['subCategory'])) {
    $request = $bdd->prepare("SELECT * FROM products INNER JOIN images ON products.product_id = images.product_id INNER JOIN liaison_items_category ON products.product_id = liaison_items_category.id_item WHERE liaison_items_category.id_category = :id_category AND image_main = 1 ORDER BY products.product_price DESC");
    $request->execute(['id_category' => $_GET['subCategory']]);
    $result = $request->fetchAll(PDO::FETCH_ASSOC);
    $json = json_encode($result);
    echo $json;
} else {
    $requestAllItems = $bdd->prepare("SELECT * FROM products INNER JOIN images ON products.product_id = images.product_id WHERE image_main = 1 ORDER BY products.product_price DESC");
    $requestAllItems->execute();
    $resultAllItems = $requestAllItems->fetchAll(PDO::FETCH_ASSOC);
    $jsonAllItems = json_encode($resultAllItems);
    echo $jsonAllItems;
}
