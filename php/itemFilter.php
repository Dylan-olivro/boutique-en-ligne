<?php
require_once('./include/required.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once('./include/head.php'); ?>
    <title>Filter Products</title>
    <link rel="stylesheet" href="../css/itemFilter.css">
    <script src="../js/itemFilter.js" defer></script>
</head>

<body>
    <?php require_once('./include/header.php'); ?>

    <main>
        <div id="container">
            <div class="tri">
                <form action="" method="get" class="triForm">
                    <select name="triCategories" id="triCategories">
                        <?php
                        $returnCategory = $bdd->prepare('SELECT * FROM category');
                        $returnCategory->execute();
                        $resultCategory = $returnCategory->fetchAll(PDO::FETCH_OBJ);

                        foreach ($resultCategory as $key) {
                        ?>
                            <option id="<?= $key->id; ?>" value="<?= $key->id; ?>"><?= $key->name; ?>
                            </option>
                        <?php
                        };
                        ?>
                    </select>
                    <select name="triSelect" id="triSelect">
                        <option value="Popularité">Popularité</option>
                        <option value="Nouveauté">Nouveauté</option>
                        <option value="Du - cher au + cher">Du - cher au + cher</option>
                        <option value="Du + cher au - cher">Du + cher au - cher</option>
                        <option value="Alphabétique A-Z">Alphabétique A-Z</option>
                        <option value="Alphabétique Z-A">Alphabétique Z-A</option>
                        <option value="Disponibilité">Disponibilité</option>
                    </select>
                    <!-- //* autre option d'affichage des filtres, pas par un select/option mais par des boutons
                    <input type="button" id="priceTri" value="Par prix"> -->
                </form>
            </div>
            <div class="catAndItems">
                <form action="" method="get">
                    <div id="filterDiv">
                        <?php
                        foreach ($resultCategoryParent as $key) {
                        ?>

                            <div class="categoryParentDiv" data-parent-id="<?= $key->id; ?>">
                                <ul>
                                    <li class="resultParent dropdown-toggle" id="<?= $key->id; ?>">
                                        <input class="categoryParentRadio" type="radio" name="categoryParentRadio" id="<?= $key->id; ?>">
                                        <span class="categoryParentName" id="<?= $key->id; ?>"><?= $key->name; ?></span>
                                        <span class="chevronCat" id="<?= $key->id; ?>"><i class="chevronCatIcon fa-solid fa-chevron-down" id="chevronCatIcon"></i></span>
                                    </li>
                                    <ul class="categoryChildDiv" id="categoryChildDiv<?= $key->id; ?>" data-parent-id="<?= $key->id; ?>">
                                        <?php
                                        $returnCategoryChild = $bdd->prepare('SELECT * FROM category WHERE id_parent = ?');
                                        $returnCategoryChild->execute([$key->id]);
                                        $resultCategoryChild = $returnCategoryChild->fetchAll(PDO::FETCH_OBJ);
                                        foreach ($resultCategoryChild as $key2) {
                                        ?>
                                            <li class="subCategoryName" id="<?= $key2->id; ?>">
                                                <input type="radio" name="subCategory" id="<?= $key2->id; ?>">
                                                <span class="" id="<?= $key2->id; ?>"><?= $key2->name; ?></span>
                                            </li>
                                        <?php
                                        }
                                        ?>
                                    </ul>
                                </ul>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                </form>
                <div id="allItems">
                </div>
            </div>
        </div>
    </main>
    <?php require_once('./include/footer.php') ?>
</body>

</html>