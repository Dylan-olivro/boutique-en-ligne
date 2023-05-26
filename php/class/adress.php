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
        $addAdress = $bdd->prepare('INSERT INTO adress (id_user,numero,name,postcode,city)  VALUES(?,?,?,?,?)');
        $addAdress->execute([$this->id_user, $this->numero, $this->name, $this->postcode, $this->city]);
    }
    public function deleteAdress($bdd)
    {
        $deleteAdress = $bdd->prepare('DELETE FROM adress WHERE id = ? AND id_user = ?');
        $deleteAdress->execute([$this->id, $this->id_user]);
    }
    public function updateAdress($bdd)
    {
        $updateAdress = $bdd->prepare('UPDATE adress SET numero = ?, name = ?, postcode = ?, city = ? WHERE id = ? AND id_user = ?');
        $updateAdress->execute([$this->numero, $this->name, $this->postcode, $this->city, $this->id, $this->id_user]);
    }
    public function returnAdressById($bdd)
    {
        $returnAdress = $bdd->prepare('SELECT * FROM adress WHERE id = ?');
        $returnAdress->execute([$this->id]);
        $result = $returnAdress->fetch(PDO::FETCH_OBJ);
        return $result;
    }
    public function returnAdressByUser($bdd)
    {
        $returnAdress = $bdd->prepare('SELECT * FROM adress WHERE id_user = ?');
        $returnAdress->execute([$this->id_user]);
        $result = $returnAdress->fetchAll(PDO::FETCH_OBJ);
        return $result;
    }
}
