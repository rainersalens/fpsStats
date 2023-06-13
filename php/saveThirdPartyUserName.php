<?php
// Connect to the database
$con = mysqli_connect('localhost', getenv('DB_USER_NAME'), getenv('DB_USER_PASS'), 'userdata');

// Check if the connection was successful
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Retrieve the game ID and new nickname from the AJAX request
$gameId = $_POST['gameId'];
$newNickname = $_POST['nickname'];
$userId = $_POST['userId'];

// Check if the nickname already exists for the given game
$query = "SELECT id FROM third_party_user_accounts WHERE game_id = '$gameId'";
$result = mysqli_query($con, $query);

if (!$result) {
    die("Error: " . mysqli_error($con));
}

if (mysqli_num_rows($result) > 0) {
    // Update the existing nickname for the game
    $row = mysqli_fetch_assoc($result);
    $accountId = $row['id'];

    $query = "UPDATE third_party_user_accounts SET username = '$newNickname' WHERE id = '$accountId'";
} else {
    // Insert a new nickname for the game
    $query = "INSERT INTO third_party_user_accounts (username, user_id, game_id) VALUES ('$newNickname', '$userId', '$gameId')";
}

// Execute the query to save the updated or new nickname
$result = mysqli_query($con, $query);

if (!$result) {
    die("Error: " . mysqli_error($con));
}

// Close the database connection
mysqli_close($con);

// Return a success response
http_response_code(200);
?>