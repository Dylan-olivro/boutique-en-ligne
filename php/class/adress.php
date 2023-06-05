<?php
class Adress
{
    public $id;
    public $id_user;
    public $numero;
    public $name;
    public $postcode;
    public $city;

    public function __construct($id, $id_user, $numero, $name, $postcode, $city)
    {
        $this->id = $id;
        $this->id_user = $id_user;
        $this->numero = $numero;
        $this->name = $name;
        $this->postcode = $postcode;
        $this->city = $city;
    }
    public function addAdress($bdd)
    {
        if (isEmpty($this->numero)) {
            $error = '<i class="fa-solid fa-circle-exclamation"></i> Le champ Numero est vide.';
            return $error;
        } elseif (isEmpty($this->name)) {
            $error = '<i class="fa-solid fa-circle-exclamation"></i> Le champ Name est vide.';
            return $error;
        } elseif (isEmpty($this->postcode)) {
            $error = '<i class="fa-solid fa-circle-exclamation"></i> Le champ Postcode est vide.';
            return $error;
        } elseif (isEmpty($this->city)) {
            $error = '<i class="fa-solid fa-circle-exclamation"></i> Le champ City est vide.';
            return $error;
        } elseif (!isStreet($this->numero)) {
            $error = '<i class="fa-solid fa-circle-exclamation"></i> Le champ Numero est invalide.';
            return $error;
        } elseif (!isPostcode($this->postcode)) {
            $error = '<i class="fa-solid fa-circle-exclamation"></i> Le champ Postcode est invalide.';
            return $error;
        } else {
            $addAdress = $bdd->prepare('INSERT INTO adress (id_user,numero,name,postcode,city)  VALUES(:id_user,:numero,:name,:postcode,:city)');
            $addAdress->execute([
                'id_user' => $this->id_user,
                'numero' => $this->numero,
                'name' => $this->name,
                'postcode' => $this->postcode,
                'city' => $this->city
            ]);
            header('Location: ../profil.php');
        }
    }
    public function deleteAdress($bdd)
    {
        $deleteAdress = $bdd->prepare('DELETE FROM adress WHERE id = :id AND id_user = :id_user');
        $deleteAdress->execute([
            'id' => $this->id,
            'id_user' => $this->id_user
        ]);
        header('Location: ../profil.php');
    }

    public function updateAdress($bdd)
    {
        if (isEmpty($this->numero)) {
            $error = '<i class="fa-solid fa-circle-exclamation"></i> Le champ Numero est vide.';
            return $error;
        } elseif (isEmpty($this->name)) {
            $error = '<i class="fa-solid fa-circle-exclamation"></i> Le champ Name est vide.';
            return $error;
        } elseif (isEmpty($this->postcode)) {
            $error = '<i class="fa-solid fa-circle-exclamation"></i> Le champ Postcode est vide.';
            return $error;
        } elseif (isEmpty($this->city)) {
            $error = '<i class="fa-solid fa-circle-exclamation"></i> Le champ City est vide.';
            return $error;
        } elseif (!isStreet($this->numero)) {
            $error = '<i class="fa-solid fa-circle-exclamation"></i> Le champ Numero est invalide.';
            return $error;
        } elseif (!isPostcode($this->postcode)) {
            $error = '<i class="fa-solid fa-circle-exclamation"></i> Le champ Postcode est invalide.';
            return $error;
        } else {
            $updateAdress = $bdd->prepare('UPDATE adress SET numero = :numero, name = :name, postcode = :postcode, city = :city WHERE id = :id AND id_user = :id_user');
            $updateAdress->execute([
                'numero' => $this->numero,
                'name' => $this->name,
                'postcode' => $this->postcode,
                'city' => $this->city,
                'id' => $this->id,
                'id_user' => $this->id_user
            ]);
            header('Location: ../profil.php');
        }
    }

    public function returnAdressById($bdd)
    {
        $returnAdress = $bdd->prepare('SELECT * FROM adress WHERE id = :id AND id_user = :id_user');
        $returnAdress->execute([
            'id' => $this->id,
            'id_user' => $_SESSION['user']->id
        ]);
        $result = $returnAdress->fetch(PDO::FETCH_OBJ);
        return $result;
    }

    public function returnAdressByUser($bdd)
    {
        $returnAdress = $bdd->prepare('SELECT * FROM adress WHERE id_user = :id_user');
        $returnAdress->execute(['id_user' => $this->id_user]);
        $result = $returnAdress->fetchAll(PDO::FETCH_OBJ);
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
     * Get the value of id_user
     */
    public function getId_user()
    {
        return $this->id_user;
    }

    /**
     * Set the value of id_user
     *
     * @return  self
     */
    public function setId_user($id_user)
    {
        $this->id_user = $id_user;

        return $this;
    }

    /**
     * Get the value of numero
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * Set the value of numero
     *
     * @return  self
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;

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
     * Get the value of postcode
     */
    public function getPostcode()
    {
        return $this->postcode;
    }

    /**
     * Set the value of postcode
     *
     * @return  self
     */
    public function setPostcode($postcode)
    {
        $this->postcode = $postcode;

        return $this;
    }

    /**
     * Get the value of city
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set the value of city
     *
     * @return  self
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }
}
