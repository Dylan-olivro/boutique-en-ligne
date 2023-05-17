<?php

$returnCategoryParent = $bdd->prepare('SELECT * FROM category WHERE id_parent = 0');
$returnCategoryParent->execute();
$resultCategoryParent = $returnCategoryParent->fetchAll(PDO::FETCH_OBJ);
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
    require_once('./php/class/item.php');
?>
    <!-- <link rel="stylesheet" href="../../css/header.css"> -->
    <header id="allHeader">
        <!-- début 1ere nav -->
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid d-flex flex-column">
                <!-- <div class="navPrincipaleAvecLogo"> -->
                <div class="navPrincipale d-flex justify-content-between w-100" id="navPrincipale">
                    <a class="navbar-brand" id="iconSite" href="#">LOGO</a>
                    <div class="w-50" id="searchDiv">
                        <ul class="navbar-nav mb-2 mb-lg-0">
                            <form method="get" class="d-flex w-100" role="search">
                                <input class="form-control" id="searchBar" name="searchBar" type="search" placeholder="Cherchez un produit..." aria-label="Search" autocomplete="off">
                                <!-- <button class="btn btn-outline-success" type="submit">Search</button> -->
                                <div id="searchResultsDesktopDiv">
                                    <!-- <div id="searchResultsDesktop"></div> -->
                                </div>
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
                        <li class="nav-item">
                            <img id="darkMode" src="./assets/img_darkMode/moon.png" alt="" srcset="">
                        </li>
                    </ul>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarBurger" aria-controls="navbarBurger" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                </div>
                <div class="collapse navbar-collapse" id="navbarBurger">
                    <!-- </div> -->
                    <div id="searchBurgerDiv">
                        <ul class="navbar-nav mb-2 mb-lg-0">
                            <form method="get" class="d-flex w-100" role="search">
                                <input class="form-control" id="searchBarBurger" name="searchBarBurger" type="search" placeholder="Cherchez un produit..." aria-label="Search" autocomplete="off">
                                <div id="searchResultsBurgerDiv">
                                    <div id="searchResultsBurger"></div>
                                </div>
                            </form>
                        </ul>
                    </div>
                    <div class="navCategories" id="navCategories">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <a href="./php/productsFilter.php" class="nav-link">Tous les produits</a>
                            <?php
                            foreach ($resultCategoryParent as $key) {
                                // var_dump($key['name']);                                
                            ?>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <?= $key->name; ?>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <?php
                                        $returnCategoryChild = $bdd->prepare('SELECT * FROM category WHERE id_parent = ?');
                                        $returnCategoryChild->execute([$key->id]);
                                        $resultCategoryChild = $returnCategoryChild->fetchAll(PDO::FETCH_OBJ);
                                        foreach ($resultCategoryChild as $key2) {
                                        ?>
                                            <li><a class="dropdown-item" href="#"><?= $key2->name; ?></a></li>
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
        </nav>
        </div>
    </header>
<?php } else {
    require_once('./class/item.php');

    // TODO: HEADER
?>
    <header>
        <!-- début 1ere nav -->
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid d-flex flex-column">
                <!-- <div class="navPrincipaleAvecLogo"> -->
                <div class="navPrincipale d-flex justify-content-between w-100" id="navPrincipale">
                    <a class="navbar-brand" id="iconSite" href="#">LOGO</a>
                    <div class="w-50" id="searchDiv">
                        <ul class="navbar-nav mb-2 mb-lg-0">
                            <form class="d-flex w-100" role="search">
                                <input class="form-control" id="searchBar" type="search" placeholder="Cherchez un produit..." aria-label="Search" autocomplete="off">
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
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarBurger" aria-controls="navbarBurger" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                </div>
                <div class="collapse navbar-collapse" id="navbarBurger">
                    <!-- </div> -->
                    <div id="searchBurgerDiv">
                        <ul class="navbar-nav mb-2 mb-lg-0">
                            <form class="d-flex w-100" role="search">
                                <input class="form-control" id="searchBarBurger" type="search" placeholder="Cherchez un produit..." aria-label="Search" autocomplete="off">
                            </form>
                        </ul>
                    </div>
                    <div class="navCategories" id="navCategories">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <a href="" class="nav-link">Tous les produits</a>
                            <?php
                            foreach ($resultCategoryParent as $key) {
                                // var_dump($key['name']);                                
                            ?>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <?= $key->name; ?>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <?php
                                        $returnCategoryChild = $bdd->prepare('SELECT * FROM category WHERE id_parent = ?');
                                        $returnCategoryChild->execute([$key->id]);
                                        $resultCategoryChild = $returnCategoryChild->fetchAll(PDO::FETCH_OBJ);
                                        foreach ($resultCategoryChild as $key2) {
                                        ?>
                                            <li><a class="dropdown-item" href="#"><?= $key2->name; ?></a></li>
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
        </nav>
        </div>
    </header>
<?php }
