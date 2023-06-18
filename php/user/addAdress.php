<?php require_once('../include/required.php');

// Empêche les utilisateurs que ne sont pas connecté de venir sur cette page
if (!isset($_SESSION['user'])) {
    header('Location:../../index.php');
    exit();
}
// Récupération de toutes les adresses de l'utilisateur
$address = new Address(null, $_SESSION['user']->user_id, null, null, null, null, null, null, null);
$allUserAddresses = $address->returnAddressesByUser($bdd);

// * Ne s'active que si le JAVASCRIPT est désactivé
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
        $INSERT_ADDRESS_ERROR = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe nom doit faire moins de 30 caractères.';
    } elseif (User::isToBig($prenom)) {
        $INSERT_ADDRESS_ERROR = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe prénom doit faire moins de 30 caractères.';
    } elseif (User::isToSmall($nom)) {
        $INSERT_ADDRESS_ERROR = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe nom doit faire plus de 2 caractères.';
    } elseif (User::isToSmall($prenom)) {
        $INSERT_ADDRESS_ERROR = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe prénom doit faire plus de 2 caractères.';
    } elseif (!User::isAName($nom)) {
        $INSERT_ADDRESS_ERROR = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe nom n\'est pas valide.';
    } elseif (!User::isAName($prenom)) {
        $INSERT_ADDRESS_ERROR = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe pr&nom n\'est pas valide.';
    } elseif (count($allUserAddresses) >= 6) {
        $INSERT_ADDRESS_ERROR = '<i class="fa-solid fa-circle-exclamation"></i>&nbspNombres maximum d\'adresse atteint (6).';
    } else {
        // $address = new Address(null, $_SESSION['user']->user_id, $numero, $name, $postcode, $city, null, $prenom, $nom);
        $tel = $address->returnFormatTel($telephone);
        // Mise à jour de l'objet Address
        $address->setNumero($numero);
        $address->setName($name);
        $address->setPostcode($postcode);
        $address->setCity($city);
        $address->setFirstname($prenom);
        $address->setLastname($nom);
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
    <script src="../../js/user/addAddress.js" defer></script>
</head>

<body>
    <?php require_once('../include/header.php'); ?>

    <main>
        <section id="container">

            <div class="MainContent">
                <!-- Formulaire pour AJOUTER une adresse à l'utilisateur -->
                <form action="" method="post" id="FormAddAddress">
                    <h3>Ajouter une Adresse</h3>
                    <label for="numero" class="FormChild">Numéro</label>
                    <input type="number" name="numero" id="numero" class="FormChild" autofocus>
                    <label for="name" class="FormChild">Adresse</label>
                    <input type="text" name="name" id="name" class="FormChild">
                    <label for="postcode" class="FormChild">Code Postal</label>
                    <input type="number" name="postcode" id="postcode" class="FormChild">
                    <label for="city" class="FormChild">Ville</label>
                    <input type="text" name="city" id="city" class="FormChild">
                    <label for="telephone" class="FormChild">Téléphone</label>
                    <input type="text" name="telephone" id="telephone" class="FormChild">
                    <label for="nom" class="FormChild">Nom</label>
                    <input type="text" name="nom" id="nom" class="FormChild">
                    <label for="prenom" class="FormChild">Prénom</label>
                    <input type="text" name="prenom" id="prenom" class="FormChild">
                    <p id="message" class="FormChild">
                        <?php if (isset($INSERT_ADDRESS_ERROR)) {
                            echo $INSERT_ADDRESS_ERROR;
                        } ?>
                    </p>
                    <input type="submit" name="submit" id="submit" class="FormChild" value="Valider">
                </form>
            </div>
        </section>
    </main>
    <?php require_once('../include/footer.php') ?>
</body>

</html>