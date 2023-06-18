<?php
class Address
{
    public $id;
    public $user_id;
    public $numero;
    public $name;
    public $postcode;
    public $city;
    public $telephone;
    public $firstname;
    public $lastname;

    public function __construct($id, $user_id, $numero, $name, $postcode, $city, $telephone, $firstname, $lastname)
    {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->numero = $numero;
        $this->name = $name;
        $this->postcode = $postcode;
        $this->city = $city;
        $this->telephone = $telephone;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
    }

    public static function formatTelephoneAccept($a): bool
    {
        return preg_match("/^(\+33|0)[1-9]([- .]?[0-9]{2}){4}$/", $a) ? true : false;
    }

    public function addAddress($bdd)
    {
        $user_id = intval($this->user_id);
        $numero = intval(trim($this->numero));
        $name = trim($this->name);
        $postcode = trim($this->postcode);
        $city = strtoupper(trim($this->city));
        $telephone = trim($this->telephone);
        $firstname = ucfirst(trim($this->firstname));
        $lastname = ucfirst(trim($this->lastname));

        $addAddress = $bdd->prepare('INSERT INTO addresses (user_id, address_numero, address_name, address_postcode, address_city, address_telephone, address_firstname, address_lastname)  VALUES(:user_id, :address_numero, :address_name, :address_postcode, :address_city, :address_telephone, :address_firstname, :address_lastname)');
        $addAddress->execute([
            'user_id' => $user_id,
            'address_numero' => $numero,
            'address_name' => $name,
            'address_postcode' => $postcode,
            'address_city' => $city,
            'address_telephone' => $telephone,
            'address_firstname' => $firstname,
            'address_lastname' => $lastname
        ]);
    }
    public function deleteAddress($bdd)
    {
        $deleteAdress = $bdd->prepare('DELETE FROM addresses WHERE address_id = :address_id AND user_id = :user_id');
        $deleteAdress->execute([
            'address_id' => $this->id,
            'user_id' => $this->user_id
        ]);
    }

    public function updateAddress($bdd)
    {

        $user_id = intval($this->user_id);
        $numero = intval(trim($this->numero));
        $name = trim($this->name);
        $postcode = trim($this->postcode);
        $city = strtoupper(trim($this->city));
        $telephone = trim($this->telephone);
        $firstname = ucfirst(trim($this->firstname));
        $lastname = ucfirst(trim($this->lastname));

        $updateAdress = $bdd->prepare('UPDATE addresses SET address_numero = :address_numero, address_name = :address_name, address_postcode = :address_postcode, address_city = :address_city, address_telephone = :address_telephone, address_firstname = :address_firstname, address_lastname = :address_lastname WHERE address_id = :address_id AND user_id = :user_id');
        $updateAdress->execute([
            'address_numero' => $numero,
            'address_name' => $name,
            'address_postcode' => $postcode,
            'address_city' => $city,
            'address_telephone' => $telephone,
            'address_firstname' => $firstname,
            'address_lastname' => $lastname,
            'address_id' => $this->id,
            'user_id' => $user_id
        ]);
    }

    public function returnAddressesById($bdd)
    {
        $returnAdress = $bdd->prepare('SELECT * FROM addresses WHERE address_id = :address_id AND user_id = :user_id');
        $returnAdress->execute([
            'address_id' => $this->id,
            'user_id' => $this->user_id
        ]);
        $result = $returnAdress->fetch(PDO::FETCH_OBJ);
        return $result;
    }

    public function returnAddressesByUser($bdd)
    {
        $returnAdress = $bdd->prepare('SELECT * FROM addresses WHERE user_id = :user_id');
        $returnAdress->execute(['user_id' => $this->user_id]);
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
     * Get the value of user_id
     */
    public function getId_user()
    {
        return $this->user_id;
    }

    /**
     * Set the value of user_id
     *
     * @return  self
     */
    public function setId_user($user_id)
    {
        $this->user_id = $user_id;

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

    /**
     * Get the value of firstname
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set the value of firstname
     *
     * @return  self
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get the value of lastname
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set the value of lastname
     *
     * @return  self
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }
}
