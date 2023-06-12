<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main</title>
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
        if (isset($_COOKIE['userName'])) {
            unset($_COOKIE['userName']);
            setcookie('userName', null, -1, '/');
        }
        if (isset($_COOKIE['userPrivilege'])) {
            unset($_COOKIE['userPrivilege']);
            setcookie('userPrivilege', null, -1, '/');
        }
        if (isset($_COOKIE['userId'])) {
            unset($_COOKIE['userId']);
            setcookie('userId', null, -1, '/');
        }
        echo '<h2 class="text-center">Successfully logged out</h2>';
        ?>
    </div>
</body>

</html>
