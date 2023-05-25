<?php
require_once('./class/user.php');
require_once('./class/item.php');
require_once('./class/category.php');
ob_start('ob_gzhandler');

if ($_SESSION['user']->role !== 2) {
    header('Location: ../index.php');
}
// AJOUT DES ITEMS
if (isset($_POST['buttonAddItem'])) {
    $nameItem = trim(htmlspecialchars($_POST['nameItem']));
    $descriptionItem = trim(htmlspecialchars($_POST['descriptionItem']));
    $date = date("Y-m-d H:i:s");
    $priceItem = trim(htmlspecialchars($_POST['priceItem']));;
    $stockItem = trim(htmlspecialchars($_POST['stockItem']));;
    $categoryItem = trim(htmlspecialchars($_POST['categoryItem']));;

    $item = new Item(null, $nameItem, $descriptionItem, $date, $priceItem, $stockItem);
    $category = new Category(null, null, $categoryItem);

    $item->addItem($bdd);
    $category->liaisonItemCategory($bdd);
}

// SUPPRIMER DES ITEMS
if (isset($_POST['buttonDeleteItem'])) {
    $itemID = $_POST['itemID'];
    $item = new Item($itemID, null, null, null, null, null, null);
    $item->deleteItem($bdd);
}

// AJOUTER UNE CATEGORIE
if (isset($_POST['buttonAddCategory'])) {
    $nameCategory = trim(htmlspecialchars($_POST['nameCategory']));
    $idParent = trim(htmlspecialchars($_POST['idParent']));

    $category = new Category(null, $nameCategory, $idParent);
    $category->addCategory($bdd);
}

// SUPPRIMER UNE CATEGORIE
if (isset($_POST['buttonDeleteCategory'])) {
    $idCategory = trim(htmlspecialchars($_POST['idCategory']));;

    $category = new Category($idCategory, null, null);
    $category->deleteCategory($bdd);
}

function getEditItemID()
{
    if (isset($_GET['editItemID'])) {
        $id = intval($_GET['editItemID']);
        // var_dump($id);
        return $id;
    }
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
                    <form action="" method="post" id="formAddItem">

                        <label for="nameItem">Name</label>
                        <input type="text" id="nameItem" name="nameItem">

                        <label for="descriptionItem">Description</label>
                        <input type="text" id="descriptionItem" name="descriptionItem">

                        <label for="priceItem">Price</label>
                        <input type="text" id="priceItem" name="priceItem">

                        <label for="stockItem">Stock</label>
                        <input type="number" id="stockItem" name="stockItem">

                        <label for="categoryItem">Category</label>
                        <input type="number" id="categoryItem" name="categoryItem">

                        <input type="submit" name="buttonAddItem" value="Ajouter">
                    </form>
                </div>

                <div id="deleteItem">
                    <h3>Supprimer un item</h3>

                    <form action="" method="post" id="formDeleteItem">
                        <label for="itemID">ID de l'item</label>
                        <input type="number" name="itemID" id="itemID">
                        <input type="submit" name="buttonDeleteItem" value="Supprimer">
                    </form>
                </div>

                <div id="editItem">
                    <h3>Modifier un item</h3>
                    <form action="" method="get" id="formEditItem">
                        <label for="editItemID">ID item</label>
                        <input type="number" name="editItemID" id="editItemID" value="<?= getEditItemID(); ?>">
                        <input type="submit" name="editItem" value="Modifier">
                    </form>
                    <?php
                    if (isset($_GET['editItemID'])) {
                        $editItemID = $_GET['editItemID'];
                        $item = new Item($editItemID, null, null, null, null, null, null);
                        $infoItem = $item->returnItem($bdd);
                        // var_dump($info->name);
                    ?>
                        <h3>Update Item</h3>
                        <form action="" method="post" id="formUpdateItem">
                            <label for="updateNameItem">Name</label>
                            <input type="text" id="updateNameItem" name="updateNameItem" value="<?= $infoItem->name ?>">

                            <label for="updateDescriptionItem">Description</label>
                            <input type="text" id="updateDescriptionItem" name="updateDescriptionItem" value="<?= $infoItem->description ?>">

                            <label for="updatePriceItem">Price</label>
                            <input type="text" id="updatePriceItem" name="updatePriceItem" value="<?= $infoItem->price ?>">

                            <label for="updateSotckItem">Stock</label>
                            <input type="number" id="updateSotckItem" name="updateSotckItem" value="<?= $infoItem->stock ?>">

                            <label for="updateImageItem">Image</label>
                            <input type="text" id="updateImageItem" name="updateImageItem" value="<?= $infoItem->image ?>">

                            <input type="submit" name="updateItem" value="Update">
                        </form>
                    <?php
                        if (isset($_POST['updateItem'])) {
                            $updateNameItem = trim(htmlspecialchars($_POST['updateNameItem']));
                            $updateDescriptionItem = trim(htmlspecialchars($_POST['updateDescriptionItem']));
                            $updatePriceItem = $_POST['updatePriceItem'];
                            $updateSotckItem = $_POST['updateSotckItem'];
                            $updateImageItem = $_POST['updateImageItem'];

                            $item = new Item($editItemID, $updateNameItem, $updateDescriptionItem, null, $updatePriceItem, $updateSotckItem, $updateImageItem);
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
                <div id="addCategory">
                    <h3>Ajouter une Categorie</h3>
                    <form action="" method="post" id="formAddCategory">
                        <label for="nameCategory">Name</label>
                        <input type="text" name="nameCategory" id="nameCategory">
                        <label for="idParent">ID parent</label>
                        <input type="number" name="idParent" id="idParent">
                        <input type="submit" name="buttonAddCategory" value="Ajouter">
                    </form>
                </div>
                <div id="deleteCategory">
                    <h3>Supprimer une Categorie</h3>
                    <form action="" method="post" id="formDeleteCategory">
                        <label for="idCategory">ID category</label>
                        <input type="text" name="idCategory" id="idCategory">
                        <input type="submit" name="buttonDeleteCategory" value="Supprimer">
                    </form>

                </div>
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