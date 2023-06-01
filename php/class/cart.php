<?php

class Cart
{
    public $id;
    public $id_user;
    public $id_item;

    public function __construct($id, $id_user, $id_item)
    {
        $this->id = $id;
        $this->id_user = $id_user;
        $this->id_item = $id_item;
    }
    public function deleteCart($bdd)
    {
        $deletePanier = $bdd->prepare('DELETE FROM cart WHERE id_user = ?');
        $deletePanier->execute([$this->id_user]);
        header('Location: cart.php');
    }
    public function returnCart($bdd)
    {
        $returnCart = $bdd->prepare("SELECT * from cart INNER JOIN items ON cart.id_item = items.id WHERE id_user = ?");
        $returnCart->execute([$this->id_user]);
        $result = $returnCart->fetchAll(PDO::FETCH_OBJ);
        return $result;
        // var_dump($result);
    }
    // public function test($bdd)
    // {
    //     $result = $this->returnCart($bdd);
    //     return $result;
    // }
}
