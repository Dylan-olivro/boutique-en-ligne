<?php

class Category
{
    public $id;
    public $name;
    public $id_parent;

    public function __construct($id, $name, $id_parent)
    {
        $this->id = $id;
        $this->name = $name;
        $this->id_parent = $id_parent;
    }
    public function addCategoty($bdd)
    {
        $addCategory = $bdd->prepare("INSERT INTO category (name,id_parent) VALUES (?,?)");
        $addCategory->execute([$this->name, $this->id_parent]);
    }
    public function deleteCategory($bdd)
    {
        $deleteCategory = $bdd->prepare("DELETE FROM category WHERE id = ?");
        $deleteCategory->execute([$this->id]);
    }
    public function liaisonItemCategory($bdd)
    {
        $returnItem = $bdd->prepare('SELECT * FROM items ORDER BY items.id DESC');
        $returnItem->execute();
        $result = $returnItem->fetch(PDO::FETCH_OBJ);

        $insertLiaison = $bdd->prepare('INSERT INTO liaison_items_category (id_item,id_category) VALUES(?,?)');
        $insertLiaison->execute([$result->id, $this->id_parent]);

        header('Location: admin.php');
    }
}
