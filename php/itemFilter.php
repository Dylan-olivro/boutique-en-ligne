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
            <form action="" method="get">
                <div id="filterDiv">
                    <?php
                    foreach ($resultCategoryParent as $key) {
                        // var_dump($key['name']);                                
                    ?>
                        <div class="categoryParentDiv" data-parent-id="<?= $key->id; ?>">
                            <ul>
                                <li class="resultParent dropdown-toggle" id="<?= $key->id; ?>">
                                    <input type="radio" name="categoryParentRadio" id="<?= $key->id; ?>">
                                    <span class="categoryParentName" id="<?= $key->id; ?>"><?= $key->name; ?></span>
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
                            </a>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </form>
            <div id="allItems">
            </div>
        </div>
    </main>
    <?php require_once('./include/footer.php') ?>
</body>

</html>