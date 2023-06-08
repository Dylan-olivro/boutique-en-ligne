<?php
class Cart
{
    public $id;
    public $user_id;
    public $product_id;

    public function __construct($id, $user_id, $product_id)
    {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->product_id = $product_id;
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
    public function deleteItem($bdd)
    {
        $deletePanier = $bdd->prepare('DELETE FROM carts WHERE user_id = :user_id AND product_id = :product_id');
        $deletePanier->execute([
            'user_id' => $this->user_id,
            'product_id' => $this->product_id
        ]);
    }
}
