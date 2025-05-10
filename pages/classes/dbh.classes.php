<?php

class Dbh {

    protected function connect() {
        try {
            $username = "root";
            $password = "root";
            $dbh = new PDO('mysql:host=localhost;dbname=musicard', $username, $password ); // connexion a la bdd
            return $dbh;


        }
        catch (PDOException $e) { // https://youtu.be/BaEm2Qv14oU?list=LL&t=1608
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }

    }








}