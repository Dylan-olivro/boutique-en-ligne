<?php
class Product
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

    public function addProduct($bdd)
    {
        $name = trim($this->name);
        $price = trim($this->price);
        $stock = trim($this->stock);
        $description = trim($this->description);

        $insertProduct = $bdd->prepare("INSERT INTO products (product_name, product_description, product_date, product_price, product_stock) VALUES(:product_name,:product_description,:product_date,:product_price,:product_stock)");
        $insertProduct->execute([
            'product_name' => $name,
            'product_description' => $description,
            'product_date' => $this->date,
            'product_price' => $price,
            'product_stock' => $stock
        ]);
    }
    public function deleteProduct($bdd)
    {
        // ! A TESTER
        $request = $bdd->prepare('SELECT * FROM images WHERE product_id = :product_id');
        $request->execute(['product_id' => $this->id]);
        $result = $request->fetchAll(PDO::FETCH_OBJ);

        foreach ($result as $res) {
            unlink('../assets/img_item/' . $res->image_name);
            $deleteImage = $bdd->prepare('DELETE FROM images WHERE product_id = :product_id');
            $deleteImage->execute(['product_id' => $this->id]);
        }

        $deleteliaisonCategory = $bdd->prepare("DELETE FROM liaison_items_category WHERE id_item = :product_id");
        $deleteliaisonCategory->execute(['product_id' => $this->id]);

        $deleteProduct = $bdd->prepare('DELETE FROM products WHERE product_id = :product_id');
        $deleteProduct->execute(['product_id' => $this->id]);
    }

    public function editProduct($bdd)
    {
        $editProduct = $bdd->prepare('UPDATE products SET product_name = :product_name, product_description = :product_description, product_price = :product_price, product_stock = :product_stock WHERE product_id = :product_id');
        $editProduct->execute([
            'product_name' => $this->name,
            'product_description' => $this->description,
            'product_price' => $this->price,
            'product_stock' => $this->stock,
            'product_id' => $this->id
        ]);
    }
    public function returnAllProducts($bdd)
    {
        $returnProducts = $bdd->prepare('SELECT * FROM products INNER JOIN liaison_items_category ON products.product_id = liaison_items_category.id_item');
        $returnProducts->execute();
        $result = $returnProducts->fetchAll(PDO::FETCH_OBJ);
        return $result;
    }
    public function returnProduct($bdd)
    {
        $returnProduct = $bdd->prepare('SELECT * FROM products WHERE product_id = :product_id');
        $returnProduct->execute(['product_id' => $this->id]);
        $result = $returnProduct->fetch(PDO::FETCH_OBJ);
        return $result;
    }
    public function returnAllProductInfo($bdd)
    {
        $returnProduct = $bdd->prepare('SELECT * FROM products INNER JOIN images ON products.product_id = images.product_id INNER JOIN liaison_items_category ON products.product_id = liaison_items_category.id_item INNER JOIN category ON category.id = liaison_items_category.id_category WHERE products.product_id = :product_id');
        $returnProduct->execute(['product_id' => $this->id]);
        $result = $returnProduct->fetch(PDO::FETCH_OBJ);
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
