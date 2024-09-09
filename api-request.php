<?php
require "config.php";
require "api-config.php";


$apiKey = API_KEY;
$teamId = '160';
$apiUrl = 'https://v3.football.api-sports.io/fixtures';

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, 'https://v3.football.api-sports.io/fixtures?team=160&from=2024-07-01&to=2025-06-30&season=2024&timezone=Europe/Berlin');
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
        $status = $game['fixture']['status']['long'];
        $homeScore = $game['goals']['home'];
        $awayScore = $game['goals']['away'];
        $seasonId = $game['league']['season'];

        $sql = 'SELECT FROM matches WHERE match_id = "' . $matchId . '"';
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) == 0) {
            $oldGame = mysqli_fetch_assoc($result);
        }
        if ($oldGame) {
            if($oldGame['status'] != $status ) {
                $sql = 'UPDATE matches SET 
                    date = "' . $dateTime . '", 
                    homeTeam = "' . $homeTeam . '", 
                    awayTeam = "' . $awayTeam . '", 
                    homeScore = "' . $homeScore . '", 
                    awayScore = "' . $awayScore . '", 
                    status = "' . $status . '", 
                    season_id = "' . $seasonId . '" 
                WHERE match_id = "' . $matchId . '"';
                if(!mysqli_query($conn, $sql)){
                    echo 'Error: ' . mysqli_error($conn);
                }
                if($status == 'Match Finished') {
                    
                }
         }
        
    }else{
        $sql = 'INSERT INTO matches (match_id, date, homeTeam, awayTeam, homeScore, awayScore, status, season_id) VALUES ("' . $matchId . '", "' . $dateTime . '", "' . $homeTeam . '", "' . $awayTeam . '", "' . $homeScore . '", "' . $awayScore . '", "' . $status . '", "' . $seasonId . '")';
        if(!mysqli_query($conn, $sql)){
            echo 'Error: ' . mysqli_error($conn);
        }
    }
}

curl_close($ch);


function saveMatchScorers($matchId, $apiKey) {

    $apiUrl = 'https://v3.football.api-sports.io/fixtures/events?fixture=' . $matchId;

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'x-apisports-key: ' . $apiKey,
        'x-rapidapi-host: v3.football.api-sports.io'
    ));

    $response = curl_exec($ch);
    curl_close($ch);

    if(curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
        return false;
    }

    $events = json_decode($response, true);

    if (!$events || !isset($events['response'])) {
        echo 'No events found for this match.';
        return false;
    }

    foreach($events['response'] as $event) {
        if ($event['type'] === 'Goal' && ($event['detail'] === 'Penalty' || $event['detail'] === 'Normal Goal')) {
            $playerId = $event['player']['id'];

            // Check if this goal is already saved to avoid duplicates
            $checkSql = 'SELECT * FROM scores WHERE match_id = "' . $matchId . '" AND player_id = "' . $playerId . '"';
            $checkResult = mysqli_query($conn, $checkSql);

            if (mysqli_num_rows($checkResult) == 0) {
                $insertSql = 'INSERT INTO scores (match_id, player_id) VALUES ("' . $matchId . '", "' . $playerId . '")';
                if(!mysqli_query($conn, $insertSql)) {
                    echo 'Error: ' . mysqli_error($conn);
                }
            }
        }
    }
}


{
    "get": "fixtures/events",
    "parameters": {
    "fixture": "215662"
    },
    "errors": [ ],
    "results": 18,
    "paging": {
    "current": 1,
    "total": 1
    },
    "response": [
    {
    "time": {
    "elapsed": 25,
    "extra": null
    },
    "team": {
    "id": 463,
    "name": "Aldosivi",
    "logo": "https://media.api-sports.io/football/teams/463.png"
    },
    "player": {
    "id": 6126,
    "name": "F. Andrada"
    },
    "assist": {
    "id": null,
    "name": null
    },
    "type": "Goal",
    "detail": "Normal Goal",
    "comments": null
    },
    {
    "time": {
    "elapsed": 33,
    "extra": null
    },
    "team": {
    "id": 442,
    "name": "Defensa Y Justicia",
    "logo": "https://media.api-sports.io/football/teams/442.png"
    },
    "player": {
    "id": 5936,
    "name": "Julio González"
    },
    "assist": {
    "id": null,
    "name": null
    },
    "type": "Card",
    "detail": "Yellow Card",
    "comments": null
    },
    {
    "time": {
    "elapsed": 33,
    "extra": null
    },
    "team": {
    "id": 463,
    "name": "Aldosivi",
    "logo": "https://media.api-sports.io/football/teams/463.png"
    },
    "player": {
    "id": 6126,
    "name": "Federico Andrada"
    },
    "assist": {
    "id": null,
    "name": null
    },
    "type": "Card",
    "detail": "Yellow Card",
    "comments": null
    },
    {
    "time": {
    "elapsed": 36,
    "extra": null
    },
    "team": {
    "id": 442,
    "name": "Defensa Y Justicia",
    "logo": "https://media.api-sports.io/football/teams/442.png"
    },
    "player": {
    "id": 5931,
    "name": "Diego Rodríguez"
    },
    "assist": {
    "id": null,
    "name": null
    },
    "type": "Card",
    "detail": "Yellow Card",
    "comments": null
    },
    {
    "time": {
    "elapsed": 39,
    "extra": null
    },
    "team": {
    "id": 442,
    "name": "Defensa Y Justicia",
    "logo": "https://media.api-sports.io/football/teams/442.png"
    },
    "player": {
    "id": 5954,
    "name": "Fernando Márquez"
    },
    "assist": {
    "id": null,
    "name": null
    },
    "type": "Card",
    "detail": "Yellow Card",
    "comments": null
    },
    {
    "time": {
    "elapsed": 44,
    "extra": null
    },
    "team": {
    "id": 463,
    "name": "Aldosivi",
    "logo": "https://media.api-sports.io/football/teams/463.png"
    },
    "player": {
    "id": 6262,
    "name": "Emanuel Iñiguez"
    },
    "assist": {
    "id": null,
    "name": null
    },
    "type": "Card",
    "detail": "Yellow Card",
    "comments": null
    },
    {
    "time": {
    "elapsed": 46,
    "extra": null
    },
    "team": {
    "id": 442,
    "name": "Defensa Y Justicia",
    "logo": "https://media.api-sports.io/football/teams/442.png"
    },
    "player": {
    "id": 35695,
    "name": "D. Rodríguez"
    },
    "assist": {
    "id": 5947,
    "name": "B. Merlini"
    },
    "type": "subst",
    "detail": "Substitution 1",
    "comments": null
    },
    {
    "time": {
    "elapsed": 62,
    "extra": null
    },
    "team": {
    "id": 463,
    "name": "Aldosivi",
    "logo": "https://media.api-sports.io/football/teams/463.png"
    },
    "player": {
    "id": 6093,
    "name": "Gonzalo Verón"
    },
    "assist": {
    "id": null,
    "name": null
    },
    "type": "Card",
    "detail": "Yellow Card",
    "comments": null
    },
    {
    "time": {
    "elapsed": 73,
    "extra": null
    },
    "team": {
    "id": 442,
    "name": "Defensa Y Justicia",
    "logo": "https://media.api-sports.io/football/teams/442.png"
    },
    "player": {
    "id": 5942,
    "name": "A. Castro"
    },
    "assist": {
    "id": 6059,
    "name": "G. Mainero"
    },
    "type": "subst",
    "detail": "Substitution 2",
    "comments": null
    },
    {
    "time": {
    "elapsed": 74,
    "extra": null
    },
    "team": {
    "id": 463,
    "name": "Aldosivi",
    "logo": "https://media.api-sports.io/football/teams/463.png"
    },
    "player": {
    "id": 6561,
    "name": "N. Solís"
    },
    "assist": {
    "id": 35845,
    "name": "H. Burbano"
    },
    "type": "subst",
    "detail": "Substitution 1",
    "comments": null
    },
    {
    "time": {
    "elapsed": 75,
    "extra": null
    },
    "team": {
    "id": 463,
    "name": "Aldosivi",
    "logo": "https://media.api-sports.io/football/teams/463.png"
    },
    "player": {
    "id": 6093,
    "name": "G. Verón"
    },
    "assist": {
    "id": 6396,
    "name": "N. Bazzana"
    },
    "type": "subst",
    "detail": "Substitution 2",
    "comments": null
    },
    {
    "time": {
    "elapsed": 79,
    "extra": null
    },
    "team": {
    "id": 463,
    "name": "Aldosivi",
    "logo": "https://media.api-sports.io/football/teams/463.png"
    },
    "player": {
    "id": 6474,
    "name": "G. Gil"
    },
    "assist": {
    "id": 6550,
    "name": "F. Grahl"
    },
    "type": "subst",
    "detail": "Substitution 3",
    "comments": null
    },
    {
    "time": {
    "elapsed": 79,
    "extra": null
    },
    "team": {
    "id": 442,
    "name": "Defensa Y Justicia",
    "logo": "https://media.api-sports.io/football/teams/442.png"
    },
    "player": {
    "id": 5936,
    "name": "J. González"
    },
    "assist": {
    "id": 70767,
    "name": "B. Ojeda"
    },
    "type": "subst",
    "detail": "Substitution 3",
    "comments": null
    },
    {
    "time": {
    "elapsed": 84,
    "extra": null
    },
    "team": {
    "id": 442,
    "name": "Defensa Y Justicia",
    "logo": "https://media.api-sports.io/football/teams/442.png"
    },
    "player": {
    "id": 6540,
    "name": "Juan Rodriguez"
    },
    "assist": {
    "id": null,
    "name": null
    },
    "type": "Card",
    "detail": "Yellow Card",
    "comments": null
    },
    {
    "time": {
    "elapsed": 85,
    "extra": null
    },
    "team": {
    "id": 463,
    "name": "Aldosivi",
    "logo": "https://media.api-sports.io/football/teams/463.png"
    },
    "player": {
    "id": 35845,
    "name": "Hernán Burbano"
    },
    "assist": {
    "id": null,
    "name": null
    },
    "type": "Card",
    "detail": "Yellow Card",
    "comments": null
    },
    {
    "time": {
    "elapsed": 90,
    "extra": null
    },
    "team": {
    "id": 442,
    "name": "Defensa Y Justicia",
    "logo": "https://media.api-sports.io/football/teams/442.png"
    },
    "player": {
    "id": 5912,
    "name": "Neri Cardozo"
    },
    "assist": {
    "id": null,
    "name": null
    },
    "type": "Card",
    "detail": "Yellow Card",
    "comments": null
    },
    {
    "time": {
    "elapsed": 90,
    "extra": null
    },
    "team": {
    "id": 463,
    "name": "Aldosivi",
    "logo": "https://media.api-sports.io/football/teams/463.png"
    },
    "player": {
    "id": 35845,
    "name": "Hernán Burbano"
    },
    "assist": {
    "id": null,
    "name": null
    },
    "type": "Card",
    "detail": "Red Card",
    "comments": null
    },
    {
    "time": {
    "elapsed": 90,
    "extra": null
    },
    "team": {
    "id": 463,
    "name": "Aldosivi",
    "logo": "https://media.api-sports.io/football/teams/463.png"
    },
    "player": {
    "id": 35845,
    "name": "Hernán Burbano"
    },
    "assist": {
    "id": null,
    "name": null
    },
    "type": "Card",
    "detail": "Yellow Card",
    "comments": null
    }
    ]
    }