<?php
session_start();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Music App</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<?php
if (isset($_SESSION["useruid"])) {
    echo "<p>connecter sous " . $_SESSION["useruid"] . "</p>";

} else {
    echo "non connecté.";
}
?>


<div class="login">
    <form action="includes/login.inc.php" method="post">
        <h2 class="h2-connextion">Connextion</h2>
        <label for="username">Nom d'utilisateur ou email:</label>
        <input type="text" id="username" name="username" required class="input">

        <label for="password">Mot de passe:</label>
        <input type="password" id="password" name="password" required class="input">

        <input type="submit" name="submit" value="Se connecter" class="button-connextion">
    </form>
    <p class="info-longin-register">Pas encore de compte ? <a class="info-longin-register-link" href="register.php">Inscrivez-vous ici </a></p>
    <p> <a href="includes/logout.inc.php">logout </a></p>

</div>

