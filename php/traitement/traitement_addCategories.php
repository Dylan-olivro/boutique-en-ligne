<?php
require_once('../class/category.php');
session_start();
require_once('../include/bdd.php');
require_once('../include/function.php');

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data)) {
    $name = $data['nameCategory'];
    $IDParent = $data['idParent'];

    if (empty($name)) {
        $message['CATEGORY_ERROR'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe champ Name est vide.';
    } elseif (empty($IDParent)) {
        $message['CATEGORY_ERROR'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe champ ID Parent est vide';
    } elseif (!isLetter($name)) {
        $message['CATEGORY_ERROR'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe champ catégorie doit contenir que des lettres.';
    } elseif (!isNumber($IDParent)) {
        $message['CATEGORY_ERROR'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspL\'ID Parent doit être un nombre.';
    } else {
        $category = new Category(null, $name, $IDParent);
        $category->addCategory($bdd);
        $message['CATEGORY_SUCCES'] = '<i class="fa-solid fa-circle-check"></i>&nbspCatégorie Ajoutée.';
    }
} else {
    $message['CONNECT_ERROR'] = "Données manquantes";
}

header('Content-Type: application/json');
echo json_encode($message);
exit;
