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

		$username = $_POST['usernreg'];
		$email = $_POST['emailreg'];
		$password = $_POST['passreg'];

		$sql = "INSERT INTO `credentials` (`username`, `email`, `password`) VALUES ('$username', '$email', '$password')";

		try {
			$result = mysqli_query($con, $sql);
			if ($result) {
				echo '<h2 class="text-center">Customer registered</h2>';
			}
		} catch (exception $e) {
			echo '<h2 class="text-center">An error occured. Please check the input data.</h2>';
		}

		?>
	</div>
</body>

</html>