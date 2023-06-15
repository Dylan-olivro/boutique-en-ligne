<?php require_once('../include/required.php');

// Empêche les utilisateurs que ne sont pas connecté de venir sur cette page
if (!isset($_SESSION['user'])) {
    header('Location:../../index.php');
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once('../include/head.php'); ?>
    <title>Product Modify</title>
</head>

<body>
    <?php require_once('../include/header.php'); ?>
    <?php require_once('../include/header-save.php') ?>

    <main>
        <!-- Formulaire pour MODIFIER l'adresse de l'utilisateur -->
        <form action="" method="post" id="formUpdateAdress">
            <label for="numero">Numero</label>
            <input type="number" name="numero" id="numero" value="<?= htmlspecialchars($userAddress->address_numero) ?>" autofocus>
            <label for="name">Name</label>
            <input type="text" name="name" id="name" value="<?= htmlspecialchars($userAddress->address_name) ?>">
            <label for="postcode">Postcode</label>
            <input type="number" name="postcode" id="postcode" value="<?= htmlspecialchars($userAddress->address_postcode) ?>">
            <label for="city">City</label>
            <input type="text" name="city" id="city" value="<?= htmlspecialchars($userAddress->address_city) ?>">
            <label for="telephone">Téléphone</label>
            <input type="text" name="telephone" id="telephone" value="<?= htmlspecialchars($userAddress->address_telephone) ?>">
            <label for="nom">Nom</label>
            <input type="text" name="nom" id="nom" value="<?= htmlspecialchars($userAddress->address_lastname) ?>">
            <label for="prenom">Prénom</label>
            <input type="text" name="prenom" id="prenom" value="<?= htmlspecialchars($userAddress->address_firstname) ?>">
            <p id="message">
                <?php if (isset($UPDATE_ADDRESS_ERROR)) {
                    echo $UPDATE_ADDRESS_ERROR;
                } ?>
            </p>
            <input type="submit" name="submit" class="input" value="Modifier">
        </form>
    </main>
    <?php require_once('../include/footer.php') ?>
</body>
<style>
    form {
        display: flex;
        flex-direction: column;
    }

    .input {
        color: #f1b16a;
        padding: 5px;
        background-color: #121a2e;
        margin-top: 10px;
    }

    label {
        font-size: 1.5rem;

    }
</style>

</html>