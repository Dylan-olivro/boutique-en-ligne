<?php
require_once('./include/required.php');
// ! VERIFIER AVEC PLESK POUR LES ACCENTS


// Récupération du produit
$recupItem = $bdd->prepare("SELECT * FROM items WHERE id = :id");
$recupItem->execute(['id' => $_GET['id']]);
$resultItem = $recupItem->fetch(PDO::FETCH_OBJ);

// Empêche d'aller sur la page si il n'y a aucun produit de selectionner 
if (!$resultItem) {
    header('Location: ../index.php');
}
// Récupération des images du produit
$image = new Image(null, $_GET['id'], null, null);
$result = $image->returnImagesByID($bdd);

// Insert le produit de la page dans le panier
if (isset($_POST['ajouter'])) {
    $insertIntoPanier = $bdd->prepare('INSERT INTO cart (id_user,id_item) VALUES(:id_user,:id_item)');
    $insertIntoPanier->execute([
        'id_user' => $_SESSION['user']->id,
        'id_item' => trim(intval($_GET['id']))
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
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
    <main>

        <section id="container">
            <!-- Affichage du produit -->
            <div id="item">
                <div id="imageItem">
                    <img src="../assets/img_item/<?= $result[0]->name_image ?>" alt="">
                </div>
                <div id="detailItem">
                    <p><?= hd($resultItem->name) ?></p>

                    <div id="description">Description :
                        <p><?= htmlspecialchars_decode($resultItem->description) ?></p>
                    </div>

                    <div id="price_cart">
                        <p><?= hd($resultItem->price) ?>€</p>
                        <?php
                        if (isset($_SESSION['user'])) {
                            if ($resultItem->stock > 0) { ?>
                                <form action="" method="post">
                                    <input type="submit" name="ajouter" value="Ajouter au panier">
                                </form>
                            <?php
                            } else { ?>
                                <p>STOCK EPUISEE</p>
                        <?php
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </section>

    </main>
    <?php require_once('./include/header-save.php') ?>
</body>
<style>

</style>

</html>