<?php
/**
 * Cheqout search index
 *
 * @author James Hill <james@appists.com>
 */
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}
?>

<!DOCTYPE HTML>
<html>
	<head lang="en">
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<title>Cheqout autocomplete site search</title>

		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" />
		<!-- Optional theme -->
		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css" />
		<!-- Latest compiled and minified Bootstrap JavaScript, all compiled plugins included -->
		<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
		<script type="text/javascript" src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
		<!-- HTML5 shiv and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		<script src="//oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="//oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
	</head>

	<body>
		<!--user input search bar-->
		<div class="col-lg-6">
			<form id='searchSubmit' action="../controllers/jsoncontroller.php" method="get">
				<div class="input-group pull-right">
					<input class="form-control" type="text" size="30" name="search" id="search" placeholder="search our products">
					<span class="input-group-btn">
						<button class="btn btn-success btn-md" id="searchSubmit" type="submit">Search</button>
					</span>
				</div>
			</form>
		</div>

		<div id="output"></div>
		<!-- Load jQuery -->
		<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
		<script type="text/javascript" src="../controllers/search.js"></script>
	</body>
</html>