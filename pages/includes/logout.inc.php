<?php

session_start();
session_unset();
session_destroy(); // logout

header("location: ../login.php"); // redirection vers la page de connexion

