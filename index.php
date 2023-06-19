<?php require_once('./php/include/required.php');

// Requête pour récupérer les produits les plus acheter
$request = $bdd->prepare("SELECT *,count(*) FROM liaison_product_order INNER JOIN products ON liaison_product_order.product_id = products.product_id INNER JOIN images ON images.product_id = products.product_id WHERE image_main = 1 GROUP BY products.product_id ORDER BY count(*) DESC LIMIT 4");
$request->execute();
$result = $request->fetchAll(PDO::FETCH_OBJ);

$requestAllItems = $bdd->prepare("SELECT * FROM products INNER JOIN images ON products.product_id = images.product_id WHERE image_main = 1 ORDER BY products.product_date DESC LIMIT 4");
$requestAllItems->execute();
$resultAllItems = $requestAllItems->fetchAll(PDO::FETCH_OBJ);

if (isset($_POST['submit'])) {
    var_dump($_POST['ok']);
    echo mb_strlen(str_replace("\n", '', $_POST['ok']));
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once('./php/include/head.php') ?>
    <title>Index</title>
    <link rel="stylesheet" href="./css/index.css">
</head>

<body>
    <form action="" method="POST">
        <textarea name="ok" id="" cols="30" rows="10"></textarea>
        <input type="submit" name="submit">
    </form>
    <?php require_once('./php/include/header.php') ?>
    <main>
        <section id="Container">

            <!-- DIV POUR LES PRODUTIS LES PLUS POPULAIRES -->
            <div class="MainContent">
                <h2>LES PLUS POPULAIRES</h2>
                <div class="BoxProducts">
                    <?php
                    foreach ($result as $key) { ?>
                        <div class="CardProduct">
                            <a href="./php/detail.php?id=<?= $key->image_id ?>" class="LinkProduct">
                                <div class="divImg">
                                    <img src="./assets/img_item/<?= $key->image_name ?>" alt="">
                                </div>
                            </a>

                            <div class="BoxDetailProduct">

                                <a href="./php/detail.php?id=<?= $key->image_id ?>" class="LinkProduct">
                                    <div class="BoxProductName">
                                        <p class="ProductName"><?= CoupePhrase(htmlspecialchars($key->product_name), 40) ?></p>
                                    </div>
                                </a>

                                <div class="BoxPriceBtn">
                                    <p class="ProductPrice"><?= htmlspecialchars($key->product_price) ?>€</p>
                                    <?php if (isset($_SESSION['user'])) { ?>
                                        <form action="" method="post" id="FormCart">
                                            <button type="submit" name="ButtonAddCartPopular<?= $key->product_id ?>" id="ButtonAddCartPopular"><i class="fa-solid fa-cart-plus"></i></button>
                                        </form>
                                    <?php } ?>
                                </div>

                            </div>

                        </div>
                    <?php
                        if (isset($_POST['ButtonAddCartPopular' . $key->product_id])) {
                            // Récupère la quantité du produit
                            $quantity = $bdd->prepare("SELECT cart_quantity FROM carts WHERE product_id = :product_id");
                            $quantity->execute(['product_id' => $key->product_id]);
                            $result_quantity = $quantity->fetch(PDO::FETCH_OBJ);

                            // Insert le produit de la page dans le panier en gérant la quantité
                            if ($quantity->rowCount() > 0) {
                                $updateQuantity = $bdd->prepare("UPDATE carts SET cart_quantity= :cart_quantity WHERE product_id = :product_id");
                                $updateQuantity->execute([
                                    'cart_quantity' => $result_quantity->cart_quantity + 1,
                                    'product_id' => $key->product_id
                                ]);
                            } else {
                                $insertQuantity = $bdd->prepare("INSERT INTO carts(user_id, product_id, cart_quantity) VALUES (:user_id,:product_id,:cart_quantity)");
                                $insertQuantity->execute([
                                    'user_id' => $_SESSION['user']->user_id,
                                    'product_id' => $key->product_id,
                                    'cart_quantity' => 1
                                ]);
                            }
                            header('Location: index.php');
                        }
                    }
                    ?>
                </div>
            </div>

            <!-- DIV POUR LES PRODUTIS LES PLUS ????????? -->
            <div class="MainContent">
                <h2>NOUVEAUTÉS</h2>
                <div class="BoxProducts">
                    <?php
                    foreach ($resultAllItems as $key2) { ?>
                        <div class="CardProduct">
                            <a href="./php/detail.php?id=<?= $key2->image_id ?>" class="LinkProduct">
                                <div class="divImg">
                                    <img src="./assets/img_item/<?= $key2->image_name ?>" alt="">
                                </div>
                            </a>

                            <div class="BoxDetailProduct">

                                <a href="./php/detail.php?id=<?= $key2->image_id ?>" class="LinkProduct">
                                    <div class="BoxProductName">
                                        <p class="ProductName"><?= CoupePhrase(htmlspecialchars($key2->product_name), 40) ?></p>
                                    </div>
                                </a>

                                <div class="BoxPriceBtn">
                                    <p class="ProductPrice"><?= htmlspecialchars($key2->product_price) ?>€</p>
                                    <?php if (isset($_SESSION['user'])) { ?>
                                        <form action="" method="post" id="FormCart">
                                            <button type="submit" name="ButtonAddCartNew<?= $key2->product_id ?>" id="ButtonAddCartNew"><i class="fa-solid fa-cart-plus"></i></button>
                                        </form>
                                    <?php } ?>
                                </div>

                            </div>

                        </div>
                    <?php
                        if (isset($_POST['ButtonAddCartNew' . $key2->product_id])) {
                            // Récupère la quantité du produit
                            $quantity = $bdd->prepare("SELECT `cart_quantity` FROM `carts` WHERE product_id = :product_id");
                            $quantity->execute(['product_id' => $key2->product_id]);
                            $result_quantity = $quantity->fetch(PDO::FETCH_OBJ);

                            // Insert le produit de la page dans le panier en gérant la quantité
                            if ($quantity->rowCount() > 0) {
                                $updateQuantity = $bdd->prepare("UPDATE `carts` SET `cart_quantity`= :cart_quantity WHERE product_id = :product_id");
                                $updateQuantity->execute([
                                    'cart_quantity' => $result_quantity->cart_quantity + 1,
                                    'product_id' => $key2->product_id
                                ]);
                            } else {
                                $insertQuantity = $bdd->prepare("INSERT INTO `carts`(`user_id`, `product_id`, `cart_quantity`) VALUES (:user_id,:product_id,:cart_quantity)");
                                $insertQuantity->execute([
                                    'user_id' => $_SESSION['user']->user_id,
                                    'product_id' => $key2->product_id,
                                    'cart_quantity' => 1
                                ]);
                            }
                            header('Location: index.php');
                        }
                    }
                    ?>
                </div>
            </div>

        </section>
    </main>
    <?php require_once('./php/include/footer.php') ?>
</body>

</html>

<?php
// * Demander si required est néssecaire vu que ça empêche d'afficher les messages d'erreurs !
// * TRAVAILLER LE CSS SUR DU 1920x1080

// ? FAIRE UNE PAGE POUR VOIR TOUTES NOS COMMANDES
// ? Quand les inputs sont différents de vide mettre leur border en --button-color
// ? Faire les quantités pour l'historique de commandes
// // ? Envoyer en base de donnée normalement mais récupérer avec la première lettre en majuscule

// ! Ajouter et modifier un produit nl2br() et if(empty(trim($textarea)))

// ! Corriger l'affichage du numero de telephone dans la modification d'adresse
// ! Condition pour la taille de l'adresse (il faut que ca passe en version mobile)
// ! Faire le responsive pour l'historique de commande

// ! VERIFIER TOUTES LES ERREURS POSSIBLE EN CHANGEANT LES GET
// ! INTVAL POUR LA CONNEXION
// ! REMETTRE LE SETINTERVAL SUR LES FETCH DE L'ADMIN

// TODO: désactiver la touche ENTRER sur l'autocomplétion car elle envoie sur une page erreur
// TODO: rajouter un header location après le post Delete de la page Cart
// TODO: FAIRE toutes les verif en html, php et js pour les formulaires des pages admin, cartPage, profil, addAdress, modifyAdress, modifyPassword 
// TODO: FAIRE la maquette
// TODO: FAIRE le MCD
// TODO: FAIRE la gestions des promotions
// TODO: FAIRE la gestion des tags produits
// TODO: FAIRE un système de payement fonctionnel
// TODO: FAIRE une génération de numéro de commande
// TODO: FAIRE le calcul de la TVA
// TODO: FAIRE un systéme de commentaire
// TODO: FAIRE les avis d'utilisateurs
// TODO: FAIRE le rating d'un produit
// TODO: FAIRE une gestion des commentaires par l'Administrateur
?>