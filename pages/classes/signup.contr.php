<?php

class SignupContr extends signup
{

    private $uid;
    private $pwd;
    private $pwdRepeat; // class privé
    private $email;

    public function __construct($uid, $pwd, $pwdRepeat, $email)
    {
        $this->uid = $uid;
        $this->pwd = $pwd;
        $this->pwdRepeat = $pwdRepeat;
        $this->email = $email;
    }


    public function signupUser()
    {
        if ($this->emptyInput() == false) {
            header("location: ../register.php?error=emptyinput"); // https://youtu.be/BaEm2Qv14oU?t=2584
        }
        if ($this->invalidUid() == false) {
            header("location: ../register.php?error=usurname"); // redirection avec les erreurs
        }
        if ($this->invalidEmail() == false) {
            header("location: ../register.php?error=email");
        }
        if ($this->pwdMatch() == false) {
            header("location: ../register.php?error=passwordmatch");
        }
        if ($this->uidTakenCheck() == false) {
            header("location: ../register.php?error=useroremailtaken");
            exit();
        }

        $this->setUser($this->uid, $this->pwd, $this->email); //

    }

    private function emptyInput()
    {
        $result;
        if (empty($this->uid) || empty($this->pwd) || empty($this->pwdRepeat) || empty($this->email)) { // regarde si un champs est vide et si c'est le cas retourne false
            $result = false;

        } else {
            $result = true;
        }
        return $result;
    }

    private function invalidUid()
    {
        $result;
        if (!preg_match("/^[a-zA-Z0-9]+$/", $this->uid)) { // https://youtu.be/BaEm2Qv14oU?list=LL&t=1376
            $result = false; // regarde si le nom d'utilisateur est valide sans cara special
        } else {
            $result = true;
        }
        return $result;
    }

    private function invalidEmail()
    {
        $result;
        if (filter_var($this->email, FILTER_VALIDATE_EMAIL)) { // regare avec filter validate email que c'est une bonne contrtuction d'email
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }

    private function pwdMatch()
    {
        $result;
        if ($this->pwd == $this->pwdRepeat) { // regarde si le mdp et mdpreapeat sont les memes er retoune false si c'est le cas
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }

    private function uidTakenCheck()
    {
        $result;
        if (!$this->checkUser($this->uid, $this->email)) { // regarde si le pseudo est deja dans la bdd et retoune false si c'est dedans
            $result = false;
        } else {
            $result = true;
        }
        return $result;
    }


}