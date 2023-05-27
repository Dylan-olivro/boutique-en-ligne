<?php
class Item
{
    public $id;
    public $name;
    public $description;
    public $date;
    public $price;
    public $stock;
    public $image;

    // ! ajouter image dans __construct et verifier tout le code en rapport avec les items
    public function __construct($id, $name, $description, $date, $price, $stock)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->date = $date;
        $this->price = $price;
        $this->stock = $stock;
        // $this->image = $image;
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

    public function getImage()
    {
        return $this->image;
    }

    public function setImage($image)
    {
        $this->image = $image;
        return $this;
    }

    public function addItem($bdd)
    {
        $insertItem = $bdd->prepare("INSERT INTO items (name,description,date,price,stock) VALUES(?,?,?,?,?)");
        $insertItem->execute([$this->name, $this->description, $this->date, $this->price, $this->stock]);

        // $returnItems = $bdd->prepare('SELECT * FROM items ORDER BY items.id DESC');
        // $returnItems->execute();
        // $resultItems = $returnItems->fetch(PDO::FETCH_OBJ);

        // $insertCategory = $bdd->prepare('INSERT INTO liaison_items_category (id_item,id_category) VALUES(?,?)');
        // $insertCategory->execute([$resultItems->id, $this->category]);

        header('Location: admin.php');
    }
    public function deleteItem($bdd)
    {
        $deleteItem = $bdd->prepare('DELETE FROM items WHERE id = ?');
        $deleteItem->execute([$this->id]);
        header('Location: admin.php');
    }
    public function editItem($bdd)
    {
        $editItem = $bdd->prepare('UPDATE items SET name = ?, description = ?, price = ?, stock = ?, image = ? WHERE id = ?');
        $editItem->execute([$this->name, $this->description, $this->price, $this->stock, $this->image, $this->id]);
        header('Location: admin.php');
    }
    public function returnItems($bdd)
    {
        $returnItems = $bdd->prepare('SELECT * FROM items INNER JOIN liaison_items_category ON items.id = liaison_items_category.id_item');
        $returnItems->execute();
        $result = $returnItems->fetchAll(PDO::FETCH_OBJ);
        return $result;
    }
    public function returnItem($bdd)
    {
        $returnItem = $bdd->prepare('SELECT * FROM items WHERE id = ?');
        $returnItem->execute([$this->id]);
        $result = $returnItem->fetch(PDO::FETCH_OBJ);
        return $result;
    }
}
