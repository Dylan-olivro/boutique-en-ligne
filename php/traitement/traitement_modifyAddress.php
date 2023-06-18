<?php
require_once('../class/address.php');
require_once('../class/user.php');
session_start();
require_once('../include/bdd.php');
require_once('../include/function.php');

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data)) {
    $id = $data['addressID'];
    $numero = $data['numero'];
    $name = $data['name'];
    $postcode = $data['postcode'];
    $city = $data['city'];
    $telephone = $data['telephone'];
    $nom = $data['nom'];
    $prenom = $data['prenom'];

    $address = new Address($id, $_SESSION['user']->user_id, null, null, null, null, null, null, null);

    if (empty($numero)) {
        $message['UPDATE_ADDRESS_ERROR'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe champ Numero est vide.';
    } elseif (empty($name)) {
        $message['UPDATE_ADDRESS_ERROR'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe champ Adresse est vide.';
    } elseif (empty($postcode)) {
        $message['UPDATE_ADDRESS_ERROR'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe champ Postcode est vide.';
    } elseif (empty($city)) {
        $message['UPDATE_ADDRESS_ERROR'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe champ City est vide.';
    } elseif (!isStreet($numero)) {
        $message['UPDATE_ADDRESS_ERROR'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe champ Numero est invalide.';
    } elseif (!isPostcode($postcode)) {
        $message['UPDATE_ADDRESS_ERROR'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe champ Postcode est invalide.';
    } elseif (!Address::formatTelephoneAccept($telephone)) {
        $message['UPDATE_ADDRESS_ERROR'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe numéro de téléphone est invalide.';
    } elseif (User::isToBig($nom)) {
        $message['UPDATE_ADDRESS_ERROR'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe nom doit faire moins de 30 caractères.';
    } elseif (User::isToBig($prenom)) {
        $message['UPDATE_ADDRESS_ERROR'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe prénom doit faire moins de 30 caractères.';
    } elseif (User::isToSmall($nom)) {
        $message['UPDATE_ADDRESS_ERROR'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe nom doit faire plus de 2 caractères.';
    } elseif (User::isToSmall($prenom)) {
        $message['UPDATE_ADDRESS_ERROR'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe prénom doit faire plus de 2 caractères.';
    } elseif (!User::isAName($nom)) {
        $message['UPDATE_ADDRESS_ERROR'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe nom n\'est pas valide.';
    } elseif (!User::isAName($prenom)) {
        $message['UPDATE_ADDRESS_ERROR'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe pr&nom n\'est pas valide.';
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
        $message['UPDATE_ADDRESS_SUCCES'] = '<i class="fa-solid fa-circle-check"></i>&nbspAdresse modifié.';
    }
} else {
    $message['UPDATE_ADDRESS_ERROR'] = "Données manquantes";
}

header('Content-Type: application/json');
echo json_encode($message);
exit;
