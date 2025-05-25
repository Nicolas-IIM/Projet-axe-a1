<?php


header('Content-Type: application/json; charset=utf-8');

$pdo = new PDO("mysql:host=localhost;dbname=musicard;charset=utf8mb4", "root", "root", [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);

$input = file_get_contents('php://input');

$track = json_decode($input, true);

if (!$track || !isset($track['id'], $track['name'], $track['album']['id'], $track['album']['name'])) {
    http_response_code(400);
    echo json_encode(['error'=>'Track invalide']);
    exit;
}


$alb_id_sp = $track['album']['id'];
$alb_title = $track['album']['name'];


$stmt = $pdo->prepare("SELECT id_album FROM albums WHERE id_alb_spotify = ?");
$stmt->execute([$alb_id_sp]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);


if ($row) {
    $id_album = $row['id_album'];

} else {
    $stmt = $pdo->prepare("INSERT INTO albums (title_album, id_alb_spotify) VALUES (?, ?)");
    $stmt->execute([$alb_title, $alb_id_sp]);
    $id_album = $pdo->lastInsertId();
}


$trc_id_sp = $track['id'];

$trc_title = $track['name'];


$stmt = $pdo->prepare("SELECT id_track FROM tracks WHERE id_trc_spotify = ?");
$stmt->execute([$trc_id_sp]);
if (!$stmt->fetch()) {
    $stmt = $pdo->prepare(
        "INSERT INTO tracks (title_track, id_album, id_trc_spotify)
       VALUES (?, ?, ?)"
    );

    $stmt->execute([$trc_title, $id_album, $trc_id_sp]);
}


