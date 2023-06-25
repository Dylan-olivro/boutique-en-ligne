<?php
require_once("../include/bdd.php");


if (isset($_GET['populaire'])) {
    if (isset($_GET['subCategory'])) {
        if ($_GET['subCategory'] < 5) {
            $requestAllItems = $bdd->prepare("SELECT *,count(*) FROM liaison_product_order INNER JOIN liaison_items_category INNER JOIN products ON liaison_product_order.product_id = products.product_id INNER JOIN images ON products.product_id = images.product_id INNER JOIN category ON liaison_items_category.id_category = category.id WHERE category.id_parent = :id_category AND images.image_main = 1 GROUP BY products.product_id ORDER BY count(*) DESC");
        } else {
            $requestAllItems = $bdd->prepare("SELECT *,count(*) FROM liaison_product_order INNER JOIN products ON liaison_product_order.product_id = products.product_id INNER JOIN liaison_items_category ON products.product_id = liaison_items_category.id_item INNER JOIN images ON products.product_id = images.product_id WHERE liaison_items_category.id_category = :id_category AND images.image_main = 1 GROUP BY products.product_id ORDER BY count(*) DESC");
        }
        $requestAllItems->execute(['id_category' => $_GET['subCategory']]);
    } else {
    $requestAllItems = $bdd->prepare("SELECT *,count(*) FROM liaison_product_order INNER JOIN products ON liaison_product_order.product_id = products.product_id INNER JOIN images ON products.product_id = images.product_id WHERE images.image_main = 1 GROUP BY products.product_id ORDER BY count(*) DESC");
    $requestAllItems->execute();
    }
} elseif (isset($_GET['nouveau'])) {
    if (isset($_GET['subCategory'])) {
        if ($_GET['subCategory'] < 5) {
            $requestAllItems = $bdd->prepare("SELECT * FROM products INNER JOIN liaison_items_category ON products.product_id = liaison_items_category.id_item INNER JOIN images ON products.product_id = images.product_id INNER JOIN category ON liaison_items_category.id_category = category.id WHERE category.id_parent = :id_category AND image_main = 1 ORDER BY products.product_date DESC");
        } else {
            $requestAllItems = $bdd->prepare("SELECT * FROM products INNER JOIN images ON products.product_id = images.product_id INNER JOIN liaison_items_category ON products.product_id = liaison_items_category.id_item WHERE liaison_items_category.id_category = :id_category AND image_main = 1 ORDER BY products.product_date DESC");
        }
        $requestAllItems->execute(['id_category' => $_GET['subCategory']]);
    } else {
        $requestAllItems = $bdd->prepare("SELECT * FROM products INNER JOIN images ON products.product_id = images.product_id WHERE image_main = 1 ORDER BY products.product_date DESC");
        $requestAllItems->execute();
    }
} elseif (isset($_GET['croissant'])) {
    if (isset($_GET['subCategory'])) {
        if ($_GET['subCategory'] < 5) {
            $requestAllItems = $bdd->prepare("SELECT * FROM products INNER JOIN liaison_items_category ON products.product_id = liaison_items_category.id_item INNER JOIN images ON products.product_id = images.product_id INNER JOIN category ON liaison_items_category.id_category = category.id WHERE category.id_parent = :id_category AND image_main = 1 ORDER BY products.product_price ASC");
        } else {
            $requestAllItems = $bdd->prepare("SELECT * FROM products INNER JOIN images ON products.product_id = images.product_id INNER JOIN liaison_items_category ON products.product_id = liaison_items_category.id_item WHERE liaison_items_category.id_category = :id_category AND image_main = 1 ORDER BY products.product_price ASC");
        }
        $requestAllItems->execute(['id_category' => $_GET['subCategory']]);
    } else {
        $requestAllItems = $bdd->prepare("SELECT * FROM products INNER JOIN images ON products.product_id = images.product_id WHERE image_main = 1 ORDER BY products.product_price ASC");
        $requestAllItems->execute();
    }
} elseif (isset($_GET['decroissant'])) {
    if (isset($_GET['subCategory'])) {
        if ($_GET['subCategory'] < 5) {
            $requestAllItems = $bdd->prepare("SELECT * FROM products INNER JOIN liaison_items_category ON products.product_id = liaison_items_category.id_item INNER JOIN images ON products.product_id = images.product_id INNER JOIN category ON liaison_items_category.id_category = category.id WHERE category.id_parent = :id_category AND image_main = 1 ORDER BY products.product_price DESC");
        } else {
            $requestAllItems = $bdd->prepare("SELECT * FROM products INNER JOIN images ON products.product_id = images.product_id INNER JOIN liaison_items_category ON products.product_id = liaison_items_category.id_item WHERE liaison_items_category.id_category = :id_category AND image_main = 1 ORDER BY products.product_price DESC");
        }
        $requestAllItems->execute(['id_category' => $_GET['subCategory']]);
    } else {
        $requestAllItems = $bdd->prepare("SELECT * FROM products INNER JOIN images ON products.product_id = images.product_id WHERE image_main = 1 ORDER BY products.product_price DESC");
        $requestAllItems->execute();
    }
} elseif (isset($_GET['aZ'])) {
    if (isset($_GET['subCategory'])) {
        if ($_GET['subCategory'] < 5) {
            $requestAllItems = $bdd->prepare("SELECT * FROM products INNER JOIN liaison_items_category ON products.product_id = liaison_items_category.id_item INNER JOIN images ON products.product_id = images.product_id INNER JOIN category ON liaison_items_category.id_category = category.id WHERE category.id_parent = :id_category AND image_main = 1 ORDER BY products.product_name ASC");
        } else {
            $requestAllItems = $bdd->prepare("SELECT * FROM products INNER JOIN images ON products.product_id = images.product_id INNER JOIN liaison_items_category ON products.product_id = liaison_items_category.id_item WHERE liaison_items_category.id_category = :id_category AND image_main = 1 ORDER BY products.product_name ASC");
        }
        $requestAllItems->execute(['id_category' => $_GET['subCategory']]);
    } else {
        $requestAllItems = $bdd->prepare("SELECT * FROM products INNER JOIN images ON products.product_id = images.product_id WHERE image_main = 1 ORDER BY products.product_name ASC");
        $requestAllItems->execute();
    }
} elseif (isset($_GET['zA'])) {
    if (isset($_GET['subCategory'])) {
        if ($_GET['subCategory'] < 5) {
            $requestAllItems = $bdd->prepare("SELECT * FROM products INNER JOIN liaison_items_category ON products.product_id = liaison_items_category.id_item INNER JOIN images ON products.product_id = images.product_id INNER JOIN category ON liaison_items_category.id_category = category.id WHERE category.id_parent = :id_category AND image_main = 1 ORDER BY products.product_name DESC");
        } else {
            $requestAllItems = $bdd->prepare("SELECT * FROM products INNER JOIN images ON products.product_id = images.product_id INNER JOIN liaison_items_category ON products.product_id = liaison_items_category.id_item WHERE liaison_items_category.id_category = :id_category AND image_main = 1 ORDER BY products.product_name DESC");
        }
        $requestAllItems->execute(['id_category' => $_GET['subCategory']]);
    } else {
        $requestAllItems = $bdd->prepare("SELECT * FROM products INNER JOIN images ON products.product_id = images.product_id WHERE image_main = 1 ORDER BY products.product_name DESC");
        $requestAllItems->execute();
    }
} elseif (isset($_GET['dispo'])) {
    if (isset($_GET['subCategory'])) {
        if ($_GET['subCategory'] < 5) {
            $requestAllItems = $bdd->prepare("SELECT * FROM products INNER JOIN liaison_items_category ON products.product_id = liaison_items_category.id_item INNER JOIN images ON products.product_id = images.product_id INNER JOIN category ON liaison_items_category.id_category = category.id WHERE category.id_parent = :id_category AND image_main = 1 ORDER BY products.product_stock DESC");
        } else {
            $requestAllItems = $bdd->prepare("SELECT * FROM products INNER JOIN images ON products.product_id = images.product_id INNER JOIN liaison_items_category ON products.product_id = liaison_items_category.id_item WHERE liaison_items_category.id_category = :id_category AND image_main = 1 ORDER BY products.product_stock DESC");
        }
        $requestAllItems->execute(['id_category' => $_GET['subCategory']]);
    } else {
        $requestAllItems = $bdd->prepare("SELECT * FROM products INNER JOIN images ON products.product_id = images.product_id WHERE image_main = 1 ORDER BY products.product_stock DESC");
        $requestAllItems->execute();
    }
}
$resultAllItems = $requestAllItems->fetchAll(PDO::FETCH_ASSOC);
$jsonAllItems = json_encode($resultAllItems);
echo $jsonAllItems;
