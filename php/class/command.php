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
        $insertCommand = $bdd->prepare('INSERT INTO command (id_user,date) VALUES (?,?)');
        $insertCommand->execute([$this->id_user, $this->date]);
    }
    public function updateCommand($bdd)
    {
        $insertCommand = $bdd->prepare('UPDATE command SET total = ? WHERE id = ? ');
        $insertCommand->execute([$this->total, $this->id]);
    }
}
