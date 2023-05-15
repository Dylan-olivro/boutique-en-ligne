<?php
require_once('./class/userJS.php');
// session_destroy();
if (isset($_SESSION['user'])) {
    header('Location:index.php');
}

if (isset($_POST['submit'])) {
    $email = trim(htmlspecialchars($_POST['email']));
    $password = $_POST['password'];

    $user = new User('', $email, '', '', $password);
    $user->connect($bdd);
    // $user->isConnected();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connect</title>
    <script src="../js/connectJS.js" defer></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/9a09d189de.js" crossorigin="anonymous"></script>
</head>

<body>
    <?php require_once('./include/header.php'); ?>
    <main>
        <form action="" method="post" id="formLogin">
            <label for="email">Email</label>
            <input type="text" id="email" name="email" placeholder="Email" autofocus>
            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Password">
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