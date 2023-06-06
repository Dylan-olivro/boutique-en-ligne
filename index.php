<?php require_once('./php/include/required.php'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <!-- CSS -->
    <link rel="stylesheet" href="./css/header.css">
    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <!-- JQUERY -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <!-- FONTAWESOME -->
    <script src="https://kit.fontawesome.com/9a09d189de.js" crossorigin="anonymous"></script>
    <!-- JAVASCRIPT -->
    <script src="./js/function.js" defer></script>
    <script src="./js/header.js" defer></script>
    <script src="./js/autocompletion.js" defer></script>
</head>

<body>
    <?php require_once('./php/include/header.php') ?>
    <?php require_once('./php/include/header-save.php') ?>
    <!-- Test de regex pour le prenom (Besoin de LETTRES, avec ACCENT, pas de CHIFFRES, possibilité d'ajouter un ' - ' ou un ESPACE pour faire des prénom composé, pas de CARACTERES SPECIAUX) -->
    <input type="text" name="a" id="a">

    <?php




    // ! TRAVAILLER LE CSS SUR DU 1920/1080

    // * Ajout de commentaire sur tout mon code + changement des execute + ajout de condition pour les formulaires et de securité sur les pages en PHP et en JS + retirer les REQUIRED + ajout d'une petite gestion de stock a la commande + blocker la commande si le stock n'est pas disponible + ajout du header.js sur toutes les pages

    // ? Passer l'affichage des Stock en fonction pour pouvoir la réutilisé dans la page détail et panier
    // ? Mettre les div de produit en lien en redirection vers la page détail
    // ? Quand les inputs sont différents de vide mettre leur border en --button-color
    // ? Ajouter nom, prenom et numéro de tél à la table adress puis à la class adress

    // ! Demander si required est néssecaire vu que ça empêche d'afficher les messages d'erreurs !
    // ! Trouver un regex pour le nom et prenom et faire les message d'erreurs
    // ! Dans le fichier user.php, à la méthode updatePassword faire un SELECT que sur le password et pas sur *
    // ! Le message d'erreur s'affiche par default pour le formulaire de modification d'adresse
    // ! PASSER LE MESSAGE DE STOCK EPUISEE SUR LE DETAIL EN --> JAVASCRIPT
    // ! Probleme si on ajoute 2 fois le même produit au panier et qu'on click sur supprimer, ça supprime les 2 (voir avec des data-id et uniqId() ou faire un systeme de quantité)
    // ! BLOQUER les adresses à 6 max
    // ! Ajouter le css concernant le main sur toutes les pages
    // ! Ajouter une adresse, ce fait en double
    ?>
</body>

</html>

<?php

// TODO: FAIRE toutes les verif en html, php et js pour les formulaires des pages admin, cartPage, profil, addAdress, modifyAdress, modifyPassword 
// TODO: FAIRE la maquette
// TODO: FAIRE le MCD
// TODO: FAIRE la gestions des promotions
// TODO: FAIRE la gestion des tags produits
// TODO: FAIRE la gestion des stocks
// TODO: FAIRE un système de payement fonctionnel
// TODO: FAIRE une génération de numéro de commande
// TODO: FAIRE le calcul de la TVA
// TODO: FAIRE un systéme de commentaire
// TODO: FAIRE les avis d'utilisateurs
// TODO: FAIRE le rating d'un produit
// TODO: FAIRE une gestion des commentaires par l'Administrateur
?>