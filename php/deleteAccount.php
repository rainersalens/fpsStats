<?php
session_start();

if (isset($_COOKIE['userName'])) {
    // User is logged in
    $username = $_COOKIE['userName'];

    // Establish database connection
    $con = mysqli_connect('localhost', getenv('DB_USER_NAME'), getenv('DB_USER_PASS'), 'userdata');

    // Delete the user account from the 'credentials' table based on the username
    $sql = "DELETE FROM `credentials` WHERE username = '$username'";

    try {
        $result = mysqli_query($con, $sql);
        if ($result) {
            // Account deletion successful
            session_destroy(); // Destroy the session after deleting the account
            setcookie('userName', '', time() - 3600, '/'); // Clear the login cookie
            header("Location: /statstask/index.html"); // Redirect to the home page
            exit();
        } else {
            echo '<h2 class="text-center">An error occurred while deleting the account.</h2>';
        }
    } catch (Exception $e) {
        echo '<h2 class="text-center">An error occurred while deleting the account.</h2>';
    }

} else {
    // User is not logged in
    echo '<h2 class="text-center">You are not logged in.</h2>';
    echo '<p class="text-center">Please log in to delete your account.</p>';
}
?>