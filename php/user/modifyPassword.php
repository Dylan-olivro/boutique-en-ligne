<?php
require_once('../include/required.php');

// Empêche les utilisateurs que ne sont pas connecté de venir sur cette page
if (!isset($_SESSION['user'])) {
    header('Location:../../index.php');
    exit();
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
    <script src="../../js/user/modifyPassword.js" defer></script>

</head>

<body>
    <?php require_once('../include/header.php'); ?>

    <main>
        <section id="container">
            <div class="MainContent">
                <!-- Formulaire pour MODIFIER le mot de passe de l'utilisateur -->
                <form action="" method="post" id="FormUpdatePassword">
                    <h3>Modifier votre Mot de passe</h3>
                    <label for="password" class="FormChild">Mot de passe</label>
                    <div class="BoxPassword FormChild">
                        <input type="password" name="password" id="password" placeholder="Mot de passe" autofocus>
                        <button type='button' id="showPassword"><i class="fa-solid fa-eye-slash"></i></button>
                    </div>
                    <label for="new_password" class="FormChild">Nouveau Mot de passe</label>
                    <div class="BoxPassword FormChild">
                        <input type="password" id="new_password" name="new_password" placeholder="Nouveau Mot de passe">
                        <button type='button' id="showNewPassword"><i class="fa-solid fa-eye-slash"></i></button>
                    </div>
                    <p id="message" class="FormChild">
                        <?php
                        // ! A CHANGER
                        if (isset($user)) {
                            echo $user->updatePassword($bdd, $old_password);
                        } ?>
                    </p>
                    <input type="submit" name="submit" id="submit" class="FormChild">
                </form>
            </div>
        </section>
    </main>
    <?php require_once('../include/footer.php') ?>
</body>

</html>