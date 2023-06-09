<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Users</title>
  <style>
    .content-container {
      margin-top: 80px;
    }
  </style>
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
          <a href="/statstask/php/logout.php" id="logoutButton">
            <button type="button" class="btn btn-outline-light me-2">Log out</button>
          </a>
        </div>
      </div>
    </div>
  </header>

  <div class="content-container container">
    <h1>Edit User Accounts</h1>
    <table class="table">
      <thead>
        <tr>
          <th>Username</th>
          <th>Email</th>
          <th>Privilege Level</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php
        // Connect to the database
        $con = mysqli_connect('localhost', getenv('DB_USER_NAME'), getenv('DB_USER_PASS'), 'userdata');

        // Check if the user has admin privilege
        $isAdmin = false;
        if (isset($_COOKIE['userName'])) {
          $username = $_COOKIE['userName'];
          $query = "SELECT privilege FROM credentials WHERE username = '$username'";
          $result = mysqli_query($con, $query);
          $row = mysqli_fetch_assoc($result);
          if ($row['privilege'] == 'admin') {
            $isAdmin = true;
          }
        }

        // Check if the user has admin privilege, otherwise redirect to another page
        if (!$isAdmin) {
          header("Location: /statstask/index.html");
          exit;
        }

        // Handle user deletion
        if (isset($_GET['deleteUserId'])) {
          $userId = $_GET['deleteUserId'];
          $query = "DELETE FROM credentials WHERE id = $userId";
          if (mysqli_query($con, $query)) {
            echo '<tr><td colspan="4">User deleted successfully.</td></tr>';
          } else {
            echo '<tr><td colspan="4">Failed to delete user.</td></tr>';
          }
        }

        // Retrieve all users from the database
        $query = "SELECT * FROM credentials";
        $result = mysqli_query($con, $query);

        // Loop through the user records and display them in the table
        while ($row = mysqli_fetch_assoc($result)) {
          $userId = $row['id'];
          $username = $row['username'];
          $email = $row['email'];
          $privilege = $row['privilege'];

          echo "<tr>";
          echo "<td>$username</td>";
          echo "<td>$email</td>";
          echo "<td>$privilege</td>";
          echo "<td><button onclick=\"confirmDelete($userId, '$username')\">Delete</button></td>";
          echo "</tr>";
        }

        // Close the database connection
        mysqli_close($con);
        ?>
      </tbody>
    </table>
  </div>

  <script src="/statstask/scripts/headerCheck.js" type="text/javascript"></script>
  <script>
    function confirmDelete(userId, username) {
      if (confirm(`Are you sure you want to delete the user '${username}'?`)) {
        // Redirect to the delete handler within the same page, passing the user ID
        window.location.href = `editUsers.php?deleteUserId=${userId}`;
      }
    }
  </script>

</body>

</html>
