<?php
require_once('../class/product.php');
require_once('../class/category.php');
require_once('../class/image.php');
session_start();
require_once('../include/bdd.php');
require_once('../include/function.php');

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data)) {
    $name = $data['nameItem'];
    $description = $data['descriptionItem'];
    $date = date("Y-m-d H:i:s");
    $price = $data['priceItem'];
    $stock = $data['stockItem'];

    $file = $data['file'];
    $category = $data['categoryItem'];


    // La sécurité empêche que les champs soient VIDES et correspondent à ce que nous voulons.
    if (empty($name)) {
        $message['PRODUCT_ERROR'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe champ Name est vide.';
    } elseif (empty($description)) {
        $message['PRODUCT_ERROR'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe champ Description est vide';
    } elseif (empty($price)) {
        $message['PRODUCT_ERROR'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe champ Prix est vide.';
    } elseif (empty($stock)) {
        $message['PRODUCT_ERROR'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe champ Stock est vide.';
    } elseif (empty($category)) {
        $message['PRODUCT_ERROR'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe champ category est vide.';
    } elseif (!isNumberWithDecimal($price)) {
        $message['PRODUCT_ERROR'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLa prix doit être un nombre avec 2 decimal maximum.';
    } elseif (!isNumber($stock)) {
        $message['PRODUCT_ERROR'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe stock doit être un nombre.';
    } elseif (!isNumber($category)) {
        $message['PRODUCT_ERROR'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLa category doit être un nombre.';
    } else {

        $product = new Product(null, $name, $description, $date, $price, $stock);
        $category = new Category(null, null, $category);
        $product->addProduct($bdd);
        $category->liaisonItemCategory($bdd);
        $message['PRODUCT_SUCCES'] = "Produit ajouté";
        // var_dump(!isNumber($stock));

        // if (isset($file)) {
        //     // Récupère l'ID du dernier produit ajouter
        //     $returnLastID = $bdd->prepare("SELECT product_id FROM products ORDER BY products.product_id DESC");
        //     $returnLastID->execute();
        //     $resultID =  $returnLastID->fetch(PDO::FETCH_OBJ);

        //     $image = new Image(null, $resultID->product_id, $file, 1);
        //     $image->addImage($bdd);
        // }
    }
} else {
    $message['PRODUCT_ERROR'] = "Données manquantes";
}

header('Content-Type: application/json');
echo json_encode($message);
exit;
