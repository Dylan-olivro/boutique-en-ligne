<?php require_once('../include/required.php');

// Empêche les utilisateurs que ne sont pas connecté de venir sur cette page
if (!isset($_SESSION['user'])) {
    header('Location:../../index.php');
}

$product = new Product($_GET['id'], null, null, null, null, null);
$result = $product->returnAllProductInfo($bdd);

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
                    <div class="divInput">
                        <label for="priceItem">Price</label>
                        <input type="text" id="priceItem" name="priceItem" autocomplete="off" value="<?= htmlspecialchars($result->product_price) ?>">
                    </div>
                    <div class="divInput">
                        <label for="stockItem">Stock</label>
                        <input type="number" id="stockItem" name="stockItem" autocomplete="off" value="<?= htmlspecialchars($result->product_stock) ?>">
                    </div>
                    <div class="divInput">
                        <label for="categoryItem">Category</label>
                        <input type="number" id="categoryItem" name="categoryItem" autocomplete="off" value="<?= htmlspecialchars($result->id_category) ?>">
                    </div>
                    <div class="divInputFile">
                        <label for="image">Image</label>
                        <input type="file" id="image" name="image">
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