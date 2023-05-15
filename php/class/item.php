<?php
if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
    $url = "https";
else {
    $url = "http";
}
// ASSEMBLAGE DE L'URL
$url .= "://";
$url .= $_SERVER['HTTP_HOST'];
$url .= $_SERVER['REQUEST_URI'];
$splitURL = explode('boutique-en-ligne', $url);

// CONDITION SI ON EST SUR L'INDEX OU PAS
if ($splitURL[1] === '/index.php' || $splitURL[1] === '/') {
    require_once('./php/include/bdd.php');
    require_once('./php/include/function.php');
} else {
    require_once('./include/bdd.php');
    require_once('./include/function.php');
}

class Item
{
    public $id;
    public $name;
    public $description;
    public $date;
    public $price;
    public $stock;
    public $category;

    public function __construct($id, $name, $description, $date, $price, $stock, $category)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->date = $date;
        $this->price = $price;
        $this->stock = $stock;
        $this->category = $category;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function setDate($date)
    {
        $this->date = $date;
        return $this;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($price)
    {
        $this->price = $price;
        return $this;
    }

    public function getStock()
    {
        return $this->stock;
    }

    public function setStock($stock)
    {
        $this->stock = $stock;
        return $this;
    }

    public function getCategory()
    {
        return $this->category;
    }

    public function setCategory($category)
    {
        $this->category = $category;
        return $this;
    }
    public function add($bdd)
    {
        $insertItems = $bdd->prepare("INSERT INTO items (name,description,date,price,stock) VALUES(?,?,?,?,?)");
        $insertItems->execute([$this->name, $this->description, $this->date, $this->price, $this->stock]);

        // $articleInfo = $bdd->prepare("SELECT articles.id, articles.article FROM articles INNER JOIN utilisateurs ON articles.id_utilisateur = utilisateurs.id WHERE utilisateurs.id = $this->id_utilisateur ORDER BY articles.id DESC");

        $recupItems = $bdd->prepare('SELECT * FROM items ORDER BY items.id DESC');
        // $recupItems = $bdd->prepare('SELECT items.id,liaison_items_category.id_item FROM items INNER JOIN liaison_items_category ON items.id = liaison_items_category.id_item ORDER BY items.id DESC');
        $recupItems->execute();
        $resultItems = $recupItems->fetch(PDO::FETCH_ASSOC);
        // var_dump($resultItems);

        $insertCategory = $bdd->prepare('INSERT INTO liaison_items_category (id_item,id_category) VALUES(?,?)');
        $insertCategory->execute([$resultItems['id'], $this->category]);

        header('Location: addItems.php');
    }
}
