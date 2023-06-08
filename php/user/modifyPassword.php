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
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Modify</title>
    <!-- CSS -->
    <link rel="stylesheet" href="../../css/header.css">
    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <!-- JQUERY -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <!-- FONTAWESOME -->
    <script src="https://kit.fontawesome.com/9a09d189de.js" crossorigin="anonymous"></script>
    <!-- JAVASCRIPT -->
    <script src="../../js/function.js" defer></script>
    <script src="../../js/header.js" defer></script>
    <script src="../../js/autocompletion.js" defer></script>
    <!-- <script src="../../js/user/modifyPassword.js" defer></script> -->

</head>

<body>
    <?php require_once('../include/header.php'); ?>
    <?php require_once('../include/header-save.php') ?>

    <main>
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
            <input type="submit" name="submit" class="input">
        </form>
    </main>
</body>
<style>
    form {
        display: flex;
        flex-direction: column;
    }

    .input {
        color: #f1b16a;
        padding: 5px;
        background-color: #121a2e;
        margin-top: 10px;
    }

    label {
        font-size: 1.5rem;

    }
</style>

</html>