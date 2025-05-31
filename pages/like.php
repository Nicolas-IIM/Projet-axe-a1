<?php
session_start();

$pdo = new PDO('mysql:host=localhost;dbname=musicard;charset=utf8', 'root', 'root');

$currentUserId = $_SESSION["userid"];

if (isset($_GET['id_track'])) {
    $id_track = $_GET['id_track'];
    $pdo->exec("UPDATE collection SET `like` = 1 WHERE id_trc_spotify = '$id_track' AND iduser = $currentUserId");
}

$result = $pdo->query("SELECT tracks.title_track, collection.id_trc_spotify, collection.like 
                       FROM collection 
                       JOIN tracks ON collection.id_trc_spotify = tracks.id_trc_spotify 
                       WHERE collection.iduser = $currentUserId");
$tracks = $result->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Like</title>
</head>
<body>
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

</body>
</html>
