<?php require_once('../include/required.php');

// Récupération du produit sélectionné
$product = new Product($_GET['id'], null, null, null, null, null);
$result = $product->returnAllProductInfo($bdd);

// Empêche les utilisateurs qui ne sont pas ADMINISTRATEUR 
if (!$result || $_SESSION['user']->user_role != 2) {
    header('Location: ../../index.php');
    exit();
}

// Récupération de toutes les catégories
$category = new Category(null, null, null);
$result_cat = $category->returnAllCategories($bdd);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once('../../php/include/head.php'); ?>
    <title>Product Modify</title>
    <link rel="stylesheet" href="../../css/modifyProduct.css">
    <script src="../../js/modifyProduct.js" defer></script>
</head>

<body>
    <?php require_once('../include/header.php'); ?>

    <main>
        <!-- Formulaire pour MODIFIER l'adresse de l'utilisateur -->
        <div id="editProduct">
            <h3>Modifier un Produit</h3>

            <form action="" method="post" id="formProduct" enctype="multipart/form-data">
                <input type="hidden" name="productID" value="<?= htmlspecialchars($_GET['id']) ?>">
                <label for="nameItem">Name</label>
                <input type="text" id="nameItem" name="nameItem" autocomplete="off" value="<?= htmlspecialchars($result->product_name) ?>">

                <div class="groupInput">
                    <div class="BoxInput">
                        <div class="divInput">
                            <label for="priceItem">Price</label>
                            <input type="text" id="priceItem" name="priceItem" autocomplete="off" value="<?= htmlspecialchars($result->product_price) ?>">
                        </div>
                        <div class="divInput">
                            <label for="stockItem">Stock</label>
                            <input type="number" id="stockItem" name="stockItem" autocomplete="off" value="<?= htmlspecialchars($result->product_stock) ?>">
                        </div>
                    </div>
                    <div class="BoxInput">

                        <div class="divInput">
                            <label for="categoryItem">Category</label>
                            <select name="categoryItem" id="categoryItem">
                                <option value="<?= $result->id_category ?>" selected><?= $result->name ?></option>
                                <?php
                                foreach ($result_cat as $cat) {
                                    if ($cat->id_parent != 0) { ?>
                                        <option value="<?= $cat->id ?>"><?= $cat->name ?></option>
                                <?php
                                    }
                                } ?>
                            </select>

                        </div>
                        <div class="divInput">
                            <label for="image">Image</label>
                            <input type="file" id="image" name="image">
                        </div>
                    </div>
                </div>

                <label for="descriptionItem">Description</label>
                <textarea name="descriptionItem" id="descriptionItem"><?= htmlspecialchars($result->product_description) ?></textarea>

                <p id="messageProduct"></p>
                <div class="submit">
                    <input type="submit" name="submit" value="Valider">
                </div>
            </form>
        </div>
    </main>
    <?php require_once('../include/footer.php') ?>
</body>

</html>