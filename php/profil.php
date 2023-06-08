<?php
require_once('./include/required.php');
// ! AJOUTER UN BOUTON VERS LE PANIER

// Empêche les utilisateurs que ne sont pas connecté de venir sur cette page
if (!isset($_SESSION['user'])) {
    header('Location:../index.php');
}

// Met à jour les informations de l'utilisateur
if (isset($_POST['updateUser'])) {
    $email = $_POST['email'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $password = $_POST['password'];

    $user = new User($_SESSION['user']->user_id, $email, $firstname, $lastname, $password, $_SESSION['user']->user_role);

    if (empty($email)) {
        $message['erreur'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe champ Email est vide.';
    } elseif (empty($firstname)) {
        $message['erreur'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe champ Firstname est vide';
    } elseif (empty($lastname)) {
        $message['erreur'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe champ Lastname est vide';
    } elseif (empty($password)) {
        $message['erreur'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe champ Password est vide';
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
    } elseif ($user->isExistExceptCurrentEmail($bdd)) {
        $message['erreur'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspCette email est déjà utilisé';
    } else {
        $res = $user->returnUserById($bdd);
        if ($password != password_verify($password, $res->user_password)) {
            $message['erreur'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspCe n\'est pas le bon mot de passe';
        } else {
            $user->update($bdd, $res->user_password);
            header('Location: profil.php');
        }
    }
}

// Récuperation des adresses de l'utilisateur
$adress = new Adress(null, $_SESSION['user']->user_id, null, null, null, null, null, null, null);
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
    <script src="../js/header.js" defer></script>
    <script src="../js/autocompletion.js" defer></script>
    <!-- <script src="../js/user/profil.js" defer></script> -->
    <script src="../js/user/profil.js" defer></script>

</head>

<body>
    <?php require_once('./include/header.php'); ?>
    <?php require_once('./include/header-save.php') ?>

    <main>
        <section id="container">
            <section class="containerProfil">
                <div class="profil">
                    <!-- Formulaire pour MODIFIER les informations de l'utilisateur -->
                    <form action="" method="post" id="formProfil">
                        <h3>Modifier ces infos personnelles</h3>
                        <label for="email">Email</label>
                        <input type="text" id="email" name="email" value="<?= htmlspecialchars($_SESSION['user']->user_email) ?>" class="input" autofocus>
                        <label for="firstname">Firstname</label>
                        <input type="text" id="firstname" name="firstname" value="<?= htmlspecialchars($_SESSION['user']->user_firstname) ?>" class="input">
                        <label for="lastname">Lastname</label>
                        <input type="text" id="lastname" name="lastname" value="<?= htmlspecialchars($_SESSION['user']->user_lastname) ?>" class="input">
                        <label for="password">Password</label>
                        <div class="password">
                            <input type="password" name="password" class="input" id="password">
                            <button type='button' id="showPassword"><i class="fa-solid fa-eye-slash"></i></button>
                        </div>
                        <!-- Affichage des erreurs -->
                        <p id="message">
                            <?php
                            if (isset($message['erreur'])) {
                                echo $message['erreur'];
                            }
                            ?>
                        </p>
                        <input type="submit" name="updateUser" id="submit" value="Enregistrer">
                        <a href="./user/modifyPassword.php" id="updatePassword">Changer de mot de passe</a>
                    </form>
                </div>
                <!-- Affichage des adresses -->
                <div class="sectionAdress">
                    <h3>Adresses enregistrées</h3>
                    <div class="addAdress">
                        <?php if (count($allUserAdress) < 6) { ?>
                            <a href="./user/addAdress.php" id="addAdress">
                                <div class="link">
                                    <span>Ajouter une adresse</span>
                                    <i class="fa-solid fa-chevron-right"></i>
                                </div>
                            </a>
                        <?php } else { ?>
                            <div class="link">
                                <span>Nombres d'adresses maximum</span>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="allAdress">

                        <?php
                        foreach ($allUserAdress as $userAdress) {
                            // var_dump($allUserAdress);
                        ?>
                            <div class="adress">
                                <div class="infoAdress">
                                    <p class="name"><?= htmlspecialchars($userAdress->adress_lastname) . " " . htmlspecialchars($userAdress->adress_firstname) ?></p>
                                    <p><?= htmlspecialchars($userAdress->adress_numero) . " " . htmlspecialchars($userAdress->adress_name) ?></p>
                                    <p><?= htmlspecialchars($userAdress->adress_city) . ", " . htmlspecialchars($userAdress->adress_postcode) ?></p>
                                    <p>France</p>
                                    <div>
                                        <p>N° de télephone:</p>
                                        <p><?= htmlspecialchars($userAdress->adress_telephone) ?></p>
                                    </div>
                                </div>
                                <div class="edit_delete">
                                    <a href="./user/modifyAdress.php?id=<?= $userAdress->adress_id ?>"><button class="button"><i class="fa-solid fa-pencil"></i></button></a>
                                    <form action="" method="post">
                                        <button type="submit" name="deleteAdress<?= $userAdress->adress_id ?>" class="button"><i class="fa-solid fa-trash-can"></i></button>
                                    </form>
                                </div>
                            </div>
                        <?php
                            // Delete l'adresse selectionné
                            if (isset($_POST['deleteAdress' . $userAdress->adress_id])) {
                                $adress = new Adress($userAdress->adress_id, $_SESSION['user']->user_id, null, null, null, null, null, null, null);
                                $adress->deleteAdress($bdd);
                                header('Location: profil.php');
                            }
                        }
                        ?>
                    </div>
                </div>
            </section>

            <!-- Historique des commandes -->
            <section class="containerCommand">
                <div class="allCommand">
                    <h3>Historique des commandes</h3>
                    <?php
                    // Récupère les commandes de l'utilisateur
                    $command = new Command(null, $_SESSION['user']->user_id, null, null, null);
                    $result = $command->returnComandByUser($bdd);

                    foreach ($result as $order) { ?>
                        <div>
                            <?php
                            $command->setId($order->id);
                            // Récupère les produits de la commande de l'utilisateur avec les images.
                            $product = $command->returnContentCommand($bdd);
                            ?>
                            <!-- Affichage des commandes -->
                            <div class="infoCommand">
                                <div>
                                    <p>COMMANDE EFFECTUEE LE :</p>
                                    <p><?= htmlspecialchars($order->date) ?></p>
                                </div>
                                <div>
                                    <p>TOTAL :</p>
                                    <p><?= htmlspecialchars($order->total) ?>€</p>
                                </div>
                                <div>
                                    <p>NUMERO DE COMMANDE :</p>
                                </div>
                            </div>
                            <?php foreach ($product as $key) { ?>
                                <div class="command">
                                    <img src="../assets/img_item/<?= $key->name_image ?>" alt="">
                                    <div class="infoProduct">
                                        <div>
                                            <p class="titleProduct"><?= htmlspecialchars($key->name) ?></p>
                                            <p class="price"><?= htmlspecialchars($key->price) ?>€</p>
                                        </div>
                                        <a href="./detail.php?id=<?= $key->id_item ?>"><button>Acheter à nouveau</button></a>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    <?php
                    }
                    ?>
                    <div class="showCommands">
                        <a href="">
                            <div class="showCommandsText">
                                <span>Voir toutes vos commandes</span>
                                <i class="fa-solid fa-angle-down"></i>
                            </div>
                        </a>
                    </div>
                </div>
            </section>
        </section>
    </main>
</body>

</html>