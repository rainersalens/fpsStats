<?php
// Get the discussion ID from the URL parameter
$discussionId = $_GET['id'];

// Delete the discussion from the database
$con = mysqli_connect('localhost', getenv('DB_USER_NAME'), getenv('DB_USER_PASS'), 'userdata');
mysqli_query($con, "DELETE FROM discussions WHERE id = $discussionId");
mysqli_query($con, "DELETE FROM comments WHERE discussion_id = $discussionId");
mysqli_close($con);
?>
