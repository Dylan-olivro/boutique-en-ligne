<?php
require_once('../include/bdd.php');
require_once('../class/user.php');
require_once('../include/function.php');

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data)) {
    $email = $data['email'];
    $firstname = $data['firstname'];
    $lastname = $data['lastname'];
    $password = $data['password'];
    $confirm_password = $data['confirm_password'];

    $user = new User(null, $email, $firstname, $lastname, $password, null);

    if (empty($email)) {
        $message['REGISTER_ERROR'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe champ Email est vide.';
    } elseif (empty($firstname)) {
        $message['REGISTER_ERROR'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe champ Firstname est vide';
    } elseif (empty($lastname)) {
        $message['REGISTER_ERROR'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe champ Lastname est vide';
    } elseif (empty($password)) {
        $message['REGISTER_ERROR'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe champ Password est vide';
    } elseif (empty($confirm_password)) {
        $message['REGISTER_ERROR'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe champ Confirm Password est vide';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message['REGISTER_ERROR'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspL\'adresse mail n\'est pas valide.';
    } elseif (!User::isAName($firstname)) {
        $message['REGISTER_ERROR'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe firstname n\'est pas valide.';
    } elseif (!User::isAName($lastname)) {
        $message['REGISTER_ERROR'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe lastname n\'est pas valide.';
    } elseif (User::isToBig($firstname)) {
        $message['REGISTER_ERROR'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe firstname doit faire moins de 30 caractères.';
    } elseif (User::isToSmall($firstname)) {
        $message['REGISTER_ERROR'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe firstname doit faire plus de 2 caractères.';
    } elseif (User::isToBig($lastname)) {
        $message['REGISTER_ERROR'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe lastname doit faire moins de 30 caractères.';
    } elseif (User::isToSmall($lastname)) {
        $message['REGISTER_ERROR'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe lastname doit faire plus de 2 caractères.';
    } elseif (!User::isSame($password, $confirm_password)) {
        $message['REGISTER_ERROR'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLes champs password sont différents.';
    } else {
        if ($user->isExist($bdd)) {
            $message['REGISTER_ERROR'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspCette email est déjà utilisé';
        } else {
            $user->register($bdd);
            $message['REGISTER_SUCCES'] = '<i class="fa-solid fa-circle-check"></i>&nbspDonnées enregistrées avec succès';
        }
    }
} else {
    $message['REGISTER_ERROR'] = "Données manquantes";
}

header('Content-Type: application/json');
echo json_encode($message);
exit;
