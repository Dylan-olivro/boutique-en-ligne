<?php
class Image
{
    public $id;
    public $id_item;
    public $name;

    public function __construct($id, $id_item, $name)
    {
        $this->id = $id;
        $this->id_item = $id_item;
        $this->name = $name;
    }
    public function addImage($bdd)
    {
        $returnLastID = $bdd->prepare("SELECT id FROM items ORDER BY items.id DESC");
        $returnLastID->execute();
        $resultID =  $returnLastID->fetch(PDO::FETCH_OBJ);

        $tmpName = $_FILES['file']['tmp_name'];
        $name = $_FILES['file']['name'];
        $size = $_FILES['file']['size'];
        $error = $_FILES['file']['error'];

        $tabExtension = explode('.', $name);
        $extension = strtolower(end($tabExtension));
        $extensions = ['jpg', 'png', 'jpeg', 'gif'];
        $maxSize = 2000000;
        $uniqueName = uniqid('', true);
        $this->name = $uniqueName . "." . $extension;

        if (in_array($extension, $extensions) && $size <= $maxSize && $error == 0) {
            move_uploaded_file($tmpName, '../assets/img_item/' . $this->name);

            $insertImage = $bdd->prepare('INSERT INTO image (id_item, name) VALUES (?,?)');
            $insertImage->execute([$resultID->id, $this->name]);
        } else {
            echo "Mauvaise extension ou taille trop grande, Une erreur est survenue";
        }
    }

    public function deleteImage($bdd)
    {
        unlink('../assets/img_item/' . $this->name);
        $deleteImage = $bdd->prepare('DELETE FROM image WHERE name = ?');
        $deleteImage->execute([$this->name]);
    }

    public function returnImages($bdd)
    {
        $recupImage = $bdd->prepare('SELECT * FROM image');
        $recupImage->execute();
        $result = $recupImage->fetchAll(PDO::FETCH_OBJ);
        return $result;
    }
}
