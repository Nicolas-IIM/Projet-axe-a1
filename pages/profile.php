<?php
session_start();
try {
    $pdo = new PDO('mysql:host=localhost;dbname=musicard;charset=utf8', 'root', 'root');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
$currentUserId = $_SESSION["userid"];
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
            <h2 class="profile" >Mes cartes</h2>

            <?php
            $query = "SELECT tracks.title_track
          FROM collection
          INNER JOIN tracks ON collection.id_trc_spotify = tracks.id_trc_spotify
          WHERE collection.iduser = $currentUserId"; // pas le titre dans la bdd collenction

            $result = $pdo->query($query);
            $myCards = $result->fetchAll(PDO::FETCH_ASSOC);

            if ($myCards) {
                foreach ($myCards as $card) {
                    echo "<div class='card card-collection margin-10'>🎶 " . $card['title_track'] . "</div>";
                }
            } else {
                echo "Pas encore de cartes dans votre collection";
            }
            ?>
        </section>

        <section>
            <h2 class="profile" >Mes cartes liké</h2>

            <?php
            $query = "SELECT tracks.title_track
          FROM collection
          INNER JOIN tracks ON collection.id_trc_spotify = tracks.id_trc_spotify
          WHERE collection.iduser = $currentUserId AND collection.like = 1";

            $result = $pdo->query($query);
            $myCards = $result->fetchAll(PDO::FETCH_ASSOC);

            if ($myCards) {
                foreach ($myCards as $card) {
                    echo "<div class='card card-collection margin-10'>🎶 " . $card['title_track'] . "</div>";
                }
            } else {
                echo "Pas encore de cartes dans votre collection";
            }
            ?>
        </section>





</body>
</html>