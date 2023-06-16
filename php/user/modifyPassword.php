<?php
require_once('../include/required.php');

// Empêche les utilisateurs que ne sont pas connecté de venir sur cette page
if (!isset($_SESSION['user'])) {
    header('Location:../../index.php');
}

// Mise à jour du mot de passe
if (isset($_POST['submit'])) {
    $old_password = $_POST['password'];
    $new_password = $_POST['new_password'];

    $user = new User($_SESSION['user']->user_id, null, null, null, $new_password, null);
    $user->updatePassword($bdd, $old_password);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once('../include/head.php'); ?>
    <title>Password Modify</title>
    <link rel="stylesheet" href="../../css/modifyPassword.css">
    <!-- <script src="../../js/user/modifyPassword.js" defer></script> -->

</head>

<body>
    <?php require_once('../include/header.php'); ?>

    <main>
        <div class="form">
            <h3>Modifier votre Mot de passe</h3>
            <!-- Formulaire pour MODIFIER le mot de passe de l'utilisateur -->
            <form action="" method="post" id="formUpdatePassword">
                <label for="password">Mot de passe</label>
                <input type="password" name="password" id="password" placeholder="Mot de passe" autofocus>
                <label for="new_password">Nouveau Mot de passe</label>
                <input type="password" name="new_password" id="new_password" placeholder="Nouveau Mot de passe">
                <p id="message">
                    <?php
                    if (isset($user)) {
                        echo $user->updatePassword($bdd, $old_password);
                    } ?>
                </p>
                <input type="submit" name="submit" class="submit">
            </form>
        </div>
    </main>
    <?php require_once('../include/footer.php') ?>
</body>

</html>