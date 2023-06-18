<?php
class Order
{
    public $id;
    public $user_id;
    public $date;
    public $total;
    public $address;
    public $number;

    public function __construct($id, $user_id, $date, $total, $address, $number)
    {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->date = $date;
        $this->total = $total;
        $this->address = $address;
        $this->number = $number;
    }

    public function addOrder($bdd)
    {
        $request = $bdd->prepare('INSERT INTO orders (user_id,order_date) VALUES (:user_id,:order_date)');
        $request->execute([
            'user_id' => $this->user_id,
            'order_date' => $this->date
        ]);
    }

    public function updateOrder($bdd)
    {
        $request = $bdd->prepare('UPDATE orders SET order_total = :order_total , order_address = :order_address, order_number = :order_number WHERE order_id = :order_id ');
        $request->execute([
            'order_total' => $this->total,
            'order_address' => $this->address,
            'order_number' => $this->number,
            'order_id' => $this->id
        ]);
    }

    public function deleteOrder($bdd)
    {
        $request = $bdd->prepare('DELETE FROM orders WHERE order_id = :order_id');
        $request->execute([
            'order_id' => $this->id
        ]);
    }

    public function returnOrdersByUser($bdd)
    {
        $request = $bdd->prepare('SELECT * FROM orders WHERE user_id  = :user_id ORDER BY order_date DESC LIMIT 5');
        $request->execute(['user_id' => $this->user_id]);
        $result = $request->fetchAll(PDO::FETCH_OBJ);
        return $result;
    }

    public function returnContentOrder($bdd)
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

    /**
     * Get the value of user_id
     */
    public function getUser_id()
    {
        return $this->user_id;
    }

    /**
     * Set the value of user_id
     *
     * @return  self
     */
    public function setUser_id($user_id)
    {
        $this->user_id = $user_id;

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
     * Get the value of total
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * Set the value of total
     *
     * @return  self
     */
    public function setTotal($total)
    {
        $this->total = $total;

        return $this;
    }

    /**
     * Get the value of address
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set the value of address
     *
     * @return  self
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get the value of number
     */ 
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Set the value of number
     *
     * @return  self
     */ 
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }
}
