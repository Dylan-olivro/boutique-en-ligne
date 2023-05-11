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
    <header>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Site PC</a>
    <form class="d-flex w-75" role="search">
      <input class="form-control me-2" type="search" placeholder="Cherchez un produit, une marque..." aria-label="Search">
      <!-- <button class="btn btn-outline-success" type="submit">Search</button> -->
    </form>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <!-- <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">Home</a>
        </li> -->
        <li class="nav-item">
          <a class="nav-link" href="#">Connexion</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Panier</a>
        </li>
      </ul>
    </div>
  </div>
</nav>    </header>
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
