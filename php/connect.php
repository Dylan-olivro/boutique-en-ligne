<?php
require_once('./include/required.php');

// Empêche les utilisateurs déjà connecté de revenir sur cette page
if (isset($_SESSION['user'])) {
    header('Location:../index.php');
}

// var_dump($_SESSION);

// * Ne s'active que si le JAVASCRIPT est désactivé
// Récupère les informations de l'utilisateur dans la base de données et les compare aux informations rentrées dans le formulaire
if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $user = new User(null, $email, null, null, $password, null);

    // La sécurité empêche que les champs soient VIDES et correspondent à ce que nous voulons.
    if (empty($email)) {
        $message['CONNECT_ERROR'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe champ Email est vide.';
    } elseif (empty($password)) {
        $message['CONNECT_ERROR'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe champ Password est vide';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message['CONNECT_ERROR'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspL\'adresse mail n\'est pas valide.';
    } elseif ($user->isExist($bdd)) {
        $res = $user->returnUserByEmail($bdd);
        // Récupération de l'email et du mot de passe de l'utilisateurs pour vérifier si ils correspondes avec ce qu'il a rentrer dans le formulaire
        $recupUser = $bdd->prepare("SELECT * FROM users WHERE user_email = :user_email AND user_password = :user_password");
        $recupUser->execute([
            'user_email' => $email,
            'user_password' => $res->password
        ]);
        $result = $recupUser->fetch(PDO::FETCH_OBJ);

        if ($result) {
            // Vérification du mot de passe 
            if (password_verify($password, $result->password)) {
                $_SESSION['user'] = $result;
                header('Location: ../index.php');
            } else {
                $message['CONNECT_ERROR'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe mot de passe est incorrect.';
            }
        }
    } else {
        $message['CONNECT_ERROR'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspCette email n\'existe pas.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once('./include/head.php'); ?>
    <title>Connect</title>
    <link rel="stylesheet" href="../css/connect.css">
    <script src="../js/user/connect.js" defer></script>

</head>

<body>
    <?php require_once('./include/header.php'); ?>

    <main>
        <section id="container">
            <div class="form">
                <!-- Formulaire pour CONNECTER un utilisateur -->
                <form method="post" id="formLogin">
                    <h3>Identifie-toi</h3>
                    <label for="email">Email</label>
                    <input type="text" id="email" name="email" placeholder="Email" class="input" autofocus>
                    <label for="password">Mot de passe</label>
                    <div class="password">
                        <input type="password" id="password" name="password" class="input" placeholder="Mot de passe">
                        <button type='button' id="showPassword"><i class="fa-solid fa-eye-slash"></i></button>
                    </div>
                    <!-- Affichage des erreurs -->
                    <p id="message">
                        <?php
                        if (isset($message['CONNECT_ERROR'])) {
                            echo $message['CONNECT_ERROR'];
                        }
                        ?>
                    </p>
                    <input type="submit" name="submit" id="submit">
                    <p class="demande">Vous n'avez pas de compte ?<a href="./register.php">&nbspS'inscrire</a></p>
                </form>
            </div>
        </section>
    </main>
    <?php require_once('./include/footer.php') ?>
</body>

</html>