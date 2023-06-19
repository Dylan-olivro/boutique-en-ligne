<?php
require_once('./include/required.php');

// Récupération du produit
$returnProduct = $bdd->prepare("SELECT * FROM products WHERE product_id = :product_id");
$returnProduct->execute(['product_id' => $_GET['id']]);
$result = $returnProduct->fetch(PDO::FETCH_OBJ);
// var_dump($result);
// Empêche d'aller sur la page si il n'y a aucun produit de selectionner 
if (!$result) {
    header('Location: ../index.php');
}

// Récupération des images du produit
$image = new Image(null, $_GET['id'], null, null);
$result_images = $image->returnImagesByID($bdd);

// Insert le produit de la page dans le panier en gérant la quantité
if (isset($_POST["ajouter"])) {
    $req2 = $bdd->prepare("SELECT `cart_quantity` FROM `carts` WHERE product_id = :product_id");
    $req2->execute(['product_id' => $result->product_id]);
    $res2 = $req2->fetch(PDO::FETCH_OBJ);

    if ($req2->rowCount() > 0) {
        $req3 = $bdd->prepare("UPDATE `carts` SET `cart_quantity`= :cart_quantity WHERE product_id = :product_id");
        $req3->execute([
            'cart_quantity' => $res2->cart_quantity + 1,
            'product_id' => $result->product_id
        ]);
        echo '<i class="fa-solid fa-circle-check" style="color: #0cad00;"></i> Article ajouté au panier.';
    } else {
        $req = $bdd->prepare("INSERT INTO `carts`(`user_id`, `product_id`, `cart_quantity`) VALUES (:user_id,:product_id,:cart_quantity)");
        $req->execute([
            'user_id' => $_SESSION['user']->user_id,
            'product_id' => $result->product_id,
            'cart_quantity' => 1
        ]);
        echo '<i class="fa-solid fa-circle-check" style="color: #0cad00;"></i> Article ajouté au panier.';
    }
}
// Permet de poster un commentaire
if (isset($_POST['submitComment'])) {
    $comment = $_POST['comment'];
    if (empty(trim($comment))) {
        $COMMENT_ERROR = '<i class="fa-solid fa-circle-exclamation"></i>&nbspVeuillez saisir un commentaire.';
    } elseif (mb_strlen(str_replace("\n", '', $comment)) > 2000) {
        $COMMENT_ERROR = '<i class="fa-solid fa-circle-exclamation"></i>&nbspCommentaire trop long (2000max).';
    } else {
        $addComment = $bdd->prepare('INSERT INTO comments (comment_text, user_id, product_id) VALUES(:comment_text, :user_id,:product_id)');
        $addComment->execute([
            'comment_text' => $_POST['comment'],
            'user_id' => $_SESSION['user']->user_id,
            'product_id' => $result->product_id
        ]);
        header('Location: detail.php?id=' . $result->product_id);
    }
}

// Récupération des commentaire du produit
$returnComments = $bdd->prepare('SELECT comments.*,users.user_firstname FROM comments INNER JOIN users ON comments.user_id = users.user_id WHERE product_id = :product_id ORDER BY comments.comment_id DESC');
$returnComments->execute(['product_id' => $result->product_id]);
$result_comments = $returnComments->fetchAll(PDO::FETCH_OBJ);
// var_dump($result_comments);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once('./include/head.php'); ?>
    <title>Detail</title>
    <link rel="stylesheet" href="../css/detail.css">
    <script src="../js/detail.js" defer></script>

</head>

<body>
    <?php require_once('./include/header.php'); ?>

    <main>

        <section id="container">
            <!-- Affichage du produit -->
            <div class="MainContent">
                <div class="BoxImg">
                    <img src="../assets/img_item/<?= $result_images[0]->image_name ?>" alt="">
                </div>
                <div class="BoxDetail">
                    <p id="productName"><?= htmlspecialchars($result->product_name) ?></p>

                    <div id="description">
                        <p>Description :</p>
                        <p><?= htmlspecialchars_decode($result->product_description) ?></p>
                    </div>

                </div>
                <div class="BoxPriceStockButton">
                    <div class="test">

                        <p id="price"><?= htmlspecialchars($result->product_price) ?>€</p>
                        <p id="stock"><?= htmlspecialchars($result->product_stock) ?></p>
                        <?php
                        // Affiche le bouton 'ajouter au panier' si l'utilisateu est connecté et si le stock est supérieur à 1
                        if (isset($_SESSION['user'])) {
                            if ($result->product_stock > 0) { ?>
                                <form action="" method="post">
                                    <button type="submit" class="button" name="ajouter">
                                        <span class="button__text">Add Item</span>
                                        <span class="button__icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" viewBox="0 0 24 24" stroke-width="2" stroke-linejoin="round" stroke-linecap="round" stroke="currentColor" height="24" fill="none" class="svg">
                                                <line y2="19" y1="5" x2="12" x1="12"></line>
                                                <line y2="12" y1="12" x2="19" x1="5"></line>
                                            </svg></span>
                                    </button>
                                    <!-- <input type="submit" name="ajouter" value="Ajouter au panier"> -->
                                </form>
                        <?php
                            }
                        }
                        ?>
                    </div>

                </div>
            </div>

            <!-- SECTION COMMENTAIRE -->
            <section class="CommentsContent">
                <h3>COMMENTAIRES</h3>
                <div class="BoxFormComments">
                    <form action="" method="POST" id="FormComments">
                        <textarea name="comment" id="TextareaComment" placeholder="Écrire un commentaire..."></textarea>
                        <!-- <input type="text" name="comment" placeholder="COMMENTAIRE"> -->
                        <p id="COMMENT_ERROR"><span><?= isset($COMMENT_ERROR) ? $COMMENT_ERROR : ''; ?></span><span id="count">0/2000</span></p>
                        <input type="submit" name="submitComment">

                    </form>
                </div>
                <div class="BoxCommentResponse">
                    <?php
                    foreach ($result_comments as $key) { ?>
                        <div class="BoxComments">
                            <p>Commenté par <?= htmlspecialchars(ucfirst($key->user_firstname)) ?></p>
                            <p id="comment"><?= nl2br(htmlspecialchars($key->comment_text)) ?></p>
                            <!-- <p style="color: blue;">Répondre</p> -->
                            <div class="BoxFormResponses">
                                <form action="" method="POST" id="FormResponses">
                                    <textarea name="response" placeholder="Ajoutez une réponse..."></textarea>
                                    <input type="submit" name="submitResponse<?= $key->comment_id ?>">
                                </form>
                            </div>

                            <?php

                            $returnResponses = $bdd->prepare('SELECT responses.*,users.user_firstname FROM responses INNER JOIN comments ON responses.comment_id = comments.comment_id INNER JOIN users ON responses.response_user_id = users.user_id WHERE product_id = :product_id AND comments.comment_id = :comment_id ORDER BY responses.response_id DESC');
                            $returnResponses->execute([
                                'product_id' => $result->product_id,
                                'comment_id' => $key->comment_id
                            ]);
                            $result_responses = $returnResponses->fetchAll(PDO::FETCH_OBJ);
                            // var_dump($result_responses);

                            foreach ($result_responses as $key2) { ?>
                                <div class="BoxResponse">
                                    <p>Réponse de <?= htmlspecialchars(ucfirst($key2->user_firstname)) ?></p>
                                    <p id="response"><?= nl2br(htmlspecialchars($key2->response_text)) ?></p>
                                </div>
                            <?php
                            }
                            ?>
                        </div>
                    <?php
                        if (isset($_POST['submitResponse' . $key->comment_id])) {
                            $response = $_POST['response'];
                            if (empty(trim($response))) {
                                $RESPONSE_ERROR = '<i class="fa-solid fa-circle-exclamation"></i>&nbspVeuillez saisir une réponse.';
                            } elseif (mb_strlen(str_replace("\n", '', $response)) > 2000) {
                                $RESPONSE_ERROR = '<i class="fa-solid fa-circle-exclamation"></i>&Réponse trop long (2000max).';
                            } else {
                                $addResponse = $bdd->prepare('INSERT INTO responses (response_text, comment_id,response_user_id) VALUES(:response_text, :comment_id, :response_user_id)');
                                $addResponse->execute([
                                    'response_text' => $_POST['response'],
                                    'comment_id' => $key->comment_id,
                                    'response_user_id' => $_SESSION['user']->user_id
                                ]);
                                header('Location: detail.php?id=' . $result->product_id);
                            }
                        }
                    }
                    ?>
                </div>
            </section>
        </section>

    </main>
    <?php require_once('./include/footer.php') ?>
</body>
<style>

</style>

</html>