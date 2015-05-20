<?php
/**
 * Cheqout search index
 *
 * @author James Hill <james@appists.com>
 */
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
		<div class="container">
			<p>Search Products</p>
			<input id="my-input" class="typeahead" type="text" placeholder="search for a product">
		</div>
		<!-- Load jQuery and the typeahead JS files -->
		<script src="//code.jquery.com/jquery-1.10.1.min.js"></script>
		<script src="//cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.9.3/typeahead.min.js"></script>

		<script type="text/javascript">
			$(function(){
				// apply typeahead to the text input box
				$('#my-input').typeahead({
					name: 'products',

					// data source
					prefetch: '../controllers/jsoncontroller.php',

					// max items in the dropdown
					limit: 5
				});

			});
		</script>
	</body>
</html>