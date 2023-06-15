<?php

if (getURL()[0][1] === '/index.php' || getURL()[0][1] === '/') {
    includeHead('./');
} else {
    if (getURL()[1][2] === 'user') {
        includeHead('../../');
    } else {
        includeHead('../');
    }
}

function includeHead($url)
{ ?>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- JQUERY -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <!-- BOOTSTRAP -->
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script> -->
    <!-- CSS -->
    <link rel="stylesheet" href="<?= $url ?>css/header.css">
    <link rel="stylesheet" href="<?= $url ?>css/footer.css">
    <!-- JAVASCRIPT -->
    <script src="<?= $url ?>js/function.js" defer></script>
    <script src="<?= $url ?>js/header.js" defer></script>
    <script src="<?= $url ?>js/autocompletion.js" defer></script>
    <!-- FONTAWESOME -->
    <script src="https://kit.fontawesome.com/9a09d189de.js" crossorigin="anonymous"></script>
    <!-- GOOGLE FONT -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
    <!-- HEAD POUR CETTE PAGE -->
<?php
}
?>