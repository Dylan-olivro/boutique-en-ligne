<?php
require_once('../class/product.php');
require_once('../class/category.php');
require_once('../class/image.php');
session_start();
require_once('../include/bdd.php');
require_once('../include/function.php');

// Vérifier si des données ont été soumises via la méthode POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name = $_POST['nameItem'];
    $description = $_POST['descriptionItem'];
    $date = date("Y-m-d H:i:s");
    $price = $_POST['priceItem'];
    $stock = $_POST['stockItem'];

    $file = $_FILES['image'];
    $category = $_POST['categoryItem'];

    if (empty($name)) {
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
    } elseif (!isNumber($stock)) {
        $message['PRODUCT_ERROR'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe stock doit être un nombre.';
    } elseif (!isNumber($category)) {
        $message['PRODUCT_ERROR'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLa category doit être un nombre.';
    } else {
        // Vérifie si l'image n'a aucune erreur
        if ($file['error'] === UPLOAD_ERR_OK) {
            $product = new Product(null, $name, $description, $date, $price, $stock);
            $category = new Category(null, null, $category);
            $product->addProduct($bdd);
            $category->liaisonItemCategory($bdd);

            // Récupère l'ID du dernier produit ajouter
            $returnLastID = $bdd->prepare("SELECT product_id FROM products ORDER BY products.product_id DESC");
            $returnLastID->execute();
            $resultID =  $returnLastID->fetch(PDO::FETCH_OBJ);

            $image = new Image(null, $resultID->product_id, $file, 1);
            $image->addImage($bdd);

            $message['PRODUCT_SUCCES'] = '<i class="fa-solid fa-circle-check"></i>&nbspProduit ajouté.';
        } else {
            $message['PRODUCT_ERROR'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspImage error';
        }
    }
} else {
    $message['PRODUCT_ERROR'] = "Données manquantes";
}

echo json_encode($message);
