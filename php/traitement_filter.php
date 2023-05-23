<?php
require_once("./include/bdd.php");

// $returnCategoryParent = $bdd->prepare('SELECT * FROM category WHERE id_parent = 0');
// $returnCategoryParent->execute();
// $resultCategoryParent = $returnCategoryParent->fetchAll(PDO::FETCH_OBJ);
if (isset($_GET['subCategory'])){

$request = $bdd->prepare("SELECT * FROM items INNER JOIN liaison_items_category WHERE liaison_items_category.id_category =  ? AND items.id = liaison_items_category.id_item");
$request->execute([$_GET['subCategory']]);
$result = $request->fetchAll(PDO::FETCH_ASSOC);
$json = json_encode($result);
echo $json;
}
