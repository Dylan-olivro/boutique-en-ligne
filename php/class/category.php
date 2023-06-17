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
    public function addCategory($bdd)
    {
        $addCategory = $bdd->prepare("INSERT INTO category (name,id_parent) VALUES (:name,:id_parent)");
        $addCategory->execute([
            'name' => $this->name,
            'id_parent' => $this->id_parent
        ]);
    }
    public function deleteCategory($bdd)
    {
        $deleteCategory = $bdd->prepare("DELETE FROM category WHERE id = :id");
        $deleteCategory->execute(['id' => $this->id]);

        $deleteLiaison = $bdd->prepare("DELETE FROM liaison_items_category WHERE id_category = :id_category");
        $deleteLiaison->execute(['id_category' => $this->id]);
    }
    public function liaisonItemCategory($bdd)
    {
        $returnItem = $bdd->prepare('SELECT * FROM products ORDER BY products.product_id DESC');
        $returnItem->execute();
        $result = $returnItem->fetch(PDO::FETCH_OBJ);

        $insertLiaison = $bdd->prepare('INSERT INTO liaison_items_category (id_item,id_category) VALUES(:id_item,:id_category)');
        $insertLiaison->execute([
            'id_item' => $result->product_id,
            'id_category' => $this->id_parent
        ]);
        // header('Location: admin.php');
    }
    public function updateCategory($bdd)
    {
        $updateCategory = $bdd->prepare('UPDATE category SET name = :name , id_parent = :id_parent WHERE id = :id');
        $updateCategory->execute([
            'name' => $this->name,
            'id_parent' => $this->id_parent,
            'id' => $this->id
        ]);
    }

    public function returnAllCategories($bdd)
    {
        $request = $bdd->prepare('SELECT * FROM category');
        $request->execute();
        $result = $request->fetchAll(PDO::FETCH_OBJ);
        return $result;
    }
    public function returnCategory($bdd)
    {
        $request = $bdd->prepare('SELECT * FROM category WHERE category.id = :id');
        $request->execute(['id' => $this->id]);
        $result = $request->fetch(PDO::FETCH_OBJ);
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
     * Get the value of id_parent
     */
    public function getId_parent()
    {
        return $this->id_parent;
    }

    /**
     * Set the value of id_parent
     *
     * @return  self
     */
    public function setId_parent($id_parent)
    {
        $this->id_parent = $id_parent;

        return $this;
    }
}
