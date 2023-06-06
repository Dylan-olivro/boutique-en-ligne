<?php
class Image
{
    public $id;
    public $id_item;
    public $name;
    public $main;

    public function __construct($id, $id_item, $name, $main)
    {
        $this->id = $id;
        $this->id_item = $id_item;
        $this->name = $name;
        $this->main = $main;
    }
    public function addImage($bdd)
    {
        $tmpName = $this->name['tmp_name'];
        $name = $this->name['name'];
        $size = $this->name['size'];
        $error = $this->name['error'];

        $tabExtension = explode('.', $name);
        $extension = strtolower(end($tabExtension));
        $extensions = ['jpg', 'png', 'jpeg', 'gif', 'webp'];
        $maxSize = 2000000;
        $uniqueName = uniqid('', true);
        $file = $uniqueName . "." . $extension;

        if (in_array($extension, $extensions) && $size <= $maxSize && $error == 0) {
            move_uploaded_file($tmpName, '../assets/img_item/' . $file);

            $insertImage = $bdd->prepare('INSERT INTO image (id_item, name_image, main) VALUES (:id_item,:name_image,:main)');
            $insertImage->execute([
                'id_item' => $this->id_item,
                'name_image' => $file,
                'main' => $this->main
            ]);
        } else {
            echo "Mauvaise extension ou taille trop grande, Une erreur est survenue";
        }
    }

    public function deleteImage($bdd)
    {
        unlink('../assets/img_item/' . $this->name);
        $deleteImage = $bdd->prepare('DELETE FROM image WHERE name_image = :name_image');
        $deleteImage->execute(['name_image' => $this->name]);
    }

    public function returnImagesByID($bdd)
    {
        $recupImage = $bdd->prepare('SELECT * FROM image WHERE id_item = :id_item');
        $recupImage->execute(['id_item' => $this->id_item]);
        $result = $recupImage->fetchAll(PDO::FETCH_OBJ);
        return $result;
    }
}
