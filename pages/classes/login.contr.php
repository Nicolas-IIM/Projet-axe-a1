<?php

class LoginContr extends login {

    private $uid;
    private $pwd;
    public function __construct($uid, $pwd, ) {
        $this->uid = $uid;
        $this->pwd = $pwd;
    }


    public function loginUser(){
        if($this->emptyInput() == false){
            header("location: ../register.php?error=emptyinput"); // https://youtu.be/BaEm2Qv14oU?t=2584
        }


        $this->getUser($this->uid, $this->pwd);

    }

    private function emptyInput(){ // regarde si un champs est vide et si c'est le cas retourne false
        $result;
        if(empty($this->uid) || empty($this->pwd)) {
            $result = false;

        }
        else{
            $result = true;
        }
        return $result;
    }





}