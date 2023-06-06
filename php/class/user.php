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
        // Récupération des utilisateurs pour vérifier si l'adresse mail existe déjà
        $recupUser = $bdd->prepare("SELECT email FROM users WHERE email = :email");
        $recupUser->execute(['email' => $this->email]);
        $insertUser = $bdd->prepare("INSERT INTO users (email,lastname,firstname,password) VALUES(:email,:lastname,:firstname,:password)");

        // La sécurité empêche que les champs soient VIDES et correspondent à ce que nous voulons.
        if (isEmpty($this->email)) {
            $error = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe champ Email est vide.';
            return $error;
        } elseif (isEmpty($this->firstname)) {
            $error = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe champ Firstname est vide';
            return $error;
        } elseif (isEmpty($this->lastname)) {
            $error = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe champ Lastname est vide';
            return $error;
        } elseif (isEmpty($this->password)) {
            $error = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe champ Password est vide';
            return $error;
        } elseif (isEmpty($confirm_password)) {
            $error = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe champ Confirm Password est vide';
            return $error;
        } elseif (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $error = '<i class="fa-solid fa-circle-exclamation"></i>&nbspL\'adresse mail n\'est pas valide.';
            return $error;
        } elseif (!isName($this->firstname)) {
            $error = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe firstname n\'est pas valide.';
            return $error;
        } elseif (!isName($this->lastname)) {
            $error = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe lastname n\'est pas valide.';
            return $error;
        } elseif (isToBig($this->firstname)) {
            $error = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe firstname doit faire moins de 30 caractères.';
            return $error;
        } elseif (isToSmall($this->firstname)) {
            $error = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe firstname doit faire plus de 2 caractères.';
            return $error;
        } elseif (isToBig($this->lastname)) {
            $error = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe lastname doit faire moins de 30 caractères.';
            return $error;
        } elseif (isToSmall($this->lastname)) {
            $error = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe lastname doit faire plus de 2 caractères.';
            return $error;
        } elseif (!isSame($this->password, $confirm_password)) {
            $error = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLes champs password sont différents.';
            return $error;
        } elseif ($recupUser->rowCount() > 0) {
            $error = '<i class="fa-solid fa-circle-exclamation"></i>&nbspCette email est déjà utilisé';
            return $error;
        } else {
            // Insert du nouveau utilisateur
            $insertUser->execute([
                'email' => $this->email,
                'lastname' => $this->lastname,
                'firstname' => $this->firstname,
                'password' => password_hash($this->password, PASSWORD_DEFAULT)
            ]);
            header('Location: ./connect.php');
        }
    }


    public function connect($bdd)
    {
        // Récupération des utilisateurs pour vérifier si l'adresse mail existe
        $request = $bdd->prepare("SELECT * FROM users WHERE email = :email");
        $request->execute(['email' => $this->email]);
        $res = $request->fetch(PDO::FETCH_OBJ);

        // La sécurité empêche que les champs soient VIDES et correspondent à ce que nous voulons.
        if (isEmpty($this->email)) {
            $error = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe champ Email est vide.';
            return $error;
        } elseif (isEmpty($this->password)) {
            $error = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe champ Password est vide';
            return $error;
        } elseif (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $error = '<i class="fa-solid fa-circle-exclamation"></i>&nbspL\'adresse mail n\'est pas valide.';
            return $error;
        } elseif ($request->rowCount() > 0) {

            // Récupération de l'email et du mot de passe de l'utilisateurs pour vérifier si ils correspondes avec ce qu'il a rentrer dans le formulaire
            $recupUser = $bdd->prepare("SELECT * FROM users WHERE email = :email AND password = :password");
            $recupUser->execute([
                'email' => $this->email,
                'password' => $res->password
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

    public function update($bdd)
    {
        // Récupération des informations de l'utilisateur
        $request = $bdd->prepare("SELECT * FROM users WHERE id = :id");
        $request->execute(['id' => $this->id]);
        $res = $request->fetch(PDO::FETCH_OBJ);

        //Récupère les utilisateurs pour voir si la nouvelle adresse mail de l'utilisateur est déjà utilisé
        $recupUser = $bdd->prepare("SELECT * FROM users WHERE email = :email AND id != :id");
        $recupUser->execute([
            'email' => $this->email,
            'id' => $this->id
        ]);
        $insertUser = $bdd->prepare("UPDATE users SET email = :email, firstname = :firstname, lastname = :lastname, password = :password WHERE id = :id ");

        // La sécurité empêche que les champs soient VIDES et correspondent à ce que nous voulons.
        if (isEmpty($this->email)) {
            $error = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe champ Email est vide.';
            return $error;
        } elseif (isEmpty($this->firstname)) {
            $error = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe champ Firstname est vide';
            return $error;
        } elseif (isEmpty($this->lastname)) {
            $error = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe champ Lastname est vide';
            return $error;
        } elseif (isEmpty($this->password)) {
            $error = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe champ Password est vide';
            return $error;
        } elseif (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $error = '<i class="fa-solid fa-circle-exclamation"></i>&nbspL\'adresse mail n\'est pas valide.';
            return $error;
        } elseif (!isName($this->firstname)) {
            $error = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe firstname n\'est pas valide.';
            return $error;
        } elseif (!isName($this->lastname)) {
            $error = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe lastname n\'est pas valide.';
            return $error;
        } elseif (isToBig($this->firstname)) {
            $error = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe firstname doit faire moins de 30 caractères.';
            return $error;
        } elseif (isToSmall($this->firstname)) {
            $error = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe firstname doit faire plus de 2 caractères.';
            return $error;
        } elseif (isToBig($this->lastname)) {
            $error = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe lastname doit faire moins de 30 caractères.';
            return $error;
        } elseif (isToSmall($this->lastname)) {
            $error = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe lastname doit faire plus de 2 caractères.';
            return $error;
        } elseif ($recupUser->rowCount() > 0) {
            $error = '<i class="fa-solid fa-circle-exclamation"></i>&nbspCette email est déjà utilisé';
            return $error;
        } else {
            // Vérification du mot de passe 
            if ($this->password != password_verify($this->password, $res->password)) {
                $error = '<i class="fa-solid fa-circle-exclamation"></i>&nbspCe n\'est pas le bon mot de passe';
                return $error;
            } else {
                // Mise à jour des informations de l'utilisateur
                $insertUser->execute([
                    'email' => $this->email,
                    'firstname' => $this->firstname,
                    'lastname' => $this->lastname,
                    'password' => $res->password,
                    'id' => $this->id
                ]);
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
        // Récupartion des informations de l'utilisateurs
        $request = $bdd->prepare("SELECT * FROM users WHERE id = :id");
        $request->execute(['id' => $this->id]);
        $res = $request->fetch(PDO::FETCH_OBJ);
        $insertUser = $bdd->prepare("UPDATE users SET password = :password WHERE id = :id ");
        // La sécurité empêche que les champs soient VIDES
        if (isEmpty($old_password)) {
            $error = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe champ Password est vide';
            return $error;
        } elseif (isEmpty($this->password)) {
            $error = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe champ New Password est vide';
            return $error;
        }
        // Vérification du mot de passe 
        elseif ($old_password == $this->password) {
            $error = '<i class="fa-solid fa-circle-exclamation"></i>&nbspLes mots de passe sont identiques';
            return $error;
        } elseif ($old_password != password_verify($old_password, $res->password)) {
            $error = '<i class="fa-solid fa-circle-exclamation"></i>&nbspCe n\'est pas le bon mot de passe';
            return $error;
        } else {
            // Mise à jour du mot de passe
            $insertUser->execute([
                'password' => password_hash($this->password, PASSWORD_DEFAULT),
                'id' => $this->id
            ]);
            $_SESSION['user']->password = $this->password;
            header('Location:../profil.php');
        }
    }
    public function disconnect()
    {
        unset($_SESSION['user']);
    }

    public function isConnected(): bool
    {
        if (isset($_SESSION['user']->login)) {
            return true;
        } else {
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
