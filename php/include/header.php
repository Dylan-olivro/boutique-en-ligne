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
    <!-- <link rel="stylesheet" href="../../css/header.css"> -->
    <header>
        <!-- début 1ere nav -->
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
                <!-- <div class="navPrincipaleAvecLogo"> -->
                    <div class=""></div>
                <a class="navbar-brand" href="#">LOGO ACCUEIL</a>
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
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
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <div class="navPrincipale" id="">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <form class="d-flex" role="search">
                                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                                <!-- <button class="btn btn-outline-success" type="submit">Search</button> -->
                            </form>
                        </ul>
                    </div>
                    <!-- </div> -->
                        <div class="navCategories">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Ordinateurs
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#">PC gaming</a></li>
                                    <li><a class="dropdown-item" href="#">PC portable</a></li>
                                    <!-- <li><hr class="dropdown-divider"></li> -->
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
                                <!-- <li><hr class="dropdown-divider"></li> -->
                                <li><a class="dropdown-item" href="#">Carte mère</a></li>
                            </ul>
                        </li>
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
