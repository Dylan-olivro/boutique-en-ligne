<?php
class Order
{
    public $id;
    public $user_id;
    public $date;
    public $total;
    public $adresse;

    public function __construct($id, $user_id, $date, $total, $adresse)
    {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->date = $date;
        $this->total = $total;
        $this->adresse = $adresse;
    }

    public function addCommand($bdd)
    {
        $request = $bdd->prepare('INSERT INTO orders (user_id,order_date) VALUES (:user_id,:order_date)');
        $request->execute([
            'user_id' => $this->user_id,
            'order_date' => $this->date
        ]);
    }

    public function updateCommand($bdd)
    {
        $request = $bdd->prepare('UPDATE orders SET order_total = :order_total , order_address = :order_address WHERE order_id = :order_id ');
        $request->execute([
            'order_total' => $this->total,
            'order_address' => $this->adresse,
            'order_id' => $this->id
        ]);
    }

    public function deleteCommand($bdd)
    {
        $request = $bdd->prepare('DELETE FROM orders WHERE order_id = :order_id');
        $request->execute([
            'order_id' => $this->id
        ]);
    }

    public function returnComandByUser($bdd)
    {
        $request = $bdd->prepare('SELECT * FROM orders WHERE user_id  = :user_id ORDER BY order_date DESC LIMIT 5');
        $request->execute(['user_id' => $this->user_id]);
        $result = $request->fetchAll(PDO::FETCH_OBJ);
        return $result;
    }

    public function returnContentCommand($bdd)
    {
        $request = $bdd->prepare('SELECT * FROM orders INNER JOIN liaison_product_order ON orders.order_id = liaison_product_order.order_id INNER JOIN products ON liaison_product_order.product_id = products.product_id INNER JOIN images ON products.product_id = images.product_id WHERE user_id = :user_id AND orders.order_id = :order_id AND image_main = 1');
        $request->execute([
            'user_id' => $this->user_id,
            'order_id' => $this->id
        ]);
        $result = $request->fetchAll(PDO::FETCH_OBJ);
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
}
