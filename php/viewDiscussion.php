<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Discussion</title>
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

    <div class="container-fluid mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <?php
                        // Get the discussion ID from the URL parameter
                        $discussionId = $_GET['id'];

                        // Fetch discussion details from the database
                        $con = mysqli_connect('localhost', getenv('DB_USER_NAME'), getenv('DB_USER_PASS'), 'userdata');
                        $result = mysqli_query($con, "SELECT * FROM discussions WHERE id = $discussionId");
                        $discussion = mysqli_fetch_assoc($result);

                        // Fetch all discussion types from the database
                        $typeResult = mysqli_query($con, "SELECT * FROM discussion_types");
                        $discussionTypes = [];

                        while ($typeRow = mysqli_fetch_assoc($typeResult)) {
                            $discussionTypes[] = $typeRow;
                        }


                        if ($discussion) {
                            $userId = $discussion['user_id'];
                            $userResult = mysqli_query($con, "SELECT * FROM credentials WHERE id = $userId");
                            $user = mysqli_fetch_assoc($userResult);

                            $discussionType = $discussion['discussion_type'];
                            $typeResult = mysqli_query($con, "SELECT * FROM discussion_types WHERE id = $discussionType");
                            $type = mysqli_fetch_assoc($typeResult);

                            echo '<h1 class="card-title">' . $discussion['title'] . '</h1>';
                            echo '<p class="mb-2">Type: <span id="discussionType">' . ($type ? $type['name'] : 'Deleted Type') . '</span></p>';
                            echo '<p style="margin-top:40px" class="mb-2">Submitted by: ';
                            if ($user) {
                                echo '<a href="/statstask/php/viewProfile.php?id=' . $user['id'] . '">' . $user['username'] . '</a>';
                            } else {
                                echo 'Deleted User';
                            }
                            echo '</p>';
                            echo '<div class="card-text border p-3">' . $discussion['content'] . '</div>';

                            // Check if the user is the one who made the discussion or an admin
                            $loggedInUserId = $_COOKIE['userId']; // Assuming the login token sets this cookie
                            $userPrivilege = $_COOKIE['userPrivilege'];

                            if ($loggedInUserId && ($userId == $loggedInUserId || $userPrivilege == 'admin')) {
                                echo '<button id="editContentButton" class="btn btn-primary mt-3">Edit Content</button>';
                                echo '<button id="deleteDiscussionButton" style="margin-left:20px" class="btn btn-warning mt-3">Delete Discussion</button>';
                            }
                        } else {
                            echo '<h2 class="text-center mt-4">Discussion not found</h2>';
                        }

                        mysqli_close($con);
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid mt-5">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h3>Comments</h3>
                            <hr>
                            <div class="mt-3">
                                <input type="text" id="commentInput" class="form-control" placeholder="Write a comment">
                                <button id="postCommentButton" class="btn btn-primary mt-2">Post comment</button>
                            </div>
                            <hr>
                            <div class="mt-3" style="max-height: 300px; overflow: auto;">
                                <?php
                                // Fetch comments for the discussion from the database
                                $con = mysqli_connect('localhost', getenv('DB_USER_NAME'), getenv('DB_USER_PASS'), 'userdata');
                                $discussionId = $_GET['id'];

                                $commentsResult = mysqli_query($con, "SELECT * FROM comments WHERE discussion_id = $discussionId ORDER BY created_on DESC");
                                $commentsCount = mysqli_num_rows($commentsResult);

                                if ($commentsCount > 0) {
                                    while ($comment = mysqli_fetch_assoc($commentsResult)) {
                                        $commentId = $comment['id'];
                                        $commentUserId = $comment['user_id'];
                                        $userResult = mysqli_query($con, "SELECT * FROM credentials WHERE id = $commentUserId");
                                        $user = mysqli_fetch_assoc($userResult);

                                        echo '<div class="mb-3">';
                                        echo '<p class="fw-bold">';
                                        if ($user) {
                                            echo '<a href="/statstask/php/viewProfile.php?id=' . $user['id'] . '">' . $user['username'] . '</a>';
                                        } else {
                                            echo 'Deleted User';
                                        }
                                        echo '</p>';
                                        echo '<p>' . $comment['content'] . '</p>';

                                        // Check if the comment belongs to the currently logged-in user
                                        $loggedInUserId = $_COOKIE['userId']; // Assuming the login token sets this cookie
                                        $userPrivilege = $_COOKIE['userPrivilege'];

                                        if (($loggedInUserId && $commentUserId == $loggedInUserId) || ($userPrivilege == 'admin')) {
                                            echo '<div class="text-end">';
                                            echo '<button style="margin-right:20px" class="btn btn-danger btn-sm delete-comment-btn" data-comment-id="' . $comment['id'] . '">Delete Comment</button>';
                                            echo '</div>';
                                        }

                                        echo '<hr>';

                                        echo '</div>';
                                    }
                                } else {
                                    echo '<p>No comments yet.</p>';
                                }

                                mysqli_close($con);
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <script>
                const editContentButton = document.getElementById('editContentButton');

                editContentButton.addEventListener('click', () => {
                    const cardTitle = document.querySelector('.card-title');
                    const cardType = document.querySelector('.card-body > p');
                    const cardContent = document.querySelector('.card-text');

                    const titleInput = document.createElement('input');
                    titleInput.setAttribute('type', 'text');
                    titleInput.classList.add('form-control', 'mb-2');
                    titleInput.value = cardTitle.textContent;

                    const typeSelect = document.createElement('select');
                    typeSelect.classList.add('form-select', 'mb-2');

                    // Add options for each existing discussion type
                    const discussionTypes = <?php echo json_encode($discussionTypes); ?>;
                    discussionTypes.forEach(type => {
                        const option = document.createElement('option');
                        option.value = type.id;
                        option.text = type.name;
                        typeSelect.appendChild(option);
                    });

                    // Set the currently selected discussion type
                    const currentType = document.getElementById('discussionType').textContent;
                    typeSelect.value = discussionTypes.find(type => type.name === currentType)?.id;

                    // Replace the existing type element with the dropdown select
                    cardType.replaceWith(typeSelect);


                    const contentTextarea = document.createElement('textarea');
                    contentTextarea.classList.add('form-control', 'mb-2');
                    contentTextarea.textContent = cardContent.textContent;

                    const saveChangesButton = document.createElement('button');
                    saveChangesButton.classList.add('btn', 'btn-primary', 'mt-3');
                    saveChangesButton.textContent = 'Save Changes';

                    saveChangesButton.addEventListener('click', () => {
                        const updatedTitle = titleInput.value;
                        const updatedType = typeSelect.value;
                        const updatedContent = contentTextarea.value;

                        // Make AJAX request to update discussion details in the database
                        const xhr = new XMLHttpRequest();
                        xhr.onreadystatechange = function() {
                            if (xhr.readyState === 4 && xhr.status === 200) {
                                // Redirect to the updated discussion page
                                window.location.href = 'viewDiscussion.php?id=<?php echo $discussionId; ?>';
                            }
                        };
                        xhr.open('POST', 'updateDiscussion.php');
                        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

                        // Add the "is_edited" parameter with a value of 1 to the request
                        const params = `id=<?php echo $discussionId; ?>&title=${encodeURIComponent(updatedTitle)}&type=${encodeURIComponent(updatedType)}&content=${encodeURIComponent(updatedContent)}&is_edited=1`;
                        xhr.send(params);
                    });


                    // Replace the existing content with the editable inputs and save changes button
                    cardTitle.replaceWith(titleInput);
                    cardType.replaceWith(typeSelect);
                    cardContent.replaceWith(contentTextarea);
                    editContentButton.replaceWith(saveChangesButton);
                });
            </script>

            <script>
                const commentButton = document.getElementById('postCommentButton');
                const commentInputElement = document.getElementById('commentInput');

                commentButton.addEventListener('click', () => {
                    const comment = commentInputElement.value.trim();

                    if (comment !== '') {
                        // Make AJAX request to post the comment to the database
                        const xhr = new XMLHttpRequest();
                        xhr.onreadystatechange = function() {
                            if (xhr.readyState === 4 && xhr.status === 200) {
                                // Reload the page to show the updated comments
                                location.reload();
                            }
                        };
                        xhr.open('POST', 'postComment.php');
                        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                        xhr.send(`discussionId=<?php echo $discussionId; ?>&comment=${encodeURIComponent(comment)}`);
                    }
                });

                // Add event listener for delete comment buttons
                const deleteCommentButtons = document.querySelectorAll('.delete-comment-btn');
                deleteCommentButtons.forEach(button => {
                    button.addEventListener('click', () => {
                        const commentId = button.dataset.commentId;
                        confirmDeleteComment(commentId);
                    });
                });

                function confirmDeleteComment(commentId) {
                    const confirmation = confirm('Are you sure you want to delete this comment?');
                    if (confirmation) {
                        deleteComment(commentId);
                    }
                }

                function deleteComment(commentId) {
                    // Make AJAX request to delete the comment from the database
                    const xhr = new XMLHttpRequest();
                    xhr.onreadystatechange = function() {
                        if (xhr.readyState === 4 && xhr.status === 200) {
                            // Remove the deleted comment from the DOM
                            const commentElement = document.querySelector(`.delete-comment-btn[data-comment-id="${commentId}"]`).closest('.mb-3');
                            commentElement.remove();
                        }
                    };
                    xhr.open('GET', `/statstask/php/deleteComment.php?commentId=${commentId}`);
                    xhr.send();
                }
            </script>

            <script>
                const deleteDiscussionButton = document.getElementById('deleteDiscussionButton');

                deleteDiscussionButton.addEventListener('click', () => {
                    confirmDeleteDiscussion();
                });

                function confirmDeleteDiscussion() {
                    const confirmation = confirm('Are you sure you want to delete this discussion?');
                    if (confirmation) {
                        deleteDiscussion();
                    }
                }

                function deleteDiscussion() {
                    // Make AJAX request to delete the discussion from the database
                    const xhr = new XMLHttpRequest();
                    xhr.onreadystatechange = function() {
                        if (xhr.readyState === 4 && xhr.status === 200) {
                            // Redirect to the forum page after successful deletion
                            window.location.href = '/statstask/php/forum.php';
                        }
                    };
                    xhr.open('GET', `deleteDiscussion.php?id=<?php echo $discussionId; ?>`);
                    xhr.send();
                }
            </script>

            <script src="/statstask/scripts/cookieCheckNotLoggedIn.js" type="text/javascript"></script>
            <script src="/statstask/scripts/headerCheck.js" type="text/javascript"></script>
</body>

</html>