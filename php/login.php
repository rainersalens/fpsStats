<html>

<head>
	<title></title>
	<script src="https://code.jquery.com/jquery-3.3.1.js"
		integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous">
		</script>
	<script>
		$(function () {
			$("#header").load("../header.html");
		});
	</script>
</head>

<body>
	<div id="header"></div>

	<div class="container">

		<?php
		$con = mysqli_connect('localhost', getenv('DB_USER_NAME'), getenv('DB_USER_PASS'), 'userdata');

		$username = $_POST['usernlog'];
		$password = $_POST['passlog'];

		$sql = "SELECT * FROM `credentials` WHERE username = '$username' AND password = '$password'";

		$result = mysqli_query($con, $sql);

		$num_rows = mysqli_num_rows($result);
		try {
			$result = mysqli_query($con, $sql);
			if ($num_rows == 1) {
				$cookie_name = "userName";
				$cookie_value = $username;
				setcookie($cookie_name, $cookie_value, time() + (86400), "/"); // 24h validity
				echo '<h2 class="text-center">User logged in</h2>';
				echo '<div class="text-center"> <a class="btn btn-primary" href="/statstask/main.html" role="button">Back to main page</a> </div>';
			} elseif ($num_rows == 0) {
				echo '<h2 class="text-center">Wrong credentials</h2>';
			} else {
				echo '<h2 class="text-center">An error occured.</h2>';
			}
		} catch (exception $e) {
			echo '<h2 class="text-center">An error occured.</h2>';
		}
		?>

	</div>
</body>

</html>