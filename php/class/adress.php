<?php
class Adress
{
    public $id;
    public $id_user;
    public $numero;
    public $name;
    public $postcode;
    public $city;
    public $telephone;
    public $prenom;
    public $nom;

    public function __construct($id, $id_user, $numero, $name, $postcode, $city, $telephone, $prenom, $nom)
    {
        $this->id = $id;
        $this->id_user = $id_user;
        $this->numero = $numero;
        $this->name = $name;
        $this->postcode = $postcode;
        $this->city = $city;
        $this->telephone = $telephone;
        $this->prenom = $prenom;
        $this->nom = $nom;
    }

    public static function formatTelephoneAccept($a): bool
    {
        return preg_match("/^(\+33|0)[1-9]([- .]?[0-9]{2}){4}$/", $a) ? true : false;
    }

    public function addAdress($bdd)
    {
        $id_user = intval($this->id_user);
        $numero = intval(trim($this->numero));
        $name = trim($this->name);
        $postcode = trim($this->postcode);
        $city = strtoupper(trim($this->city));
        $telephone = trim($this->telephone);
        $prenom = ucfirst(trim($this->prenom));
        $nom = ucfirst(trim($this->nom));

        $addAdress = $bdd->prepare('INSERT INTO adress (id_user,numero,name,postcode,city,telephone,prenom,nom)  VALUES(:id_user,:numero,:name,:postcode,:city,:telephone,:prenom,:nom)');
        $addAdress->execute([
            'id_user' => $id_user,
            'numero' => $numero,
            'name' => $name,
            'postcode' => $postcode,
            'city' => $city,
            'telephone' => $telephone,
            'prenom' => $prenom,
            'nom' => $nom
        ]);
        // header('Location: ../profil.php');
    }
    public function deleteAdress($bdd)
    {
        $deleteAdress = $bdd->prepare('DELETE FROM adress WHERE id = :id AND id_user = :id_user');
        $deleteAdress->execute([
            'id' => $this->id,
            'id_user' => $this->id_user
        ]);
    }

    public function updateAdress($bdd)
    {

        $id_user = intval($this->id_user);
        $numero = intval(trim($this->numero));
        $name = trim($this->name);
        $postcode = trim($this->postcode);
        $city = strtoupper(trim($this->city));

        $updateAdress = $bdd->prepare('UPDATE adress SET numero = :numero, name = :name, postcode = :postcode, city = :city WHERE id = :id AND id_user = :id_user');
        $updateAdress->execute([
            'numero' => $numero,
            'name' => $name,
            'postcode' => $postcode,
            'city' => $city,
            'id' => $this->id,
            'id_user' => $id_user
        ]);
        // header('Location: ../profil.php');

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

    public function returnFormatTel($numTel)
    {
        $formateNum = preg_replace('/[^0-9]/', '', $numTel); // Supprimer tous les caractères non numériques
        $formateNum = chunk_split($formateNum, 2, ' '); // Insérer un espace tous les 2 chiffres
        $formateNum = trim($formateNum); // Supprimer les espaces en début et fin de chaîne
        return $formateNum;
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

    /**
     * Get the value of telephone
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * Set the value of telephone
     *
     * @return  self
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;

        return $this;
    }
}
