<?php
require_once('./include/required.php');

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

// Insert le produit de la page dans le panier en gérant la quantité
if (isset($_POST["ajouter"])) {
    $req2 = $bdd->prepare("SELECT `cart_quantity` FROM `carts` WHERE product_id = :product_id");
    $req2->execute(['product_id' => $result->product_id]);
    $res2 = $req2->fetch(PDO::FETCH_OBJ);

    if ($req2->rowCount() > 0) {
        $req3 = $bdd->prepare("UPDATE `carts` SET `cart_quantity`= :cart_quantity WHERE product_id = :product_id");
        $req3->execute([
            'cart_quantity' => $res2->cart_quantity + 1,
            'product_id' => $result->product_id
        ]);
        echo '<i class="fa-solid fa-circle-check" style="color: #0cad00;"></i> Article ajouté au panier.';
    } else {
        $req = $bdd->prepare("INSERT INTO `carts`(`user_id`, `product_id`, `cart_quantity`) VALUES (:user_id,:product_id,:cart_quantity)");
        $req->execute([
            'user_id' => $_SESSION['user']->user_id,
            'product_id' => $result->product_id,
            'cart_quantity' => 1
        ]);
        echo '<i class="fa-solid fa-circle-check" style="color: #0cad00;"></i> Article ajouté au panier.';
    }
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
            <div class="MainContent">
                <div class="BoxImg">
                    <img src="../assets/img_item/<?= $result_images[0]->image_name ?>" alt="">
                </div>
                <div class="BoxDetail">
                    <p id="productName"><?= htmlspecialchars($result->product_name) ?></p>

                    <div id="description">
                        <p>Description :</p>
                        <p><?= htmlspecialchars_decode($result->product_description) ?></p>
                    </div>

                </div>
                <div class="BoxPriceStockButton">
                    <div class="test">

                        <p id="price"><?= htmlspecialchars($result->product_price) ?>€</p>
                        <p id="stock"><?= htmlspecialchars($result->product_stock) ?></p>
                        <?php
                        // Affiche le bouton 'ajouter au panier' si l'utilisateu est connecté et si le stock est supérieur à 1
                        if (isset($_SESSION['user'])) {
                            if ($result->product_stock > 0) { ?>
                                <form action="" method="post">
                                    <button type="submit" class="button" name="ajouter">
                                        <span class="button__text">Add Item</span>
                                        <span class="button__icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" viewBox="0 0 24 24" stroke-width="2" stroke-linejoin="round" stroke-linecap="round" stroke="currentColor" height="24" fill="none" class="svg">
                                                <line y2="19" y1="5" x2="12" x1="12"></line>
                                                <line y2="12" y1="12" x2="19" x1="5"></line>
                                            </svg></span>
                                    </button>
                                    <!-- <input type="submit" name="ajouter" value="Ajouter au panier"> -->
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
    <?php require_once('./include/footer.php') ?>
</body>
<style>

</style>

</html>