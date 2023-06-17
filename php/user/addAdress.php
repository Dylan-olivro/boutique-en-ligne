<?php require_once('../include/required.php');

// Empêche les utilisateurs que ne sont pas connecté de venir sur cette page
if (!isset($_SESSION['user'])) {
    header('Location:../../index.php');
}

$address = new Address(null, $_SESSION['user']->user_id, null, null, null, null, null, null, null);
$allUserAddresses = $address->returnAddressesByUser($bdd);


// Insert une adresse
if (isset($_POST['submit'])) {
    $numero = $_POST['numero'];
    $name = $_POST['name'];
    $postcode = $_POST['postcode'];
    $city = $_POST['city'];
    $telephone = $_POST['telephone'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];

    if (empty($numero)) {
        $INSERT_ADDRESS_ERROR = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe champ Numero est vide.';
    } elseif (empty($name)) {
        $INSERT_ADDRESS_ERROR = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe champ Name est vide.';
    } elseif (empty($postcode)) {
        $INSERT_ADDRESS_ERROR = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe champ Postcode est vide.';
    } elseif (empty($city)) {
        $INSERT_ADDRESS_ERROR = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe champ City est vide.';
    } elseif (!isStreet($numero)) {
        $INSERT_ADDRESS_ERROR = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe champ Numero est invalide.';
    } elseif (!isPostcode($postcode)) {
        $INSERT_ADDRESS_ERROR = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe champ Postcode est invalide.';
    } elseif (!Address::formatTelephoneAccept($telephone)) {
        $INSERT_ADDRESS_ERROR = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe numéro de téléphone est invalide.';
    } elseif (User::isToBig($nom)) {
        $message['erreur'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe nom doit faire moins de 30 caractères.';
    } elseif (User::isToBig($prenom)) {
        $message['erreur'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe prénom doit faire moins de 30 caractères.';
    } elseif (User::isToSmall($nom)) {
        $message['erreur'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe nom doit faire plus de 2 caractères.';
    } elseif (User::isToSmall($prenom)) {
        $message['erreur'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe prénom doit faire plus de 2 caractères.';
    } elseif (!User::isAName($nom)) {
        $message['erreur'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe nom n\'est pas valide.';
    } elseif (!User::isAName($prenom)) {
        $message['erreur'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe pr&nom n\'est pas valide.';
    } elseif (count($allUserAddresses) >= 6) {
        $INSERT_ADDRESS_ERROR = '<i class="fa-solid fa-circle-exclamation"></i>&nbspNombres maximum d\'adresse atteint (6).';
    } else {

        $address = new Address(null, $_SESSION['user']->user_id, $numero, $name, $postcode, $city, null, $prenom, $nom);
        $tel = $address->returnFormatTel($telephone);
        $address->setTelephone($tel);
        $address->addAddress($bdd);
        header('Location: ../profil.php');
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once('../include/head.php'); ?>
    <title>Adress Add</title>
    <link rel="stylesheet" href="../../css/addAddress.css">
</head>

<body>
    <?php require_once('../include/header.php'); ?>

    <main>
        <div class="form">
            <h3>Ajouter une Adresse</h3>

            <!-- Formulaire pour AJOUTER une adresse à l'utilisateur -->
            <form action="" method="post" id="formUpdateAdress">
                <label for="numero">Numéro</label>
                <input type="number" name="numero" id="numero" autofocus>
                <label for="name">Adresse</label>
                <input type="text" name="name" id="name">
                <label for="postcode">Code Postal</label>
                <input type="number" name="postcode" id="postcode">
                <label for="city">Ville</label>
                <input type="text" name="city" id="city">
                <label for="telephone">Téléphone</label>
                <input type="text" name="telephone" id="telephone">
                <label for="nom">Nom</label>
                <input type="text" name="nom" id="nom">
                <label for="prenom">Prénom</label>
                <input type="text" name="prenom" id="prenom">
                <p id="message">
                    <?php if (isset($INSERT_ADDRESS_ERROR)) {
                        echo $INSERT_ADDRESS_ERROR;
                    } ?>
                </p>
                <input type="submit" name="submit" class="submit" value="Valider">
            </form>
        </div>
    </main>
    <?php require_once('../include/footer.php') ?>
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