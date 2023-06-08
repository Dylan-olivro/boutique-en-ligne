<?php
require_once('../include/bdd.php');
session_start();
require_once('../class/user.php');
require_once('../include/function.php');

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data)) {
    $email = $data['email'];
    $firstname = $data['firstname'];
    $lastname = $data['lastname'];
    $password = $data['password'];

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
        // var_dump($res);
        if ($password != password_verify($password, $res->password)) {
            $message['erreur'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspCe n\'est pas le bon mot de passe';
        } else {
            $user->update($bdd, $res->password);
            $message['succes'] = "Données enregistrées avec succès";
        }
    }
} else {
    $message['erreur'] = "Données manquantes";
}

header('Content-Type: application/json');
echo json_encode($message);
exit;
