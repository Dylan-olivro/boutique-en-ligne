<?php
require_once('./include/required.php');

// Empêche les utilisateurs qui ne sont pas ADMINISTRATEUR ou MODERATEUR de venir sur cette page
if ($_SESSION['user']->user_role == 0) {
    header('Location: ../index.php');
    exit();
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
    <!-- <script src="../js/header.js" defer></script>
    <script src="../js/autocompletion.js" defer></script> -->
    <script src="../js/admin.js" defer></script>

</head>

<body>
    <?php // require_once('./include/header.php'); 
    ?>
    <?php require_once('./include/header-save.php') ?>
    <main>
        <?php
        $product = new Product(null, null, null, null, null, null, null);
        $result = $product->returnAllProducts($bdd);
        // var_dump($result);
        // echo $_SESSION['test'];
        ?>
        <section id="container">

            <div id="addItem">
                <h3>Ajouter un Produit</h3>

                <form action="" method="post" id="formAddItem" enctype="multipart/form-data">
                    <label for="nameItem">Name</label>
                    <input type="text" id="nameItem" name="nameItem">

                    <div class="inputDiv">
                        <div>
                            <label for="priceItem">Price</label>
                            <input type="text" id="priceItem" name="priceItem">
                        </div>
                        <div>
                            <label for="stockItem">Stock</label>
                            <input type="number" id="stockItem" name="stockItem" value="500">
                        </div>
                        <div>
                            <label for="categoryItem">Category</label>
                            <input type="number" id="categoryItem" name="categoryItem">
                        </div>
                    </div>

                    <label for="descriptionItem">Description</label>
                    <textarea name="descriptionItem" id="descriptionItem"></textarea>
                    <!-- <input type="text" id="descriptionItem" name="descriptionItem"> -->

                    <label for="file">Image</label>
                    <input type="file" id="file" name="file">

                    <input type="submit" name="buttonAddItem" value="Ajouter">
                </form>
                <div class="formEdit">
                    <p>OU</p>
                    <button id="test">Modifier un Produit</button>
                </div>

            </div>
            <!-- DIV POUR AFFICHER LMES PRODUITS -->
            <div class="tableProducts">
                <div class="closeProduct"><button id="close">Fermer le tableau</button></div>
                <table id="products">
                    <thead>
                        <tr>
                            <th id="IDProduct">ID</th>
                            <th id="NameProduct">Name</th>
                            <th id="DateProduct">Date</th>
                            <th id="PrixProduct">Prix</th>
                            <th id="StockProduct">Stock</th>
                            <th id="IDCategoryProduct">ID Cat</th>
                            <th id="EditProduct">Edit</th>
                            <th id="DeleteProduct">Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($result as $key) { ?>
                            <tr>
                                <td><?= $key->product_id ?></td>
                                <td><?= $key->product_name ?></td>
                                <td><?= $key->product_date ?></td>
                                <td><?= $key->product_price ?></td>
                                <td><?= $key->product_stock ?></td>
                                <td><?= $key->id_category ?></td>
                                <td>
                                    <button type="button" name="editProduct<?= $key->product_id ?>"><a href="./user/modifyProduct.php?<?= $key->product_id ?>"><i class="fa-solid fa-pencil"></i></a></button>
                                </td>
                                <td>
                                    <form action="" method="POST">
                                        <button type="submit" name="deleteProduct<?= $key->product_id ?>" id="<?= $key->product_id ?>"><i class="fa-solid fa-trash-can"></i></button>
                                    </form>
                                </td>
                            </tr>

                        <?php
                            if (isset($_POST['deleteProduct' . $key->product_id])) {
                                $product->setId($key->product_id);
                                // $ok = $product->deleteProduct($bdd);
                                var_dump($ok);
                                header('Location: admin.php');
                                // $_SESSION['test'] = $_POST['deleteProduct' . $key->product_id];
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>

        </section>
    </main>
</body>

</html>