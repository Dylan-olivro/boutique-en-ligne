<?php
require_once('./include/required.php');

// Récupération du produit
$returnProduct = $bdd->prepare("SELECT * FROM products WHERE product_id = :product_id");
$returnProduct->execute(['product_id' => $_GET['id']]);
$result = $returnProduct->fetch(PDO::FETCH_OBJ);

$date = date("Y-m-d H:i:s");

// Empêche d'aller sur la page si il n'y a aucun produit de selectionner 
if (!$result) {
    header('Location: ../index.php');
}

// Récupération des images du produit
$image = new Image(null, $_GET['id'], null, null);
$result_images = $image->returnImagesByID($bdd);

// Insert le produit de la page dans le panier en gérant la quantité
if (isset($_POST["ajouter"])) {
    if (isset($_SESSION['user'])) {

        // Récupère la quantité du produit
        $quantity = $bdd->prepare("SELECT `cart_quantity` FROM `carts` WHERE product_id = :product_id AND user_id = :user_id");
        $quantity->execute([
            'product_id' => $result->product_id,
            'user_id' => $_SESSION['user']->user_id
        ]);
        $result_quantity = $quantity->fetch(PDO::FETCH_OBJ);

        // Insert le produit de la page dans le panier en gérant la quantité
        if ($quantity->rowCount() > 0) {
            $updateQuantity = $bdd->prepare("UPDATE `carts` SET `cart_quantity`= :cart_quantity WHERE product_id = :product_id AND user_id = :user_id");
            $updateQuantity->execute([
                'cart_quantity' => $result_quantity->cart_quantity + 1,
                'product_id' => $result->product_id,
                'user_id' => $_SESSION['user']->user_id
            ]);
        } else {
            $insertQuantity = $bdd->prepare("INSERT INTO `carts`(`user_id`, `product_id`, `cart_quantity`) VALUES (:user_id,:product_id,:cart_quantity)");
            $insertQuantity->execute([
                'user_id' => $_SESSION['user']->user_id,
                'product_id' => $result->product_id,
                'cart_quantity' => 1
            ]);
        }
    } else {
        // Si l'utilisateur n'est pas connecté
        // Insert le produit dans la session panier ou augmente sa quantité de 1
        $select = array();
        $select['id'] = $result->product_id;
        $select['qte'] = 1;
        $select['prix'] = $result->product_price;
        if (modif_qte($result->product_id, '+')) {
        } else {
            ajout($select);
        }
        header('Location: detail.php?id=' . $result->product_id);
    }
}
// Permet de poster un commentaire
if (isset($_POST['submitComment'])) {
    $comment = $_POST['comment'];
    if (empty(trim($comment))) {
        $COMMENT_ERROR = '<i class="fa-solid fa-circle-exclamation"></i>&nbspVeuillez saisir un commentaire.';
    } elseif (mb_strlen(str_replace("\n", '', $comment)) > 2000) {
        $COMMENT_ERROR = '<i class="fa-solid fa-circle-exclamation"></i>&nbspCommentaire trop long (2000max).';
    } elseif (!isset($_POST['rate'])) {
        $COMMENT_ERROR = '<i class="fa-solid fa-circle-exclamation"></i>&nbspVeuillez saisir une note.';
    } else {
        $addComment = $bdd->prepare('INSERT INTO comments (comment_text, user_id, product_id,comment_rating, comment_date) VALUES(:comment_text, :user_id,:product_id,:comment_rating,:comment_date)');
        $addComment->execute([
            'comment_text' => $_POST['comment'],
            'user_id' => $_SESSION['user']->user_id,
            'product_id' => $result->product_id,
            'comment_rating' => $_POST['rate'],
            'comment_date' => $date
        ]);
        header('Location: detail.php?id=' . $result->product_id);
    }
}

// Récupération des commentaire du produit
$returnComments = $bdd->prepare('SELECT comments.*,users.user_firstname FROM comments INNER JOIN users ON comments.user_id = users.user_id WHERE product_id = :product_id ORDER BY comments.comment_id DESC');
$returnComments->execute(['product_id' => $result->product_id]);
$result_comments = $returnComments->fetchAll(PDO::FETCH_OBJ);

// Moyenne et comptage des notes de commentaires
$requestAverage = $bdd->prepare('SELECT AVG(comment_rating) AS avgComment, COUNT(comment_id) AS countRating FROM comments WHERE product_id = :product_id');
$requestAverage->execute(['product_id' => $_GET['id']]);
$resultAverageAndCount = $requestAverage->fetch(PDO::FETCH_OBJ);
$averageComment = ceil($resultAverageAndCount->avgComment);
$countRating = $resultAverageAndCount->countRating;
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
                    <div class="BoxAverageCount">
                        <div class="AvgRating">
                            <input type="radio" id="star5Avg" value="5" disabled <?= $averageComment == 5 ? 'checked' : ''; ?>>
                            <label for="star5Avg" title="text"></label>
                            <input type="radio" id="star4Avg" value="4" disabled <?= $averageComment == 4 ? 'checked' : ''; ?>>
                            <label for="star4Avg" title="text"></label>
                            <input type="radio" id="star3Avg" value="3" disabled <?= $averageComment == 3 ? 'checked' : ''; ?>>
                            <label for="star3Avg" title="text"></label>
                            <input type="radio" id="star2Avg" value="2" disabled <?= $averageComment == 2 ? 'checked' : ''; ?>>
                            <label for="star2Avg" title="text"></label>
                            <input type="radio" id="star1Avg" value="1" disabled <?= $averageComment == 1 ? 'checked' : ''; ?>>
                            <label for="star1Avg" title="text"></label>
                        </div>
                        <span class="countRating"><a href="#BoxCommentResponse">(<?= $countRating ?> évalution<?= $countRating > 1 ? 's' : '' ?>)</a></span>
                    </div>
                    <div id="description">
                        <p>Description :</p>
                        <p><?= htmlspecialchars_decode($result->product_description) ?></p>
                    </div>

                </div>
                <div class="BoxPriceStockButton">
                    <div class="BoxPSB">

                        <p id="price"><?= htmlspecialchars($result->product_price) ?>€</p>
                        <p id="stock"><?= htmlspecialchars($result->product_stock) ?></p>
                        <form action="" method="post">
                            <?php
                            // Affiche le bouton 'ajouter au panier' si l'utilisateu est connecté et si le stock est supérieur à 1
                            if ($result->product_stock > 0) { ?>
                                <button type="submit" class="button" name="ajouter">
                                    <span class="button__text">Add Item</span>
                                    <span class="button__icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" viewBox="0 0 24 24" stroke-width="2" stroke-linejoin="round" stroke-linecap="round" stroke="currentColor" height="24" fill="none" class="svg">
                                            <line y2="19" y1="5" x2="12" x1="12"></line>
                                            <line y2="12" y1="12" x2="19" x1="5"></line>
                                        </svg></span>
                                </button>
                            <?php
                            }
                            ?>
                        </form>
                    </div>

                </div>
            </div>

            <!-- SECTION COMMENTAIRE -->
            <section class="CommentsContent" id="CommentsContent">
                <h3>COMMENTAIRES</h3>
                <div class="BoxFormComments">
                    <?php if (isset($_SESSION['user'])) { ?>

                        <form action="" method="POST" id="FormComments">
                            <div class="rating">
                                <input type="radio" id="star5" name="rate" value="5">
                                <label for="star5" title="text"></label>
                                <input type="radio" id="star4" name="rate" value="4">
                                <label for="star4" title="text"></label>
                                <input type="radio" id="star3" name="rate" value="3">
                                <label for="star3" title="text"></label>
                                <input type="radio" id="star2" name="rate" value="2">
                                <label for="star2" title="text"></label>
                                <input type="radio" id="star1" name="rate" value="1">
                                <label for="star1" title="text"></label>
                            </div>
                            <textarea name="comment" id="TextareaComment" placeholder="Écrire un commentaire..."></textarea>
                            <p id="COMMENT_ERROR"><span><?= isset($COMMENT_ERROR) ? $COMMENT_ERROR : ''; ?></span><span id="count">0/2000</span></p>
                            <input type="submit" name="submitComment">

                        </form>
                    <?php } ?>
                </div>
                <div class="BoxCommentResponse" id="BoxCommentResponse">
                    <?php
                    foreach ($result_comments as $key) { ?>
                        <div class="BoxComments">
                            <p class="UserComment">Commenté par <?= htmlspecialchars(ucfirst($key->user_firstname)) ?>
                            <p id="commentDate"><?= htmlspecialchars($key->comment_date) ?></p>
                            <?php
                            
                            // Affichage du bouton delete le commentaire, si c'est le commentaire de l'utilisateur
                            if (isset($_SESSION['user']) && ($_SESSION['user']->user_id == $key->user_id || $_SESSION['user']->user_role > 0)) { ?>
                                <form action="" method="POST">
                                    <button type="submit" name="deleteComment<?= $key->comment_id ?>" id="DeleleCommentOrResponse" onclick="return confirm(`Voulez vous vraiment supprimer ce commentaire ?`)">Supprimer votre commentaire</button>
                                </form>
                            <?php
                            } ?>
                            </p>
                            <div class="ShowRating">
                                <input type="radio" id="star5<?= $key->comment_id ?>" value="5" disabled <?= $key->comment_rating == 5 ? 'checked' : ''; ?>>
                                <label for="star5<?= $key->comment_id ?>" title="text"></label>
                                <input type="radio" id="star4<?= $key->comment_id ?>" value="4" disabled <?= $key->comment_rating == 4 ? 'checked' : ''; ?>>
                                <label for="star4<?= $key->comment_id ?>" title="text"></label>
                                <input type="radio" id="star3<?= $key->comment_id ?>" value="3" disabled <?= $key->comment_rating == 3 ? 'checked' : ''; ?>>
                                <label for="star3<?= $key->comment_id ?>" title="text"></label>
                                <input type="radio" id="star2<?= $key->comment_id ?>" value="2" disabled <?= $key->comment_rating == 2 ? 'checked' : ''; ?>>
                                <label for="star2<?= $key->comment_id ?>" title="text"></label>
                                <input type="radio" id="star1<?= $key->comment_id ?>" value="1" disabled <?= $key->comment_rating == 1 ? 'checked' : ''; ?>>
                                <label for="star1<?= $key->comment_id ?>" title="text"></label>
                            </div>
                            <p id="comment"><?= nl2br(htmlspecialchars($key->comment_text)) ?></p>

                            <div class="BoxFormResponses">
                                <?php if (isset($_SESSION['user'])) { ?>

                                    <button id="click<?= $key->comment_id ?>" class="ClickResponse">Répondre</button>
                                    <form action="" method="POST" id="FormResponses<?= $key->comment_id ?>" class="FormResponses">
                                        <textarea name="response" id="TextareaResponse<?= $key->comment_id ?>" class="TextareaReponse" placeholder="Ajoutez une réponse..."></textarea>
                                        <div class="BoxSubmitResponse">
                                            <p id="RESPONSE_ERROR"><span id="count<?= $key->comment_id ?>" class="">0/2000</span></p>
                                            <input type="submit" name="submitResponse<?= $key->comment_id ?>">
                                        </div>
                                    </form>
                                <?php } ?>
                            </div>

                            <script>
                                // Permet de differencier les forms et les span répondre de tout les formulaires repondre
                                let form<?= $key->comment_id ?> = document.querySelector('#FormResponses<?= $key->comment_id ?>');
                                let click<?= $key->comment_id ?> = document.querySelector('#click<?= $key->comment_id ?>');

                                // Quand on click sur "répondre" un formulaire apparait 
                                click<?= $key->comment_id ?>.addEventListener('click', () => {
                                    form<?= $key->comment_id ?>.style.display = 'flex';
                                    click<?= $key->comment_id ?>.style.display = 'none';

                                    let textarea<?= $key->comment_id ?> = document.getElementById("TextareaResponse<?= $key->comment_id ?>");
                                    let count<?= $key->comment_id ?> = document.getElementById("count<?= $key->comment_id ?>");

                                    // Compteur de caractères
                                    textarea<?= $key->comment_id ?>.addEventListener("keyup", () => {
                                        count<?= $key->comment_id ?>.innerText = `${textarea<?= $key->comment_id ?>.value.length}/2000`;
                                        if (textarea<?= $key->comment_id ?>.value.length > 2000) {
                                            count<?= $key->comment_id ?>.style.color = "#c7161d";
                                        } else {
                                            count<?= $key->comment_id ?>.style.color = "";
                                        }
                                    });

                                })
                            </script>

                            <?php
                            // Efface le commentaire et les réponses lié à ce commentaire
                            if (isset($_POST['deleteComment' . $key->comment_id])) {
                                $deleteComment = $bdd->prepare('DELETE FROM comments WHERE comment_id = :comment_id');
                                $deleteComment->execute(['comment_id' => $key->comment_id]);

                                $deleteResponseWithComment = $bdd->prepare('DELETE FROM responses WHERE comment_id = :comment_id');
                                $deleteResponseWithComment->execute(['comment_id' => $key->comment_id]);

                                header('Location: detail.php?id=' . $result->product_id);
                            }

                            // Récupération des réponses en fonctions des commentaires
                            $returnResponses = $bdd->prepare('SELECT responses.*,users.user_firstname FROM responses INNER JOIN comments ON responses.comment_id = comments.comment_id INNER JOIN users ON responses.response_user_id = users.user_id WHERE product_id = :product_id AND comments.comment_id = :comment_id ORDER BY responses.response_id DESC');
                            $returnResponses->execute([
                                'product_id' => $result->product_id,
                                'comment_id' => $key->comment_id
                            ]);
                            $result_responses = $returnResponses->fetchAll(PDO::FETCH_OBJ);

                            foreach ($result_responses as $key2) { ?>
                                <div class="BoxResponse">
                                    <p class="UserComment">Réponse de <?= htmlspecialchars(ucfirst($key2->user_firstname)) ?></p>
                                    <p id="responseDate"><?= htmlspecialchars($key2->response_date) ?></p>
                                    <?php
                                    // Affichage du bouton delete la réponse, si c'est la réponse de l'utilisateur
                                    if (isset($_SESSION['user']) && ($_SESSION['user']->user_id == $key2->response_user_id || $_SESSION['user']->user_role > 0)) { ?>
                                        <form action="" method="POST">
                                            <button type="submit" name="deleteResponse<?= $key2->response_id ?>" id="DeleleCommentOrResponse" onclick="return confirm(`Voulez vous vraiment supprimer cette réponse ?`)">Supprimer votre réponse</button>
                                        </form>
                                    <?php } ?>
                                    <p id="response"><?= nl2br(htmlspecialchars($key2->response_text)) ?></p>
                                </div>
                            <?php
                                // Efface la réponse sélectionnée
                                if (isset($_POST['deleteResponse' . $key2->response_id])) {
                                    $deleteResponse = $bdd->prepare('DELETE FROM responses WHERE response_id = :response_id');
                                    $deleteResponse->execute(['response_id' => $key2->response_id]);
                                    header('Location: detail.php?id=' . $result->product_id);
                                }
                            }
                            ?>
                        </div>
                    <?php
                        // Permet de poster une réponse à un commentaire
                        if (isset($_POST['submitResponse' . $key->comment_id])) {
                            $response = $_POST['response'];
                            if (empty(trim($response))) {
                                $RESPONSE_ERROR = '<i class="fa-solid fa-circle-exclamation"></i>&nbspVeuillez saisir une réponse.';
                            } elseif (mb_strlen(str_replace("\n", '', $response)) > 2000) {
                                $RESPONSE_ERROR = '<i class="fa-solid fa-circle-exclamation"></i>&Réponse trop longue (2000max).';
                            } else {
                                $addResponse = $bdd->prepare('INSERT INTO responses (response_text, comment_id,response_user_id,response_date) VALUES(:response_text, :comment_id, :response_user_id,:response_date)');
                                $addResponse->execute([
                                    'response_text' => $_POST['response'],
                                    'comment_id' => $key->comment_id,
                                    'response_user_id' => $_SESSION['user']->user_id,
                                    'response_date' => $date
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