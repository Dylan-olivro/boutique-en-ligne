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
        <div class="sectionNav" id="sectionNav">
            <nav class="navTop">
                <div class="logo">
                    <a href="<?= $index ?>index.php"><i class="fa-solid fa-computer" style="color: #000000;"></i></a>
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
                        <?php
                        if (isset($_SESSION['user']) && (int)$_SESSION['user']->user_role !== 0) {
                            echo '<i class="fa-solid fa-user-gear"></i>';
                        } else {
                            echo '<i class="fa-solid fa-user"></i>';
                        }
                        ?>
                        <div class="userLink">
                            <?php
                            if (isset($_SESSION['user'])) { ?>
                                <a href="<?= $url ?>profil.php">Profil</a>
                                <a href="<?= $url ?>cartPage.php">Panier</a>
                                <?php if (intval($_SESSION['user']->user_role) !== 0) { ?>
                                    <a href="<?= $url ?>admin.php">Admin</a>
                                <?php } ?>
                                <a href="<?= $url ?>disconnect.php">Disconnect</a>
                            <?php } else { ?>
                                <a href="<?= $url ?>connect.php">Connect</a>
                                <a href="<?= $url ?>register.php">Register</a>
                            <?php } ?>
                        </div>
                    </span>
                    <a href="<?= $url ?>cartPage.php">
                        <i class="fa-solid fa-cart-shopping"></i>
                    </a>
                    <span id="darkMode" onclick="themeToggle()"><i class="fa-regular fa-moon" id="darkModeIcon"></i></span>
                    <!-- <span><i class="fa-regular fa-sun"></i></span> -->
                    <div class="iconBurger" onclick="burger(this)">
                        <div class="bar1"></div>
                        <div class="bar2"></div>
                        <div class="bar3"></div>
                    </div>
                </div>
            </nav>
        </div>
        <nav class="categoriesNav" id="categoriesNav">
            <div class="searchBarBurgerDiv" id="searchBarBurgerDiv">
                <form method="get" class="searchBarBurgerForm" role="search">
                    <input class="" id="searchBarBurger" name="searchBarBurger" type="text" placeholder="Cherchez un produit..." aria-label="Search" autocomplete="off">
                    <div id="searchResultsBurgerDiv">
                        <div id="searchResultsBurger"></div>
                    </div>
                </form>
            </div>

            <div class="categoriesUlDiv" id="categoriesUlDiv">
                <ul class="categoriesUl">
                    <li class="">
                        <a href="<?= $url ?>itemFilter.php" class="">Tous les produits</a>
                    </li>
                    <?php
                    foreach ($resultCategoryParent as $key) {
                        // var_dump($key['name']);                                
                    ?>
                        <li class="dropdown" id="">
                            <a class="" href="<?= $url ?>itemFilter.php?categoryParent=<?= $key->id ?>" role="button" data-bs-toggle="" aria-expanded="false">
                                <?= htmlspecialchars($key->name); ?>
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
                                    <li><a class="" href="<?= $url ?>itemFilter.php?subCategory=<?= $key2->id ?>"><?= htmlspecialchars($key2->name); ?></a>
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
