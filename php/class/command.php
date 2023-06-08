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
        $request = $bdd->prepare('INSERT INTO command (id_user,date) VALUES (:id_user,:date)');
        $request->execute([
            'id_user' => $this->id_user,
            'date' => $this->date
        ]);
    }

    public function updateCommand($bdd)
    {
        $request = $bdd->prepare('UPDATE command SET total = :total WHERE id = :id ');
        $request->execute([
            'total' => $this->total,
            'id' => $this->id
        ]);
    }

    public function deleteCommand($bdd)
    {
        $request = $bdd->prepare('DELETE FROM command WHERE id = :id');
        $request->execute([
            'id' => $this->id
        ]);
    }

    public function returnComandByUser($bdd)
    {
        $request = $bdd->prepare('SELECT * FROM command WHERE id_user  = :id_user ORDER BY date DESC LIMIT 5');
        $request->execute(['id_user' => $this->id_user]);
        $result = $request->fetchAll(PDO::FETCH_OBJ);
        return $result;
    }

    public function returnContentCommand($bdd)
    {
        $request = $bdd->prepare('SELECT * FROM command INNER JOIN liaison_cart_command ON command.id = liaison_cart_command.id_command INNER JOIN items ON liaison_cart_command.id_item = items.id INNER JOIN image ON items.id = image.id_item WHERE id_user = :id_user AND command.id = :command_id AND main = 1');
        $request->execute([
            'id_user' => $this->id_user,
            'command_id' => $this->id
        ]);
        $result = $request->fetchAll(PDO::FETCH_OBJ);
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
}
