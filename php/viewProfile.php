<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
</head>

<body>
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
                    <li><a href="/statstask/main.html" class="nav-link px-2 text-secondary">Stat tracker</a></li>
                    <li><a href="/statstask/php/forum.php" class="nav-link px-2 text-white">Forum</a></li>
                </ul>

                <div class="text-end">
                    <a href="/statstask/login.html" id="loginButton">
                        <button type="button" class="btn btn-outline-light me-2">Login</button>
                    </a>
                    <a href="/statstask/register.html" id="registerButton">
                        <button type="button" class="btn btn-warning">Sign-up</button>
                    </a>
                    <a href="/statstask/php/logout.php" id="logoutButton">
                        <button type="button" class="btn btn-outline-light me-2">Log out</button>
                    </a>
                    <a href="/statstask/edit.html" id="editButton">
                        <button type="button" class="btn btn-outline-light me-2">Edit</button>
                    </a>
                </div>
            </div>
        </div>
    </header>

    <div class="container-fluid mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <?php
                        // Get the user ID from the URL parameter
                        $userId = $_GET['id'];

                        // Fetch user details from the database
                        $con = mysqli_connect('localhost', getenv('DB_USER_NAME'), getenv('DB_USER_PASS'), 'userdata');
                        $result = mysqli_query($con, "SELECT * FROM credentials WHERE id = $userId");
                        $user = mysqli_fetch_assoc($result);

                        if ($user) {
                            $username = $user['username'];
                            $email = $user['email'];
                            $createdOn = $user['createdOn'];

                            echo '<h1 class="card-title">' . $username . '</h1>';
                            echo '<p class="card-text">Email: ' . $email . '</p>';
                            echo '<p class="card-text">Joined on: ' . $createdOn . '</p>';

                            // Check if user has a row in third_party_user_accounts table
                            $thirdPartyAccountResult = mysqli_query($con, "SELECT * FROM third_party_user_accounts WHERE user_id = $userId LIMIT 1");
                            $thirdPartyAccount = mysqli_fetch_assoc($thirdPartyAccountResult);

                            if ($thirdPartyAccount) {
                                $thirdPartyAccountId = $thirdPartyAccount['id'];

                                // Fetch the latest rank data from user_ranks_apex
                                $latestRankResult = mysqli_query($con, "SELECT * FROM user_ranks_apex WHERE third_party_user_account_id = $thirdPartyAccountId ORDER BY id DESC LIMIT 1");
                                $latestRank = mysqli_fetch_assoc($latestRankResult);

                                if ($latestRank) {
                                    $rankName = $latestRank['rank'];
                                    $rankDivision = $latestRank['rank_division'];
                                    $rankImageLink = $latestRank['rank_image_link'];
                                    $rankPoints = $latestRank['ranked_points'];

                                    // Determine the user's position in the forum based on ranked_points
                                    $userPositionQuery = "SELECT COUNT(*) AS position FROM (
                                        SELECT DISTINCT t1.third_party_user_account_id
                                        FROM user_ranks_apex AS t1
                                        INNER JOIN (
                                            SELECT MAX(id) AS max_id, third_party_user_account_id
                                            FROM user_ranks_apex
                                            GROUP BY third_party_user_account_id
                                        ) AS t2 ON t1.id = t2.max_id
                                        WHERE t1.ranked_points > $rankPoints
                                        AND t1.third_party_user_account_id <> $thirdPartyAccountId
                                    ) AS subquery";

                                    $userPositionResult = mysqli_query($con, $userPositionQuery);
                                    $userPosition = mysqli_fetch_assoc($userPositionResult)['position'] + 1;

                                    echo "<hr>";
                                    echo "<h3>Rank Data:</h3>";
                                    echo "<p>Place in forum: #$userPosition</p>";
                                    echo "<p>Rank: $rankName</p>";
                                    echo "<p>Division: $rankDivision</p>";
                                    echo "<p>Ranked Points (RP): $rankPoints</p>";
                                    echo "<img style='width: 150px; height: 150px' src='$rankImageLink' alt='Rank Image'>";
                                } else {
                                    echo "<p>No rank data available.</p>";
                                }
                            } else {
                                echo "<p>No third-party user accounts found.</p>";
                            }
                        } else {
                            echo '<p>User not found.</p>';
                        }

                        // Fetch third-party user accounts
                        $userAccounts = mysqli_query($con, "SELECT * FROM third_party_user_accounts WHERE user_id = $userId");
                        if ($userAccounts && mysqli_num_rows($userAccounts) > 0) {
                            echo "<hr>";
                            echo "<h3>Third-Party User Accounts:</h3>";
                            echo "<ul>";
                            while ($account = mysqli_fetch_assoc($userAccounts)) {
                                $gameId = $account['game_id'];
                                $gameResult = mysqli_query($con, "SELECT name FROM games WHERE id = $gameId");
                                $game = mysqli_fetch_assoc($gameResult)['name'];
                                $accountUsername = $account['username'];
                                echo "<li>$game: $accountUsername</li>";
                            }
                            echo "</ul>";
                        }
                        ?>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-dzi5jc6qrMznODSjgTzOqcGjL6G3aaj2Lwr/3/loIcaxcj4XoYZ+RD/CsYYr43Rm" crossorigin="anonymous"></script>
    <script src="/statstask/scripts/headerCheck.js" type="text/javascript"></script>
</body>

</html>