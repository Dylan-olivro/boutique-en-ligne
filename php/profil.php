<?php
require_once('./class/user.php');
// ! AJOUTER UN BOUTON VERS LE PANIER

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
                <input type="text" id="email" name="email" value="<?= hd($_SESSION['user']->email) ?>" required autofocus>
                <label for="firstname">Firstname</label>
                <input type="text" id="firstname" name="firstname" value="<?= hd($_SESSION['user']->firstname) ?>" required>
                <label for="lastname">Lastname</label>
                <input type="text" id="lastname" name="lastname" value="<?= hd($_SESSION['user']->lastname) ?>" required>
                <label for="password">Password</label>
                <input type="password" name="password" required>
                <input type="submit" name="updateUser" class="input" value="Enregistrer">
                <p id="message">
                    <?php if (isset($_SESSION['message'])) {
                        echo h($_SESSION['message']);
                    } ?>
                </p>
                <a href="./user/modifyPassword.php">Changer de mot de passe</a>
                <a href="./user/addAdress.php">Ajouter une adresse</a>

                <?php
                if (isset($_POST['updateUser'])) {
                    $email = trim(h($_POST['email']));
                    $firstname = trim(h($_POST['firstname']));
                    $lastname = trim(h($_POST['lastname']));
                    $password = trim($_POST['password']);

                    $user = new User($_SESSION['user']->id, $email, $firstname, $lastname, $password, $_SESSION['user']->role);
                    $user->update($bdd);
                } ?>
            </form>
        </div>
        <?php
        foreach ($allUserAdress as $userAdress) { ?>
            <div style="border: 1px solid; margin-bottom:10px !important">
                <p><?= hd($userAdress->numero) ?></p>
                <p><?= hd($userAdress->name) ?></p>
                <p><?= hd($userAdress->postcode) ?></p>
                <p><?= hd($userAdress->city) ?></p>
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
        <div>
            <?php
            $returnCommand2 = $bdd->prepare('SELECT * FROM command ');
            $returnCommand2->execute();
            $result2 = $returnCommand2->fetchAll(PDO::FETCH_OBJ);





            foreach ($result2 as $key2) {
                $returnCommand = $bdd->prepare('SELECT * FROM command INNER JOIN liaison_cart_command ON command.id = liaison_cart_command.id_command INNER JOIN items ON liaison_cart_command.id_item = items.id WHERE id_user = ? AND command.id = ?');
                $returnCommand->execute([$_SESSION['user']->id, $key2->id]);
                $result = $returnCommand->fetchAll(PDO::FETCH_OBJ);
                // var_dump($result2);
                echo "Commande " . $key2->id;
                echo '<br>';
                echo "Total " . $key2->total . "€";
                foreach ($result as $key) {
            ?>
                    <p><?= $key->name ?></p>

                <?php
                }
                ?>
                <br>
            <?php

                // $returnCommand2 = $bdd->prepare('SELECT * FROM liaison_cart_command WHERE liaison_cart_command.id_command = ?');
                // $returnCommand2->execute([$key->id_command]);
                // $result2 = $returnCommand2->fetchAll(PDO::FETCH_OBJ);
                // var_dump($result2);


                // var_dump($key);
            }
            ?>
        </div>
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