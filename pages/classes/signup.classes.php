<?php

class Signup extends Dbh{

    protected function setUser($uid,$pwd ,$email){ // preparation de l'ajout de la personne dans la bdd
        $stmt = $this->connect()->prepare("INSERT INTO users (usersUid, usersPwd, usersEmail) VALUES(?, ?, ?)");

        $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT); // hashage du mot de passe


        if(!$stmt->execute(array($uid,$hashedPwd ,$email))){
            $stmt = null;
            header("location: ../register.php?error=stmtfailed");
            exit();
        }
        $stmt = null;

    }

    protected function checkUser($uid, $email){
        $stmt = $this->connect()->prepare('SELECT usersUid FROM users WHERE usersUid = ? OR usersEmail = ?;'); // regarde si le pseudo ou l'email est deja dans la bdd

        if(!$stmt->execute(array($uid, $email))){
            $stmt = null;
            header("location: ../register.php?error=stmtfailed");
            exit();
        }
        $resultCheck;
        if($stmt->rowCount() > 0){
            $resultCheck = false;
        }
        else{
            $resultCheck = true;
        }
        return $resultCheck;


    }


}