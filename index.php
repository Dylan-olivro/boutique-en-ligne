<?php
require_once('./php/class/user.php');
?>
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

    <?php
    // var_dump($_SESSION);
    // $recupArticle = $bdd->prepare('SELECT * FROM items');
    // $recupArticle->execute();
    // $result = $recupArticle->fetchAll(PDO::FETCH_ASSOC);

    // var_dump($result);
    // foreach ($result as $key) {
    //     var_dump($key);
    //     # code...
    //     echo '<img src=".' . $key['image'] . '" alt="">';
    // }
    ?>
    <?php require_once('./php/include/header-save.php') ?>
</body>

</html>

<?php
// TODO: FAIRE LA MAQUETTE

// TODO: FAIRE LE MCD DE LA BASE DE DONNEE

// TODO: FAIRE LA BASE DE DONNEE

// * FAIRE LE HEADER
// TODO: + FAIRE BARRE DE RECHERCHE AVEC AUTOCOMPLETION

// * FAIRE LA PAGE D'ACCUEIL
// TODO: + GESTION DES PROMOTIONS
// TODO: + GESTION DES TAGS PRODUITS

// TODO: FAIRE LA PAGE DETAIL

// * FAIRE LA PAGE INSCRIPTION
// * + INSCRIPTION

// * FAIRE LA PAGE CONNECTION
// * + CONNECTION

// * FAIRE LA PAGE PROFIL
// TODO: + FAIRE L'HISTORIQUE DE COMMANDE, ET CONSULTATION DE PANIER

// * FAIRE LA PAGE ADMIN
// * + AJOUT DES ITEMS PAR L'ADMIN
// TODO: + SUPPRESSION DES ITEMS PAR L'ADMIN
// TODO: + MODIFICATION DES ITEMS PAR L'ADMIN
// TODO: + GERER LES STOCK PAR L'ADMIN
// TODO: + AJOUT DES CATEGORIES PAR L'ADMIN
// TODO: + SUPPRESSION DES CATEGORIES PAR L'ADMIN
// TODO: + MODIFICATION DES CATEGORIES PAR L'ADMIN
// * + MODIFICATION DES ROLES DES USERS

// TODO: FAIRE LA PAGE ALL ITEMS
// TODO: + 

// TODO: FAIRE LE PANIER
// TODO: + VALIDATION DU PANIER
// TODO: + SYSTEME DE PAYEMENT
// TODO: + GENERER UN NUMERO DE COMMANDE/ FACTURE
// TODO: + GESTION DE LA TVA

// TODO: AJOUT DU SYSTEME DE COMMENTAIRE
// TODO: + AVIS UTILISATEUR
// TODO: + RATING SUR LES PRODUITS
// TODO: + GESTION DES COMMENTAIRES PAR ADMIN
?>