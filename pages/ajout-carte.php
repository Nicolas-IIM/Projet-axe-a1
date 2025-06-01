<?php
session_start();


if (!isset($_SESSION["userid"])) {
    header("Location: login.php");
    exit();
}

require_once("includes/connexion.php");

$user_accunt_id = $_SESSION["userid"];

if (isset($_POST['add'])) {
    $idTrcSpotify = $_POST['id_trc_spotify'];

    // verifie si la carte n est pas deja ajoutee
    $check = $pdo->prepare("SELECT id_trc_spotify FROM collection WHERE id_trc_spotify = ? AND iduser = ?");
    $check->execute([$idTrcSpotify, $user_accunt_id]);

    if ($check->rowCount() == 0) {
        $insert = $pdo->prepare("INSERT INTO collection (id_trc_spotify, iduser, `like`) VALUES (?, ?, 0)");
        $insert->execute([$idTrcSpotify, $user_accunt_id]);
        $message = "✅ Carte ajoutée à ta collection !";
    } else {
        $message = "⚠️ Cette carte est déjà dans ta collection.";
    }
}


?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Musicard - Ma collection</title>
    <link rel="stylesheet" href="../css/style.css"">
</head>
<body>

<div class="message">
    <?php

    if (isset($message)) {
        echo "<p>" . ($message) . "</p>";
    }
    ?>
</div>

<div class="ajout-de-carte">
    <section>
        <h2>Rechercher un morceau</h2>
        <form method="get" class="form-recherche">
            <input type="text" name="search" placeholder="Tape un titre..." required>
            <button type="submit">Rechercher</button>
        </form>

        <?php












        if (isset($_GET['search'])) {

            $search = $_GET['search'];

            $stmt = $pdo->prepare("SELECT * FROM tracks WHERE title_track LIKE ?");
            $stmt->execute(["%$search%"]);
            $tracks = $stmt->fetchAll(PDO::FETCH_ASSOC);

            echo "<h3>Résultats :</h3>";

            if (count($tracks) > 0) {

                foreach ($tracks as $track) {
                    echo "<div class='card'>";
                    echo "<p>" . ($track['title_track']) . "</p><br>";
                    echo "<p>Code admin </p> <p>" . ($track['id_trc_spotify']) . "</p><br>";
                    echo '<form method="post" style="margin-top:5px;">
                        <input type="hidden" name="id_trc_spotify" value="' . ($track['id_trc_spotify']) . '">
                        <button type="submit" name="add">Ajouter à ma collection</button>
                      </form>';
                    echo "</div>";
                }
            } else {
                echo "Aucun morceau trouvé.";
            }
        }
        ?>
    </section>




</div>