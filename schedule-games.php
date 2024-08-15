<?php
require "config.php";
require "api-config.php";

$currentDateTime = date('Y-m-d');

$apiKey = API_KEY;
$teamId = '160';
$apiUrl = 'https://v3.football.api-sports.io/fixtures';

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, 'https://v3.football.api-sports.io/fixtures?team=160&from=' . $currentDateTime . '&to=2025-06-30&season=2024&timezone=Europe/Berlin');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'x-apisports-key: ' . API_KEY,
    'x-rapidapi-host: v3.football.api-sports.io'
));

$response = curl_exec($ch);

if(curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
} else {
    $games = json_decode($response, true);
    foreach($games['response'] AS $game){
        $matchId = $game['fixture']['id'];
        $dateTime = $game['fixture']['date'];
        $homeTeam = $game['teams']['home']['name'];
        $awayTeam = $game['teams']['away']['name'];

        $sql = 'INSERT INTO sc_freiburg_matches (match_id, date, homeTeam, awayTeam) VALUES ("'. $matchId . '", "' . $dateTime . '", "' . $homeTeam . '", "' . $awayTeam . '")';
        if(!mysqli_query($conn, $sql)){
            echo 'Error: ' . mysqli_error($conn);
        }
    }
}

curl_close($ch);

