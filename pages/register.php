<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Music App</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<div class="login">
    <form action="includes/signup.inc.php" method="post">
        <h2 class="h2-connextion">Inscription</h2>


        <label for="uid">Nom d'utilisateur:</label>
        <input type="text" id="uid" name="uid" required class="input">

        <lable for="email">Email:</lable>
        <input type="text" id="email" name="email" required class="input">  <!--pas utile de mettre type email car l'utilisateur peux le changer -->

        <label for="pwd">Mot de passe:</label>
        <input type="password" id="pwd" name="pwd" required class="input">


        <label for="pwdrepeat">Répétez le mot de passe:</label>
        <input type="password" id="pwdrepeat" name="pwdrepeat" required class="input">

        <input type="submit" name="submit" value="Se connecter" class="button-connextion">
    </form>
    <p class="info-longin-register">Deja un compte ? <a class="info-longin-register-link" href="login.php">Connecte toi ici</a></p>

</div>

