<?php
session_start();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Music App</title>
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>

<div class="container">
    <nav class="sidebar">
        <div class="sidebar-section">
            <h2>Musicard</h2>
            <ul>
                <li> <a href="">🎵 Découverte</a></li>
                <li> <a href="/pages/recherhce.php">🔍 Recherche</a> </li>
                <li>🎙️ Podcast</li>
            </ul>
        </div>
        <div class="sidebar-section">
            <h2>Mon espace</h2>
            <ul>
                <li> <a href="/pages/profile.php">🎶 Mes musiques</a></li>
                <li>🖼️ Mes cover</li>
                <li><a href="/pages/add-msc.php">🎶 📦 Mes booster</a></li>
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
        <div class="greeting">
            <?php
            if (isset($_SESSION["useruid"])) {
                echo "<h1>Bonjour " . $_SESSION["useruid"] . " !</h1>";
            } else {
                echo "non connecté.";
            }
            ?>
            <p>Top picks for you, Updated daily.</p>
        </div>

        <div class="grid">
            <?php

            $client_id = 'd5bc92c7b4a14918b80ec3531ccb03c8';
            $client_secret = 'ea50e5278b7d4ab8ab1ce1149342f320';

            function get_Spotify($id, $secret) {
                $ch = curl_init('https://accounts.spotify.com/api/token');
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, 'grant_type=client_credentials');
                curl_setopt($ch, CURLOPT_HTTPHEADER, [
                    'Authorization: Basic ' . base64_encode($id . ':' . $secret),
                ]);
                $response = curl_exec($ch);
                curl_close($ch);
                $data = json_decode($response, true);
                return $data['access_token'];
            }

            function searchTracks($token, $query) {
                $url = 'https://api.spotify.com/v1/search?q=' . urlencode($query) . '&type=track&limit=30';
                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: Bearer ' . $token]);
                $response = curl_exec($ch);
                curl_close($ch);
                return json_decode($response, true);
            }


            $token = get_Spotify($client_id, $client_secret);
            $results = searchTracks($token, 'bad bunny');

            if (isset($results['tracks']['items'])) {
                foreach ($results['tracks']['items'] as $track) {
                    $img = $track['album']['images'][0]['url'] ?? '';
                    $name = $track['name'];
                    $album = $track['album']['name'];
                    $artists = implode(', ', array_column($track['artists'], 'name'));

                    echo "
                    <div class='card'>
                        <div class='placeholder-img' style='background-image: url(\"$img\"); background-size: cover; background-position: center;'></div>
                        <h3>$name</h3>
                        <p>$artists</p>
                    </div>
                    ";
                }
            } else {
                echo "<p>erreur</p>";
            }
            ?>
        </div>


    </main>
</div>

</body>
</html>
