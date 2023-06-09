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
    <script src="./js/test.js" defer></script>
</head>

<body>

    <?php require_once('./php/include/header.php') ?>
    <?php require_once('./php/include/header-save.php') ?>
    <?php

    // Requête qui permet de récupérer les ID des produits les plus vendus
    $request = $bdd->prepare("SELECT product_id,count(*) FROM liaison_product_order GROUP BY product_id ORDER BY count(*) DESC");
    $request->execute();
    $result = $request->fetchAll(PDO::FETCH_ASSOC);
    // var_dump($result);

    // Permet de récupérer le prix HT et la TVA à partir d'un prix TTC
    function returnPriceHT(float $priceTTC)
    {
        $tva = 20 / 100;
        $priceHT = $priceTTC / (1 + $tva);
        $roundPriceHT = number_format($priceHT, 2);
        return $roundPriceHT;
    }
    function returnAmountTVA(float $priceTTC, float $priceHT)
    {
        $amountTVA = $priceTTC - $priceHT;
        $roundAmountTVA = number_format($amountTVA, 2);
        return $roundAmountTVA;
    }
    echo 'Prix TTC : ' . $prixTTC = 100;
    echo '<br>';
    echo 'Prix HT : ' . $prixHT = returnPriceHT($prixTTC);
    echo '<br>';
    echo 'TVA : ' . $TVA = returnAmountTVA($prixTTC, $prixHT);
    echo '<br>';

    // Permet de générer un numéro de commande
    echo str_replace(".", "-", strtoupper(uniqid('', true)));



    // * Demander si required est néssecaire vu que ça empêche d'afficher les messages d'erreurs !

    // ? FAIRE UNE PAGE POUR VOIR TOUTES NOS COMMANDES
    // ? Quand les inputs sont différents de vide mettre leur border en --button-color
    // ? PASSER LE MESSAGE DE STOCK EPUISEE SUR LE DETAIL EN --> JAVASCRIPT

    // ! TRAVAILLER LE CSS SUR DU 1920/1080
    // ! Ajouter le css concernant le main sur toutes les pages

    // ! Probleme si on ajoute 2 fois le même produit au panier et qu'on click sur supprimer, ça supprime les 2 (voir avec des data-id et uniqId() ou faire un systeme de quantité)
    ?>
</body>

</html>

<?php

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