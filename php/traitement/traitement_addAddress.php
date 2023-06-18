<?php
require_once('../class/address.php');
require_once('../class/user.php');
session_start();
require_once('../include/bdd.php');
require_once('../include/function.php');

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data)) {
    $numero = $data['numero'];
    $name = $data['name'];
    $postcode = $data['postcode'];
    $city = $data['city'];
    $telephone = $data['telephone'];
    $nom = $data['nom'];
    $prenom = $data['prenom'];

    $address = new Address(null, $_SESSION['user']->user_id, null, null, null, null, null, null, null);
    $allUserAddresses = $address->returnAddressesByUser($bdd);

    if (empty($numero)) {
        $message['INSERT_ADDRESS_ERROR'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe champ Numero est vide.';
    } elseif (empty($name)) {
        $message['INSERT_ADDRESS_ERROR'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe champ Adresse est vide.';
    } elseif (empty($postcode)) {
        $message['INSERT_ADDRESS_ERROR'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe champ Postcode est vide.';
    } elseif (empty($city)) {
        $message['INSERT_ADDRESS_ERROR'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe champ City est vide.';
    } elseif (!isStreet($numero)) {
        $message['INSERT_ADDRESS_ERROR'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe champ Numero est invalide.';
    } elseif (!isName($name)) {
        $message['INSERT_ADDRESS_ERROR'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe champ Adresse est invalide.';
    } elseif (!isName($city)) {
        $message['INSERT_ADDRESS_ERROR'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe champ Ville est invalide.';
    } elseif (!isPostcode($postcode)) {
        $message['INSERT_ADDRESS_ERROR'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe champ Postcode est invalide.';
    } elseif (!Address::formatTelephoneAccept($telephone)) {
        $message['INSERT_ADDRESS_ERROR'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe numéro de téléphone est invalide.';
    } elseif (User::isToBig($nom)) {
        $message['INSERT_ADDRESS_ERROR'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe nom doit faire moins de 30 caractères.';
    } elseif (User::isToBig($prenom)) {
        $message['INSERT_ADDRESS_ERROR'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe prénom doit faire moins de 30 caractères.';
    } elseif (User::isToSmall($nom)) {
        $message['INSERT_ADDRESS_ERROR'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe nom doit faire plus de 2 caractères.';
    } elseif (User::isToSmall($prenom)) {
        $message['INSERT_ADDRESS_ERROR'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe prénom doit faire plus de 2 caractères.';
    } elseif (!User::isAName($nom)) {
        $message['INSERT_ADDRESS_ERROR'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe nom n\'est pas valide.';
    } elseif (!User::isAName($prenom)) {
        $message['INSERT_ADDRESS_ERROR'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe pr&nom n\'est pas valide.';
    } elseif (count($allUserAddresses) >= 6) {
        $message['INSERT_ADDRESS_ERROR'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspNombres maximum d\'adresse atteint (6).';
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
        $message['INSERT_ADDRESS_SUCCES'] = '<i class="fa-solid fa-circle-check"></i>&nbspAdresse ajouté.';
    }
} else {
    $message['INSERT_ADDRESS_ERROR'] = "Données manquantes";
}

header('Content-Type: application/json');
echo json_encode($message);
exit;
