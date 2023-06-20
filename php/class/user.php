<?php
class User
{
    public $id;
    public $email;
    public $firstname;
    public $lastname;
    public $password;
    public $role;

    public function __construct($id, $email, $firstname, $lastname, $password, $role)
    {
        $this->id = $id;
        $this->email = $email;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->password = $password;
        $this->role = $role;
    }

    // * STATIC FUNCTION -------------------------------------------------------------
    public static function isAName($a): bool
    {
        return preg_match("#^(\pL+[- ']?)*\pL$#ui", $a) ? true : false;
    }

    public static function isToBig($a): bool
    {
        return mb_strlen($a) > 30 ? true : false;
    }

    public static function isToSmall($a): bool
    {
        return mb_strlen($a) < 2 ? true : false;
    }
    public static function isSame($a, $b): bool
    {
        return $a == $b ? true : false;
    }

    // * MAIN FUNCTION -------------------------------------------------------------
    public function register($bdd)
    {
        $email = trim($this->email);
        $lastname = ucfirst(trim($this->lastname));
        $firstname = ucfirst(trim($this->firstname));
        $password = password_hash(trim($this->password), PASSWORD_DEFAULT);
        // Insert du nouveau utilisateur
        $request = $bdd->prepare("INSERT INTO users (user_email,user_lastname,user_firstname,user_password) VALUES(:user_email,:user_lastname,:user_firstname,:user_password)");
        $request->execute([
            'user_email' => $email,
            'user_lastname' => $lastname,
            'user_firstname' => $firstname,
            'user_password' => $password
        ]);
    }

    public function connect($bdd)
    {
        // Récupération des utilisateurs pour vérifier si l'adresse mail existe
        $request = $bdd->prepare("SELECT * FROM users WHERE user_email = :user_email");
        $request->execute(['user_email' => $this->email]);
        $res = $request->fetch(PDO::FETCH_OBJ);

        if ($request->rowCount() > 0) {

            // Récupération de l'email et du mot de passe de l'utilisateurs pour vérifier si ils correspondes avec ce qu'il a rentrer dans le formulaire
            $recupUser = $bdd->prepare("SELECT * FROM users WHERE user_email = :user_email AND user_password = :user_password");
            $recupUser->execute([
                'user_email' => $this->email,
                'user_password' => $res->password
            ]);
            $result = $recupUser->fetch(PDO::FETCH_OBJ);

            if ($result) {
                // Vérification du mot de passe 
                if (password_verify($this->password, $result->password)) {
                    $this->id = intval($result->id);
                    $this->email = $result->email;
                    $this->firstname = $result->firstname;
                    $this->lastname = $result->lastname;
                    $this->password = $result->password;
                    $this->role = intval($result->role);

                    $_SESSION['user'] = $this;
                    header('Location: ../index.php');
                } else {
                    $error = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe mot de passe est incorrect.';
                    return $error;
                }
            }
        } else {
            $error = '<i class="fa-solid fa-circle-exclamation"></i>&nbspCette email n\'existe pas.';
            return $error;
        }
    }

    public function update($bdd, $password_bdd)
    {
        $email = trim($this->email);
        $lastname = ucfirst(trim($this->lastname));
        $firstname = ucfirst(trim($this->firstname));
        $password = trim($this->password);

        $request = $bdd->prepare("UPDATE users SET user_email = :user_email, user_firstname = :user_firstname, user_lastname = :user_lastname, user_password = :user_password WHERE user_id = :user_id ");
        $request->execute([
            'user_email' => $email,
            'user_firstname' => $firstname,
            'user_lastname' => $lastname,
            'user_password' => $password_bdd,
            'user_id' => $this->id
        ]);

        $_SESSION['user']->user_email = $email;
        $_SESSION['user']->user_firstname = $firstname;
        $_SESSION['user']->user_lastname = $lastname;
        $_SESSION['user']->user_password = $password;
    }

    public function updatePassword($bdd, $old_password)
    {
        // ! faire un SELECT que sur le password et pas sur *
        // Récupartion des informations de l'utilisateurs
        $request = $bdd->prepare("SELECT * FROM users WHERE user_id = :user_id");
        $request->execute(['user_id' => $this->id]);
        $res = $request->fetch(PDO::FETCH_OBJ);
        $insertUser = $bdd->prepare("UPDATE users SET user_password = :user_password WHERE user_id = :user_id ");
        // La sécurité empêche que les champs soient VIDES
        if (empty($old_password)) {
            $error = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe champ Password est vide';
            return $error;
        } elseif (empty($this->password)) {
            $error = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe champ New Password est vide';
            return $error;
        }
        // Vérification du mot de passe 
        elseif ($old_password == $this->password) {
            $error = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLes mots de passe sont identiques';
            return $error;
        } elseif ($old_password != password_verify($old_password, $res->user_password)) {
            $error = '<i class="fa-solid fa-circle-exclamation"></i>&nbspCe n\'est pas le bon mot de passe';
            return $error;
        } else {
            // Mise à jour du mot de passe
            $insertUser->execute([
                'user_password' => password_hash($this->password, PASSWORD_DEFAULT),
                'user_id' => $this->id
            ]);
            $_SESSION['user']->user_password = $this->password;
            header('Location:../profil.php');
        }
    }

    public function disconnect()
    {
        unset($_SESSION['user']);
        unset($_SESSION['code']);
    }

    // * SECONDARY FUNCTION -------------------------------------------------------------
    public function isExist($bdd): bool
    {
        // Récupération des utilisateurs pour vérifier si l'adresse mail existe déjà
        $request = $bdd->prepare("SELECT user_email FROM users WHERE user_email = :user_email");
        $request->execute(['user_email' => $this->email]);

        if ($request->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function isExistExceptCurrentEmail($bdd): bool
    {
        // Récupération des utilisateurs pour vérifier si l'adresse mail existe déjà sauf celle qui est utilisé
        $request = $bdd->prepare("SELECT * FROM users WHERE user_email = :user_email AND user_id != :user_id");
        $request->execute([
            'user_email' => $this->email,
            'user_id' => $this->id
        ]);

        if ($request->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function returnUserByEmail($bdd)
    {
        $request = $bdd->prepare("SELECT * FROM users WHERE user_email = :user_email");
        $request->execute(['user_email' => $this->email]);
        $result = $request->fetch(PDO::FETCH_OBJ);
        return $result;
    }
    public function returnUserByEmailAndPassword($bdd, $bdd_password)
    {
        // Récupération de l'email et du mot de passe de l'utilisateurs pour vérifier si ils correspondes avec ce qu'il a rentrer dans le formulaire
        $recupUser = $bdd->prepare("SELECT * FROM users WHERE user_email = :user_email AND user_password = :user_password");
        $recupUser->execute([
            'user_email' => $this->email,
            'user_password' => $bdd_password
        ]);
        $result = $recupUser->fetch(PDO::FETCH_OBJ);
        return $result;
    }

    public function returnUserById($bdd)
    {
        $request = $bdd->prepare("SELECT * FROM users WHERE user_id = :user_id");
        $request->execute(['user_id' => $this->id]);
        $result = $request->fetch(PDO::FETCH_OBJ);
        return $result;
    }

    public function returnAllUser($bdd)
    {
        $request = $bdd->prepare("SELECT * FROM users");
        $request->execute();
        $result = $request->fetchAll(PDO::FETCH_OBJ);
        return $result;
    }
    public function deleteUserByID($bdd)
    {
        $request = $bdd->prepare("DELETE FROM users WHERE user_id = :user_id");
        $request->execute(['user_id' => $this->id]);

        $req = $bdd->prepare('DELETE FROM carts WHERE user_id = :user_id');
        $req->execute(['user_id' => $this->id]);
    }

    public function isConnected(): bool
    {
        if (isset($_SESSION['user']->user_login)) {
            return true;
        } else {
            return false;
        }
    }

    public function getAllinfo()
    {
        return $this->id;
        return $this->email;
        return $this->firstname;
        return $this->lastname;
        return $this->password;
        return $this->role;
    }

    // * GETTER AND SETTER
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
     * Get the value of email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */
    public function setEmail($email)
    {
        $this->email = $email;

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

    /**
     * Get the value of password
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of password
     *
     * @return  self
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get the value of role
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Set the value of role
     *
     * @return  self
     */
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }
}
