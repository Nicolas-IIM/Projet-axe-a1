<?php

if(isset($_POST["submit"])){

    // recupere les données du formulaire
    $uid = $_POST["uid"];
    $pwd = $_POST["pwd"];
    $pwdRepeat = $_POST["pwdrepeat"];
    $email = $_POST["email"];

    // https://youtu.be/BaEm2Qv14oU?list=LL&t=1036

    // initialiser le controller
    include "../classes/dbh.classes.php";
    include "../classes/signup.classes.php";
    include "../classes/signup.contr.php";
    $signup = new SignupContr($uid, $pwd, $pwdRepeat, $email);

    // lancement des erreur dans singup.contr.php
    $signup->signupUser();

    // redirection
    header("location: ../register.php?compte=ok");
}
