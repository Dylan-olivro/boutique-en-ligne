<?php
session_start();
// ob_start();
ob_start('ob_gzhandler');
// ! REGLER LE PROBLEME DU MESSAGE EN SESSION QUI RESTE SI ON CHANGE DE PAGE !
// ! DEMANDER SI REQUIRED EST NESSECAIRE VU QUE CA EMPECHE D'AFFICHER LES MESSAGE D'ERREUR !

// RECUPERER L'URL POUR SAVOIR SI C'EST L'INDEX OU LES AUTRES PAGES
function getURL()
{
    if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
        $url = "https";
    else {
        $url = "http";
    }
    // ASSEMBLAGE DE L'URL
    $url .= "://";
    $url .= $_SERVER['HTTP_HOST'];
    $url .= $_SERVER['REQUEST_URI'];
    $splitURL = explode('boutique-en-ligne', $url);
    $splitURL2 = explode('/', $splitURL[1]);
    return [$splitURL, $splitURL2];
}
// CONDITION SI ON EST SUR L'INDEX OU PAS
if (getURL()[0][1] === '/index.php' || getURL()[0][1] === '/') {
    require_once('./php/include/bdd.php');
    require_once('./php/include/function.php');
    require_once('./php/class/adress.php');
    require_once('./php/class/image.php');
    require_once('./php/class/item.php');
    require_once('./php/class/category.php');
    require_once('./php/class/cart.php');
    require_once('./php/class/command.php');
} else {
    if (getURL()[1][2] === 'user') {
        require_once('../include/bdd.php');
        require_once('../include/function.php');
        require_once('../class/adress.php');
        require_once('../class/image.php');
        require_once('../class/item.php');
        require_once('../class/category.php');
        require_once('../class/cart.php');
        require_once('../class/command.php');
    } else {
        require_once('./include/bdd.php');
        require_once('./include/function.php');
        require_once('./class/adress.php');
        require_once('./class/image.php');
        require_once('./class/item.php');
        require_once('./class/category.php');
        require_once('./class/cart.php');
        require_once('./class/command.php');
    }
}


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
            $_SESSION['message'] = 'Email déjà utilisé';
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
                    unset($_SESSION['message']);
                    header('Location: ../index.php');
                }
            }
        } else {
            $_SESSION['message'] = 'utilisateurs inconnu';
            //? VOIR SI ON PEUT S'EN PASSER
            header('Location: connect.php');
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
            $_SESSION['message'] = 'Email déjà utilisé';
            //? VOIR SI ON PEUT S'EN PASSER
            header('Location:./profil.php');
        } else {
            if ($this->password != password_verify($this->password, $res->password)) {
                $_SESSION['message'] = 'Ce n\'est pas le bon mot de passe';
                //? VOIR SI ON PEUT S'EN PASSER
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
