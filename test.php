<?php require_once('./php/include/required.php');

if (isset($_POST['submit'])) {
    var_dump(1);

    $returnCode = $bdd->prepare('SELECT * FROM codes WHERE code_name = :code_name');
    $returnCode->execute(['code_name' => $_POST['code']]);
    $res = $returnCode->fetch(PDO::FETCH_OBJ);

    $total = 1323.84;
    var_dump($res);
    if ($result_code) {
        $discount = (intval($result_code->code_discount) * $total) / 100;
        $result = $total - $discount;
        var_dump('promo');
        var_dump($result);
    } else {
        echo $total;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once('./php/include/head.php') ?>
    <title>test</title>
</head>

<body>
    <main>
        <form action="" method="POST">
            <input type="text" name="code" autofocus>
            <input type="submit" name="submit">
        </form>
    </main>
</body>

</html>