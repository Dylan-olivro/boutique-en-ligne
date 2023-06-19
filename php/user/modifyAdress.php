<?php require_once('../include/required.php');

// Empêche les utilisateurs que ne sont pas connecté de venir sur cette page
if (!isset($_SESSION['user'])) {
    header('Location: ../../index.php');
    exit();
}

$address = new Address($_GET['id'], $_SESSION['user']->user_id, null, null, null, null, null, null, null);
$userAddress = $address->returnAddressesById($bdd);
// Récupération de l'adresse à modifier
// Empêche d'aller sur la page si il n'y a aucun ID selectionner dans le lien ou si l'ID ne correspond pas à une adresse de l'utilisateur
if (!$userAddress) {
    header('Location: ../profil.php');
    exit();
}


// * Ne s'active que si le JAVASCRIPT est désactivé
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

        $address->setNumero($numero);
        $address->setName($name);
        $address->setPostcode($postcode);
        $address->setCity($city);
        $address->setTelephone($telephone);
        $address->setFirstname($prenom);
        $address->setLastname($nom);
        // $address = new Address($userAddress->address_id, $_SESSION['user']->user_id, $numero, $name, $postcode, $city, $telephone, $prenom, $nom);
        $address->updateAddress($bdd);
        header('Location: ../profil.php');
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once('../include/head.php'); ?>
    <title>Adress Modify</title>
    <link rel="stylesheet" href="../../css/modifyAddress.css">
    <script src="../../js/user/modifyAddress.js" defer></script>
</head>

<body>
    <?php require_once('../include/header.php'); ?>

    <main>
        <section id="container">
            <div class="MainContent">
                <!-- Formulaire pour MODIFIER l'adresse de l'utilisateur -->
                <form action="" method="post" id="FormUpdateAddress">
                    <h3>Modifier votre adresse</h3>
                    <input type="hidden" name="addressID" value="<?= htmlspecialchars($_GET['id']) ?>">
                    <label for="numero" class="FormChild">Numero</label>
                    <input type="number" name="numero" id="numero" class="FormChild" value="<?= htmlspecialchars($userAddress->address_numero) ?>" autofocus>
                    <label for="name" class="FormChild">Name</label>
                    <input type="text" name="name" id="name" class="FormChild" value="<?= htmlspecialchars($userAddress->address_name) ?>">
                    <label for="postcode" class="FormChild">Postcode</label>
                    <input type="number" name="postcode" id="postcode" class="FormChild" value="<?= htmlspecialchars($userAddress->address_postcode) ?>">
                    <label for="city" class="FormChild">City</label>
                    <input type="text" name="city" id="city" class="FormChild" value="<?= htmlspecialchars($userAddress->address_city) ?>">
                    <label for="telephone" class="FormChild">Téléphone</label>
                    <input type="text" name="telephone" id="telephone" class="FormChild" value="<?= htmlspecialchars($userAddress->address_telephone) ?>">
                    <label for="nom" class="FormChild">Nom</label>
                    <input type="text" name="nom" id="nom" class="FormChild" value="<?= htmlspecialchars($userAddress->address_lastname) ?>">
                    <label for="prenom" class="FormChild">Prénom</label>
                    <input type="text" name="prenom" id="prenom" class="FormChild" value="<?= htmlspecialchars($userAddress->address_firstname) ?>">
                    <p id="message" class="FormChild">
                        <?php if (isset($UPDATE_ADDRESS_ERROR)) {
                            echo $UPDATE_ADDRESS_ERROR;
                        } ?>
                    </p>
                    <input type="submit" name="submit" id="submit" class="FormChild" value="Modifier">
                </form>
            </div>
        </section>
    </main>
    <?php require_once('../include/footer.php') ?>
</body>

</html>