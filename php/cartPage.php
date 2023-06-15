<?php
require_once('./include/required.php');

// var_dump(uniqid());
// Empêche les utilisateurs qui ne sont pas connecté de venir sur cette page
if (!isset($_SESSION['user'])) {
    header('Location:../index.php');
}

// Récupère le panier de l'utilisateur
$cart = new Cart(null, $_SESSION['user']->user_id, null, null);
$result_cart = $cart->returnCart($bdd);
// var_dump($result_cart);
// Récupère les stock dans un tableau
$stock = [];
foreach ($result_cart as $product) {
    array_push($stock, $product->product_stock);
}

$address = new Address(null, $_SESSION['user']->user_id, null, null, null, null, null, null, null);
$allUserAddresses = $address->returnAddressesByUser($bdd);

// Valide le panier de l'utilisateur, créer une commande et vide le panier
if (isset($_POST['valider'])) {
    if (!empty($result_cart)) {
        if (!in_array(0, $stock)) {

            $date = date("Y-m-d H:i:s");
            $order = new Order(null, $_SESSION['user']->user_id, $date, null, null, null);
            $order->addOrder($bdd);

            $lastInsertId = $bdd->lastInsertId();

            $prices = [];
            foreach ($result_cart as $cartProduct) {
                if ($cartProduct->cart_quantity > 1) {
                    for ($i = 1; $i < (int)$cartProduct->cart_quantity; $i++) {
                        array_push($prices, $cartProduct->product_price);
                    }
                }
                array_push($prices, $cartProduct->product_price);

                $updateStock = $bdd->prepare('UPDATE products SET product_stock = :product_stock WHERE product_id = :product_id');
                $updateStock->execute([
                    'product_stock' => $cartProduct->product_stock - (int)$cartProduct->cart_quantity,
                    'product_id' => $cartProduct->product_id
                ]);
                for ($i = 0; $i < (int)$cartProduct->cart_quantity; $i++) {
                    $insertLiaison = $bdd->prepare('INSERT INTO liaison_product_order (order_id,product_id) VALUES (:order_id,:product_id)');
                    $insertLiaison->execute([
                        'order_id' => $lastInsertId,
                        'product_id' => $cartProduct->product_id
                    ]);
                }
            }
            $total = array_sum($prices);
            $orderNumber = str_replace(".", "-", strtoupper(uniqid('', true)));
            $order = new Order($lastInsertId, $_SESSION['user']->user_id, $date, $total, $_POST['adress'], $orderNumber);

            $order->updateOrder($bdd);
            $cart->deleteCart($bdd);
            header('Location: cartPage.php');
        } else {
            $ORDER_ERROR = 'Un article dans votre panier a son stock epuisée';
        }
    } else {
        $ORDER_ERROR = 'Panier vide';
    }
}

// Permet de vider le panier 
if (isset($_POST['vider'])) {
    $cart->deleteCart($bdd);
    header('Location: cartPage.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once('./include/head.php'); ?>
    <title>Connect</title>
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

                    if (!empty($result_cart)) {
                        // Affichage du panier
                        foreach ($result_cart as $product) {
                            // var_dump($product);

                    ?>
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
                                    <button type="submit" name="delete<?= $product->cart_id ?>" id="delete"><i class="fa-solid fa-xmark"></i></button>
                                </form>
                            </div>
                        <?php
                            // var_dump((int)$product->cart_quantity == 1);
                            // var_dump((int)$product->cart_quantity);
                            // var_dump((int)$product->product_id);
                            // * TEST DELETE PRODUCT
                            if (isset($_POST['delete' . $product->cart_id])) {
                                if ((int)$product->cart_quantity > 1) {
                                    $req3 = $bdd->prepare("UPDATE `carts` SET `cart_quantity`= :cart_quantity WHERE user_id = :user_id AND product_id = :product_id");
                                    $req3->execute([
                                        'cart_quantity' => $product->cart_quantity - 1,
                                        'user_id' => $_SESSION['user']->user_id,
                                        'product_id' => $product->product_id
                                    ]);
                                    echo '<i class="fa-solid fa-circle-minus fa-lg" style="color: #ff0000;"></i> Article supprimé du panier.';
                                } elseif ((int)$product->cart_quantity == 1) {
                                    $req = $bdd->prepare("DELETE FROM `carts` WHERE user_id = :user_id AND product_id = :product_id ");
                                    $req->execute([
                                        'user_id' => $_SESSION['user']->user_id,
                                        'product_id' => $product->product_id
                                    ]);
                                    echo '<i class="fa-solid fa-circle-minus fa-lg" style="color: #ff0000;"></i> Article supprimé du panier.';
                                }
                            }
                            // * FIN TEST

                            // if (isset($_POST['delete' . $product->cart_id])) {
                            //     $cart2 = new Cart($product->cart_id, $_SESSION['user']->user_id, $product->product_id, $quantity->quantity);
                            //     $cart2->deleteProduct($bdd);
                            //     header('Location: cartPage.php');
                            // }
                        }
                    } else { ?>
                        <div class="cartVide">
                            <p>Votre panier est vide !</p>
                            <a href="./itemFilter.php"><button>Découvrez nos produits</button></a>
                        </div>
                    <?php
                    }
                    ?>
                </div>

                <div class="order">
                    <div class="total">
                        <div class="totalDetail">
                            <?php
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
                            ?>
                            <p>HT : <?= returnPriceHT($total) ?>€</p>
                            <p>TVA : <?= returnAmountTVA($total, returnPriceHT($total)) ?>€</p>
                            <hr>
                            <p class="priceTotal">TTC : <?= number_format($total, 2) ?>€</p>

                        </div>
                    </div>
                    <?php
                    if (!empty($result_cart)) { ?>

                        <form action="" method="post" class="formOrder">
                            <p>Choisissez Votre Adresse</p>
                            <div class="formOrderAddress">
                                <select name="adress" id="">
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
                            <div class="formOrderValide">
                                <input type="submit" name="valider" value="Passer la commande">
                            </div>
                        </form>

                        <p>
                            <?php
                            if (isset($ORDER_ERROR)) {
                                echo $ORDER_ERROR;
                            }
                            ?>
                        </p>
                    <?php
                    }
                    ?>
                </div>
                <!-- </section> -->
            </div>
        </section>
    </main>
    <?php require_once('./include/footer.php') ?>
</body>
<style>

</style>

</html>