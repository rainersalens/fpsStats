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
                            echo '<p class="card-text">Created On: ' . $createdOn . '</p>';
                        } else {
                            echo '<p>User not found.</p>';
                        }
                        $userAccounts = mysqli_query($con, "SELECT * FROM third_party_user_accounts WHERE user_id = $userId");
                        if ($userAccounts && mysqli_num_rows($userAccounts) > 0) {
                            echo "<hr>";
                            echo "<h3>Third-Party User Accounts:</h3>";
                            echo "<ul>";
                            while ($account = mysqli_fetch_assoc($userAccounts)) {
                                $gameId = $account['game_id'];
                                $gameResult = mysqli_query($con, "SELECT name FROM games WHERE id = $gameId");
                                $game = mysqli_fetch_assoc($gameResult)['name'];
                                echo "<li>$game: $username</li>";
                            }
                            echo "</ul>";
                        }

                        // Check if the user has rank data in user_ranks_apex
                        $userRanksResult = mysqli_query($con, "SELECT * FROM user_ranks_apex WHERE third_party_user_account_id IN (SELECT id FROM third_party_user_accounts WHERE user_id = $userId)");
                        if ($userRanksResult && mysqli_num_rows($userRanksResult) > 0) {
                            echo "<hr>";
                            echo "<h3>Rank Data:</h3>";
                            echo "<ul>";
                            while ($rank = mysqli_fetch_assoc($userRanksResult)) {
                                $rankName = $rank['rank'];
                                $rankDivision = $rank['rank_division'];
                                $rankImageLink = $rank['rank_image_link'];
                                echo "<li>Rank: $rankName</li>";
                                echo "<li>Division: $rankDivision</li>";
                                echo "<li><img src='$rankImageLink' alt='Rank Image'></li>";
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