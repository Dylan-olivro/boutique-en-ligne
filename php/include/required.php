<?php
// ! REGLER LE PROBLEME DU MESSAGE EN SESSION QUI RESTE SI ON CHANGE DE PAGE !
// ! DEMANDER SI REQUIRED EST NESSECAIRE VU QUE CA EMPECHE D'AFFICHER LES MESSAGE D'ERREUR !
// RECUPERER L'URL POUR SAVOIR SI C'EST L'INDEX OU LES AUTRES PAGES
function getURL()
{
    if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
        $url = "https";
    else {
        $url = "http";
    }
    // ASSEMBLAGE DE L'URL
    $url .= "://";
    $url .= $_SERVER['HTTP_HOST'];
    $url .= $_SERVER['REQUEST_URI'];
    $splitURL = explode('boutique-en-ligne', $url);
    $splitURL2 = explode('/', $splitURL[1]);
    return [$splitURL, $splitURL2];
}
// CONDITION SI ON EST SUR L'INDEX OU PAS
if (getURL()[0][1] === '/index.php' || getURL()[0][1] === '/') {
    require_once('./php/include/bdd.php');
    require_once('./php/include/function.php');
    require_once('./php/class/user.php');
    require_once('./php/class/adress.php');
    require_once('./php/class/image.php');
    require_once('./php/class/item.php');
    require_once('./php/class/category.php');
    require_once('./php/class/cart.php');
    require_once('./php/class/command.php');
} else {
    if (getURL()[1][2] === 'user') {
        require_once('../include/bdd.php');
        require_once('../include/function.php');
        require_once('../class/user.php');
        require_once('../class/adress.php');
        require_once('../class/image.php');
        require_once('../class/item.php');
        require_once('../class/category.php');
        require_once('../class/cart.php');
        require_once('../class/command.php');
    } else {
        require_once('./include/bdd.php');
        require_once('./include/function.php');
        require_once('./class/user.php');
        require_once('./class/adress.php');
        require_once('./class/image.php');
        require_once('./class/item.php');
        require_once('./class/category.php');
        require_once('./class/cart.php');
        require_once('./class/command.php');
    }
}

session_start();
// ob_start();
ob_start('ob_gzhandler');
