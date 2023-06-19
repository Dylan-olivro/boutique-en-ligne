<?php require_once('../include/required.php');

// Récupération de la catégorie sélectionnée
$category = new Category($_GET['id'], null, null);
$result = $category->returnCategory($bdd);
$result_cat = $category->returnAllCategories($bdd);

// Empêche les utilisateurs qui ne sont pas ADMINISTRATEUR
if (!$result || $_SESSION['user']->user_role != 2) {
    header('Location: ../../index.php');
    exit();
}
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
        <section id="container">
            <div class="MainContent">
                <form action="" method="post" id="FormCategories">
                    <h3>Modifier une Categorie</h3>
                    <input type="hidden" name="id" value="<?= htmlspecialchars($_GET['id']) ?>">
                    <label for="nameCategory" class="FormChild">Name</label>
                    <input type="text" name="nameCategory" id="nameCategory" class="FormChild" value="<?= htmlspecialchars($result->name) ?>">
                    <label for="idParent" class="FormChild">Catégorie parent</label>
                    <select name="idParent" id="idParent" class="FormChild">
                        <option value="<?= $result->id_parent ?>">Actuellement</option>
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
                    <input type="submit" name="submit" id="submit" class="FormChild" value="Modifier">
                </form>
            </div>
        </section>
    </main>
    <?php require_once('../include/footer.php') ?>
</body>

</html>