<?php
require_once('./class/user.php');
require_once('./class/item.php');
// session_destroy();
// if (isset($_SESSION['user'])) {
//     header('Location:index.php');
// }
// $date2 = new date();
// var_dump($date);

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $date = date("Y-m-d H:i:s");
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $category = $_POST['category'];

    $item = new Item('', $name, $description, $date, $price, $stock, $category);
    $item->add($bdd);
}


$recupItems2 = $bdd->prepare('SELECT * FROM items INNER JOIN liaison_items_category ON items.id = liaison_items_category.id_item');
$recupItems2->execute();
$res = $recupItems2->fetchAll(PDO::FETCH_ASSOC);
// var_dump($res);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connect</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/9a09d189de.js" crossorigin="anonymous"></script>
</head>

<body>
    <?php require_once('./include/header.php'); ?>
    <main>
        <form action="" method="post">

            <label for="name">Name</label>
            <input type="text" id="name" name="name">

            <label for="description">description</label>
            <input type="text" id="description" name="description">

            <label for="name">price</label>
            <input type="number" id="price" name="price">

            <label for="name">stock</label>
            <input type="number" id="stock" name="stock">

            <label for="name">Category</label>
            <input type="number" id="category" name="category">

            <input type="submit" name="submit">
        </form>
    </main>
    <?php require_once('./include/header-save.php') ?>
</body>
<style>

</style>

</html>