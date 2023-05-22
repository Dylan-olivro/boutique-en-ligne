<?php
require_once('./class/user.php');
ob_start('ob_gzhandler');

if (!isset($_SESSION['user'])) {
    header('Location:../index.php');
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
    <script src="../js/user/modifyPassword.js" defer></script>
    <script src="../js/autocompletion.js" defer></script>


</head>

<body>
    <?php require_once('./include/header.php'); ?>

    <main>
        <form action="" method="post" id="formUpdatePassword">
            <label for="password">Password</label>
            <input type="password" name="password" id="password">
            <label for="new_password">New Password</label>
            <input type="password" name="new_password" id="new_password">
            <input type="submit" name="submit" class="input">
            <p id="message"></p>

            <?php
            // var_dump($_SESSION);
            // unset($_SESSION['message']);

            if (isset($_POST['submit'])) {
                $user = new User($_SESSION['user']->id, '', '', '', password_hash($_POST['new_password'], PASSWORD_DEFAULT), '');
                $user->updatePassword($bdd);
            }
            ?>
        </form>
    </main>
    <?php require_once('./include/header-save.php') ?>
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