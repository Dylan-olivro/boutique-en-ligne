<?php require_once('../include/required.php');

// Empêche les utilisateurs que ne sont pas connecté de venir sur cette page
if (!isset($_SESSION['user'])) {
    header('Location:../../index.php');
}

$category = new Category($_GET['id'], null, null);
$result = $category->returnCategory($bdd);
$result_cat = $category->returnAllCategories($bdd);
var_dump($result);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once('../include/head.php'); ?>
    <title>Category Modify</title>
    <link rel="stylesheet" href="../../css/modifyCategories.css">
    <script src="../../js/modifyCategories.js" defer></script>
</head>

<body>
    <?php require_once('../include/header.php'); ?>

    <main>
        <!-- Formulaire pour MODIFIER l'adresse de l'utilisateur -->
        <div id="addCategory">
            <!-- Formulaire pour AJOUTER une catégorie -->
            <h3>Modifier une Categorie</h3>
            <form action="" method="post" id="formCategories">
                <input type="hidden" name="id" value="<?= htmlspecialchars($_GET['id']) ?>">
                <label for="nameCategory">Name</label>
                <input type="text" name="nameCategory" id="nameCategory" value="<?= htmlspecialchars($result->name) ?>">
                <label for="idParent">ID parent</label>
                <select name="idParent" id="idParent">
                    <option value="<?= $result->id_parent ?>">Current</option>
                    <?php
                    foreach ($result_cat as $cat) {
                        if ($cat->id_parent == 0) { ?>
                            <option value="<?= $cat->id ?>"><?= $cat->name ?></option>
                    <?php
                        }
                    } ?>
                    <option value="0">Nouveau Parent</option>
                </select>
                <p id="messageCategories"></p>
                <div class="submit">
                    <input type="submit" name="submit " value="Modifier">
                </div>
            </form>

        </div>
    </main>
    <?php require_once('../include/footer.php') ?>
</body>

</html>