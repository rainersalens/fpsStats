<?php
require "functions.php";
$game = $_POST['chooseGame'];
$username = $_POST['fortniteUserName'];
$timeWindow = $_POST['fortniteTimeframe'];
$image = "all"; // Set the image parameter to "all"

if ($game == 'fortnite') {
    $endPoint = 'https://fortnite-api.com/v2/stats/br/v2';
    $authHeader = getenv('FORTNITE_API_KEY');
    $headers = [
        "Authorization: $authHeader",
    ];
    $data = array(
        'name' => $username,
        'accountType' => 'epic',
        'timeWindow' => $timeWindow,
        'image' => $image
    );
}

$json = callApi('GET', $endPoint, $headers, $data);
$response = json_decode($json, true);

// Check if the API response is valid and does not contain an error
if (isset($response['Error'])) {
    $errorMessage = "No player found on the platform.";
} elseif (isset($response['data']['image'])) {
    $image = $response['data']['image'];
} else {
    // Handle error when the API response is invalid or missing necessary data
    $errorMessage = "No data found for player on the platform.";
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">

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
                    <li><a href="/statstask/index.html" class="nav-link px-2 text-secondary">Home/About</a></li>
                    <li><a href="/statstask/main.html" class="nav-link px-2 text-white">Stat tracker</a></li>
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

    <div class="container">
        <?php if (isset($image)): ?>
            <img src="<?php echo $image; ?>" alt="Player Image">
        <?php else: ?>
            <p><?php echo $errorMessage; ?></p>
        <?php endif; ?>
    </div>

    <script src="/statstask/scripts/headerCheck.js" type="text/javascript"></script>
</body>

</html>
