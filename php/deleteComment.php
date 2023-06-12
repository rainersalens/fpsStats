<?php
if (isset($_GET['commentId'])) {
    $commentId = $_GET['commentId'];

    // Delete the comment from the database
    $con = mysqli_connect('localhost', getenv('DB_USER_NAME'), getenv('DB_USER_PASS'), 'userdata');
    $result = mysqli_query($con, "DELETE FROM comments WHERE id = $commentId");

    if ($result) {
        // Comment deleted successfully
        echo 'Comment deleted successfully.';
    } else {
        // Failed to delete comment
        echo 'Failed to delete comment.';
    }

    mysqli_close($con);
} else {
    // Comment ID parameter not provided
    echo 'Comment ID not specified.';
}
?>
