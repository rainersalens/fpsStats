<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Discussion</title>
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
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Create a New Discussion</h5>
                        <form action="newDiscussion.php" method="POST">
                            <div class="mb-3">
                                <label for="discussionName" class="form-label">Discussion Title</label>
                                <input type="text" class="form-control" id="discussionName" name="discussionName" value="<?php echo isset($_GET['discussionName']) ? $_GET['discussionName'] : ''; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="discussionContent" class="form-label">Discussion Content</label>
                                <textarea class="form-control" id="discussionContent" name="discussionContent" rows="6"></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="discussionType" class="form-label">Discussion Type</label>
                                <select class="form-select" id="discussionType" name="discussionType" required>
                                    <?php
                                    // Fetch discussion types from the database
                                    $con = mysqli_connect('localhost', getenv('DB_USER_NAME'), getenv('DB_USER_PASS'), 'userdata');
                                    $result = mysqli_query($con, "SELECT * FROM discussion_types");
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $selected = isset($_GET['discussionType']) && $_GET['discussionType'] == $row['id'] ? 'selected' : '';
                                        echo '<option value="' . $row['id'] . '" ' . $selected . '>' . $row['name'] . '</option>';
                                    }
                                    mysqli_close($con);
                                    ?>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                        <?php
                        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                            if (!empty($_POST['discussionName']) && !empty($_POST['discussionContent'])) {
                                $con = mysqli_connect('localhost', getenv('DB_USER_NAME'), getenv('DB_USER_PASS'), 'userdata');
                                $discussionName = $_POST['discussionName'];
                                $discussionContent = isset($_POST['discussionContent']) ? $_POST['discussionContent'] : '';
                                $discussionType = $_POST['discussionType'];

                                // Escape the apostrophes in discussionName and discussionContent
                                $discussionName = mysqli_real_escape_string($con, $discussionName);
                                $discussionContent = mysqli_real_escape_string($con, $discussionContent);

                                // Get the user ID from the session or wherever it is stored
                                $userId = $_COOKIE['userId'];

                                $date = date('Y-m-d H:i:s');
                                $pinned = 0; // Assuming initially the discussion is not pinned

                                $sql = "INSERT INTO discussions (title, content, created_at, pinned, user_id, discussion_type) 
                VALUES ('$discussionName', '$discussionContent', '$date', $pinned, $userId, '$discussionType')";

                                if (mysqli_query($con, $sql)) {
                                    $discussionId = mysqli_insert_id($con);
                                    mysqli_close($con);
                                    header("Location: /statstask/php/viewDiscussion.php?id=$discussionId");
                                    exit;
                                } else {
                                    echo '<h2 class="text-center mt-4">Error saving discussion</h2>';
                                }
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="/statstask/scripts/cookieCheckNotLoggedIn.js" type="text/javascript"></script>
    <script src="/statstask/scripts/headerCheck.js" type="text/javascript"></script>
</body>

</html>