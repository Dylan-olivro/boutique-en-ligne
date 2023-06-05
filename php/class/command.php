<?php
class Command
{
    public $id;
    public $id_user;
    public $date;
    public $total;

    public function __construct($id, $id_user, $date, $total)
    {
        $this->id = $id;
        $this->id_user = $id_user;
        $this->date = $date;
        $this->total = $total;
    }
    public function addCommand($bdd)
    {
        $insertCommand = $bdd->prepare('INSERT INTO command (id_user,date) VALUES (:id_user,:date)');
        $insertCommand->execute([
            'id_user' => $this->id_user,
            'date' => $this->date
        ]);
    }
    public function updateCommand($bdd)
    {
        $insertCommand = $bdd->prepare('UPDATE command SET total = :total WHERE id = :id ');
        $insertCommand->execute([
            'total' => $this->total,
            'id' => $this->id
        ]);
    }
    public function deleteCommand($bdd)
    {
        $deleteCommand = $bdd->prepare('DELETE FROM command WHERE id = :id');
        $deleteCommand->execute([
            'id' => $this->id
        ]);
    }
}
