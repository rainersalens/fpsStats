<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $discussionId = $_POST['id'];
    $updatedTitle = $_POST['title'];
    $updatedType = $_POST['type'];
    $updatedContent = $_POST['content'];

    // Update the discussion details in the database
    $con = mysqli_connect('localhost', getenv('DB_USER_NAME'), getenv('DB_USER_PASS'), 'userdata');
    $updatedTitle = mysqli_real_escape_string($con, $updatedTitle);
    $updatedType = mysqli_real_escape_string($con, $updatedType);
    $updatedContent = mysqli_real_escape_string($con, $updatedContent);

    // Include the "is_edited" column in the update query
    $updateSql = "UPDATE discussions SET title = '$updatedTitle', content = '$updatedContent', is_edited = 1 WHERE id = $discussionId";
    mysqli_query($con, $updateSql);

    mysqli_close($con);

    // Return a response to the AJAX request
    echo 'success';
}
?>
