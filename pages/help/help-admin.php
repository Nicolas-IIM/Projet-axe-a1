<?php

// meme code pour la librairei mais dadapter au formulaire de support / gestion des tickets

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

if(isset($_POST['submit-edit'])) {
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


$stmt = $pdo->query("SELECT * FROM ticket_support");
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

                        echo "<li>✨ Mon compte (" . $_SESSION["useruid"] . ")</li>";


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
        <h1>Mes tickets en BDD</h1>

        <table border="1">
            <thead>
            <th>Titre</th>
            <th>Email</th>
            <th>Rapport</th>
            <th>Supprimer</th>
            <th>Modifier</th>
            </thead>

            <tbody>

            <?php
            foreach ($tickets as $key => $ticket) {
                echo "<tr>";
                echo "<td>" . $ticket["titre_support"] . "</td>"; // affiche le titre
                echo "<td>" . $ticket["email_support"] . "</td>";
                echo "<td>" . $ticket["report_support"] . "</td>";
                echo "<td> <a href='?id_ticket=". $ticket["id_ticket"] . "&action=delete'> Supprimer </a> </td>";
                echo "<td> <a href='?id_ticket=". $ticket["id_ticket"] . "&action=modify'> Modifier </a> </td>";
                echo "</tr>";
            }
            ?>

            </tbody>
        </table>

        <br>
        <br>

        <form method="POST">
            <p>Formulaire de modification</p>

            <input type="hidden" name="id_ticket" value="<?php echo isset($ticket_to_edit) ? $ticket_to_edit["id_ticket"] : "" ?>">

            <label for="titre_support-edit">Titre:</label>
            <input type="text" name="titre_support-edit" id="titre_support-edit" placeholder="Titre"
                   value="<?php echo isset($ticket_to_edit) ? $ticket_to_edit["titre_support"] : "" ?>"> <!-- si ticket to edit est defini il affiche ticket to edit avec la valeur titre_support de la bdd sinon rien == "" -->

            <label for="email_support-edit">Email:</label>
            <input type="text" name="email_support-edit" id="email_support-edit" placeholder="Email"
                   value="<?php echo isset($ticket_to_edit) ? $ticket_to_edit["email_support"] : "" ?>">

            <label for="report_support-edit">Rapport:</label>
            <input type="text" name="report_support-edit" id="report_support-edit"
                   value="<?php echo isset($ticket_to_edit) ? $ticket_to_edit["report_support"] : "" ?>">

            <input type="submit" name="submit-edit" value="Modifier ticket">
        </form>

        <form method="POST">
            <p>Formulaire de création</p>

            <label for="titre_support">Titre:</label>
            <input type="text" name="titre_support" id="titre_support" placeholder="Titre">

            <label for="email_support">Email:</label>
            <input type="text" name="email_support" id="email_support" placeholder="Email">

            <label for="report_support">Rapport:</label>
            <input type="text" name="report_support" id="report_support">

            <input type="submit" name="submit" value="Créer ticket">
        </form>
    </main>
</div>


</body>
</html>