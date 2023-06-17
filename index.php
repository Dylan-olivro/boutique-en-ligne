<?php require_once('./php/include/required.php');

$request = $bdd->prepare("SELECT *,count(*) FROM liaison_product_order INNER JOIN products ON liaison_product_order.product_id = products.product_id INNER JOIN images ON images.product_id = products.product_id WHERE image_main = 1 GROUP BY products.product_id ORDER BY count(*) DESC LIMIT 8");
$request->execute();
$result = $request->fetchAll(PDO::FETCH_OBJ);



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once('./php/include/head.php') ?>
    <title>Home</title>
    <link rel="stylesheet" href="./css/index.css">
</head>

<body>
    <?php require_once('./php/include/header.php') ?>
    <main>
        <section id="container">

            <div class="populaire">
                <h2>LES PLUS POPULAIRES</h2>
                <div class="productPop">
                    <?php
                    foreach ($result as $key) { ?>
                        <div class="cardPop">
                            <a href="./php/detail.php?id=<?= $key->image_id ?>" class="linkPop">
                                <div class="divImg">
                                    <img src="./assets/img_item/<?= $key->image_name ?>" alt="">
                                </div>
                                <div class="divText">
                                    <p class="productName"><?= CoupePhrase(htmlspecialchars($key->product_name), 40) ?></p>
                                </div>
                            </a>
                            <div class="priceAndCart">
                                <p class="productPrice"><?= htmlspecialchars($key->product_price) ?>€</p>
                                <form action="" method="post" id="formPop">
                                    <button type="submit" name="addPop<?= $key->product_id ?>" id="addPop"><i class="fa-solid fa-cart-plus"></i></button>
                                </form>
                            </div>
                        </div>
                    <?php
                        if (isset($_POST['addPop' . $key->product_id])) {
                            // Insert le produit de la page dans le panier en gérant la quantité
                            $quantity = $bdd->prepare("SELECT `cart_quantity` FROM `carts` WHERE product_id = :product_id");
                            $quantity->execute(['product_id' => $key->product_id]);
                            $result_quantity = $quantity->fetch(PDO::FETCH_OBJ);

                            if ($quantity->rowCount() > 0) {
                                $updateQuantity = $bdd->prepare("UPDATE `carts` SET `cart_quantity`= :cart_quantity WHERE product_id = :product_id");
                                $updateQuantity->execute([
                                    'cart_quantity' => $result_quantity->cart_quantity + 1,
                                    'product_id' => $key->product_id
                                ]);
                            } else {
                                $insertQuantity = $bdd->prepare("INSERT INTO `carts`(`user_id`, `product_id`, `cart_quantity`) VALUES (:user_id,:product_id,:cart_quantity)");
                                $insertQuantity->execute([
                                    'user_id' => $_SESSION['user']->user_id,
                                    'product_id' => $key->product_id,
                                    'cart_quantity' => 1
                                ]);
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
// * Demander si required est néssecaire vu que ça empêche d'afficher les messages d'erreurs !

// ? FAIRE UNE PAGE POUR VOIR TOUTES NOS COMMANDES
// ? Quand les inputs sont différents de vide mettre leur border en --button-color
// ? PASSER LE MESSAGE DE STOCK EPUISEE SUR LE DETAIL EN --> JAVASCRIPT
// ? Faire un select sur les categories

// ! VERIFIER TOUTES LES ERREURS POSSIBLE EN CHANGEANT LES GET
// ! AJOUTER LES CONDITIONS POUR LES IMAGES DANS LE FORMULAIRE DU PRODUIT
// ! INTVAL POUR LA CONNEXION
// ! TRAVAILLER LE CSS SUR DU 1920/1080
// ! Ajouter le css concernant le main sur toutes les pages
// ! REMETTRE LE SETINTERVAL SUR LES FETCH DE L'ADMIN
// ! Probleme si on ajoute 2 fois le même produit au panier et qu'on click sur supprimer, ça supprime les 2 (voir avec des data-id et uniqId() ou faire un systeme de quantité)

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