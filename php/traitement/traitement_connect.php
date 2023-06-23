<?php
require_once('../class/user.php');
require_once('../class/cart.php');
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
        $result = $user->returnUserByEmail($bdd);
        // $res = $user->returnUserByEmailAndPassword($bdd, $res->user_password);

        if ($result) {
            // Vérification du mot de passe 
            if (password_verify($password, $result->user_password)) {

                // $user = new User($res->user_id, $email, $res->user_firstname, $res->user_lastname, $res->user_password, $res->user_role);
                // $_SESSION['user'] = $user;

                // $_SESSION['user']->user_id = (int)$res->user_id;
                // $_SESSION['user']->user_email = $res->user_email;
                // $_SESSION['user']->user_firstname = $res->user_firstname;
                // $_SESSION['user']->user_lastname = $res->user_lastname;
                // $_SESSION['user']->user_password = $res->user_password;
                // $_SESSION['user']->user_role = (int)$res->user_role;

                $_SESSION['user'] = $result;
                if (!empty($_SESSION['panier']['id_article'])) {

                    foreach ($_SESSION['panier']['id_article'] as $element) {
                        $a = array_search($element, $_SESSION['panier']['id_article']); // $key = 2;

                        $quantity = $bdd->prepare("SELECT `cart_quantity` FROM `carts` WHERE product_id = :product_id AND user_id = :user_id");
                        $quantity->execute([
                            'product_id' => $element,
                            'user_id' => $_SESSION['user']->user_id
                        ]);
                        $result_quantity = $quantity->fetch(PDO::FETCH_OBJ);

                        if ($quantity->rowCount() > 0) {
                            $updateQuantity = $bdd->prepare("UPDATE `carts` SET `cart_quantity`= :cart_quantity WHERE product_id = :product_id AND user_id = :user_id");
                            $updateQuantity->execute([
                                'cart_quantity' => $result_quantity->cart_quantity + $_SESSION['panier']['qte'][$a],
                                'product_id' => $element,
                                'user_id' => $_SESSION['user']->user_id
                            ]);
                        } else {
                            $insertQuantity = $bdd->prepare("INSERT INTO `carts`(`user_id`, `product_id`, `cart_quantity`) VALUES (:user_id,:product_id,:cart_quantity)");
                            $insertQuantity->execute([
                                'user_id' => $_SESSION['user']->user_id,
                                'product_id' => $element,
                                'cart_quantity' => $_SESSION['panier']['qte'][$a]
                            ]);
                        }

                        // $cart = $bdd->prepare("INSERT INTO carts(user_id, product_id, cart_quantity) VALUES (:user_id,:product_id,:cart_quantity)");
                        // $cart->execute([
                        //     'user_id' => $_SESSION['user']->user_id,
                        //     'product_id' => $element,
                        //     'cart_quantity' => $_SESSION['panier']['qte'][$a]
                        // ]);
                    }
                    unset($_SESSION['panier']);
                }
                $message['CONNECT_SUCCES'] = '<i class="fa-solid fa-circle-check"></i>&nbspUtilisateur connecté avec succès';
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
