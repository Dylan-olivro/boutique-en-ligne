<?php
require_once('./include/required.php');

$image = new Image(null, null, null, null);
// $image->returnImages($bdd);
// var_dump($image->returnImages($bdd));
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image</title>
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
    <!-- <script src="../js/detail.js" defer></script> -->

</head>

<body>
    <?php require_once('./include/header.php'); ?>
    <main>
        <form action="" method="POST" enctype="multipart/form-data">
            <input type="file" name="file">
            <input type="submit" name="submit">
        </form>
        <div>
            <?php

            if (isset($_POST['submit'])) {
                if (isset($_FILES['file'])) {
                    $file = $_FILES['file']['name'];
                    $image = new Image(null, 4, $file, null);
                    $image->addImage($bdd);
                    header('Location: image.php');
                }
            }

            $recupImage = $bdd->prepare('SELECT * FROM image');
            $recupImage->execute();
            $result = $recupImage->fetchAll(PDO::FETCH_OBJ);
            foreach ($result as $key) {
                // var_dump($key);
                $image = new Image($key->id, $key->id_item, $key->name, null);
                // $image->addImage($bdd);
            ?>
                <div>
                    <img src="../assets/img_item/<?= $key->name ?>" alt="">
                </div>
                <form action="" method="post">
                    <input type="submit" name="delete<?= $key->id ?>" value="Delete">
                </form>
            <?php
                if (isset($_POST['delete' . $key->id])) {
                    $image->deleteImage($bdd);
                    header('Location: image.php');
                }
            }
            ?>
        </div>

    </main>
    <?php require_once('./include/header-save.php') ?>
</body>
<style>
    img {
        width: 50px;
    }
</style>

</html>