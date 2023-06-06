<?php
require_once('./include/required.php');
// ! OBLIGER DE RENTRER DES CHIFFRES DANS LES CHAMPS NUMBER ET PAS e OU -  
// ! VERIFIER QUE LES CHAMPS priceItem, StockItem et categoryItem MARCHE ENCORE AVEC intval()
// ! NE PAS OUBLIER DE CHANGER LES VALUES DES INPUT

// Empêche les utilisateurs qui ne sont pas ADMINISTRATEUR ou MODERATEUR de venir sur cette page
if ($_SESSION['user']->role == 0) {
    header('Location: ../index.php');
}

// Insert un produit avec une catégorie et une image
if (isset($_POST['buttonAddItem'])) {
    $nameItem = trim(h($_POST['nameItem']));
    $descriptionItem = trim(h($_POST['descriptionItem']));
    $date = date("Y-m-d H:i:s");
    $priceItem = trim(h(intval($_POST['priceItem'])));
    $stockItem = trim(h(intval($_POST['stockItem'])));
    $categoryItem = trim(h(intval($_POST['categoryItem'])));
    // $mainImage = trim(h(intval($_POST['mainImage'])));

    $item = new Item(null, $nameItem, $descriptionItem, $date, $priceItem, $stockItem);
    $category = new Category(null, null, $categoryItem);
    $item->addItem($bdd);
    $category->liaisonItemCategory($bdd);
    if (isset($_FILES['file'])) {
        // Récupère l'ID du dernier produit ajouter
        $returnLastID = $bdd->prepare("SELECT id FROM items ORDER BY items.id DESC");
        $returnLastID->execute();
        $resultID =  $returnLastID->fetch(PDO::FETCH_OBJ);

        $file = $_FILES['file'];
        $image = new Image(null, $resultID->id, $file, 1);
        $image->addImage($bdd);
    }
    header('Location: admin.php');
}

// Supprime un produit choisi en fonction de son ID
if (isset($_POST['buttonDeleteItem'])) {
    $itemID = trim(intval($_POST['itemID']));
    $item = new Item($itemID, null, null, null, null, null, null);
    $item->deleteItem($bdd);
}

// Insert une catégorie Parent/Enfant
if (isset($_POST['buttonAddCategory'])) {
    $nameCategory = trim(h($_POST['nameCategory']));
    $idParent = trim(h(intval($_POST['idParent'])));

    $category = new Category(null, $nameCategory, $idParent);
    $category->addCategory($bdd);
}

// Supprime une catégorie Parent/Enfant
if (isset($_POST['buttonDeleteCategory'])) {
    $idCategory = trim(h(intval($_POST['idCategory'])));;

    $category = new Category($idCategory, null, null);
    $category->deleteCategory($bdd);
}

// Permet de modifier le nom d'une catégorie
if (isset($_POST['buttonUpdateCategory'])) {
    $updateIdCategory = trim(h(intval($_POST['updateIdCategory'])));
    $updateNameCategory = trim(h($_POST['updateNameCategory']));

    $category = new Category($updateIdCategory, $updateNameCategory, null);
    $category->updateCategory($bdd);
}

// Permet d'ajouter d'autres images à un produit
if (isset($_POST['insertImage'])) {
    if (isset($_FILES['imageSecondary'])) {
        $file = $_FILES['imageSecondary'];
        $itemID = $_POST['imageID'];
        $image = new Image(null, $itemID, $file, 0);
        $image->addImage($bdd);
        header('Location: admin.php');
    }
}

// fonction pour récupérer l'ID d'un produit
function getEditItemID()
{
    if (isset($_GET['editItemID'])) {
        $id = trim(h(intval($_GET['editItemID'])));
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
    <script src="../js/header.js" defer></script>
    <script src="../js/autocompletion.js" defer></script>
    <!-- <script src="../js/admin.js" defer></script> -->

</head>

<body>
    <?php require_once('./include/header.php'); ?>
    <?php require_once('./include/header-save.php') ?>

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
                <!-- Formulaire pour AJOUTER un produit -->
                <div id="addItem">
                    <h3>Ajouter un Produit</h3>
                    <form action="" method="post" id="formAddItem" enctype="multipart/form-data">

                        <label for="nameItem">Name</label>
                        <input type="text" id="nameItem" name="nameItem">

                        <label for="descriptionItem">Description</label>
                        <input type="text" id="descriptionItem" name="descriptionItem">

                        <label for="priceItem">Price</label>
                        <input type="text" id="priceItem" name="priceItem">

                        <label for="stockItem">Stock</label>
                        <input type="number" id="stockItem" name="stockItem" value="500">

                        <label for="categoryItem">Category</label>
                        <input type="number" id="categoryItem" name="categoryItem">

                        <label for="file">Image</label>
                        <input type="file" id="file" name="file">

                        <input type="submit" name="buttonAddItem" value="Ajouter">
                    </form>
                </div>

                <div id="deleteItem">
                    <h3>Supprimer un item</h3>
                    <!-- Formulaire pour SUPPRIMER un produit -->
                    <form action="" method="post" id="formDeleteItem">
                        <label for="itemID">ID de l'item</label>
                        <input type="number" name="itemID" id="itemID">
                        <input type="submit" name="buttonDeleteItem" value="Supprimer">
                    </form>
                </div>

                <div id="editItem">
                    <h3>Modifier un item</h3>
                    <!-- Formulaire pour MODIFIER un produit -->
                    <form action="" method="get" id="formEditItem">
                        <label for="editItemID">ID item</label>
                        <input type="number" name="editItemID" id="editItemID" value="<?= hd(getEditItemID()); ?>">
                        <input type="submit" name="editItem" value="Modifier">
                    </form>
                    <?php
                    if (isset($_GET['editItemID'])) {
                        $editItemID = trim(h(intval($_GET['editItemID'])));
                        $item = new Item($editItemID, null, null, null, null, null);
                        $infoItem = $item->returnItem($bdd);
                    ?>
                        <h3>Update Item</h3>
                        <!-- Affichage du produit à modifier -->
                        <form action="" method="post" id="formUpdateItem">
                            <label for="updateNameItem">Name</label>
                            <input type="text" id="updateNameItem" name="updateNameItem" value="<?= hd($infoItem->name) ?>">

                            <label for="updateDescriptionItem">Description</label>
                            <input type="text" id="updateDescriptionItem" name="updateDescriptionItem" value="<?= hd($infoItem->description) ?>">

                            <label for="updatePriceItem">Price</label>
                            <input type="text" id="updatePriceItem" name="updatePriceItem" value="<?= hd($infoItem->price) ?>">

                            <label for="updateSotckItem">Stock</label>
                            <input type="number" id="updateSotckItem" name="updateSotckItem" value="<?= hd($infoItem->stock) ?>">

                            <input type="submit" name="updateItem" value="Update">
                        </form>
                    <?php
                        // Mise à jour des informations du produit
                        if (isset($_POST['updateItem'])) {
                            $updateNameItem = trim(h($_POST['updateNameItem']));
                            $updateDescriptionItem = trim(h($_POST['updateDescriptionItem']));
                            $updatePriceItem = trim(h(intval($_POST['updatePriceItem'])));
                            $updateSotckItem = trim(h(intval($_POST['updateSotckItem'])));
                            $updateImageItem = trim(h($_POST['updateImageItem']));

                            $item = new Item($editItemID, $updateNameItem, $updateDescriptionItem, null, $updatePriceItem, $updateSotckItem);
                            $item->editItem($bdd);
                        }
                    }
                    ?>
                </div>
                <div>
                    <h3>image</h3>
                    <!-- Formulaire pour AJOUTER des images à un produit -->
                    <form action="" method="post" enctype="multipart/form-data">
                        <input type="number" name="imageID" id="imageID">
                        <input type="file" name="imageSecondary">
                        <input type="submit" name="insertImage">
                    </form>
                </div>
            </div>

            <!-- SECTION POUR LES CATEGORIES -->
            <h2>CATEGORY</h2>
            <div id="divCategory">
                <div id="addCategory">
                    <!-- Formulaire pour AJOUTER une catégorie -->
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
                    <!-- Formulaire pour SUPPRIMER une catégorie -->
                    <form action="" method="post" id="formDeleteCategory">
                        <label for="idCategory">ID category</label>
                        <input type="text" name="idCategory" id="idCategory">
                        <input type="submit" name="buttonDeleteCategory" value="Supprimer">
                    </form>
                </div>

                <div id="updateCategory">
                    <h3>Modifier une Categorie</h3>
                    <!-- Formulaire pour MODIFIER une catégorie -->
                    <form action="" method="post" id="formUpdateCategory">
                        <label for="updateIdCategory">ID category</label>
                        <input type="text" name="updateIdCategory" id="updateIdCategory">
                        <label for="updateNameCategory">New Name</label>
                        <input type="text" name="updateNameCategory" id="updateNameCategory">
                        <input type="submit" name="buttonUpdateCategory" value="Modifier">
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
                        // Récupération de tous les utilisateurs 
                        $request = $bdd->prepare("SELECT * FROM users ");
                        $request->execute();
                        $result = $request->fetchAll(PDO::FETCH_ASSOC);
                        // Affichage des utilisateurs
                        foreach ($result as $key => $value) { ?>

                            <form method="post" class="d-flex flex-wrap justify-content-center" id="formUser">
                                <div class="w-25 border rounded text-center m-2 pb-2 bg-primary-subtle">
                                    <p class="m-1">Email : <?= hd($value['email']) ?></p>
                                    <p class="m-1">User : <?= hd($value['firstname']) ?></p>
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
                                    <?php if ($_SESSION['user']->role == 2) { ?>
                                        <!-- Formulaire pour MODIFIER le ROLE d'un utilisateur -->
                                        <label for="<?= $value['id'] ?>">Admin</label>
                                        <input type="radio" id="<?= $value['id'] ?>" value="2" name="role">
                                        <label for="<?= $value['id'] ?>">Modo</label>
                                        <input type="radio" id="<?= $value['id'] ?>" value='1' name="role">
                                        <label for="<?= $value['id'] ?>">Aucun</label>
                                        <input type="radio" id="<?= $value['id'] ?>" value="0" name="role">
                                        <br>
                                        <input type="submit" id="<?= $value['id'] ?>" value="Update" name="update<?= $value['id'] ?>" class="bg-black rounded text-white mt-2">
                                </div>
                    <?php
                                    }
                                    // Mise à jour du ROLE d'un utilisateur
                                    if (isset($_POST['update' . $value['id']])) {
                                        $accept = $bdd->prepare("UPDATE users SET role = ? WHERE id = ? ");
                                        $accept->execute([intval($_POST['role']), $value['id']]);
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

                        <!-- Affichage des Administrateur -->
                        <h4>Admin</h4>
                        <?php
                        foreach ($result as $key => $value) {
                            if ($value['role'] == 2) : ?>
                                <p class="text-warning fw-bold fs-5"><?= hd($value['firstname']) ?>, <?= hd($value['email']) ?>.</p>
                        <?php
                            endif;
                        }
                        ?>

                        <!-- Affichage des modérateur -->
                        <h4>Moderator</h4>
                        <?php
                        foreach ($result as $key => $value) {
                            if ($value['role'] == 1) : ?>
                                <p class="text-warning fw-bold fs-5"><?= hd($value['firstname']) ?>, <?= hd($value['email']) ?>.</p>
                        <?php
                            endif;
                        }
                        ?>
                    </div>
                </div>
            </div>

        </section>
    </main>
</body>
<style>
    /* onclick="return confirm(`Voulez vous vraiment supprimer votre compte ?`)">Supprimer le compte */
</style>

</html>