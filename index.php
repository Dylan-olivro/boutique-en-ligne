<?php require_once('./php/include/required.php');

// Requête pour récupérer les produits les plus acheter
$request = $bdd->prepare("SELECT *,count(*) FROM liaison_product_order INNER JOIN products ON liaison_product_order.product_id = products.product_id INNER JOIN images ON images.product_id = products.product_id WHERE image_main = 1 GROUP BY products.product_id ORDER BY count(*) DESC LIMIT 4");
$request->execute();
$result = $request->fetchAll(PDO::FETCH_OBJ);

// Requête pour récupérer les produits les plus récents
$requestAllItems = $bdd->prepare("SELECT * FROM products INNER JOIN images ON products.product_id = images.product_id WHERE image_main = 1 ORDER BY products.product_date DESC LIMIT 4");
$requestAllItems->execute();
$resultAllItems = $requestAllItems->fetchAll(PDO::FETCH_OBJ);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once('./php/include/head.php') ?>
    <title>Index</title>
    <link rel="stylesheet" href="./css/index.css">
</head>

<body>
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
                                    <form action="" method="post" id="FormCart">
                                        <button type="submit" name="ButtonAddCartPopular<?= $key->product_id ?>" id="ButtonAddCartPopular"><i class="fa-solid fa-cart-plus"></i></button>
                                    </form>
                                </div>

                            </div>

                        </div>
                    <?php
                        if (isset($_POST['ButtonAddCartPopular' . $key->product_id])) {
                            if (isset($_SESSION['user'])) {

                                // Récupère la quantité du produit
                                $quantity = $bdd->prepare("SELECT cart_quantity FROM carts WHERE product_id = :product_id AND user_id = :user_id");
                                $quantity->execute([
                                    'product_id' => $key->product_id,
                                    'user_id' => $_SESSION['user']->user_id
                                ]);
                                $result_quantity = $quantity->fetch(PDO::FETCH_OBJ);

                                // Insert le produit de la page dans le panier en gérant la quantité
                                if ($quantity->rowCount() > 0) {
                                    $updateQuantity = $bdd->prepare("UPDATE carts SET cart_quantity= :cart_quantity WHERE product_id = :product_id AND user_id = :user_id");
                                    $updateQuantity->execute([
                                        'cart_quantity' => $result_quantity->cart_quantity + 1,
                                        'product_id' => $key->product_id,
                                        'user_id' => $_SESSION['user']->user_id
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
                            } else {
                                // Si l'utilisateur n'est pas connecté
                                // Insert le produit dans la session panier ou augmente sa quantité de 1
                                $select = array();
                                $select['id'] = $key->product_id;
                                $select['qte'] = 1;
                                $select['prix'] = $key->product_price;
                                if (modif_qte($key->product_id, '+')) {
                                } else {
                                    ajout($select);
                                }
                                header('Location: index.php');
                            }
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
                                    <form action="" method="post" id="FormCart">
                                        <button type="submit" name="ButtonAddCartNew<?= $key2->product_id ?>" id="ButtonAddCartNew"><i class="fa-solid fa-cart-plus"></i></button>
                                    </form>
                                </div>

                            </div>

                        </div>
                    <?php
                        if (isset($_POST['ButtonAddCartNew' . $key2->product_id])) {
                            if (isset($_SESSION['user'])) {

                                // Récupère la quantité du produit
                                $quantity = $bdd->prepare("SELECT `cart_quantity` FROM `carts` WHERE product_id = :product_id AND user_id = :user_id");
                                $quantity->execute([
                                    'product_id' => $key2->product_id,
                                    'user_id' => $_SESSION['user']->user_id
                                ]);
                                $result_quantity = $quantity->fetch(PDO::FETCH_OBJ);
                                var_dump($result_quantity);


                                // Insert le produit de la page dans le panier en gérant la quantité
                                if ($quantity->rowCount() > 0) {
                                    $updateQuantity = $bdd->prepare("UPDATE `carts` SET `cart_quantity`= :cart_quantity WHERE product_id = :product_id AND user_id = :user_id");
                                    $updateQuantity->execute([
                                        'cart_quantity' => $result_quantity->cart_quantity + 1,
                                        'product_id' => $key2->product_id,
                                        'user_id' => $_SESSION['user']->user_id
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
                            } else {
                                // Si l'utilisateur n'est pas connecté
                                // Insert le produit dans la session panier ou augmente sa quantité de 1
                                $select = array();
                                $select['id'] = $key2->product_id;
                                $select['qte'] = 1;
                                $select['prix'] = $key2->product_price;
                                if (modif_qte($key2->product_id, '+')) {
                                } else {
                                    ajout($select);
                                }
                                header('Location: index.php');
                            }
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

// ? FAIRE UNE PAGE POUR VOIR TOUTES NOS COMMANDES
// ? Faire les quantités pour l'historique de commandes

// ! Quand on ouvre les categories en version mobile, impossible de les réouvrir en desktop
// ! Condition pour la taille de l'adresse (il faut que ca passe en version mobile)
// ! REMETTRE LE SETINTERVAL SUR LES FETCH DE L'ADMIN

// TODO: Empiler des quantité dans l'historique des commandes
// TODO: FAIRE la gestions des promotions
// TODO: FAIRE la gestion des tags produits
// TODO: FAIRE un système de payement fonctionnel
?>