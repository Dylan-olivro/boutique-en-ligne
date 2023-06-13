<?php
require_once('./include/required.php');
// ! OBLIGER DE RENTRER DES CHIFFRES DANS LES CHAMPS NUMBER ET PAS e OU -  
// ! VERIFIER QUE LES CHAMPS priceItem, StockItem et categoryItem MARCHE ENCORE AVEC intval()
// ! NE PAS OUBLIER DE CHANGER LES VALUES DES INPUT

// Empêche les utilisateurs qui ne sont pas ADMINISTRATEUR ou MODERATEUR de venir sur cette page
if ($_SESSION['user']->user_role == 0) {
    header('Location: ../index.php');
}

// Insert un produit avec une catégorie et une image
if (isset($_POST['buttonAddItem'])) {
    $nameItem = trim($_POST['nameItem']);
    $descriptionItem = trim($_POST['descriptionItem']);
    $date = date("Y-m-d H:i:s");
    $priceItem = trim(intval($_POST['priceItem']));
    $stockItem = trim(intval($_POST['stockItem']));
    $categoryItem = trim(intval($_POST['categoryItem']));
    // $mainImage = trim(h(intval($_POST['mainImage'])));

    $product = new Product(null, $nameItem, $descriptionItem, $date, $priceItem, $stockItem);
    $category = new Category(null, null, $categoryItem);
    $product->addProduct($bdd);
    $category->liaisonItemCategory($bdd);
    if (isset($_FILES['file'])) {
        // Récupère l'ID du dernier produit ajouter
        $returnLastID = $bdd->prepare("SELECT product_id FROM products ORDER BY products.product_id DESC");
        $returnLastID->execute();
        $resultID =  $returnLastID->fetch(PDO::FETCH_OBJ);

        $file = $_FILES['file'];
        $image = new Image(null, $resultID->product_id, $file, 1);
        $image->addImage($bdd);
    }
    header('Location: admin.php');
}

// Supprime un produit choisi en fonction de son ID
if (isset($_POST['buttonDeleteItem'])) {
    $itemID = trim(intval($_POST['itemID']));
    $product = new Product($itemID, null, null, null, null, null, null);
    $product->deleteProduct($bdd);
    header('Location: admin.php');
}

// Insert une catégorie Parent/Enfant
if (isset($_POST['buttonAddCategory'])) {
    $nameCategory = trim($_POST['nameCategory']);
    $idParent = trim(intval($_POST['idParent']));

    $category = new Category(null, $nameCategory, $idParent);
    $category->addCategory($bdd);
}

// Supprime une catégorie Parent/Enfant
if (isset($_POST['buttonDeleteCategory'])) {
    $idCategory = trim(intval($_POST['idCategory']));

    $category = new Category($idCategory, null, null);
    $category->deleteCategory($bdd);
}

// Permet de modifier le nom d'une catégorie
if (isset($_POST['buttonUpdateCategory'])) {
    $updateIdCategory = trim(intval($_POST['updateIdCategory']));
    $updateNameCategory = trim($_POST['updateNameCategory']);

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
        $id = trim(intval($_GET['editItemID']));
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
            <p id="titleItem">Product</p>
            <p id="titleCategory">Category</p>
        </div> -->
        <section id="container">
            <!-- SECTION POUR LES ITEMS -->
            <section class="sectionItem">
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

                    <div id="editItem">
                        <h3>Modifier un Product</h3>
                        <!-- Formulaire pour MODIFIER un produit -->
                        <form action="" method="get" id="formEditItem">
                            <label for="editItemID">ID Product</label>
                            <input type="number" name="editItemID" id="editItemID" value="<?= htmlspecialchars(getEditItemID()); ?>">
                            <input type="submit" name="editItem" value="Modifier">
                        </form>
                        <?php
                        if (isset($_GET['editItemID'])) {
                            $editItemID = trim(intval($_GET['editItemID']));
                            $product = new Product($editItemID, null, null, null, null, null);
                            $infoItem = $product->returnProduct($bdd);
                            // var_dump($infoItem);
                            if ($infoItem) {


                        ?>
                                <h3>Update Product</h3>
                                <!-- Affichage du produit à modifier -->
                                <form action="" method="post" id="formUpdateItem">
                                    <label for="updateNameItem">Name</label>
                                    <input type="text" id="updateNameItem" name="updateNameItem" value="<?= htmlspecialchars($infoItem->product_name) ?>">

                                    <label for="updateDescriptionItem">Description</label>
                                    <input type="text" id="updateDescriptionItem" name="updateDescriptionItem" value="<?= htmlspecialchars($infoItem->product_description) ?>">

                                    <label for="updatePriceItem">Price</label>
                                    <input type="text" id="updatePriceItem" name="updatePriceItem" value="<?= htmlspecialchars($infoItem->product_price) ?>">

                                    <label for="updateSotckItem">Stock</label>
                                    <input type="number" id="updateSotckItem" name="updateSotckItem" value="<?= htmlspecialchars($infoItem->product_stock) ?>">

                                    <input type="submit" name="updateItem" value="Update">
                                </form>
                        <?php
                            } else {
                                echo "Ce produit n'existe pas";
                            }
                            // Mise à jour des informations du produit
                            if (isset($_POST['updateItem'])) {
                                $updateNameItem = trim($_POST['updateNameItem']);
                                $updateDescriptionItem = trim($_POST['updateDescriptionItem']);
                                $updatePriceItem = trim(intval($_POST['updatePriceItem']));
                                $updateSotckItem = trim(intval($_POST['updateSotckItem']));
                                $updateImageItem = trim($_POST['updateImageItem']);

                                $product = new Product($editItemID, $updateNameItem, $updateDescriptionItem, null, $updatePriceItem, $updateSotckItem);
                                $product->editProduct($bdd);
                            }
                        }
                        ?>
                    </div>

                    <div class="deleteProduct_addImg">
                        <div id="deleteItem">
                            <h3>Supprimer un Product</h3>
                            <!-- Formulaire pour SUPPRIMER un produit -->
                            <form action="" method="post" id="formDeleteItem">
                                <label for="itemID">ID du Product</label>
                                <input type="number" name="itemID" id="itemID">
                                <input type="submit" name="buttonDeleteItem" value="Supprimer">
                            </form>
                        </div>
                        <div>
                            <h3>image</h3>
                            <!-- Formulaire pour AJOUTER des images à un produit -->
                            <form action="" method="post" enctype="multipart/form-data" class="formImg">
                                <input type="number" name="imageID" id="imageID">
                                <input type="file" name="imageSecondary">
                                <input type="submit" name="insertImage">
                            </form>
                        </div>
                    </div>
                </div>
            </section>
            <!-- SECTION POUR LES CATEGORIES -->
            <section class="sectionCategories">
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
            </section>

            <!-- SECTION POUR LES USERS -->
            <h2>USER</h2>
            <div id="divUser">
                <div class="w-75">
                    <h1 class="text-center m-4">All Users</h1>
                    <?php
                    if ($_SESSION['user']->user_role > 0) {
                        // Récupération de tous les utilisateurs 
                        $request = $bdd->prepare("SELECT * FROM users ");
                        $request->execute();
                        $result = $request->fetchAll(PDO::FETCH_ASSOC);
                        // Affichage des utilisateurs
                        foreach ($result as $key => $value) { ?>

                            <form method="post" class="d-flex flex-wrap justify-content-center" id="formUser">
                                <div class="w-25 border rounded text-center m-2 pb-2 bg-primary-subtle">
                                    <p class="m-1">Email : <?= htmlspecialchars($value['user_email']) ?></p>
                                    <p class="m-1">User : <?= htmlspecialchars($value['user_firstname']) ?></p>
                                    <p class="m-1">Role :
                                        <?php if ($value['user_role'] == 2) {
                                            echo 'Administrator';
                                        } else if ($value['user_role'] == 1) {
                                            echo 'Moderator';
                                        } else {
                                            echo 'Aucun';
                                        }
                                        ?>
                                    </p>
                                    <?php if ($_SESSION['user']->user_role == 2) { ?>
                                        <!-- Formulaire pour MODIFIER le ROLE d'un utilisateur -->
                                        <label for="<?= $value['user_id'] ?>">Admin</label>
                                        <input type="radio" id="<?= $value['user_id'] ?>" value="2" name="role">
                                        <label for="<?= $value['user_id'] ?>">Modo</label>
                                        <input type="radio" id="<?= $value['user_id'] ?>" value='1' name="role">
                                        <label for="<?= $value['user_id'] ?>">Aucun</label>
                                        <input type="radio" id="<?= $value['user_id'] ?>" value="0" name="role">
                                        <br>
                                        <input type="submit" id="<?= $value['user_id'] ?>" value="Update" name="update<?= $value['user_id'] ?>" class="bg-black rounded text-white mt-2">
                                </div>
                    <?php
                                    }
                                    // Mise à jour du ROLE d'un utilisateur
                                    if (isset($_POST['update' . $value['user_id']])) {
                                        $accept = $bdd->prepare("UPDATE users SET user_role = ? WHERE user_id = ? ");
                                        $accept->execute([intval($_POST['role']), $value['user_id']]);
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
                            if ($value['user_role'] == 2) : ?>
                                <p class="text-warning fw-bold fs-5"><?= htmlspecialchars($value['user_firstname']) ?>, <?= htmlspecialchars($value['user_email']) ?>.</p>
                        <?php
                            endif;
                        }
                        ?>

                        <!-- Affichage des modérateur -->
                        <h4>Moderator</h4>
                        <?php
                        foreach ($result as $key => $value) {
                            if ($value['user_role'] == 1) : ?>
                                <p class="text-warning fw-bold fs-5"><?= htmlspecialchars($value['user_firstname']) ?>, <?= htmlspecialchars($value['user_email']) ?>.</p>
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