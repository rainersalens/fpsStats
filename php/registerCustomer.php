<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
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
                    <li><a href="/statstask/main.html" class="nav-link px-2 text-secondary">Stat tracker</a></li>
                    <li><a href="/statstask/php/forum.php" class="nav-link px-2 text-secondary">Forum</a></li>
                </ul>

                <div class="text-end">
                    <a href="/statstask/login.html">
                        <button type="button" class="btn btn-outline-light me-2">Login</button>
                    </a>
                    <a href="/statstask/register.html">
                        <button type="button" class="btn btn-warning">Sign-up</button>
                    </a>
                </div>
            </div>
        </div>
    </header>
    <div class="container">
        <?php
        $con = mysqli_connect('localhost', getenv('DB_USER_NAME'), getenv('DB_USER_PASS'), 'userdata');

        // Check if any of the form fields are empty
        $username = $_POST['usernreg'];
        $email = $_POST['emailreg'];
        $password = $_POST['passreg'];

        if (empty($username) || empty($email) || empty($password)) {
            echo '<h2 class="text-center">Please fill in all the required fields.</h2>';
            echo '<div class="text-center">
                    <a href="/statstask/register.html">
                        <button type="button" class="btn btn-primary">Go back</button>
                    </a>
                </div>';
        } else {
            // Check if the username already exists
            $usernameQuery = "SELECT * FROM `credentials` WHERE `username` = '$username'";
            $usernameResult = mysqli_query($con, $usernameQuery);
            if (mysqli_num_rows($usernameResult) > 0) {
                echo '<h2 class="text-center">Username already exists. Please choose a different one.</h2>';
            } else {
                // Check if the email already exists
                $emailQuery = "SELECT * FROM `credentials` WHERE `email` = '$email'";
                $emailResult = mysqli_query($con, $emailQuery);
                if (mysqli_num_rows($emailResult) > 0) {
                    echo '<h2 class="text-center">Email already exists. Please choose a different one.</h2>';
                } else {
                    // Insert the new user data into the database
                    $sql = "INSERT INTO `credentials` (`username`, `email`, `password`) VALUES ('$username', '$email', '$password')";
                    $insertResult = mysqli_query($con, $sql);
                    if ($insertResult) {
                        echo '<h2 class="text-center">Customer registered</h2>';
                        echo '<div class="text-center">
                                <a href="/statstask/login.html">
                                    <button type="button" class="btn btn-primary">Go to main page</button>
                                </a>
                            </div>';
                    } else {
                        echo '<h2 class="text-center">An error occurred. Please try again later.</h2>';
                        echo '<div class="text-center">
                                <a href="/statstask/register.html">
                                    <button type="button" class="btn btn-primary">Go back</button>
                                </a>
                            </div>';
                    }
                }
            }
        }
        ?>
    </div>
</body>

</html>
