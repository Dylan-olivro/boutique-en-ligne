<?php
$returnCategoryParent = $bdd->prepare('SELECT * FROM category WHERE id_parent = 0');
$returnCategoryParent->execute();
$resultCategoryParent = $returnCategoryParent->fetchAll(PDO::FETCH_OBJ);

// $nombre = $bdd->prepare('SELECT SUM(cart_quantity) AS sum FROM carts WHERE user_id = :user_id');
// $nombre->execute(["user_id" => $_SESSION['user']->user_id]);
// $nombreResult = $nombre->fetch(PDO::FETCH_OBJ);

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
                    <a href="<?= $index ?>index.php">
                        <img src="<?= $image ?>assets/logo-blanc.png" id="logoImg" alt="">
                    </a>
                </div>
                <div class="searchBarDiv">
                    <form action="" method="get" role="search">
                        <input type="text" id="searchBar" name="searchBar" type="text" placeholder="Cherchez un produit..." aria-label="Search" autocomplete="off">
                        <div id="searchResultsDesktopDiv">
                        </div>
                    </form>
                </div>
                <div class="iconNavDiv">
                    <span class="iconNav userIcon">
                        <?= isset($_SESSION['user']) && (int)$_SESSION['user']->user_role !== 0 ? '<i class="fa-solid fa-user-gear"></i>' : '<i class="fa-solid fa-user"></i>';
                        ?>
                        <div class="userLink">
                            <?php
                            if (isset($_SESSION['user'])) { ?>
                                <a href="<?= $url ?>profil.php">Profil</a>
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
                    <span id="cartSpan" class="iconNav cartSpan">
                        <a href="<?= $url ?>cartPage.php">
                            <?php
                            // Affichage du nombre de produits dans le panier 
                            if (isset($_SESSION['user'])) {
                                $numberCart = $bdd->prepare('SELECT SUM(cart_quantity) AS sumQuantity FROM carts WHERE user_id = :user_id');
                                $numberCart->execute(["user_id" => $_SESSION['user']->user_id]);
                                $numberCartResult = $numberCart->fetch(PDO::FETCH_OBJ);
                            ?>
                                <span id="sumQuantity">
                                    <?php
                                    if ($numberCartResult->sumQuantity > 10) {
                                        echo "10+";
                                    } else {
                                        echo $numberCartResult->sumQuantity;
                                    }
                                    ?>
                                </span>
                                <?php
                            } else {
                                // Affichage du nombre de produits dans le panier pour les utilisateurs pas connecté
                                if (!empty($_SESSION['panier']['id_article'])) {
                                    $quantityX = array_sum($_SESSION['panier']['qte']);
                                ?>
                                    <span id="sumQuantity">
                                        <?php
                                        if ($quantityX > 10) {
                                            echo "10+";
                                        } else {
                                            echo $quantityX;
                                        }
                                        ?>
                                    </span>
                            <?php
                                }
                            }
                            ?>
                            <svg id="cart-icon" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" viewBox="0 0 256 256" xml:space="preserve">
                                <defs>
                                </defs>
                                <g style="stroke: none; stroke-width: 0; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: none; fill-rule: nonzero; opacity: 1;" transform="translate(1.4065934065934016 1.4065934065934016) scale(2.81 2.81)">
                                    <path d="M 72.975 58.994 H 31.855 c -1.539 0 -2.897 -1.005 -3.347 -2.477 L 15.199 13.006 H 3.5 c -1.933 0 -3.5 -1.567 -3.5 -3.5 s 1.567 -3.5 3.5 -3.5 h 14.289 c 1.539 0 2.897 1.005 3.347 2.476 l 13.309 43.512 h 36.204 l 10.585 -25.191 h -6.021 c -1.933 0 -3.5 -1.567 -3.5 -3.5 s 1.567 -3.5 3.5 -3.5 H 86.5 c 1.172 0 2.267 0.587 2.915 1.563 s 0.766 2.212 0.312 3.293 L 76.201 56.85 C 75.655 58.149 74.384 58.994 72.975 58.994 z" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill-rule: nonzero; opacity: 1;" transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round" />
                                    <circle cx="28.88" cy="74.33" r="6.16" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill-rule: nonzero; opacity: 1;" transform="  matrix(1 0 0 1 0 0) " />
                                    <circle cx="74.59" cy="74.33" r="6.16" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill-rule: nonzero; opacity: 1;" transform="  matrix(1 0 0 1 0 0) " />
                                </g>
                            </svg>
                        </a>
                    </span>
                    <span class="iconNav" id="darkMode" onclick="themeToggle()"><i class="fa-regular fa-moon" id="darkModeIcon"></i></span>
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
                    ?>
                        <li class="dropdown" id="">
                            <a class="" href="<?= $url ?>itemFilter.php?categoryParent=<?= $key->id ?>" role="button" data-bs-toggle="" aria-expanded="false">
                                <?= htmlspecialchars($key->name); ?>
                            </a>
                            <span class="chevronRight" id="">
                                <i class="fa-solid fa-circle-chevron-right"></i>
                            </span>
                            <ul class="dropdown-content" id="">
                                <span class="backToCategories" id="">
                                    <i class="fa-solid fa-circle-chevron-left"></i>
                                    Retour
                                </span>
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
