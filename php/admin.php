<?php
require_once('./class/user.php');
require_once('./class/item.php');
ob_start('ob_gzhandler');

if ($_SESSION['user']->role !== 2) {
    header('Location: ../index.php');
}

// AJOUT DES ITEMS
if (isset($_POST['addItem'])) {
    $name = trim(htmlspecialchars($_POST['name']));
    $description = trim(htmlspecialchars($_POST['description']));
    $date = date("Y-m-d H:i:s");
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $category = $_POST['category'];

    $item = new Item('', $name, $description, $date, $price, $stock, $category);
    $item->addItem($bdd);
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
    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <!-- JQUERY -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <!-- FONTAWESOME -->
    <script src="https://kit.fontawesome.com/9a09d189de.js" crossorigin="anonymous"></script>
    <!-- JAVASCRIPT -->
    <script src="../js/function.js" defer></script>
    <script src="../js/admin.js" defer></script>
</head>

<body>
    <?php require_once('./include/header.php');
    ?>
    <main>
        <div id="nav">
            <!-- page -->
            <p id="titleUser">User</p>
            <p id="titleItem">Item</p>
            <p id="titleCategory">Category</p>
        </div>
        <section id="container">
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
            <div id="divItem">
                <form action="" method="post" id="formItem">

                    <label for="name">Name</label>
                    <input type="text" id="name" name="name">

                    <label for="description">description</label>
                    <input type="text" id="description" name="description">

                    <label for="name">price</label>
                    <input type="text" id="price" name="price">

                    <label for="name">stock</label>
                    <input type="number" id="stock" name="stock">

                    <label for="name">Category</label>
                    <input type="number" id="category" name="category">

                    <input type="submit" name="addItem" value="Ajouter">
                </form>
            </div>
            <div id="divCategory">
                <p>Je suis le contenu de CATEGORY</p>
            </div>
        </section>
    </main>
    <?php require_once('./include/header-save.php') ?>
</body>
<style>
    /* onclick="return confirm(`Voulez vous vraiment supprimer votre compte ?`)">Supprimer le compte */
</style>

</html>