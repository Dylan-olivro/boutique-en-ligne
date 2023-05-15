<?php
require_once('./php/class/item.php');

$returnCategory = $bdd->prepare('SELECT * FROM category WHERE id_parent = 0');
$returnCategory->execute();
$resultCategory = $returnCategory->fetchAll(PDO::FETCH_OBJ);
// var_dump($resultCategory);


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
    <!-- <link rel="stylesheet" href="../../css/header.css"> -->
    <header>
        <!-- début 1ere nav -->
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid d-flex flex-column">
                <!-- <div class="navPrincipaleAvecLogo"> -->
                <div class="navPrincipale d-flex justify-content-between w-100" id="navPrincipale">
                    <a class="navbar-brand" id="iconSite" href="#">LOGO</a>
                    <div class="w-50" id="searchDiv">
                        <ul class="navbar-nav mb-2 mb-lg-0" id="searchBar">
                            <form class="d-flex w-100" role="search">
                                <input class="form-control" type="search" placeholder="Cherchez un produit..." aria-label="Search">
                                <!-- <button class="btn btn-outline-success" type="submit">Search</button> -->
                            </form>
                        </ul>
                    </div>
                    <ul class="navbar-nav mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#"><i class="fa-solid fa-user fa-lg"></i></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#"><i class="fa-solid fa-cart-shopping fa-lg"></i></a>
                        </li>
                    </ul>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                </div>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- </div> -->
                    <div class="navCategories" id="navCategories">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <?php
                            foreach ($resultCategory as $key) {
                                // var_dump($key['name']);                                
                                 ?>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <?= $key->name; ?>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <?php
                                                $returnCategory2 = $bdd->prepare('SELECT * FROM category WHERE id_parent = ?');
                                                $returnCategory2->execute([$key->id]);
                                                $resultCategory2 = $returnCategory2->fetchAll(PDO::FETCH_OBJ);                                     
                                        foreach($resultCategory2 as $key2){
                                            ?>
                                        <li><a class="dropdown-item" href="#"><?= $key2->name; ?></a></li>
                                        <!-- <li><a class="dropdown-item" href="#">PC portable</a></li> -->
                                        <!-- <li><hr class="dropdown-divider"></li> -->
                                        <!-- <li><a class="dropdown-item" href="#">Tablette</a></li> -->
                                        <?php
                                    }
                                    ?>
                                    </ul>
                                </li>
                                <?php
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        </nav><!-- début 2e nav -->
        <!-- <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="">
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Ordinateurs
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">PC gaming</a></li>
                                <li><a class="dropdown-item" href="#">PC portable</a></li>
                                <li><a class="dropdown-item" href="#">Tablette</a></li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Composants
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Processeur</a></li>
                                <li><a class="dropdown-item" href="#">Carte graphique</a></li>
                                <li><a class="dropdown-item" href="#">Carte mère</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav> -->
        </div>
    </header>
<?php } else {
    // TODO: HEADER
?>
    <header>
        <!-- 1ere NAV POUR LOGO, SEARCH BAR, CONN ET PANIER -->
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
        <!-- 2e NAV POUR LES CATEGORIES PARENTS -->
        <nav>

        </nav>
    </header>
<?php }
