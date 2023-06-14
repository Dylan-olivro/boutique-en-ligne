<?php
require_once('./include/required.php');
// ! VERIFIER AVEC PLESK POUR LES ACCENTS


// Récupération du produit
$returnProduct = $bdd->prepare("SELECT * FROM products WHERE product_id = :product_id");
$returnProduct->execute(['product_id' => $_GET['id']]);
$result = $returnProduct->fetch(PDO::FETCH_OBJ);

// Empêche d'aller sur la page si il n'y a aucun produit de selectionner 
if (!$result) {
    header('Location: ../index.php');
}
// Récupération des images du produit
$image = new Image(null, $_GET['id'], null, null);
$result_images = $image->returnImagesByID($bdd);

// Insert le produit de la page dans le panier
if (isset($_POST['ajouter'])) {
    $insertIntoPanier = $bdd->prepare('INSERT INTO carts (user_id,product_id) VALUES(:user_id,:product_id)');
    $insertIntoPanier->execute([
        'user_id' => $_SESSION['user']->user_id,
        'product_id' => trim(intval($_GET['id']))
    ]);
    header('Location: detail.php?id=' . $_GET['id']);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail</title>
    <!-- CSS -->
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/detail.css">
    <!-- BOOTSTRAP -->
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script> -->
    <!-- JQUERY -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <!-- FONTAWESOME -->
    <script src="https://kit.fontawesome.com/9a09d189de.js" crossorigin="anonymous"></script>
    <!-- JAVASCRIPT -->
    <script src="../js/function.js" defer></script>
    <script src="../js/header.js" defer></script>
    <script src="../js/autocompletion.js" defer></script>
    <script src="../js/detail.js" defer></script>

</head>

<body>
    <?php require_once('./include/header.php'); ?>
    <?php require_once('./include/header-save.php') ?>

    <main>

        <section id="container">
            <!-- Affichage du produit -->
            <div id="item">
                <div id="imageItem">
                    <img src="../assets/img_item/<?= $result_images[0]->image_name ?>" alt="">
                </div>
                <div id="detailItem">
                    <p><?= htmlspecialchars($result->product_name) ?></p>

                    <div id="description">Description :
                        <p><?= htmlspecialchars_decode($result->product_description) ?></p>
                    </div>

                    <div id="price_cart">
                        <p><?= htmlspecialchars($result->product_price) ?>€</p>
                        <p class="stock"><?= htmlspecialchars($result->product_stock) ?></p>
                        <?php
                        if (isset($_SESSION['user'])) {
                            if ($result->product_stock > 0) { ?>
                                <form action="" method="post">
                                    <input type="submit" name="ajouter" value="Ajouter au panier">
                                </form>
                        <?php
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </section>

    </main>
</body>
<style>

</style>

</html>