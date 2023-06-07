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
        $deletePanier = $bdd->prepare('DELETE FROM cart WHERE id_user = :id_user');
        $deletePanier->execute(['id_user' => $this->id_user]);
        header('Location: cartPage.php');
    }
    public function returnCart($bdd)
    {
        $returnCart = $bdd->prepare("SELECT * from cart INNER JOIN items ON cart.id_item = items.id INNER JOIN image ON items.id = image.id_item WHERE id_user = :id_user AND main = 1");
        $returnCart->execute(['id_user' => $this->id_user]);
        $result = $returnCart->fetchAll(PDO::FETCH_OBJ);
        return $result;
    }
    public function deleteItem($bdd)
    {
        $deletePanier = $bdd->prepare('DELETE FROM cart WHERE id_user = :id_user AND id_item = :id_item');
        $deletePanier->execute([
            'id_user' => $this->id_user,
            'id_item' => $this->id_item
        ]);
    }
}
