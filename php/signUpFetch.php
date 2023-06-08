<?php
require_once('./include/required.php');

// Empêche les utilisateurs déjà connecté de revenir sur cette page
if (isset($_SESSION['user'])) {
    header('Location:../index.php');
}

// * Ne s'active que si le JAVASCRIPT est désactivé
// L'insertion de l'utilisateur dans la base de donnée
if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    $user = new User(null, $email, $firstname, $lastname, $password, null);

    if (empty($email)) {
        $message['erreur'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe champ Email est vide.';
    } elseif (empty($firstname)) {
        $message['erreur'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe champ Firstname est vide';
    } elseif (empty($lastname)) {
        $message['erreur'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe champ Lastname est vide';
    } elseif (empty($password)) {
        $message['erreur'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe champ Password est vide';
    } elseif (empty($confirm_password)) {
        $message['erreur'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe champ Confirm Password est vide';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message['erreur'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspL\'adresse mail n\'est pas valide.';
    } elseif (!User::isAName($firstname)) {
        $message['erreur'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe firstname n\'est pas valide.';
    } elseif (!User::isAName($lastname)) {
        $message['erreur'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe lastname n\'est pas valide.';
    } elseif (User::isToBig($firstname)) {
        $message['erreur'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe firstname doit faire moins de 30 caractères.';
    } elseif (User::isToBig($firstname)) {
        $message['erreur'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe firstname doit faire plus de 2 caractères.';
    } elseif (User::isToBig($lastname)) {
        $message['erreur'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe lastname doit faire moins de 30 caractères.';
    } elseif (User::isToSmall($lastname)) {
        $message['erreur'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe lastname doit faire plus de 2 caractères.';
    } elseif (!User::isSame($password, $confirm_password)) {
        $message['erreur'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLes champs password sont différents.';
    } else {
        if ($user->isExist($bdd)) {
            $message['erreur'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspCette email est déjà utilisé';
        } else {
            $user->register($bdd);
            header('Location: ./connectFetch.php');
        }
    }
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
                <form id="signup" method="POST">
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
                    <!-- Affichage des erreurs -->
                    <p id="message">
                        <?php
                        if (isset($message['erreur'])) {
                            echo $message['erreur'];
                        }
                        ?>
                    </p>
                    <input type="submit" name="submit" id="submit">
                    <p class="demande">Vous avez déjà un compte ?<a href="./connectFetch.php">&nbspConnexion</a></p>
                </form>
            </div>
        </section>
    </main>
</body>

</html>