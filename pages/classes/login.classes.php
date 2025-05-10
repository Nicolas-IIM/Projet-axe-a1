<?php

class Login extends Dbh{

    protected function getUser($uid,$pwd){
        $stmt = $this->connect()->prepare("SELECT usersPwd FROM users WHERE usersUid = ? OR usersEmail = ?");


        if(!$stmt->execute(array($uid, $uid))){ // https://youtu.be/BaEm2Qv14oU?t=3546
            $stmt = null;
            header("location: ../login.php?error=stmtfailed"); // redirection avec les erreurs
            exit();
        }

        $pwdHash = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if(count($pwdHash) == 0) {
            $stmt = null;
            header("location: ../login.php?error=usernotfound");
            exit();
        }



        $checkPdw = password_verify($pwd,$pwdHash[0]['usersPwd']); // https://youtu.be/BaEm2Qv14oU?t=3546

        if($checkPdw == false){
            $stmt = null;
            header("location: ../login.php?error=wrongpwd");
            exit();

        }
        elseif ($checkPdw == true){
            $stmt = $this->connect()->prepare("SELECT * FROM users WHERE usersUid = ? OR usersEmail = ? AND usersPwd = ?"); // preparation de la requete


            if (!$stmt->execute(array($uid, $uid, $pwdHash[0]['usersPwd']))) {

                $stmt = null;
                header("location: ../login.php?error=stmtfailed");
                exit();

            }

            $user = $stmt->fetchAll(PDO::FETCH_ASSOC);
            session_start();
            $_SESSION["userid"] = $user[0]["usersId"]; // recuperation de l'id de l'utilisateur
            $_SESSION["useruid"] = $user[0]["usersUid"];
        }

        $stmt = null;

    }


}

