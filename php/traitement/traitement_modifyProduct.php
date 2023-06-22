<?php
require_once('../class/product.php');
require_once('../class/image.php');
session_start();
require_once('../include/bdd.php');
require_once('../include/function.php');

// Vérifier si des données ont été soumises via la méthode POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = $_POST['productID'];
    $name = $_POST['nameItem'];
    $description = $_POST['descriptionItem'];
    $date = date("Y-m-d H:i:s");
    $price = $_POST['priceItem'];
    $stock = $_POST['stockItem'];

    $file = $_FILES['image'];
    $category = $_POST['categoryItem'];

    if (empty($id)) {
        $message['PRODUCT_ERROR'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspAucun ID selectionné.';
    } elseif (empty($name)) {
        $message['PRODUCT_ERROR'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe champ Name est vide.';
    } elseif (empty(trim($description))) {
        $message['PRODUCT_ERROR'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe champ Description est vide';
    } elseif (empty($price)) {
        $message['PRODUCT_ERROR'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe champ Prix est vide.';
    } elseif (empty($stock)) {
        $message['PRODUCT_ERROR'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe champ Stock est vide.';
    } elseif (empty($category)) {
        $message['PRODUCT_ERROR'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe champ category est vide.';
    } elseif (!isNumberWithDecimal($price)) {
        $message['PRODUCT_ERROR'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLa prix doit être un nombre avec 2 decimal maximum.';
    } elseif (!isNumber($id)) {
        $message['PRODUCT_ERROR'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspL\'ID doit être un nombre.';
    } elseif (!isNumber($stock)) {
        $message['PRODUCT_ERROR'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe stock doit être un nombre.';
    } elseif (!isNumber($category)) {
        $message['PRODUCT_ERROR'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLa category doit être un nombre.';
    } else {
        $product = new Product($id, $name, $description, $date, $price, $stock);
        $product->editProduct($bdd);

        $updateLiaison = $bdd->prepare('UPDATE liaison_items_category SET id_category = :id_category WHERE id_item = :id_item');
        $updateLiaison->execute([
            'id_category' => (int)$category,
            'id_item' => (int)$id
        ]);

        if ($file['error'] === UPLOAD_ERR_OK) {
            $image = new Image(null, $id, $file, 1);
            $result = $image->returnMainImageByID($bdd);
            $image->updateMainImage($bdd, $result->image_name);
        }

        $message['PRODUCT_SUCCES'] = '<i class="fa-solid fa-circle-check"></i>&nbspProduit ajouté';
    }
} else {
    $message['PRODUCT_ERROR'] = "Données manquantes";
}

echo json_encode($message);
