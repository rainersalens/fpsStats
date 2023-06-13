<?php
// Connect to the database
$con = mysqli_connect('localhost', getenv('DB_USER_NAME'), getenv('DB_USER_PASS'), 'userdata');

// Check if the connection was successful
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch the list of games from the database
$query = "SELECT * FROM games";
$result = mysqli_query($con, $query);

if (!$result) {
    die("Error: " . mysqli_error($con));
}

$games = array();
while ($row = mysqli_fetch_assoc($result)) {
    $games[] = $row;
}

// Fetch the in-game nicknames for the logged-in user
$userId = $_COOKIE['userId']; // Assuming you have a cookie named 'userId' that stores the logged-in user's ID

$query = "SELECT tpu.id, tpu.username, tpu.user_id, tpu.game_id, g.name AS game_name
          FROM third_party_user_accounts AS tpu
          INNER JOIN games AS g ON tpu.game_id = g.id
          WHERE tpu.user_id = '$userId'";

$result = mysqli_query($con, $query);

if (!$result) {
    die("Error: " . mysqli_error($con));
}

$nicknames = array();
while ($row = mysqli_fetch_assoc($result)) {
    $nicknames[] = $row;
}

// Close the database connection
mysqli_close($con);

// Prepare the response as an array of games and associated nicknames
$response = array();
foreach ($games as $game) {
    $gameId = $game['id'];
    $gameName = $game['name'];

    // Find the nickname for the current game
    $nickname = '';
    foreach ($nicknames as $row) {
        if ($row['game_id'] == $gameId) {
            $nickname = $row['username'];
            break;
        }
    }

    // Add the game and nickname to the response
    $response[] = array(
        'game_id' => $gameId,
        'game_name' => $gameName,
        'nickname' => $nickname
    );
}

// Return the response as JSON
echo json_encode($response);
?>
