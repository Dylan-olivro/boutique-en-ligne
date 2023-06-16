<?php require_once('./php/include/required.php');
// ! AJOUTER LES CONDITIONS POUR LES IMAGES DANS LE FORMULAIRE DU PRODUIT
// ! INTVAL POUR LA CONNEXION
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once('./php/include/head.php') ?>
    <title>Home</title>

</head>

<body>
    <form action="" method="post">
        <input type="text" name="test">
        <input type="submit" name="submit">
    </form>

    <?php require_once('./php/include/header.php') ?>
    <?php
    var_dump($_SESSION);
    if (isset($_POST['submit'])) {
        var_dump(isLetter($_POST['test']) ? true : false);
    }
    // Requête qui permet de récupérer les ID des produits les plus vendus
    $request = $bdd->prepare("SELECT product_id,count(*) FROM liaison_product_order GROUP BY product_id ORDER BY count(*) DESC");
    $request->execute();
    $result = $request->fetchAll(PDO::FETCH_ASSOC);
    // var_dump($result);



    // * Demander si required est néssecaire vu que ça empêche d'afficher les messages d'erreurs !

    // ? FAIRE UNE PAGE POUR VOIR TOUTES NOS COMMANDES
    // ? Quand les inputs sont différents de vide mettre leur border en --button-color
    // ? PASSER LE MESSAGE DE STOCK EPUISEE SUR LE DETAIL EN --> JAVASCRIPT

    // ! TRAVAILLER LE CSS SUR DU 1920/1080
    // ! Ajouter le css concernant le main sur toutes les pages
    // ! REMETTRE LE SETINTERVAL SUR LES FETCH DE L'ADMIN
    // ! Probleme si on ajoute 2 fois le même produit au panier et qu'on click sur supprimer, ça supprime les 2 (voir avec des data-id et uniqId() ou faire un systeme de quantité)
    ?>
    <?php require_once('./php/include/footer.php') ?>
</body>

</html>

<?php

// TODO: désactiver la touche ENTRER sur l'autocomplétion car elle envoie sur une page erreur
// TODO: rajouter un header location après le post Delete de la page Cart
// TODO: FAIRE toutes les verif en html, php et js pour les formulaires des pages admin, cartPage, profil, addAdress, modifyAdress, modifyPassword 
// TODO: FAIRE la maquette
// TODO: FAIRE le MCD
// TODO: FAIRE la gestions des promotions
// TODO: FAIRE la gestion des tags produits
// TODO: FAIRE un système de payement fonctionnel
// TODO: FAIRE une génération de numéro de commande
// TODO: FAIRE le calcul de la TVA
// TODO: FAIRE un systéme de commentaire
// TODO: FAIRE les avis d'utilisateurs
// TODO: FAIRE le rating d'un produit
// TODO: FAIRE une gestion des commentaires par l'Administrateur
?>