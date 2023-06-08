<?php
class Image
{
    public $id;
    public $product_id;
    public $name;
    public $main;

    public function __construct($id, $product_id, $name, $main)
    {
        $this->id = $id;
        $this->product_id = $product_id;
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

            $insertImage = $bdd->prepare('INSERT INTO images (product_id, image_name, image_main) VALUES (:product_id,:image_name,:image_main)');
            $insertImage->execute([
                'product_id' => $this->product_id,
                'image_name' => $file,
                'image_main' => $this->main
            ]);
        } else {
            echo "Mauvaise extension ou taille trop grande, Une erreur est survenue";
        }
    }

    public function deleteImage($bdd)
    {
        unlink('../assets/img_item/' . $this->name);
        $deleteImage = $bdd->prepare('DELETE FROM images WHERE image_name = :image_name');
        $deleteImage->execute(['image_name' => $this->name]);
    }

    public function returnImagesByID($bdd)
    {
        $recupImage = $bdd->prepare('SELECT * FROM images WHERE product_id = :product_id');
        $recupImage->execute(['product_id' => $this->product_id]);
        $result = $recupImage->fetchAll(PDO::FETCH_OBJ);
        return $result;
    }
}
