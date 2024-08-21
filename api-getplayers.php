<?php
require "config.php";
require "api-config.php";


$apiKey = API_KEY;
$apiUrl = 'https://v3.football.api-sports.io/players/squads?team=160';

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $apiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'x-apisports-key: ' . API_KEY,
    'x-rapidapi-host: v3.football.api-sports.io'
));

$response = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
} else {
    $players = json_decode($response, true);
    
    // Print the entire API response for debugging
    echo "<pre>";
    print_r($players);
    echo "</pre>";

    if(isset($players['response'][0]['players'])) {
        foreach($players['response'][0]['players'] as $player) {
            $playerId = $player['id'];
            $number = isset($player['number']) ? $player['number'] : 'NULL'; // Handle null numbers
            $name = $player['name'];
            $position = $player['position'];

            $sql = 'INSERT INTO players (player_id, number, name, position) VALUES ("'. $playerId . '", "' . $number . '", "' . $name . '", "' . $position . '")';
            
            if (!mysqli_query($conn, $sql)) {
                echo 'Error: ' . mysqli_error($conn);
            } else {
                echo "Successfully inserted player: $name <br>";
            }
        }
    } else {
        echo "No players found in API response.";
    }
}
curl_close($ch);


