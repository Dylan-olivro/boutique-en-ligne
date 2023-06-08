<?php
require_once('./include/required.php');
// ! FAIRE UNE CLASSE CART

// var_dump(uniqid());
// Empêche les utilisateurs qui ne sont pas connecté de venir sur cette page
if (!isset($_SESSION['user'])) {
    header('Location:../index.php');
}
// Récupère le panier de l'utilisateur
$cart = new Cart(null, $_SESSION['user']->user_id, null);
$result = $cart->returnCart($bdd);

// Récupère les stock dans un tableau
$stock = [];
foreach ($result as $item) {
    array_push($stock, $item->product_stock);
}

$adress = new Address(null, $_SESSION['user']->user_id, null, null, null, null, null, null, null);
$res = $adress->returnAdressByUser($bdd);

// Valide le panier de l'utilisateur, créer une commande et vide le panier
if (isset($_POST['valider'])) {
    if (!empty($result)) {
        if (!in_array(0, $stock)) {

            $date = date("Y-m-d H:i:s");
            $command = new Order(null, $_SESSION['user']->user_id, $date, null, null);
            $command->addCommand($bdd);

            $id = $bdd->lastInsertId();

            $prices = [];
            foreach ($result as $key) {

                array_push($prices, $key->product_price);

                $updateStock = $bdd->prepare('UPDATE products SET product_stock = :product_stock WHERE product_id = :product_id');
                $updateStock->execute([
                    'product_stock' => $key->product_stock - 1,
                    'product_id' => $key->product_id
                ]);

                $insertLiaison = $bdd->prepare('INSERT INTO liaison_product_order (order_id,product_id) VALUES (:order_id,:product_id)');
                $insertLiaison->execute([
                    'order_id' => $id,
                    'product_id' => $key->product_id
                ]);
            }
            $total = array_sum($prices);

            $command = new Order($id, $_SESSION['user']->user_id, $date, $total, $_POST['adress']);

            $command->updateCommand($bdd);
            $cart->deleteCart($bdd);
            header('Location: cartPage.php');
        } else {
            $errorStockMessage = 'Un article dans votre panier a son stock epuisée';
        }
    } else {
        $errorStockMessage = 'Panier vide';
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
        <form action="" method="post">
            <input type="submit" name="vider" value="Vider le panier">
        </form>

        <form action="" method="post">
            <select name="adress" id="">
                <?php
                foreach ($res as $key) {
                    $orderAdress = sprintf('%d %s, %d %s', htmlspecialchars($key->address_numero), htmlspecialchars($key->address_name), htmlspecialchars($key->address_postcode), htmlspecialchars($key->address_city));
                ?>
                    <option value="<?= $orderAdress ?>">
                        <?= $orderAdress ?>
                    </option>
                <?php
                }
                ?>
            </select>
            <input type="submit" name="valider" value="valider panier">
        </form>

        <p>
            <?php
            if (isset($errorStockMessage)) {
                echo $errorStockMessage;
            }
            ?>
        </p>
        <section class="containerCart">

            <div class="cart">

                <?php
                // Affichage du panier
                foreach ($result as $item) { ?>
                    <a href="./detail.php?id=<?= $item->product_id ?>">
                        <div class="cartDetail">
                            <img src="../assets/img_item/<?= $item->image_name ?>" alt="">
                            <div class="cartInfo">
                                <p><?= htmlspecialchars($item->product_name) ?></p>
                                <p><?= htmlspecialchars($item->product_price) ?>€</p>
                                <p><?= htmlspecialchars($item->product_stock) ?> en Stock</p>
                            </div>
                            <form action="" method="post">
                                <input type="submit" name="delete<?= $item->product_id ?>" value="delete">
                            </form>
                        </div>
                    </a>
                <?php
                    if (isset($_POST['delete' . $item->product_id])) {
                        $cart2 = new Cart(null, $_SESSION['user']->user_id, $item->product_id);
                        $cart2->deleteItem($bdd);
                        header('Location: cartPage.php');
                    }
                }
                ?>
            </div>
        </section>
    </main>

</body>
<style>

</style>

</html>