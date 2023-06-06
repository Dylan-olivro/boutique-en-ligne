<?php
require_once('./include/bdd.php');
require_once('./class/user.php');
require_once('.//include/function.php');

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data)) {
    $email = $data['email'];
    $firstname = $data['firstname'];
    $lastname = $data['lastname'];
    $password = $data['password'];
    $confirm_password = $data['confirm_password'];

    if (isEmpty($email)) {
        $message['erreur'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe champ Email est vide.';
    } elseif (isEmpty($firstname)) {
        $message['erreur'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe champ Firstname est vide';
    } elseif (isEmpty($lastname)) {
        $message['erreur'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe champ Lastname est vide';
    } elseif (isEmpty($password)) {
        $message['erreur'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe champ Password est vide';
    } elseif (isEmpty($confirm_password)) {
        $message['erreur'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe champ Confirm Password est vide';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message['erreur'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspL\'adresse mail n\'est pas valide.';
    } elseif (!isName($firstname)) {
        $message['erreur'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe firstname n\'est pas valide.';
    } elseif (!isName($lastname)) {
        $message['erreur'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe lastname n\'est pas valide.';
    } elseif (isToBig($firstname)) {
        $message['erreur'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe firstname doit faire moins de 30 caractères.';
    } elseif (isToSmall($firstname)) {
        $message['erreur'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe firstname doit faire plus de 2 caractères.';
    } elseif (isToBig($lastname)) {
        $message['erreur'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe lastname doit faire moins de 30 caractères.';
    } elseif (isToSmall($lastname)) {
        $message['erreur'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe lastname doit faire plus de 2 caractères.';
    } elseif (!isSame($password, $confirm_password)) {
        $message['erreur'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLes champs password sont différents.';
    } else {
        $recupUser = $bdd->prepare("SELECT email FROM users WHERE email = :email");
        $recupUser->execute(['email' => $email]);
        $insertUser = $bdd->prepare("INSERT INTO users (email,lastname,firstname,password) VALUES(:email,:lastname,:firstname,:password)");

        if ($recupUser->rowCount() > 0) {
            $message['erreur'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspCette email est déjà utilisé';
        } else {
            $insertUser->execute([
                'email' => $email,
                'lastname' => $lastname,
                'firstname' => $firstname,
                'password' => password_hash($password, PASSWORD_DEFAULT)
            ]);
            $message['succes'] = "Données enregistrées avec succès";
        }
    }
} else {
    $message['erreur'] = "Données manquantes";
}

header('Content-Type: application/json');
echo json_encode($message);
exit;
