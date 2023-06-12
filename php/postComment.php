<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $discussionId = $_POST['discussionId'];
    $comment = $_POST['comment'];

    // Validate and sanitize the comment input
    $comment = trim($comment);
    // You can add additional validation if needed

    // Save the comment to the database
    $con = mysqli_connect('localhost', getenv('DB_USER_NAME'), getenv('DB_USER_PASS'), 'userdata');
    $userId = $_COOKIE['userId']; // Assuming the login token sets this cookie
    $comment = mysqli_real_escape_string($con, $comment);

    $insertSql = "INSERT INTO comments (user_id, discussion_id, content, created_on) VALUES ('$userId', '$discussionId', '$comment', NOW())";
    mysqli_query($con, $insertSql);

    mysqli_close($con);

    // Return a response indicating success
    echo 'success';
}
?>
