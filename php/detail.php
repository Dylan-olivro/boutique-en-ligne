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
    <?php require_once('./include/head.php'); ?>
    <title>Detail</title>
    <link rel="stylesheet" href="../css/detail.css">
    <script src="../js/detail.js" defer></script>

</head>

<body>
    <?php require_once('./include/header.php'); ?>

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