<?php require_once('../include/required.php');

// Empêche les utilisateurs que ne sont pas connecté de venir sur cette page
if (!isset($_SESSION['user'])) {
    header('Location:../../index.php');
}

// Récupération de l'adresse à modifier
if (isset($_GET['id'])) {
    $address = new Address($_GET['id'], null, null, null, null, null, null, null, null);
    $userAddress = $address->returnAddressesById($bdd);

    // Empêche d'aller sur la page si il n'y a aucun ID selectionner dans le lien ou si l'ID ne correspond pas à une adresse de l'utilisateur
    if (!$userAddress) {
        header('Location: ../profil.php');
    }
}

// Mise à jour de l'adresse sélectionner
if (isset($_POST['submit'])) {
    $numero = $_POST['numero'];
    $name = $_POST['name'];
    $postcode = $_POST['postcode'];
    $city = $_POST['city'];
    $telephone = $_POST['telephone'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];

    if (empty($numero)) {
        $UPDATE_ADDRESS_ERROR = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe champ Numero est vide.';
    } elseif (empty($name)) {
        $UPDATE_ADDRESS_ERROR = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe champ Name est vide.';
    } elseif (empty($postcode)) {
        $UPDATE_ADDRESS_ERROR = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe champ Postcode est vide.';
    } elseif (empty($city)) {
        $UPDATE_ADDRESS_ERROR = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe champ City est vide.';
    } elseif (!isStreet($numero)) {
        $UPDATE_ADDRESS_ERROR = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe champ Numero est invalide.';
    } elseif (!isPostcode($postcode)) {
        $UPDATE_ADDRESS_ERROR = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe champ Postcode est invalide.';
    } elseif (!Address::formatTelephoneAccept($telephone)) {
        $UPDATE_ADDRESS_ERROR = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe numéro de téléphone est invalide.';
    } elseif (User::isToBig($nom)) {
        $UPDATE_ADDRESS_ERROR = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe nom doit faire moins de 30 caractères.';
    } elseif (User::isToBig($prenom)) {
        $UPDATE_ADDRESS_ERROR = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe prénom doit faire moins de 30 caractères.';
    } elseif (User::isToSmall($nom)) {
        $UPDATE_ADDRESS_ERROR = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe nom doit faire plus de 2 caractères.';
    } elseif (User::isToSmall($prenom)) {
        $UPDATE_ADDRESS_ERROR = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe prénom doit faire plus de 2 caractères.';
    } elseif (!User::isAName($nom)) {
        $UPDATE_ADDRESS_ERROR = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe nom n\'est pas valide.';
    } elseif (!User::isAName($prenom)) {
        $UPDATE_ADDRESS_ERROR = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe pr&nom n\'est pas valide.';
    } else {
        $address = new Address($userAddress->address_id, $_SESSION['user']->user_id, $numero, $name, $postcode, $city, $telephone, $prenom, $nom);
        $address->updateAddress($bdd);
        header('Location: ../profil.php');
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adress Modify</title>
    <!-- CSS -->
    <link rel="stylesheet" href="../../css/header.css">
    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <!-- JQUERY -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <!-- FONTAWESOME -->
    <script src="https://kit.fontawesome.com/9a09d189de.js" crossorigin="anonymous"></script>
    <!-- JAVASCRIPT -->
    <script src="../../js/function.js" defer></script>
    <script src="../../js/header.js" defer></script>
    <script src="../../js/autocompletion.js" defer></script>

</head>

<body>
    <?php require_once('../include/header.php'); ?>
    <?php require_once('../include/header-save.php') ?>

    <main>
        <!-- Formulaire pour MODIFIER l'adresse de l'utilisateur -->
        <form action="" method="post" id="formUpdateAdress">
            <label for="numero">Numero</label>
            <input type="number" name="numero" id="numero" value="<?= htmlspecialchars($userAddress->address_numero) ?>" autofocus>
            <label for="name">Name</label>
            <input type="text" name="name" id="name" value="<?= htmlspecialchars($userAddress->address_name) ?>">
            <label for="postcode">Postcode</label>
            <input type="number" name="postcode" id="postcode" value="<?= htmlspecialchars($userAddress->address_postcode) ?>">
            <label for="city">City</label>
            <input type="text" name="city" id="city" value="<?= htmlspecialchars($userAddress->address_city) ?>">
            <label for="telephone">Téléphone</label>
            <input type="text" name="telephone" id="telephone" value="<?= htmlspecialchars($userAddress->address_telephone) ?>">
            <label for="nom">Nom</label>
            <input type="text" name="nom" id="nom" value="<?= htmlspecialchars($userAddress->address_lastname) ?>">
            <label for="prenom">Prénom</label>
            <input type="text" name="prenom" id="prenom" value="<?= htmlspecialchars($userAddress->address_firstname) ?>">
            <p id="message">
                <?php if (isset($UPDATE_ADDRESS_ERROR)) {
                    echo $UPDATE_ADDRESS_ERROR;
                } ?>
            </p>
            <input type="submit" name="submit" class="input" value="Modifier">
        </form>
    </main>
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