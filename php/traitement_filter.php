<?php
require_once("./include/bdd.php");

// $returnCategoryParent = $bdd->prepare('SELECT * FROM category WHERE id_parent = 0');
// $returnCategoryParent->execute();
// $resultCategoryParent = $returnCategoryParent->fetchAll(PDO::FETCH_OBJ);

if (isset($_GET['subCategory'])) {
    $request = $bdd->prepare("SELECT * FROM products INNER JOIN images ON products.product_id = images.product_id INNER JOIN liaison_items_category WHERE liaison_items_category.id_category =  ? AND products.product_id = liaison_items_category.id_item ");
    $request->execute([$_GET['subCategory']]);
    $result = $request->fetchAll(PDO::FETCH_ASSOC);
    $json = json_encode($result);
    echo $json;
} else {
    $requestAllItems = $bdd->prepare("SELECT * FROM products INNER JOIN images ON products.product_id = images.product_id ORDER BY products.product_price DESC");
    $requestAllItems->execute();
    $resultAllItems = $requestAllItems->fetchAll(PDO::FETCH_ASSOC);
    $jsonAllItems = json_encode($resultAllItems);
    echo $jsonAllItems;
}
