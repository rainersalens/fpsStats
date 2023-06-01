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
		if (isset($_COOKIE['userName'])) {
			unset($_COOKIE['userName']);
			setcookie('userName', null, -1, '/');
		}
		echo '<h2 class="text-center">Succesfully logged out</h2>';
		?>
	</div>
</body>

</html>