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
	<?php
	require "functions.php";
	$game = $_POST['chooseGame'];
	$username = $_POST['userName'];

	if ($game == 'apex') {
		$endPoint = 'https://api.mozambiquehe.re/bridge';
		$authHeader = getenv('APEX_LEGENDS_API_KEY');
		$headers =
			[
				"Authorization: $authHeader",
			];
		$data = array(
			'player' => $username,
			'platform' => 'PC',
		);
	} elseif ($game == 'fortnite') {
		$endPoint = 'https://fortnite-api.com/v2/stats/br/v2';
		$authHeader = getenv('FORTNITE_API_KEY');
		$headers =
			[
				"Authorization: $authHeader",
			];
		$data = array(
			'name' => $username,
			'accountType' => 'epic',
		);
	}

	echo "<h2 class=\"text-center\">Stats for player $username in game - $game</h2>";
	?>

	<div class="container">
		<table class="table" id="tbstyle">
			<tbody>
				<tr>
					<th>Area</th>
					<th>Kills</th>
				</tr>

				<?php
				$json = callApi('GET', $endPoint, $headers, $data);
				$all = json_decode($json, true)['legends']['all'];
				foreach ($all as $area => $areaName) {
					if (isset($areaName['data'])) {
						foreach ($areaName['data'] as $properties => $propertyValue) {
							if ($propertyValue['key'] == 'kills') {
								?>
								<tr>
									<td>
										<?= $area ?>
									</td>
									<td>
										<?= $propertyValue['value'] ?>
									</td>
								</tr>
								<?php
							}
						}
					}
				}
				?>
			</tbody>
		</table>
	</div>



</body>

</html>