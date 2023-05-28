<?php
class Item
{
    public $id;
    public $name;
    public $description;
    public $date;
    public $price;
    public $stock;

    public function __construct($id, $name, $description, $date, $price, $stock)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->date = $date;
        $this->price = $price;
        $this->stock = $stock;
    }

    public function addItem($bdd)
    {
        $insertItem = $bdd->prepare("INSERT INTO items (name,description,date,price,stock) VALUES(?,?,?,?,?)");
        $insertItem->execute([$this->name, $this->description, $this->date, $this->price, $this->stock]);
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

    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set the value of description
     *
     * @return  self
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get the value of date
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set the value of date
     *
     * @return  self
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get the value of price
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set the value of price
     *
     * @return  self
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get the value of stock
     */
    public function getStock()
    {
        return $this->stock;
    }

    /**
     * Set the value of stock
     *
     * @return  self
     */
    public function setStock($stock)
    {
        $this->stock = $stock;

        return $this;
    }
}
