<?php
session_start();

$pdo = new PDO('mysql:host=localhost;dbname=musicard;charset=utf8', 'root', 'root');

$currentUserId = $_SESSION["userid"];

if (isset($_GET['id_track'])) { // si l'url contient un id_track
    $id_track = $_GET['id_track'];
    $pdo->exec("UPDATE collection SET `like` = 1 WHERE id_trc_spotify = '$id_track' AND iduser = $currentUserId");
}

$result = $pdo->query("SELECT tracks.title_track, collection.id_trc_spotify, collection.like 
                       FROM collection 
                       JOIN tracks ON collection.id_trc_spotify = tracks.id_trc_spotify 
                       WHERE collection.iduser = $currentUserId");
$tracks = $result->fetchAll(PDO::FETCH_ASSOC); // pas le titre dans la bdd collenction
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Like</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>


<div class="container">
    <nav class="sidebar">
        <div class="sidebar-section">
            <h2>Musicard</h2>
            <ul>
                <li> <a href="../dashboard.php">🎵 Découverte</a></li>
                <li> <a href="recherhce.php">🔍 Recherche</a> </li>
                <li>🎙️ Podcast</li>
            </ul>
        </div>
        <div class="sidebar-section">
            <h2>Mon espace</h2>
            <ul>
                <li> <a href="profile.php">🎶 Mes musiques</a></li>
                <li>🖼️ Mes cover</li>
                <li><a href="add-msc.php">🎶 📦 Mes booster</a></li>
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
            <h2 >Mon compte</h2>
            <ul>
                <li>
                    <?php
                    if (isset($_SESSION["useruid"])) {
                        echo "<li>✨ Mon compte (" . $_SESSION["useruid"] . ")</li>";
                    } else {
                        echo "non connecté.";
                    }
                    ?>
                </li>
                <li class="sans-mise-en-forme-liens"><a href="pages/includes/logout.inc.php">✨ Déconnexion</a></li>
                <li class="sans-mise-en-forme-liens"><a href="pages/help/help.php">✨ Aide</a></li>
                <li>✨ Mes likes</li>

            </ul>
        </div>
    </nav>

    <main class="main-content">
        <div class="profile">
            <h2>Mon Profil</h2>
            <p>Bienvenue sur votre profil, <?php echo isset($_SESSION["useruid"]) ? $_SESSION["useruid"] : "Invité"; ?>!</p>
        </div>


        <section>
            <h1>Mes musique</h1>
            <?php
            echo "<table border='1'>";
            echo "<tr><th>Titre</th><th>Like</th></tr>";

            foreach ($tracks as $track) {
                echo "<tr>";
                echo "<td>" . $track['title_track'] . "</td>";
                echo "<td>";
                if ($track['like'] == 1) {
                    echo "❤️ Déjà liké";
                } else {
                    echo "<a href='?id_track=" . $track['id_trc_spotify'] . "'>Liker</a>";
                }
                echo "</td>";
                echo "</tr>";
            }

            echo "</table>";
            ?>
        </section>





        </body>
        </html>




