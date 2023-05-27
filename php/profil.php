<?php
require_once('./class/user.php');

if (!isset($_SESSION['user'])) {
    header('Location:../index.php');
}

$adress = new Adress(null, $_SESSION['user']->id, null, null, null, null);
$allUserAdress = $adress->returnAdressByUser($bdd);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil</title>
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
    <script src="../js/autocompletion.js" defer></script>
    <script src="../js/user/profil.js" defer></script>

</head>

<body>
    <?php require_once('./include/header.php'); ?>
    <main>
        <div>

            <form action="" method="post" id="formProfil">
                <label for="email">Email</label>
                <input type="text" id="email" name="email" value="<?= $_SESSION['user']->email ?>" required autofocus>
                <label for="firstname">Firstname</label>
                <input type="text" id="firstname" name="firstname" value="<?= $_SESSION['user']->firstname ?>" required>
                <label for="lastname">Lastname</label>
                <input type="text" id="lastname" name="lastname" value="<?= $_SESSION['user']->lastname ?>" required>
                <label for="password">Password</label>
                <input type="password" name="password" required>
                <input type="submit" name="updateUser" class="input" value="Enregistrer">
                <p id="message">
                    <?php if (!empty($_SESSION['message'])) {
                        echo $_SESSION['message'];
                    } ?>
                </p>
                <a href="./user/modifyPassword.php">Changer de mot de passe</a>
                <a href="./user/addAdress.php">Ajouter une adresse</a>

                <?php
                if (isset($_POST['updateUser'])) {
                    $email = trim(htmlspecialchars($_POST['email']));
                    $firstname = trim(htmlspecialchars($_POST['firstname']));
                    $lastname = trim(htmlspecialchars($_POST['lastname']));
                    $password = $_POST['password'];

                    $user = new User($_SESSION['user']->id, $email, $firstname, $lastname, $password, $_SESSION['user']->role);
                    $user->update($bdd);
                } ?>
            </form>
        </div>
        <?php
        foreach ($allUserAdress as $userAdress) { ?>
            <div style="border: 1px solid; margin-bottom:10px !important">
                <p><?= $userAdress->numero ?></p>
                <p><?= $userAdress->name ?></p>
                <p><?= $userAdress->postcode ?></p>
                <p><?= $userAdress->city ?></p>
                <a href="./user/modifyAdress.php?id=<?= $userAdress->id ?>"><button>Modifier</button></a>
                <form action="" method="post">
                    <input type="submit" value="Supprimer" name="deleteAdress<?= $userAdress->id ?>">
                </form>
            </div>
        <?php
            if (isset($_POST['deleteAdress' . $userAdress->id])) {
                $adress = new Adress($userAdress->id, $_SESSION['user']->id, null, null, null, null);
                $adress->deleteAdress($bdd);
                header('Location: profil.php');
            }
        }
        ?>
    </main>
    <?php require_once('./include/header-save.php') ?>
</body>
<style>
    /* form {
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

    } */
</style>

</html>