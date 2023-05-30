<?php
require_once('./class/user.php');
// ! FAIRE UNE CLASSE CART

if (!isset($_SESSION['user'])) {
    header('Location:../index.php');
}

$returnCart = $bdd->prepare("SELECT * from cart INNER JOIN items ON cart.id_item = items.id WHERE id_user = ?");
$returnCart->execute([$_SESSION['user']->id]);
$result = $returnCart->fetchAll(PDO::FETCH_OBJ);
var_dump($result);

if (isset($_POST['valider'])) {
    $date = date("Y-m-d H:i:s");
    $insertCommand = $bdd->prepare('INSERT INTO command (id_user,date) VALUES (?,?)');
    $insertCommand->execute([$_SESSION['user']->id, $date]);

    $recupCommandID = $bdd->prepare('SELECT id FROM command ORDER BY date DESC');
    $recupCommandID->execute();
    $resultID = $recupCommandID->fetch(PDO::FETCH_OBJ);
    // var_dump($resultID);
    $prices = [];
    foreach ($result as $key) {
        array_push($prices, $key->price);

        $insertLiaison = $bdd->prepare('INSERT INTO liaison_cart_command (id_command,id_item) VALUES (?,?)');
        $insertLiaison->execute([$resultID->id, $key->id_item]);
    }
    $total = array_sum($prices);

    $insertCommand = $bdd->prepare('UPDATE command SET total = ? WHERE id = ? ');
    $insertCommand->execute([$total, $resultID->id]);

    $deletePanier = $bdd->prepare('DELETE FROM cart WHERE id_user = ?');
    $deletePanier->execute([$_SESSION['user']->id]);
    header('Location: cart.php');
}

if (isset($_POST['vider'])) {
    $deletePanier = $bdd->prepare('DELETE FROM cart WHERE id_user = ?');
    $deletePanier->execute([$_SESSION['user']->id]);
    header('Location: cart.php');
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
    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <!-- JQUERY -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <!-- FONTAWESOME -->
    <script src="https://kit.fontawesome.com/9a09d189de.js" crossorigin="anonymous"></script>
    <!-- JAVASCRIPT -->
    <script src="../js/function.js" defer></script>
    <script src="../js/autocompletion.js" defer></script>
    <!-- <script src="../js/user/connectJS.js" defer></script> -->

</head>

<body>
    <?php require_once('./include/header.php'); ?>
    <main>
        <form action="" method="post">
            <input type="submit" name="vider" value="Vider le panier">
        </form>

        <form action="" method="post">
            <input type="submit" name="valider" value="valider panier">
        </form>
    </main>
    <?php require_once('./include/header-save.php') ?>

</body>
<style>

</style>

</html>