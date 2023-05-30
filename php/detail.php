<?php
require_once('./class/user.php');

if (isset($_POST['ajouter'])) {
    $insertIntoPanier = $bdd->prepare('INSERT INTO cart (id_user,id_item) VALUES(?,?)');
    $insertIntoPanier->execute([$_SESSION['user']->id, trim(intval($_GET['id']))]);
    header('Location: detail.php?id=' . $_GET['id']);
}


$recupItem = $bdd->prepare("SELECT * FROM items WHERE id = ?");
$recupItem->execute([$_GET['id']]);
$resultItem = $recupItem->fetch(PDO::FETCH_OBJ);
// var_dump($resultItem);

$image = new Image(null, $_GET['id'], null, null);
$result = $image->returnImagesByID($bdd);
// var_dump($result);

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
    <script src="../js/autocompletion.js" defer></script>
    <script src="../js/detail.js" defer></script>

</head>

<body>
    <?php require_once('./include/header.php');
    // var_dump($resultItem->image);
    ?>
    <main>

        <section id="container">
            <div id="item">
                <div id="imageItem">
                    <img src="../assets/img_item/<?= $result[0]->name ?>" alt="">
                </div>
                <div id="detailItem">
                    <p><?= $resultItem->name ?></p>

                    <div id="description">Description :
                        <p><?= $resultItem->description ?></p>
                    </div>

                    <div id="price_cart">
                        <p><?= $resultItem->price ?></p>
                        <?php
                        if (isset($_SESSION['user'])) { ?>
                            <form action="" method="post">
                                <input type="submit" name="ajouter" value="Ajouter au panier">
                            </form>
                        <?php
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