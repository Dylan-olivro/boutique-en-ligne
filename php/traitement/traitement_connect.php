<?php
require_once('../class/user.php');
session_start();
require_once('../include/bdd.php');
require_once('..//include/function.php');

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data)) {
    $email = $data['email'];
    $password = $data['password'];

    $user = new User(null, $email, null, null, $password, null);

    // La sécurité empêche que les champs soient VIDES et correspondent à ce que nous voulons.
    if (empty($email)) {
        $message['erreur'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe champ Email est vide.';
    } elseif (empty($password)) {
        $message['erreur'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe champ Password est vide';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message['erreur'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspL\'adresse mail n\'est pas valide.';
    } elseif ($user->isExist($bdd)) {
        $res = $user->returnUser($bdd);
        // Récupération de l'email et du mot de passe de l'utilisateurs pour vérifier si ils correspondes avec ce qu'il a rentrer dans le formulaire
        $recupUser = $bdd->prepare("SELECT * FROM users WHERE email = :email AND password = :password");
        $recupUser->execute([
            'email' => $email,
            'password' => $res->password
        ]);
        $result = $recupUser->fetch(PDO::FETCH_OBJ);

        if ($result) {
            // Vérification du mot de passe 
            if (password_verify($password, $result->password)) {
                $_SESSION['user'] = $result;
                $message['succes'] = "Utilisateur connecté avec succès";
            } else {
                $message['erreur'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe mot de passe est incorrect.';
            }
        }
    } else {
        $message['erreur'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspCette email n\'existe pas.';
    }
} else {
    $message['erreur'] = "Données manquantes";
}

header('Content-Type: application/json');
echo json_encode($message);
exit;
