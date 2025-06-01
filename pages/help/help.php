<?php

// pas grand chose est utile mais c'est pour que le form s'envoie bien

require_once("../includes/connexion.php"); // me permet de récupérer ma connexion

if(isset($_POST['submit'])) { // si le formulaire de creation est soumis
    // var_dump($_POST);
    $titre_support = $_POST["titre_support"];
    $email_support = $_POST["email_support"];
    $report_support = $_POST["report_support"];

    try {

        $stmt = $pdo->prepare("INSERT INTO ticket_support (titre_support, email_support, report_support)
    VALUES( :titre_support, :email_support, :report_support )");

        $stmt->execute([ // execute la requête et evite les injections
            "titre_support" => $titre_support,
            "email_support" => $email_support,
            "report_support" => $report_support,
        ]);

    } catch (PDOException $e) { // si une erreur
        echo $e->getMessage();
    }
}

if(isset($_GET['action']) && $_GET['action'] == 'delete') { // si l'action est delete
    $id_ticket = $_GET['id_ticket'];

    try {
        $stmt = $pdo->prepare("DELETE FROM ticket_support WHERE id_ticket = :id_ticket"); // prépare

        $stmt->execute([ // execute
            "id_ticket" => $id_ticket,

        ])
        ;

        echo "Le ticket a bien été supprimé !";  // notif

    } catch (PDOException $e) { // erreur
        echo $e->getMessage();
    }
}


if(isset($_GET['action']) && $_GET['action'] == 'modify') { // si l'action est modify
    $id_ticket = $_GET['id_ticket']; // récupere l'id du ticket

    try {

        $stmt = $pdo->prepare("SELECT * FROM ticket_support WHERE id_ticket = :id_ticket");
        $stmt->execute([
            "id_ticket" => $id_ticket,


        ]);


        $ticket_to_edit = $stmt->fetch(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        echo $e->getMessage();


    }
}

if(isset($_POST['submit-edit'])) { // si le formulaire de modification est soumis
    $id_ticket = $_POST['id_ticket'];
    $titre_support = $_POST['titre_support-edit'];
    $email_support = $_POST['email_support-edit'];
    $report_support = $_POST['report_support-edit'];


    try {

        $stmt = $pdo->prepare("UPDATE ticket_support SET titre_support = :titre_support, email_support = :email_support, report_support = :report_support WHERE id_ticket = :id_ticket");

        $stmt->execute([
            "id_ticket" => $id_ticket,
            "titre_support" => $titre_support,
            "email_support" => $email_support,
            "report_support" => $report_support
        ]);

        echo "Le ticket a bien été modifié !";

    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

/////
///// SELECT
/////
$stmt = $pdo->query("SELECT * FROM ticket_support"); // PDO STATEMENT
$tickets = $stmt->fetchAll(PDO::FETCH_ASSOC);


?>






<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Music App</title>
    <link rel="stylesheet" href="../../css/style.css">
</head>

<?php
session_start();
?>
<body>

<div class="container">
    <nav class="sidebar">
        <div class="sidebar-section">
            <h2>Musicard</h2>
            <ul>
                <li class="sidebar-section-hover">🎵 Découverte</li>
                <li>🔍 Recherche</li>
                <li>🎙️ Podcast</li>
            </ul>
        </div>
        <div class="sidebar-section">
            <h2>Mon espace</h2>
            <ul>
                <li>🎶 Mes musiques</li>
                <li>🖼️ Mes cover</li>
                <li>📦 Mes booster</li>
            </ul>
        </div>
        <div class="sidebar-section">
            <h2>Autre</h2>
            <ul>
                <li>✨ Boutique</li>
                <li>✨ Marketplace</li>
                <li>✨ Rareté</li>
            </ul>
        </div>
        <div class="sidebar-section">
            <h2>Mon compte</h2>
            <ul>
                <li>
                    <?php
                    if (isset($_SESSION["useruid"])) {

                        echo "<li>✨ Mon compte (" . $_SESSION["useruid"] . ")</li>"; // affiche le nom de l'utilisateur


                    } else {
                        echo "non connecté.";
                    }
                    ?></li>
                <li class="sans-mise-en-forme-liens"><a href="pages/includes/logout.inc.php">✨ Déconnexion </a></li>
                <li class="sans-mise-en-forme-liens"><a href="pages/includes/logout.inc.php">✨ Aide </a></li>
                <li>✨ Mes likes</li>
            </ul>
        </div>
    </nav>


    <main class="main-content">
        <form method="POST">
            <p class="titre-help-creation">Formulaire de création de ticket</p>

            <label for="titre_support">Titre:</label>
            <input type="text" name="titre_support" id="titre_support" class="input-help" placeholder="Titre">


            <label for="email_support">Email:</label>
            <input type="text" name="email_support" id="email_support" placeholder="Email" class="input-help">


            <input type="text" name="report_support" id="report_support" class="input-text-report-help" class="input-help" placeholder="Decris ton problmeme ici...">

            <p>Merci davoir soumis un ticket !</p>
            <input type="submit" name="submit" value="Créer ticket" class="button-send-ticket">
        </form>
    </main>
</div>


</body>
</html>






