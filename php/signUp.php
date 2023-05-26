<?php
require_once('./class/user.php');
require_once('./class/adress.php');
require_once('./class/image.php');
require_once('./class/item.php');
require_once('./class/category.php');
ob_start('ob_gzhandler');

if (isset($_SESSION['user'])) {
    header('Location:../index.php');
}

if (isset($_POST['submit'])) {
    $email = trim(htmlspecialchars($_POST['email']));
    $firstname = trim(htmlspecialchars($_POST['firstname']));
    $lastname = trim(htmlspecialchars($_POST['lastname']));
    $password = $_POST['password'];

    $user = new User('', $email, $firstname, $lastname, $password, '');
    $user->register($bdd);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <!-- CSS -->
    <!-- <link rel="stylesheet" href="./css/common.css"> -->
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
    <script src="../js/user/signUpJS.js" defer></script>
    <script src="../js/autocompletion.js" defer></script>

</head>

<body>
    <?php require_once('./include/header.php'); ?>
    <main>
        <form action="" method="post" id="signup">
            <label for="email">Email</label>
            <input type="" id="email" name="email" autofocus>
            <label for="firstname">Firstname</label>
            <input type="text" id="firstname" name="firstname">
            <label for="lastname">Lastname</label>
            <input type="text" id="lastname" name="lastname">
            <label for="password">Password</label>
            <input type="password" id="password" name="password">
            <label for="confirm_password">Confirm password</label>
            <input type="password" id="confirm_password" name="confirm_password">
            <input type="submit" name="submit" class="input">
            <p id="message">
                <?php
                if (!empty($_SESSION['message'])) {
                    echo $_SESSION['message'];
                }
                ?>
            </p>

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