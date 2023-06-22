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
    <?php require_once('./include/head.php'); ?>
    <title>Admin</title>
    <link rel="stylesheet" href="../css/admin.css">
    <script src="../js/admin.js" defer></script>
</head>

<body>
    <?php require_once('./include/header.php'); ?>

    <main>
        <?php
        // Récupération de tous les produits de la base de donnée
        $product = new Product(null, null, null, null, null, null, null);
        $result_products = $product->returnAllProducts($bdd);

        // Récupération de toutes les catégories de la base de donnée
        $category = new Category(null, null, null);
        $result_cat = $category->returnAllCategories($bdd);

        // Récupération de tous les utilisateurs de la base de donnée
        $user = new User(null, null, null, null, null, null);
        $result_users = $user->returnAllUser($bdd);
        ?>
        <!-- Affichage des Statistiques -->
        <section id="firstContainer">
            <div class="allShowButtons">
                <ul>
                    <li><button id="showProducts">Produits</button></li>
                    <li> <button id="showCategories">Catégories</button></li>
                    <li><button id="showUsers">Utilisateurs</button></li>
                </ul>
            </div>
            <section id="secondContainer">
                <section class="sectionStats">
                    <h3>Statistiques</h3>
                    <div class="stats">
                        <div class="cardStat">
                            <p><i class="fa-solid fa-users"></i></p>
                            <p id="countUser">0</p>
                            <p class="statsText">Nombres d'utilisateurs</p>

                        </div>
                        <div class="cardStat">
                            <p><i class="fa-solid fa-cubes"></i></p>
                            <p id="countProduct">0</p>
                            <p class="statsText">Nombres de produits</p>
                        </div>
                        <div class="cardStat">
                            <p><i class="fa-solid fa-truck-fast"></i></p>
                            <p id="countOrder">0</p>
                            <p class="statsText">Nombres de commandes</p>
                        </div>
                        <div class="cardStat">
                            <p><i class="fa-solid fa-credit-card"></i></p>
                            <p id="avgOrder">0</p>
                            <p class="statsText">Paniers moyen</p>
                        </div>
                        <div class="cardStat">
                            <p><i class="fa-solid fa-sack-dollar"></i></p>
                            <p id="salesRevenues">0</p>
                            <p class="statsText">Chiffres d'affaires</p>
                        </div>
                    </div>

                </section>

                <div class="FormForAdd">
                    <!-- AJOUTER DES PRODUITS -->
                    <div id="addItem">
                        <h3>Ajouter un Produit</h3>

                        <form action="" method="post" id="formProduct" enctype="multipart/form-data">
                            <label for="nameItem">Name</label>
                            <input type="text" id="nameItem" name="nameItem" autocomplete="off">

                            <div class="groupInput">

                                <div class="BoxInput">
                                    <div class="divInput">
                                        <label for="priceItem">Price</label>
                                        <input type="text" id="priceItem" name="priceItem" autocomplete="off">
                                    </div>

                                    <div class="divInput">
                                        <label for="categoryItem">Category</label>
                                        <select name="categoryItem" id="categoryItem">
                                            <?php
                                            foreach ($result_cat as $cat) {
                                                if ($cat->id_parent != 0) { ?>
                                                    <option value="<?= $cat->id ?>"><?= $cat->name ?></option>
                                            <?php
                                                }
                                            } ?>
                                        </select>
                                        <!-- <input type="number" id="categoryItem" name="categoryItem" autocomplete="off"> -->
                                    </div>
                                </div>

                                <div class="BoxInput">
                                    <div class="divInput">
                                        <label for="stockItem">Stock</label>
                                        <input type="number" id="stockItem" name="stockItem" autocomplete="off">
                                    </div>
                                    <div class="divInput">
                                        <label for="image">Image</label>
                                        <input type="file" id="image" name="image">
                                    </div>
                                </div>
                            </div>

                            <label for="descriptionItem">Description</label>
                            <textarea name="descriptionItem" id="descriptionItem"></textarea>

                            <p id="messageProduct"></p>
                            <div class="submit">
                                <input type="submit" name="buttonAddItem" value="Valider">
                            </div>
                        </form>
                    </div>


                    <div class="MainContent">
                        <!-- Formulaire pour AJOUTER une catégorie -->
                        <form action="" method="post" id="FormCategories">
                            <h3>Ajouter une Categorie</h3>
                            <label for="nameCategory" class="FormChild">Nom</label>
                            <input type="text" name="nameCategory" id="nameCategory" class="FormChild">
                            <label for="idParent" class="FormChild">Catégorie parent</label>
                            <select name="idParent" id="idParent" class="FormChild">
                                <?php
                                foreach ($result_cat as $cat) {
                                    if ($cat->id_parent == 0) { ?>
                                        <option value="<?= $cat->id ?>"><?= $cat->name ?></option>
                                <?php
                                    }
                                } ?>
                                <option value="0">Nouveau Parent</option>
                            </select>
                            <p id="messageCategories" class="FormChild"></p>
                            <input type="submit" name="buttonAddCategory" class="FormChild" id="submitCategorie" value="Ajouter">
                        </form>
                    </div>

                </div>
            </section>

            <!-- DIV POUR AFFICHER LES CATEGORIES -->
            <div class="tableCategories">
                <div class="closeCategories"><button id="hideCategories">Fermer le tableau</button></div>
                <table id="categories">
                    <thead>
                        <tr>
                            <th id="IDCategories">ID</th>
                            <th id="NameCategories">Name</th>
                            <th id="IDParentCategories">ID Parent</th>
                            <th id="EditCategories">Edit</th>
                            <th id="DeleteCategories">Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($result_cat as $key_cat) { ?>
                            <tr>
                                <td><?= htmlspecialchars($key_cat->id) ?></td>
                                <td><?= htmlspecialchars($key_cat->name) ?></td>
                                <td><?= htmlspecialchars($key_cat->id_parent) ?></td>

                                <td>
                                    <button type="button" name="editCategories<?= $key_cat->id ?>"><a href="./user/modifyCategories.php?id=<?= (int)$key_cat->id ?>"><i class="fa-solid fa-pencil"></i></a></button>
                                </td>
                                <td>
                                    <form action="" method="POST">
                                        <button type="submit" name="deleteCategories<?= $key_cat->id ?>" id="<?= $key_cat->id ?>" onclick="return confirm(`Voulez vous vraiment supprimer cette catégorie ?`)"><i class="fa-solid fa-trash-can"></i></button>
                                    </form>
                                </td>
                            </tr>

                        <?php
                            // Supprime la catégorie selectionnée
                            if (isset($_POST['deleteCategories' . $key_cat->id])) {
                                $category->setId($key_cat->id);
                                $delete = $category->deleteCategory($bdd);
                                header('Location: admin.php');
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <!-- DIV POUR AFFICHER LMES PRODUITS -->
            <div class="tableProducts">
                <div class="closeProduct"><button id="hideProducts">Fermer le tableau</button></div>
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
                        <?php foreach ($result_products as $key_product) { ?>
                            <tr>
                                <td class="product_id"><?= htmlspecialchars($key_product->product_id) ?></td>
                                <td class="product_name"><?= htmlspecialchars($key_product->product_name) ?></td>
                                <td class="product_date"><?= htmlspecialchars($key_product->product_date) ?></td>
                                <td class="product_price"><?= htmlspecialchars($key_product->product_price) ?></td>
                                <td class="product_stock"><?= htmlspecialchars($key_product->product_stock) ?></td>
                                <td class="id_category"><?= htmlspecialchars($key_product->id_category) ?></td>
                                <td>
                                    <button type="button" name="editProduct<?= $key_product->product_id ?>"><a href="./user/modifyProduct.php?id=<?= $key_product->product_id ?>"><i class="fa-solid fa-pencil"></i></a></button>
                                </td>
                                <td>
                                    <form action="" method="POST">
                                        <button type="submit" name="deleteProduct<?= $key_product->product_id ?>" id="<?= $key_product->product_id ?>" onclick="return confirm(`Voulez vous vraiment supprimer ce produit ?`)"><i class="fa-solid fa-trash-can"></i></button>
                                    </form>
                                </td>
                            </tr>

                        <?php
                            // Supprime le produit selectionnée
                            if (isset($_POST['deleteProduct' . $key_product->product_id])) {
                                $product->setId($key_product->product_id);
                                $delete = $product->deleteProduct($bdd);
                                header('Location: admin.php');
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <!-- DIV POUR AFFICHER LES UTILISATEURS -->
            <div class="tableUsers">
                <div class="closeUsers"><button id="hideUsers">Fermer le tableau</button></div>
                <table id="users">
                    <thead>
                        <tr>
                            <th id="IDUsers">ID</th>
                            <th id="EmailUsers">Email</th>
                            <th id="LastnameUsers">Lastname</th>
                            <th id="FirstnameUsers">Firstname</th>
                            <th id="RoleUsers">Role</th>
                            <th id="EditCategories">Edit</th>
                            <th id="DeleteCategories">Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($result_users as $key_user) { ?>
                            <tr>
                                <td class="user_id"><?= htmlspecialchars($key_user->user_id) ?></td>
                                <td class="user_email"><?= htmlspecialchars($key_user->user_email) ?></td>
                                <td class="user_lastname"><?= htmlspecialchars($key_user->user_lastname) ?></td>
                                <td class="user_firstname"><?= htmlspecialchars($key_user->user_firstname) ?></td>
                                <td>
                                    <?php
                                    if ($key_user->user_role == 2) {
                                        echo 'Admin';
                                    } else if ($key_user->user_role == 1) {
                                        echo "Modo";
                                    } else {
                                        echo 'Membre';
                                    }

                                    ?>
                                </td>

                                <td>
                                    <button type="button" name="editUser<?= $key_user->user_id ?>"><a href="./user/modifyUser.php?id=<?= $key_user->user_id ?>"><i class="fa-solid fa-pencil"></i></a></button>
                                </td>
                                <td>
                                    <form action="" method="POST">
                                        <button type="submit" name="deleteUser<?= $key_user->user_id ?>" id="<?= $key_user->user_id ?>" onclick="return confirm(`Voulez vous vraiment supprimer cette utilisateur ?`)"><i class="fa-solid fa-trash-can"></i></button>
                                    </form>
                                </td>
                            </tr>

                        <?php
                            // Supprime l'utilisateur selectionnée
                            if (isset($_POST['deleteUser' . $key_user->user_id])) {
                                $user->setId($key_user->user_id);
                                $delete = $user->deleteUserByID($bdd);
                                header('Location: admin.php');
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </section>
    </main>
    <?php require_once('./include/footer.php') ?>
</body>

</html>