<?php
// RECUPERER L'URL POUR SAVOIR SI C'EST L'INDEX OU LES AUTRES PAGES
if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
    $url = "https";
else {
    $url = "http";
}

// ASSEMBLAGE DE L'URL
$url .= "://";
$url .= $_SERVER['HTTP_HOST'];
$url .= $_SERVER['REQUEST_URI'];
$splitURL = explode('boutique-en-ligne', $url);  //PHP

if ($splitURL[1] === '/index.php' || $splitURL[1] === '/') {
    // TODO: HEADER INDEX
?>
    <div>
        <nav>
            <a href="./index.php">Index</a>
            <!-- <a href="https://github.com/Dylan-olivro">Github</a> -->
            <?php
            if (isset($_SESSION['user'])) { ?>
                <a href="./php/profil.php">Profil</a>
                <a href="./php/disconnect.php">Disconnect</a>
            <?php } else { ?>
                <a href="./php/connect.php">connect</a>
                <a href="./php/connectJS.php">connectJS</a>
                <a href="./php/signUp.php">signUp</a>
                <a href="./php/signUpJS.php">signUpJS</a>
            <?php } ?>
        </nav>
    </div>
<?php } else {
    // TODO: HEADER
?>
    <div>
        <nav>
            <a href="../index.php">Index</a>
            <?php
            if (isset($_SESSION['user'])) { ?>
                <a href="./profil.php">Profil</a>
                <a href="./disconnect.php">Deco</a>
            <?php } else { ?>
                <a href="./connect.php">Connect</a>
                <a href="./signUp.php">signUp</a>
            <?php } ?>
        </nav>
    </div>
<?php }