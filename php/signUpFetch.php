<?php
require_once('./include/required.php');

// Empêche les utilisateurs déjà connecté de revenir sur cette page
if (isset($_SESSION['user'])) {
    header('Location:../index.php');
}

// L'insertion de l'utilisateur dans la base de donnée
// if (isset($_POST['submit'])) {
//     $email = trim(h($_POST['email']));
//     $firstname = trim(h($_POST['firstname']));
//     $lastname = trim(h($_POST['lastname']));
//     $password = trim($_POST['password']);
//     $confirm_password = trim($_POST['confirm_password']);

//     $user = new User(null, $email, $firstname, $lastname, $password, null);
//     $user->register($bdd, $confirm_password);
// }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <!-- CSS -->
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/signUp.css">
    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <!-- JQUERY -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <!-- FONTAWESOME -->
    <script src="https://kit.fontawesome.com/9a09d189de.js" crossorigin="anonymous"></script>
    <!-- JAVASCRIPT -->
    <script src="../js/function.js" defer></script>
    <script src="../js/header.js" defer></script>
    <script src="../js/autocompletion.js" defer></script>
    <script src="../js/user/signUp_fetch.js" defer></script>

</head>

<body>
    <?php require_once('./include/header.php'); ?>
    <?php require_once('./include/header-save.php') ?>
    <main>
        <section id="container">
            <div class="form">
                <!-- Formulaire pour AJOUTER un utilisateur -->
                <form id="signup">
                    <label for="email">Email *</label>
                    <input type="" id="email" name="email" class="input" placeholder="Email" autofocus>
                    <label for="firstname">Firstname *</label>
                    <input type="text" id="firstname" name="firstname" class="input" placeholder="Firstname">
                    <label for="lastname">Lastname *</label>
                    <input type="text" id="lastname" name="lastname" class="input" placeholder="Lastname">
                    <label for="password">Password *</label>
                    <div class="password">
                        <input type="password" id="password" name="password" class="input" placeholder="Password">
                        <button type='button' id="showPassword"><i class="fa-solid fa-eye-slash"></i></button>
                    </div>
                    <label for="confirm_password">Confirm password *</label>
                    <div class="password">
                        <input type="password" id="confirm_password" name="confirm_password" class="input" placeholder="Confirm Password">
                        <button type='button' id="showConfirmPassword"><i class="fa-solid fa-eye-slash"></i></button>
                    </div>
                    <p id="message" style="display:none"></p>
                    <input type="submit" name="submit" id="submit">
                </form>
            </div>
        </section>
    </main>
</body>

</html>