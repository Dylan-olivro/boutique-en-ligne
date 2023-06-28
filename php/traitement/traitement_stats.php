<?php require_once("../include/bdd.php");

if (isset($_GET['product'])) {
    $request = $bdd->prepare("SELECT COUNT(*) as nb FROM products ");
} else if (isset($_GET['user'])) {
    $request = $bdd->prepare("SELECT COUNT(*) as nb FROM users ");
} else if (isset($_GET['order'])) {
    $request = $bdd->prepare("SELECT COUNT(*) as nb FROM orders ");
} else if (isset($_GET['orderAverage'])) {
    $request = $bdd->prepare("SELECT AVG(order_total) as avg FROM orders ");
} else if (isset($_GET['salesRevenues'])) {
    $request = $bdd->prepare("SELECT SUM(order_total) as sum FROM orders ");
}
$request->execute();
$result = $request->fetchAll(PDO::FETCH_ASSOC);
$json = json_encode($result);
echo $json;
