<?php
class Cart
{
    public $id;
    public $user_id;
    public $product_id;
    public $quantity;

    public function __construct($id, $user_id, $product_id, $quantity)
    {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->product_id = $product_id;
        $this->quantity = $quantity;
    }
    public function deleteCart($bdd)
    {
        $deletePanier = $bdd->prepare('DELETE FROM carts WHERE user_id = :user_id');
        $deletePanier->execute(['user_id' => $this->user_id]);
        // header('Location: cartPage.php');
    }
    public function returnCart($bdd)
    {
        $returnCart = $bdd->prepare("SELECT * from carts INNER JOIN products ON carts.product_id = products.product_id INNER JOIN images ON products.product_id = images.product_id WHERE user_id = :user_id AND image_main = 1");
        $returnCart->execute(['user_id' => $this->user_id]);
        $result = $returnCart->fetchAll(PDO::FETCH_OBJ);
        return $result;
    }
    public function deleteProduct($bdd)
    {
        $deletePanier = $bdd->prepare('DELETE FROM carts WHERE user_id = :user_id AND product_id = :product_id AND cart_id = :cart_id');
        $deletePanier->execute([
            'user_id' => $this->user_id,
            'product_id' => $this->product_id,
            'cart_id' => $this->id
        ]);
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
     * Get the value of product_id
     */
    public function getProduct_id()
    {
        return $this->product_id;
    }

    /**
     * Set the value of product_id
     *
     * @return  self
     */
    public function setProduct_id($product_id)
    {
        $this->product_id = $product_id;

        return $this;
    }
    /**
     * Get the value of product_id
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set the value of product_id
     *
     * @return  self
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }
}
