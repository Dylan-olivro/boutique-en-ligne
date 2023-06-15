<?php
require_once('./include/required.php');

// Empêche les utilisateurs déjà connecté de revenir sur cette page
if (isset($_SESSION['user'])) {
    header('Location:../index.php');
}

$erreur = '1';
$ERROR = '2';
var_dump($erreur);
var_dump($ERROR);

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
        $message['REGISTER_ERROR'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe champ Email est vide.';
    } elseif (empty($firstname)) {
        $message['REGISTER_ERROR'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe champ Firstname est vide';
    } elseif (empty($lastname)) {
        $message['REGISTER_ERROR'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe champ Lastname est vide';
    } elseif (empty($password)) {
        $message['REGISTER_ERROR'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe champ Password est vide';
    } elseif (empty($confirm_password)) {
        $message['REGISTER_ERROR'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe champ Confirm Password est vide';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message['REGISTER_ERROR'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspL\'adresse mail n\'est pas valide.';
    } elseif (!User::isAName($firstname)) {
        $message['REGISTER_ERROR'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe firstname n\'est pas valide.';
    } elseif (!User::isAName($lastname)) {
        $message['REGISTER_ERROR'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe lastname n\'est pas valide.';
    } elseif (User::isToBig($firstname)) {
        $message['REGISTER_ERROR'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe firstname doit faire moins de 30 caractères.';
    } elseif (User::isToBig($firstname)) {
        $message['REGISTER_ERROR'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe firstname doit faire plus de 2 caractères.';
    } elseif (User::isToBig($lastname)) {
        $message['REGISTER_ERROR'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe lastname doit faire moins de 30 caractères.';
    } elseif (User::isToSmall($lastname)) {
        $message['REGISTER_ERROR'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe lastname doit faire plus de 2 caractères.';
    } elseif (!User::isSame($password, $confirm_password)) {
        $message['REGISTER_ERROR'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLes champs password sont différents.';
    } else {
        if ($user->isExist($bdd)) {
            $message['REGISTER_ERROR'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspCette email est déjà utilisé';
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
    <?php require_once('./include/head.php'); ?>
    <title>Register</title>
    <link rel="stylesheet" href="../css/register.css">
    <script src="../js/user/register.js" defer></script>

</head>

<body>
    <?php require_once('./include/header.php'); ?>
    <main>
        <section id="container">
            <div class="form">
                <!-- Formulaire pour AJOUTER un utilisateur -->
                <form id="registerForm" method="POST">
                    <h3>Créer ton compte</h3>
                    <label for="email">Email *</label>
                    <input type="" id="email" name="email" class="input" placeholder="Email" autofocus>
                    <label for="firstname">Prénom *</label>
                    <input type="text" id="firstname" name="firstname" class="input" placeholder="Prénom">
                    <label for="lastname">Nom *</label>
                    <input type="text" id="lastname" name="lastname" class="input" placeholder="Nom">
                    <label for="password">Mot de passe *</label>
                    <div class="password">
                        <input type="password" id="password" name="password" class="input" placeholder="Mot de passe">
                        <button type='button' id="showPassword"><i class="fa-solid fa-eye-slash"></i></button>
                    </div>
                    <label for="confirm_password">Confirmé votre mot de passe *</label>
                    <div class="password">
                        <input type="password" id="confirm_password" name="confirm_password" class="input" placeholder="Confirmé votre mot de passe">
                        <button type='button' id="showConfirmPassword"><i class="fa-solid fa-eye-slash"></i></button>
                    </div>
                    <!-- Affichage des erreurs -->
                    <p id="message">
                        <?php
                        if (isset($message['REGISTER_ERROR'])) {
                            echo $message['REGISTER_ERROR'];
                        }
                        ?>
                    </p>
                    <input type="submit" name="submit" id="submit" value="Valider">
                    <p class="demande">Vous avez déjà un compte ?<a href="./connect.php">&nbspConnexion</a></p>
                </form>
            </div>
        </section>
    </main>
</body>

</html>