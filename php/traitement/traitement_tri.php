<?php
require_once("../include/bdd.php");


if (isset($_GET['populaire'])) {
    $requestAllItems = $bdd->prepare("SELECT *,count(*) FROM liaison_product_order INNER JOIN products ON liaison_product_order.product_id = products.product_id INNER JOIN images ON products.product_id = images.product_id WHERE images.image_main = 1 GROUP BY products.product_id ORDER BY count(*) DESC");
    $requestAllItems->execute();
    $resultAllItems = $requestAllItems->fetchAll(PDO::FETCH_ASSOC);
    $jsonAllItems = json_encode($resultAllItems);
    echo $jsonAllItems;
} elseif (isset($_GET['nouveau'])) {
    $requestAllItems = $bdd->prepare("SELECT * FROM products INNER JOIN images ON products.product_id = images.product_id WHERE image_main = 1 ORDER BY products.product_date DESC");
    $requestAllItems->execute();
    $resultAllItems = $requestAllItems->fetchAll(PDO::FETCH_ASSOC);
    $jsonAllItems = json_encode($resultAllItems);
    echo $jsonAllItems;
} elseif (isset($_GET['croissant'])) {
    $requestAllItems = $bdd->prepare("SELECT * FROM products INNER JOIN images ON products.product_id = images.product_id WHERE image_main = 1 ORDER BY products.product_price ASC");
    $requestAllItems->execute();
    $resultAllItems = $requestAllItems->fetchAll(PDO::FETCH_ASSOC);
    $jsonAllItems = json_encode($resultAllItems);
    echo $jsonAllItems;
} elseif (isset($_GET['decroissant'])) {
    $requestAllItems = $bdd->prepare("SELECT * FROM products INNER JOIN images ON products.product_id = images.product_id WHERE image_main = 1 ORDER BY products.product_price DESC");
    $requestAllItems->execute();
    $resultAllItems = $requestAllItems->fetchAll(PDO::FETCH_ASSOC);
    $jsonAllItems = json_encode($resultAllItems);
    echo $jsonAllItems;
} elseif (isset($_GET['aZ'])) {
    $requestAllItems = $bdd->prepare("SELECT * FROM products INNER JOIN images ON products.product_id = images.product_id WHERE image_main = 1 ORDER BY products.product_name ASC");
    $requestAllItems->execute();
    $resultAllItems = $requestAllItems->fetchAll(PDO::FETCH_ASSOC);
    $jsonAllItems = json_encode($resultAllItems);
    echo $jsonAllItems;
} elseif (isset($_GET['zA'])) {
    $requestAllItems = $bdd->prepare("SELECT * FROM products INNER JOIN images ON products.product_id = images.product_id WHERE image_main = 1 ORDER BY products.product_name DESC");
    $requestAllItems->execute();
    $resultAllItems = $requestAllItems->fetchAll(PDO::FETCH_ASSOC);
    $jsonAllItems = json_encode($resultAllItems);
    echo $jsonAllItems;
} elseif (isset($_GET['dispo'])) {
    $requestAllItems = $bdd->prepare("SELECT * FROM products INNER JOIN images ON products.product_id = images.product_id WHERE image_main = 1 ORDER BY products.product_stock DESC");
    $requestAllItems->execute();
    $resultAllItems = $requestAllItems->fetchAll(PDO::FETCH_ASSOC);
    $jsonAllItems = json_encode($resultAllItems);
    echo $jsonAllItems;
}
