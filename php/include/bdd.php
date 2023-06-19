<?php
$servername = 'localhost';
$username = 'root';
$password = '';
$charset = 'utf8mb4';

try {
    $bdd = new PDO("mysql:host=$servername;dbname=boutique;charset=$charset", $username, $password);

    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
