<?php
require_once('../class/user.php');
session_start();
require_once('../include/bdd.php');
require_once('../include/function.php');

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data)) {
    $id = $data['id'];
    $firstname = $data['firstname'];
    $lastname = $data['lastname'];
    $role = (int)$data['role'];


    // La sécurité empêche que les champs soient VIDES et correspondent à ce que nous voulons.
    if (empty($id)) {
        $message['USER_ERROR'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspAucun ID selectionné.';
    } elseif (empty($firstname)) {
        $message['USER_ERROR'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe champ Firstname est vide.';
    } elseif (empty($lastname)) {
        $message['USER_ERROR'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe champ Lastname est vide.';
    } elseif (!isNumber($id)) {
        $message['USER_ERROR'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspL\'ID doit être un nombre.';
    } elseif (!isName($firstname)) {
        $message['USER_ERROR'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe Firstname doit comporté que des lettres.';
    } elseif (!isName($lastname)) {
        $message['USER_ERROR'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe Lastname doit comporté que des lettres.';
    } else {
        if ($data['role'] == 0 || $data['role'] == 1 || $data['role'] == 2) {
            $accept = $bdd->prepare("UPDATE users SET user_firstname = :user_firstname, user_lastname = :user_lastname, user_role = :user_role WHERE user_id = :user_id ");
            $accept->execute([
                'user_firstname' => $firstname,
                'user_lastname' => $lastname,
                'user_role' => $role,
                'user_id' => $id
            ]);
            $message['USER_SUCCES'] = '<i class="fa-solid fa-circle-check"></i>&nbspUtilisateur Modifier';
        }
    }
} else {
    $message['USER_ERROR'] = "Données manquantes";
}

header('Content-Type: application/json');
echo json_encode($message);
exit;
