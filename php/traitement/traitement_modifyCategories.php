<?php
require_once('../class/category.php');
session_start();
require_once('../include/bdd.php');
require_once('../include/function.php');

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data)) {
    $id = $data['id'];
    $name = $data['nameCategory'];
    $idParent = $data['idParent'];


    // La sécurité empêche que les champs soient VIDES et correspondent à ce que nous voulons.
    if (empty($id)) {
        $message['CATEGORY_ERROR'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspAucun ID selectionné.';
    } elseif (empty($name)) {
        $message['CATEGORY_ERROR'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe champ Name est vide';
    } elseif (empty($idParent)) {
        $message['CATEGORY_ERROR'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe champ ID Parent est vide';
    } elseif (!isNumber($id)) {
        $message['CATEGORY_ERROR'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspL\'ID doit être un nombre.';
    } elseif (!isLetter($name)) {
        $message['CATEGORY_ERROR'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe name doit comporté que des lettres.';
    } elseif (!isNumber($idParent)) {
        $message['CATEGORY_ERROR'] = '<i class="fa-solid fa-circle-exclamation"></i>&nbspL\'ID Parent doit être un nombre.';
    } else {
        $category = new Category($id, $name, $idParent);
        $category->updateCategory($bdd);
        $message['CATEGORY_SUCCES'] = '<i class="fa-solid fa-circle-check"></i>&nbspCatégorie Modifier';
    }
} else {
    $message['CATEGORY_ERROR'] = "Données manquantes";
}

header('Content-Type: application/json');
echo json_encode($message);
exit;
