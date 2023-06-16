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
            move_uploaded_file($tmpName, '../../assets/img_item/' . $file);

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

    public function updateMainImage($bdd, $old_image)
    {
        unlink('../../assets/img_item/' . $old_image);

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
            move_uploaded_file($tmpName, '../../assets/img_item/' . $file);


            $updateImg = $bdd->prepare('UPDATE images SET image_name = :image_name WHERE product_id = :product_id AND image_main = 1');
            $updateImg->execute([
                'image_name' => $file,
                'product_id' => $this->product_id
            ]);
        }
    }

    public function returnImagesByID($bdd)
    {
        $recupImage = $bdd->prepare('SELECT * FROM images WHERE product_id = :product_id');
        $recupImage->execute(['product_id' => $this->product_id]);
        $result = $recupImage->fetchAll(PDO::FETCH_OBJ);
        return $result;
    }
    public function returnMainImageByID($bdd)
    {
        $recupImage = $bdd->prepare('SELECT * FROM images WHERE product_id = :product_id AND image_main = 1');
        $recupImage->execute(['product_id' => $this->product_id]);
        $result = $recupImage->fetch(PDO::FETCH_OBJ);
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
     * Get the value of main
     */
    public function getMain()
    {
        return $this->main;
    }

    /**
     * Set the value of main
     *
     * @return  self
     */
    public function setMain($main)
    {
        $this->main = $main;

        return $this;
    }
}
