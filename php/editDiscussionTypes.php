<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Discussion Types</title>
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
          <li><a href="/statstask/main.html" class="nav-link px-2 text-secondary">Stat tracker</a></li>
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
        </div>
      </div>
    </div>
  </header>

  <div class="content-container container">
    <h1>Edit Discussion Types</h1>
    <table class="table">
      <thead>
        <tr>
          <th>Name</th>
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
          header("Location: /statstask/php/Forum.php");
          exit;
        }

        // Handle discussion type deletion
        if (isset($_GET['deleteTypeId'])) {
          $typeId = $_GET['deleteTypeId'];
          $query = "DELETE FROM discussion_types WHERE id = $typeId";
          if (mysqli_query($con, $query)) {
            echo '<tr><td colspan="2">Discussion type deleted successfully.</td></tr>';
          } else {
            echo '<tr><td colspan="2">Failed to delete discussion type.</td></tr>';
          }
        }

        // Retrieve all discussion types from the database
        $query = "SELECT * FROM discussion_types";
        $result = mysqli_query($con, $query);

        // Loop through the discussion type records and display them in the table
        while ($row = mysqli_fetch_assoc($result)) {
          $typeId = $row['id'];
          $typeName = $row['name'];

          echo "<tr>";
          echo "<td>$typeName</td>";
          echo "<td><button onclick=\"editType($typeId, '$typeName')\">Edit</button> <button onclick=\"confirmDelete($typeId, '$typeName')\">Delete</button></td>";
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
    function editType(typeId, typeName) {
      // Redirect to the edit page for the selected discussion type
      window.location.href = `editDiscussionTypes.php?typeId=${typeId}&typeName=${encodeURIComponent(typeName)}`;
    }

    function confirmDelete(typeId, typeName) {
      if (confirm(`Are you sure you want to delete the discussion type '${typeName}'?`)) {
        // Redirect to the delete handler within the same page, passing the type ID
        window.location.href = `editDiscussionTypes.php?deleteTypeId=${typeId}`;
      }
    }
  </script>

</body>

</html>
