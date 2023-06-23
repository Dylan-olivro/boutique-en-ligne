<?php require_once('./include/required.php');

if (isset($_SESSION['user'])) {
    // Récupère le panier de l'utilisateur
    $cart = new Cart(null, $_SESSION['user']->user_id, null, null);
    $result_cart = $cart->returnCart($bdd);

    // Récupère les stock dans un tableau
    $stock = [];
    foreach ($result_cart as $product) {
        array_push($stock, $product->product_stock);
    }

    // Récupère les adresses de l'utilisateur
    $address = new Address(null, $_SESSION['user']->user_id, null, null, null, null, null, null, null);
    $allUserAddresses = $address->returnAddressesByUser($bdd);
}

// Valide le panier de l'utilisateur, créer une commande et vide le panier
if (isset($_POST['valider'])) {
    if (!empty($result_cart)) {
        if (isset($_POST['address'])) {

            if (!in_array(0, $stock)) {

                $date = date("Y-m-d H:i:s");
                $order = new Order(null, $_SESSION['user']->user_id, $date, null, null, null);
                $order->addOrder($bdd);

                $lastInsertId = $bdd->lastInsertId();

                // Récupère les prix dans un tableau
                $prices = [];
                foreach ($result_cart as $cartProduct) {
                    // SI la quantité est supérieur à 1, ajoute le nombre de fois le prix dans le tableau
                    if ($cartProduct->cart_quantity > 1) {
                        for ($i = 1; $i < (int)$cartProduct->cart_quantity; $i++) {
                            array_push($prices, $cartProduct->product_price);
                        }
                    }
                    array_push($prices, $cartProduct->product_price);

                    // Mise à jour des stock du produit à l'achat
                    $updateStock = $bdd->prepare('UPDATE products SET product_stock = :product_stock WHERE product_id = :product_id');
                    $updateStock->execute([
                        'product_stock' => $cartProduct->product_stock - (int)$cartProduct->cart_quantity,
                        'product_id' => $cartProduct->product_id
                    ]);
                    // Insertion du nombre de produit dans le panier, dans la table de liaison
                    $insertLiaison = $bdd->prepare('INSERT INTO liaison_product_order (order_id,product_id, product_quantity) VALUES (:order_id,:product_id,:product_quantity)');
                    $insertLiaison->execute([
                        'order_id' => $lastInsertId,
                        'product_id' => $cartProduct->product_id,
                        'product_quantity' => $cartProduct->cart_quantity
                    ]);
                }
                $total = array_sum($prices);

                // Récupération du code promo rentrer par l'utilisateur
                // $returnCode = $bdd->prepare('SELECT * FROM codes WHERE code_name = :code_name');
                // $returnCode->execute(['code_name' => $_SESSION['code']]);
                // $result_code = $returnCode->fetch(PDO::FETCH_OBJ);
                // var_dump($result_code);

                // Si le code promo existe, nouveau prix avec la réduction
                if (isset($_SESSION['code'])) {
                    $discount = (intval($_SESSION['code']) * $total) / 100;
                    $total = $total - $discount;
                    unset($_SESSION['code']);
                }
                // Création de numéro de commande
                $orderNumber = str_replace(".", "-", strtoupper(uniqid('', true)));

                // Mise à jour de l'objet Order
                $order->setId($lastInsertId);
                $order->setTotal($total);
                $order->setAddress($_POST['address']);
                $order->setNumber($orderNumber);
                // $order = new Order($lastInsertId, $_SESSION['user']->user_id, $date, $total, $_POST['adress'], $orderNumber);

                $order->updateOrder($bdd);
                $cart->deleteCart($bdd);
                header('Location: cartPage.php');
            } else {
                $ORDER_ERROR = 'Un article dans votre panier a son stock epuisée';
            }
        } else {
            $ORDER_ERROR = 'Veuillez choisir une adresse';
        }
    } else {
        $ORDER_ERROR = 'Panier vide';
    }
}

// Permet de vider le panier 
if (isset($_POST['vider'])) {
    if (isset($_SESSION['user'])) {
        $cart->deleteCart($bdd);
    } else {
        unset($_SESSION['panier']);
    }
    header('Location: cartPage.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once('./include/head.php'); ?>
    <title>Panier</title>
    <link rel="stylesheet" href="../css/cartPage.css">
    <script src="../js/cart.js" defer></script>
</head>

<body>
    <?php require_once('./include/header.php'); ?>

    <main>
        <section id="container">
            <!-- <section class="containerCart"> -->
            <div class="sectionCart">
                <div class="cart">
                    <h3>Ton Panier</h3>
                    <div class="banniere">
                        <p>Article</p>
                        <p>Prix</p>
                        <p>Qté</p>
                        <form action="" method="post">
                            <button type="submit" name="vider" class="vider"><i class="fa-solid fa-trash-can"></i></button>
                        </form>
                    </div>
                    <?php

                    if (isset($_SESSION['user'])) {
                        // Si le panier de l'utilisateur n'est pas vide
                        if (!empty($result_cart)) {
                            // Affichage du panier
                            foreach ($result_cart as $product) { ?>
                                <div class="cartDetail">
                                    <div class="cartProduct">
                                        <div class="cartImage">
                                            <img src="../assets/img_item/<?= $product->image_name ?>" alt="">
                                        </div>
                                        <div class="cartInfo">
                                            <a href="./detail.php?id=<?= $product->product_id ?>">
                                                <p class="name"><?= htmlspecialchars(CoupePhrase($product->product_name)) ?></p>
                                            </a>
                                            <p class="stock"><?= htmlspecialchars($product->product_stock) ?></p>
                                        </div>
                                    </div>
                                    <p class="price"><?= htmlspecialchars($product->product_price) ?>€</p>
                                    <p class="quantity"><?= htmlspecialchars($product->cart_quantity) ?></p>
                                    <form action="" method="post">
                                        <button type="submit" name="add<?= $product->cart_id ?>" id="add" style="background-color:transparent">
                                            <i class="fa-solid fa-plus"></i>
                                        </button>
                                        <button type="submit" name="delete<?= $product->cart_id ?>" id="delete">
                                            <!-- Affiche - ou + en fonction de la quantité dans le panier -->
                                            <?= $product->cart_quantity <= 1 ? '<i class="fa-solid fa-xmark"></i>' : '<i class="fa-solid fa-minus"></i>' ?>
                                        </button>
                                    </form>
                                </div>
                            <?php
                                // Ajoute 1 à la quantité du produit sélectionné
                                if (isset($_POST['add' . $product->cart_id])) {
                                    $requestUpdateCart = $bdd->prepare("UPDATE `carts` SET `cart_quantity`= :cart_quantity WHERE product_id = :product_id");
                                    $requestUpdateCart->execute([
                                        'cart_quantity' => $product->cart_quantity + 1,
                                        'product_id' => $product->product_id
                                    ]);
                                    echo '<i class="fa-solid fa-circle-check" style="color: #0cad00;"></i> Article ajouté au panier.';
                                    header('Location: cartPage.php');
                                }

                                // décrémente ou supprime un produit du panier 
                                if (isset($_POST['delete' . $product->cart_id])) {
                                    if ((int)$product->cart_quantity > 1) {
                                        $requestUpdateCart = $bdd->prepare("UPDATE `carts` SET `cart_quantity`= :cart_quantity WHERE user_id = :user_id AND product_id = :product_id");
                                        $requestUpdateCart->execute([
                                            'cart_quantity' => $product->cart_quantity - 1,
                                            'user_id' => $_SESSION['user']->user_id,
                                            'product_id' => $product->product_id
                                        ]);
                                    } elseif ((int)$product->cart_quantity == 1) {
                                        $requestDeleteCart = $bdd->prepare("DELETE FROM `carts` WHERE user_id = :user_id AND product_id = :product_id ");
                                        $requestDeleteCart->execute([
                                            'user_id' => $_SESSION['user']->user_id,
                                            'product_id' => $product->product_id
                                        ]);
                                    }
                                    header('Location: cartPage.php');
                                }
                            }
                        } else { ?>
                            <div class="cartVide">
                                <p>Votre panier est vide !</p>
                                <a href="./itemFilter.php"><button>Découvrez nos produits</button></a>
                            </div>
                            <?php }
                    } else {

                        // Si le panier de l'utilisateur pas connecté n'est pas vide
                        if (!empty($_SESSION['panier']['id_article'])) {
                            // Récupère les infos de tout les produits
                            foreach ($_SESSION['panier']['id_article'] as $element) {
                                $returnCartSession = $bdd->prepare("SELECT * from products INNER JOIN images ON products.product_id = images.product_id WHERE products.product_id = :product_id AND image_main = 1");
                                $returnCartSession->execute(['product_id' => $element]);
                                $resultSession = $returnCartSession->fetch(PDO::FETCH_OBJ);
                                $a = array_search($element, $_SESSION['panier']['id_article']); // $key = 2;
                            ?>
                                <div class="cartDetail">
                                    <div class="cartProduct">
                                        <div class="cartImage">
                                            <img src="../assets/img_item/<?= $resultSession->image_name ?>" alt="">
                                        </div>
                                        <div class="cartInfo">
                                            <a href="./detail.php?id=<?= $resultSession->product_id ?>">
                                                <p class="name"><?= htmlspecialchars(CoupePhrase($resultSession->product_name)) ?></p>
                                            </a>
                                            <p class="stock"><?= htmlspecialchars($resultSession->product_stock) ?></p>
                                        </div>
                                    </div>
                                    <p class="price"><?= htmlspecialchars($resultSession->product_price) ?>€</p>
                                    <p class="quantity"><?= $_SESSION['panier']['qte'][$a]; ?></p>
                                    <form action="" method="post">
                                        <button type="submit" name="add<?= $element ?>" id="add" style="background-color:transparent">
                                            <i class="fa-solid fa-plus"></i>
                                        </button>
                                        <button type="submit" name="delete<?= $element ?>" id="delete">
                                            <!-- Affiche - ou + en fonction de la quantité dans le panier -->
                                            <?= $_SESSION['panier']['qte'][$a] <= 1 ? '<i class="fa-solid fa-xmark"></i>' : '<i class="fa-solid fa-minus"></i>' ?>

                                        </button>
                                    </form>

                                </div>
                            <?php
                                // Ajoute 1 a la quantité si l'utilisateur click sur le +
                                if (isset($_POST['add' . $element])) {
                                    modif_qte($element, '+');
                                    header('Location: cartPage.php');
                                }
                                // Supprime ou décrémente le produit 
                                if (isset($_POST['delete' . $element])) {
                                    if ((int)$_SESSION['panier']['qte'][$a] > 1) {
                                        modif_qte($element, '-');
                                        header('Location: cartPage.php');
                                    } else {
                                        supprim_article($element);
                                        header('Location: cartPage.php');
                                    }
                                }
                            }
                        } else { ?>
                            <div class="cartVide">
                                <p>Votre panier est vide !</p>
                                <a href="./itemFilter.php"><button>Découvrez nos produits</button></a>
                            </div>
                    <?php }
                    } ?>
                </div>

                <div class="order">
                    <div class="total">
                        <div class="totalDetail">
                            <?php
                            if (isset($_SESSION['user'])) {

                                // Récupère les prix dans un tableau
                                $prices = [];
                                foreach ($result_cart as $cartProduct) {
                                    if ($cartProduct->cart_quantity > 1) {
                                        for ($i = 1; $i < (int)$cartProduct->cart_quantity; $i++) {
                                            array_push($prices, $cartProduct->product_price);
                                        }
                                    }
                                    array_push($prices, $cartProduct->product_price);
                                }

                                $total = array_sum($prices);
                            }

                            if (isset($_SESSION['user'])) {

                                if (isset($_POST['SubmitCode'])) {
                                    // Récupération du code promo rentrer par l'utilisateur
                                    $returnCode = $bdd->prepare('SELECT * FROM codes WHERE code_name = :code_name');
                                    $returnCode->execute(['code_name' => $_POST['code']]);
                                    $result_code = $returnCode->fetch(PDO::FETCH_OBJ);

                                    // Si le code promo existe, nouveau prix avec la réduction
                                    if ($result_code) {
                                        $discount = (intval($result_code->code_discount) * $total) / 100;
                                        $total = $total - $discount;
                                        $CODE_MESSAGE = sprintf('Code %s appliqué (%d%%)', $result_code->code_name, $result_code->code_discount);
                                        $_SESSION['code'] = $result_code->code_discount;
                                    } else {
                                        $CODE_MESSAGE  = 'Code promo invalide';
                                        unset($_SESSION['code']);
                                    }
                                }

                            ?>
                                <!-- Calcul du prix HT et de la TVA -->
                                <p>HT : <?= returnPriceHT($total) ?>€</p>
                                <p>TVA : <?= returnAmountTVA($total, returnPriceHT($total)) ?>€</p>
                                <hr>
                                <p class="priceTotal">TTC : <?= number_format($total, 2) ?>€</p>

                            <?php } else { ?>
                                <!-- Calcul du prix HT et de la TVA Pour l'utilisateur pas connecté-->
                                <p>HT : <?= returnPriceHT(montant_panier()) ?>€</p>
                                <p>TVA : <?= returnAmountTVA(montant_panier(), returnPriceHT(montant_panier())) ?>€</p>
                                <hr>
                                <p class="priceTotal">TTC : <?= montant_panier() ?>€</p>
                            <?php } ?>
                        </div>
                    </div>
                    <?php
                    if (isset($_SESSION['user'])) {
                        // Si le panier n'est pas vide
                        if (!empty($result_cart)) { ?>
                            <div class="BoxFormCodeFormAddress">
                                <form method="POST" id="FormCode">
                                    <input type="text" name="code" placeholder="CODE PROMO">
                                    <button type="submit" name="SubmitCode"><i class="fa-solid fa-plus"></i></button>
                                </form>
                                <p><?= isset($CODE_MESSAGE) ? $CODE_MESSAGE : ''; ?></p>
                                <form action="" method="post" class="formOrder">
                                    <p>Choisissez Votre Adresse</p>
                                    <div class="formOrderAddress">
                                        <select name="address" id="">
                                            <?php
                                            foreach ($allUserAddresses as $userAddress) {
                                                $orderAddress = sprintf('%d %s, %d %s', htmlspecialchars($userAddress->address_numero), htmlspecialchars($userAddress->address_name), htmlspecialchars($userAddress->address_postcode), htmlspecialchars($userAddress->address_city));
                                            ?>
                                                <option value="<?= $orderAddress ?>">
                                                    <?= $orderAddress ?>
                                                </option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <p class=""><?= isset($ORDER_ERROR) ? $ORDER_ERROR : '' ?></p>
                                    <div class="formOrderValide">
                                        <input type="submit" name="valider" value="Passer la commande">
                                    </div>
                                </form>
                            </div>
                        <?php
                        }
                    } else {
                        // Si le panier n'est pas vide quand l'utilisateur n'est pas connecté
                        if (!empty($_SESSION['panier']['id_article'])) { ?>
                            <div class="BoxFormCodeFormAddress">
                                <form action="" method="post" class="formOrder">
                                    <div class="formOrderValide">
                                        <a href="./connect.php" class="LinkConnect">
                                            <button type="button" class="ButtonConnect">
                                                <span id="connect">Se connecter pour commander</span>
                                            </button>
                                        </a>
                                    </div>
                                </form>
                            </div>
                    <?php
                        }
                    }
                    ?>
                </div>
            </div>
        </section>
    </main>
    <?php require_once('./include/footer.php') ?>
</body>
<style>

</style>

</html>