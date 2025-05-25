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
    $url = 'https://api.spotify.com/v1/search?q=' . urlencode($query) . '&type=track&limit=21';
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: Bearer ' . $token]);
    $response = curl_exec($ch);
    curl_close($ch);
    return json_decode($response, true);
}

$q = isset($_GET['q']) ? trim($_GET['q']) : '';
if ($q === '') {
    http_response_code(400);
    echo json_encode(['error'=>'Paramètre q manquant']);
    exit;
}

try {
    // avoir le token
    $token = get_Spotify($client_id, $client_secret);




    $tracks = searchTracks($token, $q);

    // résultats
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($tracks);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error'=>'Token invalide']);
    exit;
}