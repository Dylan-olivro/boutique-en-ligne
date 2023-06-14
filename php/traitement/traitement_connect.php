<?php
require_once('../class/user.php');
session_start();
require_once('../include/bdd.php');
require_once('../include/function.php');

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data)) {
    $email = $data['email'];
    $password = $data['password'];

    $user = new User(null, $email, null, null, $password, null);

    // La sécurité empêche que les champs soient VIDES et correspondent à ce que nous voulons.
    if (empty($email)) {
        $message['CONNECT_ERROR'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe champ Email est vide.';
    } elseif (empty($password)) {
        $message['CONNECT_ERROR'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe champ Password est vide';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message['CONNECT_ERROR'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspL\'adresse mail n\'est pas valide.';
    } elseif ($user->isExist($bdd)) {
        $res = $user->returnUserByEmail($bdd);
        $result = $user->returnUserByEmailAndPassword($bdd, $res->user_password);

        if ($result) {
            // Vérification du mot de passe 
            if (password_verify($password, $result->user_password)) {
                $_SESSION['user'] = $result;
                $message['CONNECT_SUCCES'] = "Utilisateur connecté avec succès";
            } else {
                $message['CONNECT_ERROR'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe mot de passe est incorrect.';
            }
        }
    } else {
        $message['CONNECT_ERROR'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspCette email n\'existe pas.';
    }
} else {
    $message['CONNECT_ERROR'] = "Données manquantes";
}

header('Content-Type: application/json');
echo json_encode($message);
exit;
