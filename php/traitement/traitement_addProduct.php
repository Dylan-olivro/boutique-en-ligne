<?php
require_once('../class/product.php');
require_once('../class/category.php');
require_once('../class/image.php');
session_start();
require_once('../include/bdd.php');
require_once('../include/function.php');

// $data = json_decode(file_get_contents('php://input'), true);
// var_dump($data);


// Vérifier si des données ont été soumises via la méthode POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // var_dump($_FILES);
    // var_dump($_POST);

    $name = $_POST['nameItem'];
    $description = $_POST['descriptionItem'];
    $date = date("Y-m-d H:i:s");
    $price = $_POST['priceItem'];
    $stock = $_POST['stockItem'];

    $file = $_FILES['image'];
    $category = $_POST['categoryItem'];

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
        // var_dump($file['error']);
        if ($file['error'] === UPLOAD_ERR_OK)
        //  && $_FILES["image"]["error"] === UPLOAD_ERR_OK
        {
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


            $message['PRODUCT_SUCCES'] = "Produit ajouté";
            // Récupérer les données du formulaire
            // $productName = $_POST["productName"];
            // $productDescription = $_POST["productDescription"];

            // if (isset($file)) {
            // Récupère l'ID du dernier produit ajouter
            //     $returnLastID = $bdd->prepare("SELECT product_id FROM products ORDER BY products.product_id DESC");
            //     $returnLastID->execute();
            //     $resultID =  $returnLastID->fetch(PDO::FETCH_OBJ);

            //     $image = new Image(null, $resultID->product_id, $file, 1);
            //     $image->addImage($bdd);
            // }



            // Vérifier si un fichier a été téléchargé
            // $image = $_FILES["image"];
            // $imageName = $image["name"];
            // $imageTmpPath = $image["tmp_name"];
            // $imageSize = $image["size"];
            // $imageType = $image["type"];

            // Déplacez le fichier téléchargé vers un emplacement souhaité
            // $targetDirectory = "chemin/vers/dossier/images/";
            // $targetPath = $targetDirectory . $imageName;
            // move_uploaded_file($imageTmpPath, $targetPath);

            // Vous pouvez effectuer d'autres opérations avec le fichier, comme le redimensionner ou le sauvegarder dans une base de données
        } else {
            $message['PRODUCT_ERROR'] = "Image error";
        }

        // Effectuez d'autres opérations avec les données du formulaire
        // ...

        // Envoyer une réponse JSON indiquant le succès ou l'erreur
        // $response = array();
        // $response["PRODUCT_SUCCESS"] = "Le produit a été ajouté avec succès.";
        // $response["PRODUCT_ERROR"] = "Une erreur s'est produite lors de l'ajout du produit.";

    }
} else {
    $message['PRODUCT_ERROR'] = "Données manquantes";
}

echo json_encode($message);
