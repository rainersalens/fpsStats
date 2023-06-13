<?php
require "functions.php";
$game = $_POST['chooseGame'];
$username = $_POST['apexUserName'];
$platform = strtoupper($_POST['platform']);

$endPoint = 'https://api.mozambiquehe.re/bridge';
$authHeader = getenv('APEX_LEGENDS_API_KEY');
$headers = [
    "Authorization: $authHeader",
];
$data = array(
    'player' => $username,
    'platform' => $platform,
);

$json = callApi('GET', $endPoint, $headers, $data);
$response = json_decode($json, true);

// Check if the API response is valid and does not contain an error
if (isset($response['Error'])) {
    $errorMessage = "No player found on the platform.";
} elseif (isset($response['global'])) {
    $playerName = $response['global']['name'];
    $avatarUrl = $response['global']['avatar'];
    $platform = $response['global']['platform'];
    $level = isset($response['global']['level']) ? $response['global']['level'] : '';
    $toNextLevelPercent = isset($response['global']['toNextLevelPercent']) ? $response['global']['toNextLevelPercent'] : '';

    // Ban information
    $banIsActive = isset($response['global']['bans']['isActive']) ? $response['global']['bans']['isActive'] : false;
    $banRemainingSeconds = isset($response['global']['bans']['remainingSeconds']) ? $response['global']['bans']['remainingSeconds'] : 0;
    $lastBanReason = isset($response['global']['bans']['last_banReason']) ? getBanReasonText($response['global']['bans']['last_banReason']) : '';

    // Player rank information
    $rankScore = isset($response['global']['rank']['rankScore']) ? $response['global']['rank']['rankScore'] : '';
    $rankName = isset($response['global']['rank']['rankName']) ? $response['global']['rank']['rankName'] : '';
    $rankDiv = isset($response['global']['rank']['rankDiv']) ? $response['global']['rank']['rankDiv'] : '';
    $rankImg = isset($response['global']['rank']['rankImg']) ? $response['global']['rank']['rankImg'] : '';

    // Check if the user has a saved entry for Apex in third_party_user_accounts
    $con = mysqli_connect('localhost', getenv('DB_USER_NAME'), getenv('DB_USER_PASS'), 'userdata');
    $userAccounts = mysqli_query($con, "SELECT * FROM third_party_user_accounts WHERE username = '$username' AND game_id = (SELECT id FROM games WHERE name = 'Apex Legends') LIMIT 1");

    if ($userAccounts && mysqli_num_rows($userAccounts) > 0) {
        // Entry found, create an entry in the user_ranks_apex table
        $accountData = mysqli_fetch_assoc($userAccounts);
        $thirdPartyAccountId = $accountData['id'];

        // Insert values into the user_ranks_apex table
        $sql = "INSERT INTO user_ranks_apex (third_party_user_account_id, rank, rank_division, rank_image_link) VALUES ('$thirdPartyAccountId', '$rankName', '$rankDiv', '$rankImg')";
        mysqli_query($con, $sql);
    }
} else {
    // Handle error when the API response is invalid or missing necessary data
    $errorMessage = "No data found for player on the platform.";
}

function getBanReasonText($banReason)
{
    // Replace underscores with spaces and capitalize first letters
    $formattedReason = ucwords(str_replace('_', ' ', $banReason));

    return $formattedReason;
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stats</title>
</head>

<body>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">

    <div class="b-example-divider"></div>

    <header class="p-3 text-bg-dark">
        <div class="container">
            <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
                <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
                    <svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap">
                        <use xlink:href="#bootstrap" />
                    </svg>
                </a>

                <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                    <li><a href="/statstask//index.html" class="nav-link px-2 text-secondary">Home/About</a></li>
                    <li><a href="/statstask//main.html" class="nav-link px-2 text-white">Stat tracker</a></li>
                    <li><a href="/statstask/php/forum.php" class="nav-link px-2 text-secondary">Forum</a></li>
                </ul>

                <div class="text-end">
                    <a href="/statstask/login.html" id="loginButton">
                        <button type="button" class="btn btn-outline-light me-2">Login</button>
                    </a>
                    <a href="/statstask/register.html" id="registerButton">
                        <button type="button" class="btn btn-warning">Sign-up</button>
                    </a>
                    <a href="php/logout.php" id="logoutButton">
                        <button type="button" class="btn btn-outline-light me-2">Log out</button>
                    </a>
                    <a href="/statstask/edit.html" id="editButton">
                        <button type="button" class="btn btn-outline-light me-2">Edit</button>
                    </a>
                </div>
            </div>
        </div>
    </header>

    <?php if (isset($errorMessage)) : ?>
        <div class="container">
            <h2 class="text-center"><?= $errorMessage ?></h2>
        </div>
    <?php else : ?>
        <h2 class="text-center">Stats for player <q><?= $playerName ?></q> in game - <?= $game ?></h2>

        <div class="container">
            <!-- Add player information -->
            <div class="player-info">
                <img src="<?= $avatarUrl ?>" alt="Avatar" width="50" height="50">
                <div>
                    <p>Player: <?= $playerName ?></p>
                    <p>Platform: <?= $platform ?></p>
                    <p>
                        Level: <?= $level ?>
                        (<?= $toNextLevelPercent ?>% progress to next level)
                    </p>
                    <p>Last Ban Reason: <?= $lastBanReason ?></p>
                    <p>Ban info: <?= $banIsActive ? 'Active' : 'Not active' ?></p>
                    <?php if ($banIsActive) : ?>
                        <p>Remaining Ban Seconds: <?= $banRemainingSeconds ?></p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Add player rank information -->
            <div class="player-rank">
                <hr>
                <p>Ranked Points (RP): <?= $rankScore ?></p>
                <p>Rank: <?= $rankName ?></p>
                <p>Rank Division: <?= $rankDiv ?></p>
                <img src="<?= $rankImg ?>" alt="Rank Image" style="width: 150px; height: 150px;">
                <hr>
            </div>

            <table class="table" id="tbstyle">
                <tbody>
                    <tr>
                        <th>Legend</th>
                        <th>Kills</th>
                    </tr>

                    <?php
                    $all = $response['legends']['all'];
                    foreach ($all as $area => $areaName) {
                        if (isset($areaName['data'])) {
                            foreach ($areaName['data'] as $properties => $propertyValue) {
                                if ($propertyValue['key'] == 'kills') {
                    ?>
                                    <tr>
                                        <td>
                                            <?= $area ?>
                                        </td>
                                        <td>
                                            <?= $propertyValue['value'] ?>
                                        </td>
                                    </tr>
                    <?php
                                }
                            }
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>

    <script src="/statstask/scripts/headerCheck.js" type="text/javascript"></script>
</body>

</html>