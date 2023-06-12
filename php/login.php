<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
                    <li><a href="/statstask//index.html" class="nav-link px-2 text-secondary">Home/About</a></li>
                    <li><a href="/statstask//main.html" class="nav-link px-2 text-secondary">Stat tracker</a></li>
                    <li><a href="/statstask/php/forum.php" class="nav-link px-2 text-secondary">Forum</a></li>
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

    <div class="container">

        <?php
        $con = mysqli_connect('localhost', getenv('DB_USER_NAME'), getenv('DB_USER_PASS'), 'userdata');

        $username = $_POST['usernlog'];
        $password = $_POST['passlog'];

        $sql = "SELECT * FROM `credentials` WHERE username = '$username' AND password = '$password'";

        $result = mysqli_query($con, $sql);

        $num_rows = mysqli_num_rows($result);
        try {
            $result = mysqli_query($con, $sql);
            if ($num_rows == 1) {
                $row = mysqli_fetch_assoc($result);
                $privilege = $row['privilege'];
                $userId = $row['id']; // Get the user ID

                // Set the cookie for userId
                $cookie_name_userId = "userId";
                $cookie_value_userId = $userId;
                setcookie($cookie_name_userId, $cookie_value_userId, time() + (86400), "/"); // 24h validity

                $cookie_name = "userName";
                $cookie_value = $username;
                setcookie($cookie_name, $cookie_value, time() + (86400), "/"); // 24h validity

                $cookie_name_privilege = "userPrivilege";
                $cookie_value_privilege = $privilege;
                setcookie($cookie_name_privilege, $cookie_value_privilege, time() + (86400), "/"); // 24h validity

                echo '<h2 class="text-center">Successfully logged in</h2>';
                echo '<div class="text-center"> <a class="btn btn-primary" href="/statstask/index.html" role="button">Back to main page</a> </div>';
            } elseif ($num_rows == 0) {
                echo '<h2 class="text-center">Wrong credentials</h2>';
            } else {
                echo '<h2 class="text-center">An error occurred.</h2>';
            }
        } catch (exception $e) {
            echo '<h2 class="text-center">An error occurred.</h2>';
        }
        ?>
    </div>
</body>
<script src="/statstask/scripts/headerCheck.js" type="text/javascript"></script>

</html>
