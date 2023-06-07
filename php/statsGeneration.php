<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Stats</title>
</head>

<body>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
		integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">

	<div class="b-example-divider"></div>

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
					<li><a href="/statstask//main.html" class="nav-link px-2 text-white">Stat tracker</a></li>
				</ul>

				<div class="text-end">
					<a href="/statstask/login.html" id="loginButton">
						<button type="button" class="btn btn-outline-light me-2">Login</button>
					</a>
					<a href="/statstask/register.html" id="registerButton">
						<button type="button" class="btn btn-warning">Sign-up</button>
					</a>
					<a href="php/logout.php" id="logoutButton">
						<button type="button" class="btn btn-outline-light me-2">Log out</button>
					</a>
				</div>
			</div>
		</div>
	</header>

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
<script src="/statstask/scripts/headerCheck.js" type="text/javascript"></script>

</html>