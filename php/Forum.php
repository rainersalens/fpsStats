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
                    <li><a href="/statstask//main.html" class="nav-link px-2 text-secondary">Stat tracker</a></li>
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
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-4">
                <div style="border: 1px solid black; padding: 20px; height: 320px;">
                    <h4 class="text-center">Discussion types</h4>
                    <div style="overflow-y: scroll; height: 200px;">
                        <?php
                        // Fetch discussion types from the database
                        $con = mysqli_connect('localhost', getenv('DB_USER_NAME'), getenv('DB_USER_PASS'), 'userdata');
                        $result = mysqli_query($con, "SELECT * FROM discussion_types");
                        while ($row = mysqli_fetch_assoc($result)) {
                            $name = $row['name'];
                            $createdDate = $row['created_at'];
                            echo "<p>$name - $createdDate</p>";
                        }
                        mysqli_close($con);
                        ?>
                    </div>
                    <?php
                    // Check user privilege and show the "Edit Discussion Types" button if admin
                    if (isset($_COOKIE['userPrivilege']) && $_COOKIE['userPrivilege'] == 'admin') {
                        echo '<a href="/statstask/php/editDiscussionTypes.php" class="btn btn-primary mt-3">Edit Discussion Types</a>';
                    }
                    ?>
                </div>
            </div>
            <div class="col-md-8">
                <div style="border: 1px solid black; padding: 20px; height: 300px;">
                    <h4 class="text-center">New discussion</h4>
                    <?php
                    // Fetch discussion types from the database
                    $con = mysqli_connect('localhost', getenv('DB_USER_NAME'), getenv('DB_USER_PASS'), 'userdata');
                    $query = "SELECT * FROM discussion_types";
                    $result = mysqli_query($con, $query);
                    ?>
                    <form action="/statstask/php/newDiscussion.php" method="GET">
                        <div class="mb-3">
                            <label for="discussionType" class="form-label">Discussion type:</label>
                            <select name="discussionType" id="discussionType" class="form-select">
                                <?php
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $id = $row['id'];
                                    $name = $row['name'];
                                    echo "<option value='$id'>$name</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="discussionName" class="form-label">Discussion name:</label>
                            <input type="text" name="discussionName" id="discussionName" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-primary" name="submit">Create discussion</button>
                    </form>
                    <?php mysqli_close($con); ?>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-12">
                <div style="border: 1px solid black; padding: 20px; height: 300px; overflow-y: scroll;">
                    <h4 class="text-center">Discussions</h4>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>User</th>
                                <th>Title</th>
                                <th>Type</th>
                                <th>Created At</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Fetch discussions from the database
                            $con = mysqli_connect('localhost', getenv('DB_USER_NAME'), getenv('DB_USER_PASS'), 'userdata');
                            $query = "SELECT * FROM discussions";
                            $result = mysqli_query($con, $query);

                            while ($row = mysqli_fetch_assoc($result)) {
                                $discussionId = $row['id'];
                                $userId = $row['user_id'];
                                $title = $row['title'];
                                $type = $row['discussion_type'];
                                $createdAt = $row['created_at'];

                                // Fetch username and discussion type name from related tables
                                $userResult = mysqli_query($con, "SELECT username FROM credentials WHERE id = $userId");
                                $userRow = mysqli_fetch_assoc($userResult);
                                $username = $userRow ? $userRow['username'] : '(Deleted User)';

                                $typeResult = mysqli_query($con, "SELECT name FROM discussion_types WHERE id = $type");
                                $typeRow = mysqli_fetch_assoc($typeResult);
                                $typeName = $typeRow ? $typeRow['name'] : '(Deleted Type)';

                                // Output a row in the table for each discussion
                                echo "<tr>";
                                echo "<td>$username</td>";
                                echo "<td>$title</td>";
                                echo "<td>$typeName</td>";
                                echo "<td>$createdAt</td>";
                                echo "<td><a href='/statstask/php/viewDiscussion.php?id=$discussionId' class='btn btn-primary'>View</a></td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="/statstask/scripts/cookieCheckNotLoggedIn.js" type="text/javascript"></script>
    <script src="/statstask/scripts/headerCheck.js" type="text/javascript"></script>

</body>

</html>