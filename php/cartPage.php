<?php
require_once('./include/required.php');

// var_dump(uniqid());
// Empêche les utilisateurs qui ne sont pas connecté de venir sur cette page
if (!isset($_SESSION['user'])) {
    header('Location:../index.php');
}
// Récupère le panier de l'utilisateur
$cart = new Cart(null, $_SESSION['user']->user_id, null);
$result_cart = $cart->returnCart($bdd);

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

                array_push($prices, $cartProduct->product_price);

                $updateStock = $bdd->prepare('UPDATE products SET product_stock = :product_stock WHERE product_id = :product_id');
                $updateStock->execute([
                    'product_stock' => $cartProduct->product_stock - 1,
                    'product_id' => $cartProduct->product_id
                ]);

                $insertLiaison = $bdd->prepare('INSERT INTO liaison_product_order (order_id,product_id) VALUES (:order_id,:product_id)');
                $insertLiaison->execute([
                    'order_id' => $lastInsertId,
                    'product_id' => $cartProduct->product_id
                ]);
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
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connect</title>
    <!-- CSS -->
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/cartPage.css">
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

</head>

<body>
    <?php require_once('./include/header.php'); ?>
    <?php require_once('./include/header-save.php') ?>

    <main>
        <section id="container">
            <!-- <section class="containerCart"> -->
            <div class="sectionCart">
                <h3>Ton Panier</h3>
                <div class="cart">
                    <div class="banniere">
                        <p>Article</p>
                        <p>Prix</p>
                        <form action="" method="post">
                            <button type="submit" name="vider" class="vider"><i class="fa-solid fa-trash-can"></i></button>
                        </form>
                    </div>
                    <?php
                    // Affichage du panier
                    foreach ($result_cart as $product) {
                        // var_dump($product);
                    ?>
                        <div class="cartDetail">
                            <div class="cartProduct">
                                <img src="../assets/img_item/<?= $product->image_name ?>" alt="">
                                <div class="cartInfo">
                                    <a href="./detail.php?id=<?= $product->product_id ?>">
                                        <p><?= htmlspecialchars($product->product_name) ?></p>
                                    </a>
                                    <p><?= htmlspecialchars($product->product_stock) ?> en Stock</p>
                                </div>
                            </div>
                            <p><?= htmlspecialchars($product->product_price) ?>€</p>
                            <form action="" method="post">
                                <button type="submit" name="delete<?= $product->cart_id ?>" id="delete"><i class="fa-solid fa-xmark"></i></button>
                            </form>
                        </div>
                    <?php
                        if (isset($_POST['delete' . $product->cart_id])) {
                            $cart2 = new Cart($product->cart_id, $_SESSION['user']->user_id, $product->product_id);
                            $cart2->deleteProduct($bdd);
                            header('Location: cartPage.php');
                        }
                    }
                    ?>
                    <?php
                    if (!empty($result_cart)) { ?>

                        <form action="" method="post">
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
                            <input type="submit" name="valider" value="valider panier">
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

</body>
<style>

</style>

</html>