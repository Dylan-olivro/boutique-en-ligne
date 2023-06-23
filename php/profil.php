<?php
require_once('./include/required.php');

// Empêche les utilisateurs que ne sont pas connecté de venir sur cette page
if (!isset($_SESSION['user'])) {
    header('Location:../index.php');
}

// * Ne s'active que si le JAVASCRIPT est désactivé
// Met à jour les informations de l'utilisateur
if (isset($_POST['updateUser'])) {
    $email = $_POST['email'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $password = $_POST['password'];

    $user = new User($_SESSION['user']->user_id, $email, $firstname, $lastname, $password, $_SESSION['user']->user_role);

    if (empty($email)) {
        $message['UPDATE_ERROR'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe champ Email est vide.';
    } elseif (empty($firstname)) {
        $message['UPDATE_ERROR'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe champ Prénom est vide';
    } elseif (empty($lastname)) {
        $message['UPDATE_ERROR'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe champ Nom est vide';
    } elseif (empty($password)) {
        $message['UPDATE_ERROR'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe champ Mot de Passe est vide';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message['UPDATE_ERROR'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspL\'adresse mail n\'est pas valide.';
    } elseif (!User::isAName($firstname)) {
        $message['UPDATE_ERROR'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe prénom n\'est pas valide.';
    } elseif (!User::isAName($lastname)) {
        $message['UPDATE_ERROR'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe nom n\'est pas valide.';
    } elseif (User::isToBig($firstname)) {
        $message['UPDATE_ERROR'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe prénom doit faire moins de 30 caractères.';
    } elseif (User::isToSmall($firstname)) {
        $message['UPDATE_ERROR'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe prénom doit faire plus de 2 caractères.';
    } elseif (User::isToBig($lastname)) {
        $message['UPDATE_ERROR'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe nom doit faire moins de 30 caractères.';
    } elseif (User::isToSmall($lastname)) {
        $message['UPDATE_ERROR'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe nom doit faire plus de 2 caractères.';
    } elseif ($user->isExistExceptCurrentEmail($bdd)) {
        $message['UPDATE_ERROR'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspCette email est déjà utilisé';
    } else {
        $res = $user->returnUserById($bdd);
        if ($password != password_verify($password, $res->user_password)) {
            $message['UPDATE_ERROR'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspCe n\'est pas le bon mot de passe';
        } else {
            $user->update($bdd, $res->user_password);
            header('Location: profil.php');
        }
    }
}

// Récuperation des adresses de l'utilisateur
$address = new Address(null, $_SESSION['user']->user_id, null, null, null, null, null, null, null);
$allUserAdresses = $address->returnAddressesByUser($bdd);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once('./include/head.php'); ?>
    <title>Profil</title>
    <link rel="stylesheet" href="../css/profil.css">
    <script src="../js/user/profil.js" defer></script>
</head>

<body>
    <?php require_once('./include/header.php'); ?>

    <main>
        <section id="container">
            <section class="ProfilContent">
                <div class="BoxProfil">
                    <!-- Formulaire pour MODIFIER les informations de l'utilisateur -->
                    <form action="" method="post" id="FormProfil">
                        <h3>Modifier ces infos personnelles</h3>
                        <label for="email" class="FormChild">Email</label>
                        <input type="text" id="email" name="email" class="FormChild" value="<?= htmlspecialchars($_SESSION['user']->user_email) ?>">
                        <label for="firstname" class="FormChild">Prénom</label>
                        <input type="text" id="firstname" name="firstname" class="FormChild" value="<?= htmlspecialchars($_SESSION['user']->user_firstname) ?>">
                        <label for="lastname" class="FormChild">Nom</label>
                        <input type="text" id="lastname" name="lastname" class="FormChild" value="<?= htmlspecialchars($_SESSION['user']->user_lastname) ?>">
                        <label for="password" class="FormChild">Mot de passe</label>
                        <div class="BoxPassword FormChild">
                            <input type="password" name="password" id="password" placeholder="Mot de passe">
                            <button type='button' id="showPassword"><i class="fa-solid fa-eye-slash"></i></button>
                        </div>
                        <!-- Affichage des erreurs -->
                        <p id="message" class="FormChild">
                            <?php
                            if (isset($message['UPDATE_ERROR'])) {
                                echo $message['UPDATE_ERROR'];
                            }
                            ?>
                        </p>
                        <input type="submit" name="updateUser" id="submit" value="Enregistrer" class="FormChild">
                        <a href="./user/modifyPassword.php" id="LinkPassword">Changez de mot de passe</a>
                    </form>
                </div>
                <!-- Affichage des adresses -->
                <div class="BoxAddress">
                    <h3>Adresses enregistrées</h3>
                    <div class="BoxAddAddress">
                        <?php if (count($allUserAdresses) < 6) { ?>
                            <a href="./user/addAdress.php" id="LinkAddAddress">
                                <span>Ajouter une adresse</span>
                                <i class="fa-solid fa-chevron-right"></i>
                            </a>
                        <?php } else { ?>
                            <p id="MaxAddress">Nombres d'adresses maximum</p>
                        <?php } ?>
                    </div>
                    <div class="ListAddresses">

                        <?php
                        foreach ($allUserAdresses as $userAdress) { ?>
                            <div class="DetailAddress">
                                <div class="InfoAddress">
                                    <p id="name"><?= htmlspecialchars($userAdress->address_lastname) . " " . htmlspecialchars($userAdress->address_firstname) ?></p>
                                    <p><?= htmlspecialchars($userAdress->address_numero) . " " . htmlspecialchars($userAdress->address_name) ?></p>
                                    <p><?= htmlspecialchars($userAdress->address_city) . ", " . htmlspecialchars($userAdress->address_postcode) ?></p>
                                    <p>France</p>
                                    <p><?= htmlspecialchars($userAdress->address_telephone) ?></p>

                                </div>
                                <!-- Button supprimer et modifier une adresse -->
                                <div class="BoxButtons">
                                    <a href="./user/modifyAdress.php?id=<?= $userAdress->address_id ?>"><button class="ButtonAddress"><i class="fa-solid fa-pencil"></i></button></a>
                                    <form action="" method="post">
                                        <button type="submit" name="deleteAdress<?= $userAdress->address_id ?>" class="ButtonAddress" onclick="return confirm(`Voulez vous vraiment supprimer cette adresse ?`)"><i class="fa-solid fa-trash-can"></i></button>
                                    </form>
                                </div>
                            </div>
                        <?php
                            // Delete l'adresse selectionné
                            if (isset($_POST['deleteAdress' . $userAdress->address_id])) {
                                // $address = new Address($userAdress->address_id, $_SESSION['user']->user_id, null, null, null, null, null, null, null);
                                $address->setId($userAdress->address_id);
                                $address->deleteAddress($bdd);
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
                    $order = new Order(null, $_SESSION['user']->user_id, null, null, null, null);
                    $allUserOrders = $order->returnOrdersByUser($bdd);

                    foreach ($allUserOrders as $userOrder) { ?>
                        <div>
                            <?php
                            $order->setId($userOrder->order_id);
                            // Récupère les produits de la commande de l'utilisateur avec les images.
                            $product = $order->returnContentOrder($bdd);
                            ?>
                            <!-- Affichage des commandes -->
                            <div class="infoCommand">
                                <div>
                                    <p>COMMANDE EFFECTUEE LE :</p>
                                    <p><?= htmlspecialchars($userOrder->order_date) ?></p>
                                </div>
                                <div>
                                    <p>TOTAL :</p>
                                    <p><?= htmlspecialchars($userOrder->order_total) ?>€</p>
                                </div>
                                <div>
                                    <p>NUMERO DE COMMANDE :</p>
                                    <p><?= htmlspecialchars($userOrder->order_number) ?></p>
                                </div>
                            </div>
                            <?php foreach ($product as $infoProduct) {
                            ?>
                                <div class="command">
                                    <img src="../assets/img_item/<?= $infoProduct->image_name ?>" alt="">
                                    <div class="infoProduct">
                                        <a href="./detail.php?id=<?= $infoProduct->product_id ?>">
                                            <p class="titleProduct"><?= htmlspecialchars($infoProduct->product_name) ?></p>
                                        </a>
                                        <p class="price"><?= htmlspecialchars($infoProduct->product_price * $infoProduct->product_quantity) ?> €</p>
                                        <p class="quantity">(<?= htmlspecialchars($infoProduct->product_price) ?> x<?= htmlspecialchars($infoProduct->product_quantity) ?>)</p>
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
    <?php require_once('./include/footer.php') ?>
</body>

</html>