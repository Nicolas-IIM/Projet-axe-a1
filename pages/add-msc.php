<?php
session_start();
$pdo = new PDO('mysql:host=localhost;dbname=musicard;charset=utf8', 'root', 'root');
$currentUserId = $_SESSION["userid"];

if (isset($_GET['booster'])) {
    $stmt = $pdo->query("SELECT id_trc_spotify FROM tracks ORDER BY RAND() LIMIT 5"); // ajoute 5 morceau au hasard avec rand
    $randomTracks = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($randomTracks as $track) {
        $id_trc_spotify = $track['id_trc_spotify'];
        $pdo->exec("INSERT IGNORE INTO collection (id_trc_spotify, iduser, `like`) 
                    VALUES ('$id_trc_spotify', $currentUserId, 0)"); // erreur si pas de '' sur like
    }

    echo "✅ 5 morceaux sont ajoutés, merci de revenir demain !";
}
?>






<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Booster</title>
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
            <h1>Mes boosters</h1>
            <p>Vous pouvez ajouter 5 morceaux aléatoires par jour.</p>
        <section>
            <form method="get">
                <button type="submit" name="booster" value="1" class="button-connextion margin-10">Ajouter 5 morceaux aléatoires</button>
            </form>

        </section>





</body>
</html>













