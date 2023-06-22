<?php require_once('../include/required.php');

// Récupération du l'utilisateur sélectionné
$user = new User($_GET['id'], null, null, null, null, null);
$result = $user->returnUserById($bdd);

// Empêche les utilisateurs qui ne sont pas ADMINISTRATEUR
if (!$result || $_SESSION['user']->user_role != 2) {
    header('Location: ../../index.php');
    exit();
}
// Mise à jour du ROLE d'un utilisateur
// if (isset($_POST['update'])) {
//     if ($_POST['role'] == 0 || $_POST['role'] == 1 || $_POST['role'] == 2) {
//         $accept = $bdd->prepare("UPDATE users SET user_firstname = :user_firstname, user_lastname = :user_lastname, user_role = :user_role WHERE user_id = :user_id ");
//         $accept->execute([
//             'user_firstname' => $_POST['firstname'],
//             'user_lastname' => $_POST['lastname'],
//             'user_role' => (int)$_POST['role'],
//             'user_id' => $result->user_id
//         ]);
//     }
//     // header('Location: ./admin.php');
// }

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once('../include/head.php'); ?>
    <title>User Modify</title>
    <link rel="stylesheet" href="../../css/modifyUser.css">
    <script src="../../js/modifyUser.js" defer></script>
</head>

<body>
    <?php require_once('../include/header.php'); ?>

    <main>
        <!-- SECTION POUR LES USERS -->
        <section class="editUser">
            <h2>Modifier l'utilisateur</h2>
            <div id="divUser">

                <form method="post" id="formUser">
                    <input type="hidden" name="id" value="<?= htmlspecialchars($_GET['id']) ?>">
                    <p class="emailP">Email : <span class="email FormChild"> <?= htmlspecialchars($result->user_email) ?></span></p>
                    <div>
                        <label for="fisrtname">Firstname</label>
                        <input type="text" id="firstname" name="firstname" class="FormChild" value="<?= htmlspecialchars($result->user_firstname) ?>">
                    </div>
                    <div>
                        <label for="lastname">Lastname</label>
                        <input type="text" id="lastname" name="lastname" class="FormChild" value="<?= htmlspecialchars($result->user_lastname) ?>">
                    </div>
                    <p>Role Actuel :<span class="actuelRole">
                            <?php
                            $role = "";
                            switch ($result->user_role) {
                                case 2:
                                    $role = 'Administrator';
                                    break;
                                case 1:
                                    $role = 'Moderator';
                                    break;
                                default:
                                    $role = 'Membre';
                                    break;
                            }
                            echo $role;
                            ?>
                        </span>
                    </p>
                    <div class="radio">
                        <!-- Formulaire pour MODIFIER le ROLE d'un utilisateur -->
                        <div>
                            <label for="admin">Administrateur</label>
                            <span>
                                <input type="radio" id="admin" value="2" name="role" <?= $result->user_role == 2 ? 'checked' : "" ?>>
                            </span>
                        </div>

                        <div>
                            <label for="modo">Modérateur</label>
                            <span>
                                <input type="radio" id="modo" value='1' name="role" <?= $result->user_role == 1 ? 'checked' : "" ?>>
                            </span>
                        </div>

                        <div>
                            <label for="membre">Membre</label>
                            <span>
                                <input type="radio" id="membre" value="0" name="role" <?= $result->user_role == 0 ? 'checked' : "" ?>>
                            </span>
                        </div>
                    </div>
                    <p id="message"></p>
                    <input type="submit" value="Valider" name="update" id="submit">
                </form>
            </div>

        </section>
    </main>
    <?php require_once('../include/footer.php') ?>
</body>

</html>