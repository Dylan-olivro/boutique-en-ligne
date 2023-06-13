<?php
$returnCategoryParent = $bdd->prepare('SELECT * FROM category WHERE id_parent = 0');
$returnCategoryParent->execute();
$resultCategoryParent = $returnCategoryParent->fetchAll(PDO::FETCH_OBJ);

if (getURL()[0][1] === '/index.php' || getURL()[0][1] === '/') {
    includeHeader($bdd, './', './php/', './');
} else {
    if (getURL()[1][2] === 'user') {
        includeHeader($bdd, '../../', '../', '../../');
    } else {
        includeHeader($bdd, '../', './', '../');
    }
}

function includeHeader($bdd, $index, $url, $image)
{
    $returnCategoryParent = $bdd->prepare('SELECT * FROM category WHERE id_parent = 0');
    $returnCategoryParent->execute();
    $resultCategoryParent = $returnCategoryParent->fetchAll(PDO::FETCH_OBJ);

?>
    <header id="allHeader">
        <nav class="navTop">
            <div class="logo">
                <a href="<?= $index ?>">LOGO</a>
            </div>
            <div class="searchBarDiv">
                <form action="" method="get" role="search">
                    <input type="text" id="searchBar" name="searchBar" type="text" placeholder="Cherchez un produit..." aria-label="Search" autocomplete="off">
                    <div id="searchResultsDesktopDiv">
                    </div>
                </form>
            </div>
            <div class="iconNavDiv">
                <span class="userIcon">
                    <i class="fa-solid fa-user"></i>
                    <div class="userLink">
                        <a href="http://">Se Connecter</a>
                        <a href="http://">S'inscrire</a>
                        <a href="http://">Profil</a>
                        <a href="http://">Admin</a>
                        <a href="http://">Déconnexion</a>
                        </div>
                </span>
                <a href="<?= $url ?>cartPage.php"><i class="fa-solid fa-cart-shopping"></i></a>
                <span id="darkMode"><i class="fa-regular fa-moon"></i></span>
                <!-- <span><i class="fa-regular fa-sun"></i></span> -->
                <div class="iconBurger" onclick="burger(this)">
                    <div class="bar1"></div>
                    <div class="bar2"></div>
                    <div class="bar3"></div>
                </div>
            </div>
        </nav>
        <nav class="categoriesNav">
            <form method="get" class="searchBarBurgerForm" role="search">
                <input class="" id="searchBarBurger" name="searchBarBurger" type="text" placeholder="Cherchez un produit..." aria-label="Search" autocomplete="off">
                <div id="searchResultsBurgerDiv">
                    <div id="searchResultsBurger"></div>
                </div>
            </form>

            <div class="navCategories" id="navCategories">
                <ul class="categoriesUl">
                    <a href="<?= $url ?>itemFilter.php" class="">Tous les produits</a>
                    <?php
                    foreach ($resultCategoryParent as $key) {
                        // var_dump($key['name']);                                
                    ?>
                        <li class="dropdown" id="">
                            <a class="" href="<?= $url ?>itemFilter.php?categoryParent=<?= $key->id ?>" role="button" data-bs-toggle="" aria-expanded="false">
                                <?= hd($key->name); ?>
                            </a>
                            <span class="chevronRight" id="">
                                <i class="fa-solid fa-circle-chevron-right"></i>
                            </span>
                            <ul class="dropdown-content" id="">
                                <li class="backToCategories" id="">
                                    <i class="fa-solid fa-circle-chevron-left"></i>
                                    Retour
                                </li>
                                <?php
                                $returnCategoryChild = $bdd->prepare('SELECT * FROM category WHERE id_parent = ?');
                                $returnCategoryChild->execute([$key->id]);
                                $resultCategoryChild = $returnCategoryChild->fetchAll(PDO::FETCH_OBJ);
                                foreach ($resultCategoryChild as $key2) {
                                ?>
                                    <li><a class="" href="<?= $url ?>itemFilter.php?subCategory=<?= $key2->id ?>"><?= hd($key2->name); ?></a>
                                    </li>
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

        </nav>
    </header>
<?php
}
