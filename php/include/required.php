<?php
// Fonction pour récupérer l'URL de la page et gérer les redirections en fonction de la page
function getURL()
{
    if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
        $url = "https";
    else {
        $url = "http";
    }
    // Assemblage de L'URL
    $url .= "://";
    $url .= $_SERVER['HTTP_HOST'];
    $url .= $_SERVER['REQUEST_URI'];
    $splitURL = explode('boutique-en-ligne', $url);
    $splitURL2 = explode('/', $splitURL[1]);
    return [$splitURL, $splitURL2];
}
// Si on se trouve sur l'index
if (getURL()[0][1] === '/index.php' || getURL()[0][1] === '/') {
    require_once('./php/include/bdd.php');
    require_once('./php/include/function.php');
    require_once('./php/class/user.php');
    require_once('./php/class/address.php');
    require_once('./php/class/image.php');
    require_once('./php/class/product.php');
    require_once('./php/class/category.php');
    require_once('./php/class/cart.php');
    require_once('./php/class/order.php');
} else {
    // Si on se trouve dans le fichier PHP puis dans un fichier USER
    if (getURL()[1][2] === 'user') {
        require_once('../include/bdd.php');
        require_once('../include/function.php');
        require_once('../class/user.php');
        require_once('../class/address.php');
        require_once('../class/image.php');
        require_once('../class/product.php');
        require_once('../class/category.php');
        require_once('../class/cart.php');
        require_once('../class/order.php');
    } else {
        require_once('./include/bdd.php');
        require_once('./include/function.php');
        require_once('./class/user.php');
        require_once('./class/address.php');
        require_once('./class/image.php');
        require_once('./class/product.php');
        require_once('./class/category.php');
        require_once('./class/cart.php');
        require_once('./class/order.php');
    }
}

session_start();
// ob_start();
ob_start('ob_gzhandler');

// Création du panier pour les utilisateurs qui ne sont pas connecté
if (!isset($_SESSION['user'])) {
    if (!isset($_SESSION['panier'])) {
        /* Initialisation du panier */
        $_SESSION['panier'] = array();
        /* Subdivision du panier */
        $_SESSION['panier']['id_article'] = array();
        $_SESSION['panier']['qte'] = array();
        $_SESSION['panier']['prix'] = array();
    }
}
