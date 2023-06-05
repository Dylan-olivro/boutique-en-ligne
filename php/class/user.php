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

    public function getAllinfo()
    {
        return $this->id;
        return $this->email;
        return $this->firstname;
        return $this->lastname;
        return $this->password;
        return $this->role;
    }

    public function register($bdd, $confirm_password)
    {
        $recupUser = $bdd->prepare("SELECT email FROM users WHERE email = ?");
        $recupUser->execute([$this->email]);
        $insertUser = $bdd->prepare("INSERT INTO users (email,lastname,firstname,password) VALUES(?,?,?,?)");

        if (isEmpty($this->email)) {
        } elseif (isEmpty($this->firstname)) {
        } elseif (isEmpty($this->lastname)) {
        } elseif (isEmpty($this->password)) {
        } elseif (isEmpty($confirm_password)) {
        } elseif (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
        } elseif (!isName($this->firstname)) {
        } elseif (!isName($this->lastname)) {
        } elseif (isToBig($this->firstname)) {
        } elseif (isToSmall($this->firstname)) {
        } elseif (isToBig($this->lastname)) {
        } elseif (isToSmall($this->lastname)) {
        } elseif (!isSame($this->password, $confirm_password)) {
        } elseif ($recupUser->rowCount() > 0) {
            // $_SESSION['message'] = 'Email déjà utilisé';
            $error = 'Email déjà utilisé';
            return $error;
        } else {
            unset($_SESSION['message']);
            $insertUser->execute([$this->email, $this->lastname, $this->firstname, password_hash($this->password, PASSWORD_DEFAULT)]);
            header('Location: ./connect.php');
        }
    }


    public function connect($bdd)
    {
        $request = $bdd->prepare("SELECT * FROM users WHERE email = ?");
        $request->execute([$this->email]);
        $res = $request->fetch(PDO::FETCH_OBJ);

        if (isEmpty($this->email)) {
        } elseif (isEmpty($this->password)) {
        } elseif (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
        } elseif ($request->rowCount() > 0) {

            $recupUser = $bdd->prepare("SELECT * FROM users WHERE email = ? AND password = ?");
            $recupUser->execute([$this->email, $res->password]);
            $result = $recupUser->fetch(PDO::FETCH_OBJ);

            if ($result) {
                if (password_verify($this->password, $result->password)) {
                    $this->id = intval($result->id);
                    $this->email = $result->email;
                    $this->firstname = $result->firstname;
                    $this->lastname = $result->lastname;
                    $this->password = $result->password;
                    $this->role = intval($result->role);

                    $_SESSION['user'] = $this;
                    // unset($_SESSION['message']);
                    header('Location: ../index.php');
                } else {
                    $error = 'Mauvais mot de passe';
                    return $error;
                    // $_SESSION['message'] = 'Mauvais mot de passe';
                    // header('Location: connect.php');
                }
            }
        } else {
            $error = 'Utilisateurs inconnu';
            return $error;
            // $_SESSION['message'] = 'utilisateurs inconnu';
            // header('Location: connect.php');
        }
    }

    public function update($bdd)
    {

        $request = $bdd->prepare("SELECT * FROM users WHERE id = ?");
        $request->execute([$this->id]);
        $res = $request->fetch(PDO::FETCH_OBJ);

        $recupUser = $bdd->prepare("SELECT * FROM users WHERE email = ? AND id != ?");
        $recupUser->execute([$this->email, $this->id]);
        $insertUser = $bdd->prepare("UPDATE users SET email = ?, firstname = ?, lastname = ?, password = ? WHERE id = ? ");

        if (isEmpty($this->email)) {
        } elseif (isEmpty($this->firstname)) {
        } elseif (isEmpty($this->lastname)) {
        } elseif (isEmpty($this->password)) {
        } elseif (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
        } elseif (!isName($this->firstname)) {
        } elseif (!isName($this->lastname)) {
        } elseif (isToBig($this->firstname)) {
        } elseif (isToSmall($this->firstname)) {
        } elseif (isToBig($this->lastname)) {
        } elseif (isToSmall($this->lastname)) {
        } elseif ($recupUser->rowCount() > 0) {
            $error = 'Email déjà utilisé';
            return $error;
            // $_SESSION['message'] = 'Email déjà utilisé';

            // header('Location:./profil.php');
        } else {
            if ($this->password != password_verify($this->password, $res->password)) {

                $error = 'Ce n\'est pas le bon mot de passe';
                return $error;
                // $_SESSION['message'] = 'Ce n\'est pas le bon mot de passe';
                header('Location:./profil.php');
            } else {
                unset($_SESSION['message']);
                $insertUser->execute([$this->email, $this->firstname, $this->lastname, $res->password, $this->id]);
                $_SESSION['user']->email = $this->email;
                $_SESSION['user']->firstname = $this->firstname;
                $_SESSION['user']->lastname = $this->lastname;
                $_SESSION['user']->password = $this->password;
                header('Location:./profil.php');
            }
        }
    }

    public function updatePassword($bdd, $old_password)
    {
        $request = $bdd->prepare("SELECT * FROM users WHERE id = ?");
        $request->execute([$this->id]);
        $res = $request->fetch(PDO::FETCH_OBJ);
        $insertUser = $bdd->prepare("UPDATE users SET password = ? WHERE id = ? ");

        if (isEmpty($old_password)) {
        } elseif (isEmpty($this->password)) {
        } elseif ($old_password != password_verify($old_password, $res->password)) {
            $_SESSION['message'] = 'Ce n\'est pas le bon mot de passe';
            header('Location:./modifyPassword.php');
        } else {
            unset($_SESSION['message']);
            $insertUser->execute([$this->password, $this->id]);
            $_SESSION['user']->password = $this->password;
            header('Location:../profil.php');
        }
    }
    public function disconnect()
    {
        unset($_SESSION['user']);
    }

    public function isConnected()
    {
        if (isset($_SESSION['user']->login)) {
            // echo 'Connected';
            return true;
        } else {
            // echo 'Disconnected';
            return false;
        }
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
