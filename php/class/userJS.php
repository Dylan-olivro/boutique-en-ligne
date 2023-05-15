<?php
session_start();
// RECUPERER L'URL POUR SAVOIR SI C'EST L'INDEX OU LES AUTRES PAGES
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

// CONDITION SI ON EST SUR L'INDEX OU PAS
if ($splitURL[1] === '/index.php' || $splitURL[1] === '/') {
    require_once('./php/include/bdd.php');
    require_once('./php/include/function.php');
} else {
    require_once('./include/bdd.php');
    require_once('./include/function.php');
}


class User
{
    public $id;
    public $email;
    public $firstname;
    public $lastname;
    public $password;

    public function __construct($id, $email, $firstname, $lastname, $password,)
    {
        $this->id = $id;
        $this->email = $email;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->password = $password;
    }

    public function getAllinfo()
    {
        return $this->password;
        return $this->email;
        return $this->firstname;
        return $this->lastname;
    }

    public function getId($id)
    {
        return $this->id;
    }
    public function setId($id)
    {
        $this->id = $id;
    }

    public function getPassword($password)
    {
        return $this->password;
    }
    public function setPassword($password)
    {
        $this->password = $password;
    }


    public function getEmail($email)
    {
        return $this->email;
    }
    public function setEmail($email)
    {
        $this->email = $email;
    }


    public function getFirstname($firstname)
    {
        return $this->firstname;
    }
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    }


    public function getLastname($lastname)
    {
        return $this->lastname;
    }
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    }

    public function register($bdd)
    {
        $recupUser = $bdd->prepare("SELECT email FROM users WHERE email = ?");
        $recupUser->execute([$this->email]);
        $insertUser = $bdd->prepare("INSERT INTO users (email,lastname,firstname,password) VALUES(?,?,?,?)");

        if ($recupUser->rowCount() > 0) {
            $_SESSION['message'] = 'Email déjà utilisé';
        } else {
            unset($_SESSION['message']);
            $insertUser->execute([$this->email, $this->lastname, $this->firstname, password_hash($this->password, PASSWORD_DEFAULT)]);
            header('Location:../index.php');
        }
    }


    public function connect($bdd)
    {
        $request = $bdd->prepare("SELECT email FROM users WHERE email = ?");
        $request->execute([$this->email]);
        $res = $request->fetchAll(PDO::FETCH_OBJ);
        // var_dump($res);

        if ($request->rowCount() > 0) {

            $recupUser = $bdd->prepare("SELECT * FROM users WHERE email = ? AND password = ?");
            $recupUser->execute([$this->email, $res[0]->password]);
            $result = $recupUser->fetch(PDO::FETCH_OBJ);

            if ($result != false) {
                if (password_verify($this->password, $result->password)) {
                    $this->id = $result->id;
                    $this->email = $result->email;
                    $this->firstname = $result->firstname;
                    $this->lastname = $result->lastname;
                    $this->password = $result->password;

                    $_SESSION['user'] = $this;
                    unset($_SESSION['message']);
                    header('Location: ../index.php');
                }
            }
        } else {
            $_SESSION['message'] = 'utilisateurs inconnu';
            //? VOIR SI ON PEUT S'EN PASSER
            header('Location: connectJS.php');
        }
    }

    public function update($bdd)
    {

        $request = $bdd->prepare("SELECT * FROM users WHERE id = ?");
        $request->execute([$this->id]);
        $res = $request->fetchAll(PDO::FETCH_OBJ);
        // var_dump($res[0]->password);

        $recupUser = $bdd->prepare("SELECT * FROM users WHERE email = ? AND id != ?");
        $recupUser->execute([$this->email, $this->id]);
        // var_dump($res);
        $insertUser = $bdd->prepare("UPDATE users SET email = ?, firstname = ?, lastname = ?, password = ? WHERE id = ? ");

        if (email($this->email) == false) {
        } elseif (password($this->password) == false) {
        } elseif (firstname($this->firstname) == false) {
        } elseif (lastname($this->lastname) == false) {
        } elseif ($recupUser->rowCount() > 0) {
            echo 'Email déjà utilisé';
        } else {
            if ($this->password != password_verify($this->password, $res[0]->password)) {
                echo  "Ce n'est pas le bon mot de passe";
            } else {
                $insertUser->execute([$this->email, $this->firstname, $this->lastname, $res[0]->password, $this->id]);
                $_SESSION['user']->email = $this->email;
                $_SESSION['user']->firstname = $this->firstname;
                $_SESSION['user']->lastname = $this->lastname;
                $_SESSION['user']->password = $this->password;
                header('Location:./profil.php');
            }
        }
    }
    public function updatePassword($bdd)
    {
        $request = $bdd->prepare("SELECT * FROM users WHERE id = ?");
        $request->execute([$this->id]);
        $res = $request->fetchAll(PDO::FETCH_OBJ);
        // var_dump($res);
        $insertUser = $bdd->prepare("UPDATE users SET password = ? WHERE id = ? ");


        if (password($this->password) == false) {
        } elseif (empty($_POST['new_password'])) {
            echo 'Champ New Password vide';
        } elseif ($_POST['password'] != password_verify($_POST['password'], $res[0]->password)) {
            echo  "Ce n'est pas le bon mot de passe";
        } else {
            $insertUser->execute([$this->password, $this->id]);
            $_SESSION['user']->password = $this->password;
            header('Location:./profil.php');
        }
    }
    public function disconnect()
    {
        unset($_SESSION['user']);
    }

    public function isConnected()
    {
        if (isset($_SESSION['user']->login)) {
            echo 'Connected';
            return true;
        } else {
            echo 'Disconnected';
            return false;
        }
    }
}

// $user = new User($login, $password, $email, $firstname, $lastname);
// $user = new User('a', 'a', 'a', 'a', 'a');
// var_dump($user);

// $user->register($bdd);
// $user->connect($bdd);
// $user->disconnect();
// $user->isConnected();

// $user->getAllinfo();
// $user->getLogin();
// $user->setLogin();
// $user->getPassword();
// $user->setPassword();
// $user->getEmail();
// $user->setEmail();
// $user->getFirstname();
// $user->setFirstname();
// $user->getLastname();
// $user->setLastname();
