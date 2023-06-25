<?php
require_once("../include/bdd.php");

if (isset($_GET['categoryParent'])) {
    $request = $bdd->prepare("SELECT * FROM products INNER JOIN liaison_items_category ON products.product_id = liaison_items_category.id_item INNER JOIN images ON products.product_id = images.product_id INNER JOIN category ON liaison_items_category.id_category = category.id WHERE category.id_parent = ? AND image_main = 1 ORDER BY products.product_price DESC");
    $request->execute([$_GET['categoryParent']]);
} elseif (isset($_GET['subCategory'])) {
    $request = $bdd->prepare("SELECT * FROM products INNER JOIN images ON products.product_id = images.product_id INNER JOIN liaison_items_category ON products.product_id = liaison_items_category.id_item WHERE liaison_items_category.id_category = :id_category AND image_main = 1 ORDER BY products.product_price DESC");
    $request->execute(['id_category' => $_GET['subCategory']]);
} elseif (isset($_GET['categories'])) {
    if ($_GET['categories'] < 5) {
        $request = $bdd->prepare("SELECT * FROM products INNER JOIN liaison_items_category ON products.product_id = liaison_items_category.id_item INNER JOIN images ON products.product_id = images.product_id INNER JOIN category ON liaison_items_category.id_category = category.id WHERE category.id_parent = :id_category AND image_main = 1 ORDER BY products.product_price DESC");
    } else {
        $request = $bdd->prepare("SELECT * FROM products INNER JOIN images ON products.product_id = images.product_id INNER JOIN liaison_items_category ON products.product_id = liaison_items_category.id_item WHERE liaison_items_category.id_category = :id_category AND image_main = 1 ORDER BY products.product_price DESC");
    }
    $request->execute(['id_category' => $_GET['categories']]);
} else {
    $request = $bdd->prepare("SELECT *,count(*) FROM liaison_product_order INNER JOIN products ON liaison_product_order.product_id = products.product_id INNER JOIN images ON products.product_id = images.product_id WHERE images.image_main = 1 GROUP BY products.product_id ORDER BY count(*) DESC");
    $request->execute();
}
$result = $request->fetchAll(PDO::FETCH_ASSOC);
$json = json_encode($result);
echo $json;
