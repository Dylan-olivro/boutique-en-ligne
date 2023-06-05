<?php
require_once('./include/required.php');
// ! AJOUTER UN BOUTON VERS LE PANIER

// Empêche les utilisateurs que ne sont pas connecté de venir sur cette page
if (!isset($_SESSION['user'])) {
    header('Location:../index.php');
}

// Met à jour les informations de l'utilisateur
if (isset($_POST['updateUser'])) {
    $email = trim(h($_POST['email']));
    $firstname = trim(h($_POST['firstname']));
    $lastname = trim(h($_POST['lastname']));
    $password = trim($_POST['password']);

    $user = new User($_SESSION['user']->id, $email, $firstname, $lastname, $password, $_SESSION['user']->role);
    $user->update($bdd);
}
// Récuperation des adresses de l'utilisateur
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
    <link rel="stylesheet" href="../css/profil.css">
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
    <!-- <script src="../js/user/profil.js" defer></script> -->

</head>

<body>
    <?php require_once('./include/header.php'); ?>
    <main>
        <section class="mainContainer">
            <section class="container">
                <div class="profil">
                    <!-- Formulaire pour MODIFIER les informations de l'utilisateur -->
                    <form action="" method="post" id="formProfil">
                        <label for="email">Email</label>
                        <input type="text" id="email" name="email" value="<?= hd($_SESSION['user']->email) ?>" class="input" autofocus>
                        <label for="firstname">Firstname</label>
                        <input type="text" id="firstname" name="firstname" value="<?= hd($_SESSION['user']->firstname) ?>" class="input">
                        <label for="lastname">Lastname</label>
                        <input type="text" id="lastname" name="lastname" value="<?= hd($_SESSION['user']->lastname) ?>" class="input">
                        <label for="password">Password</label>
                        <div class="password">
                            <input type="password" name="password" class="input" id="password">
                            <button type='button' id="showPassword"><i class="fa-solid fa-eye-slash"></i></button>
                        </div>
                        <!-- les messages d'erreurs -->
                        <p id="message">
                            <?php if (isset($user)) {
                                echo $user->update($bdd);
                            } ?>
                        </p>
                        <input type="submit" name="updateUser" id="submit" value="Enregistrer">
                        <a href="./user/modifyPassword.php">Changer de mot de passe</a>
                    </form>
                </div>
                <!-- Affichage des adresses -->
                <div class="allAdress">
                    <a href="./user/addAdress.php">Ajouter une adresse</a>
                    <?php
                    foreach ($allUserAdress as $userAdress) { ?>
                        <div style="border: 1px solid; margin-bottom:10px !important" class="adress">
                            <div class="infoAdress">
                                <p><?= hd($_SESSION['user']->firstname) . " " . hd($_SESSION['user']->lastname) ?></p>
                                <p><?= hd($userAdress->numero) . " " . hd($userAdress->name) ?></p>
                                <p><?= hd($userAdress->city) . ", " . hd($userAdress->postcode) ?></p>
                                <p>France</p>
                                <p>Numéro de télephone: 00 00 00 00 00</p>
                            </div>
                            <div class="edit_delete">
                                <a href="./user/modifyAdress.php?id=<?= $userAdress->id ?>"><button><i class="fa-solid fa-pencil"></i></button></a>
                                <form action="" method="post">
                                    <button type="submit" name="deleteAdress<?= $userAdress->id ?>"><i class="fa-solid fa-trash-can"></i></button>
                                </form>
                            </div>
                        </div>
                    <?php
                        // Delete l'adresse selectionné
                        if (isset($_POST['deleteAdress' . $userAdress->id])) {
                            $adress = new Adress($userAdress->id, $_SESSION['user']->id, null, null, null, null);
                            $adress->deleteAdress($bdd);
                            header('Location: profil.php');
                        }
                    }
                    ?>
                </div>
            </section>
        </section>

        <!-- Historique des commandes -->
        <section class="containerCommand">
            <div class="allCommand">
                <?php
                // Récupère les commandes de l'utilisateur
                $returnCommand2 = $bdd->prepare('SELECT * FROM command WHERE id_user  = :id_user ORDER BY date DESC');
                $returnCommand2->execute(['id_user' => $_SESSION['user']->id]);
                $result2 = $returnCommand2->fetchAll(PDO::FETCH_OBJ);

                foreach ($result2 as $key2) { ?>

                    <div>
                        <?php
                        // Récupère les produits de la commande de l'utilisateur avec les images.
                        $returnCommand = $bdd->prepare('SELECT * FROM command INNER JOIN liaison_cart_command ON command.id = liaison_cart_command.id_command INNER JOIN items ON liaison_cart_command.id_item = items.id INNER JOIN image ON items.id = image.id_item WHERE id_user = :id_user AND command.id = :command_id AND main = 1');
                        $returnCommand->execute([
                            'id_user' => $_SESSION['user']->id,
                            'command_id' => $key2->id
                        ]);
                        $result = $returnCommand->fetchAll(PDO::FETCH_OBJ); ?>
                        <!-- Affichage des commandes -->
                        <div class="infoCommand">
                            <div>
                                <p>COMMANDE ÉFFECTUÉE LE</p>
                                <p><?= $key2->date ?></p>
                            </div>
                            <div>
                                <p>TOTAL</p>
                                <p><?= $key2->total ?>€</p>
                            </div>
                            <div>
                                <p>N° DE COMMANDE</p>
                            </div>
                        </div>
                        <?php foreach ($result as $key) { ?>
                            <div class="command">
                                <img src="../assets/img_item/<?= $key->name_image ?>" alt="">
                                <div>
                                    <p><?= hd($key->name) ?></p>
                                    <p><?= hd($key->price) ?></p>
                                    <a href="./detail.php?id=<?= $key->id_item ?>"><button>Acheter a nouveau</button></a>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                <?php
                }
                ?>
            </div>
        </section>
    </main>
    <?php require_once('./include/header-save.php') ?>
</body>

</html>