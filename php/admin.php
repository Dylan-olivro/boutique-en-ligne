<?php
require_once('./class/user.php');
require_once('./class/item.php');
require_once('./class/category.php');
ob_start('ob_gzhandler');

if ($_SESSION['user']->role !== 2) {
    header('Location: ../index.php');
}

// AJOUT DES ITEMS
if (isset($_POST['addItem'])) {
    $name = trim(htmlspecialchars($_POST['name']));
    $description = trim(htmlspecialchars($_POST['description']));
    $date = date("Y-m-d H:i:s");
    $price = trim(htmlspecialchars($_POST['price']));;
    $stock = trim(htmlspecialchars($_POST['stock']));;
    $category = trim(htmlspecialchars($_POST['category']));;

    $item = new Item(null, $name, $description, $date, $price, $stock, $category);
    $itemCategory = new Category(null, null, $category);

    $item->addItem($bdd);
    $itemCategory->liaisonItemCategory($bdd);
}
// SUPPRIMER DES ITEMS
if (isset($_POST['deleteItem'])) {
    $id_item = $_POST['id_item'];
    $item = new Item($id_item, null, null, null, null, null, null);
    $item->deleteItem($bdd);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <!-- CSS -->
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/admin.css">
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
    <!-- <script src="../js/admin.js" defer></script> -->

</head>

<body>
    <?php require_once('./include/header.php');
    ?>
    <main>
        <!-- <div id="nav">
            <p id="titleUser">User</p>
            <p id="titleItem">Item</p>
            <p id="titleCategory">Category</p>
        </div> -->
        <section id="container">
            <!-- SECTION POUR LES ITEMS -->
            <h2>ITEMS</h2>
            <div id="divItem">

                <div id="addItem">
                    <h3>Ajouter un Produit</h3>
                    <form action="" method="post" id="formItem">

                        <label for="name">Name</label>
                        <input type="text" id="name" name="name">

                        <label for="description">description</label>
                        <input type="text" id="description" name="description">

                        <label for="price">price</label>
                        <input type="text" id="price" name="price">

                        <label for="stock">stock</label>
                        <input type="number" id="stock" name="stock">

                        <label for="category">Category</label>
                        <input type="number" id="category" name="category">

                        <input type="submit" name="addItem" value="Ajouter">
                    </form>
                </div>

                <div id="deleteItem">
                    <h3>Supprimer un item</h3>

                    <form action="" method="post">
                        <input type="number" name="id_item">
                        <input type="submit" name="deleteItem" value="Supprimer">
                    </form>
                </div>

                <div id="editItem">
                    <h3>Modifier un item</h3>
                    <form action="" method="get">
                        <input type="number" name="id_item2">
                        <input type="submit" name="editItem" value="Modifier">
                    </form>
                    <?php
                    if (isset($_GET['id_item2'])) {
                        $id_item = $_GET['id_item2'];
                        $item = new Item($id_item, null, null, null, null, null, null);
                        $info = $item->returnItem($bdd);
                        // var_dump($info->name);
                    ?>
                        <h3>Update Item</h3>
                        <form action="" method="post">
                            <label for="name2">Name</label>
                            <input type="text" id="name2" name="name2" value="<?= $info->name ?>">

                            <label for="description2">description</label>
                            <input type="text" id="description2" name="description2" value="<?= $info->description ?>">

                            <label for="price2">price</label>
                            <input type="text" id="price2" name="price2" value="<?= $info->price ?>">

                            <label for="stock2">stock</label>
                            <input type="number" id="stock2" name="stock2" value="<?= $info->stock ?>">

                            <label for="image2">image</label>
                            <input type="text" id="image2" name="image2" value="<?= $info->image ?>">

                            <input type="submit" name="updateItem" value="Update">
                        </form>
                    <?php
                        if (isset($_POST['updateItem'])) {
                            $name = trim(htmlspecialchars($_POST['name2']));
                            $description = trim(htmlspecialchars($_POST['description2']));
                            $price = $_POST['price2'];
                            $stock = $_POST['stock2'];
                            $image = $_POST['image2'];

                            $item = new Item($id_item, $name, $description, null, $price, $stock, $image);
                            $item->editItem($bdd);
                            header('Location: admin.php');
                        }
                    }
                    ?>
                </div>
            </div>

            <!-- SECTION POUR LES CATEGORIES -->
            <h2>CATEGORY</h2>
            <div id="divCategory">
            </div>

            <!-- SECTION POUR LES USERS -->
            <h2>USER</h2>
            <div id="divUser">
                <div class="w-75">
                    <h1 class="text-center m-4">All Users</h1>
                    <?php
                    if ($_SESSION['user']->role > 0) {
                        $request = $bdd->prepare("SELECT * FROM users ");
                        $request->execute();
                        $result = $request->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($result as $key => $value) { ?>

                            <form method="post" class="d-flex flex-wrap justify-content-center" id="formUser">
                                <div class="w-25 border rounded text-center m-2 pb-2 bg-primary-subtle">
                                    <p class="m-1">Email : <?= $value['email'] ?></p>
                                    <p class="m-1">User : <?= $value['firstname'] ?></p>
                                    <p class="m-1">Role :
                                        <?php if ($value['role'] == 2) {
                                            echo 'Administrator';
                                        } else if ($value['role'] == 1) {
                                            echo 'Moderator';
                                        } else {
                                            echo 'Aucun';
                                        }
                                        ?>
                                    </p>
                                    <?php
                                    if ($_SESSION['user']->role == 2) {
                                    ?>
                                        <label for="<?= $value['id'] ?>">Admin</label>
                                        <input type="radio" id="<?= $value['id'] ?>" value="2" name="role">
                                        <label for="<?= $value['id'] ?>">Modo</label>
                                        <input type="radio" id="<?= $value['id'] ?>" value='1' name="role">
                                        <label for="<?= $value['id'] ?>">Aucun</label>
                                        <input type="radio" id="<?= $value['id'] ?>" value="0" name="role">
                                        <br>
                                        <input type="submit" id="<?= $value['id'] ?>" value="Update" name="update<?= $value['id'] ?>" class="bg-black rounded text-white mt-2">
                                </div>
                    <?php }
                                    if (isset($_POST['update' . $value['id']])) {

                                        $accept = $bdd->prepare("UPDATE users SET role = ? WHERE id = ? ");
                                        $accept->execute([$_POST['role'], $value['id']]);
                                        header('Location: ./admin.php');
                                    }
                                }
                            }
                    ?>
                            </form>
                </div>
                <div>
                    <h2 class="mt-4 mb-4">Moderator & Administrator</h2>
                    <div>

                        <!-- Affichage Administrateur -->
                        <h4>Admin</h4>
                        <?php
                        foreach ($result as $key => $value) {
                            if ($value['role'] == 2) : ?>
                                <p class="text-warning fw-bold fs-5"><?= $value['firstname'] ?>, <?= $value['email'] ?>.</p>
                        <?php
                            endif;
                        }
                        ?>

                        <!-- Affichage modérateur -->
                        <h4>Moderator</h4>
                        <?php
                        foreach ($result as $key => $value) {
                            if ($value['role'] == 1) : ?>
                                <p class="text-warning fw-bold fs-5"><?= $value['firstname'] ?>, <?= $value['email'] ?>.</p>
                        <?php
                            endif;
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
    /* onclick="return confirm(`Voulez vous vraiment supprimer votre compte ?`)">Supprimer le compte */
</style>

</html>