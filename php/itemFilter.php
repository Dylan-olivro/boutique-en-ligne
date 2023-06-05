<?php
require_once('./class/user.php');

// $returnCategoryParent = $bdd->prepare('SELECT * FROM category WHERE id_parent != 0');
// $returnCategoryParent->execute();
// $resultCategoryParent = $returnCategoryParent->fetchAll(PDO::FETCH_OBJ);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Filter Products</title>
    <!-- CSS -->
    <link rel="stylesheet" href="../css/itemFilter.css">
    <link rel="stylesheet" href="../css/header.css">
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
                                    <?= $key->name; ?>
                                </li>
                                <ul class="categoryChildDiv" id="categoryChildDiv<?= $key->id; ?>" data-parent-id="<?= $key->id; ?>">
                                    <?php
                                    $returnCategoryChild = $bdd->prepare('SELECT * FROM category WHERE id_parent = ?');
                                    $returnCategoryChild->execute([$key->id]);
                                    $resultCategoryChild = $returnCategoryChild->fetchAll(PDO::FETCH_OBJ);
                                    foreach ($resultCategoryChild as $key2) {
                                    ?>
                                        <li id="<?= $key2->name; ?>">
                                            <input type="radio" name="subCategory" id="<?= $key2->id; ?>">
                                            <?= $key2->name; ?>
                                        </li>
                                    <?php
                                    }
                                    ?>
                                </ul>
                            </ul>
                            </a>

                            <!-- <ul class="dropdown-menu categoryParent"> -->
                        </div>
                        <!-- </ul> -->
                    <?php
                    }
                    ?>
                </div>
            </form>
            <div id="allItems">
            </div>
        </div>
    </main>
    <?php require_once('./include/header-save.php') ?>
</body>

</html>