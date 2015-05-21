<!DOCTYPE html>
<html lang="en">

	<head>
		<meta charset="utf-8"/>
		<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
		<meta name="viewport" content="width=device-width, initial-scale=1"/>

		<!-- Bootstrap Latest compiled and minified CSS -->
		<link type="text/css" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet"/>

		<!-- Optional Bootstrap theme -->
		<link type="text/css" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css" rel="stylesheet"/>

		<link type="text/css" href="../css/sidebar.css" rel="stylesheet"/>

		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		<script type="text/javascript" src="//oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script type="text/javascript" src="//oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->

		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
		<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery.form/3.51/jquery.form.min.js"></script>
		<script type="text/javascript" src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.13.1/jquery.validate.min.js"></script>
		<script type="text/javascript" src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.13.1/additional-methods.min.js"></script>

		<!-- Latest compiled and minified Bootstrap JavaScript, all compiled plugins included -->
		<script type="text/javascript" src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
		<title>Sidebar</title>
	</head>

	<body>

		<div id="wrapper">

			<!-- Sidebar -->
			<div id="sidebar-wrapper">

				<ul class="sidebar-nav">
					<li class="menu-button">
						<a href="#menu-toggle" class="btn btn-link" id="menu-toggle"><span class="glyphicon glyphicon-menu-hamburger"></span></a>
					</li>
					<li class="link sidebar-brand">
						<a href="../">
							Cheqout
						</a>
					</li>
					<li class="link">
						<form class="search-form" role="search">
							<input type="text" class="form-control" placeholder="Search">
						</form>
					</li>
					<li class="link">
						<a href="#">Shop</a>
					</li>
					<li class="link">
						<a href="#">Account</a>
					</li>
					<li class="link">
						<a href="#">Cart</a>
					</li>
					<li class="link">
						<a href="#">About</a>
					</li>
				</ul>
			</div>
			<!-- /#sidebar-wrapper -->

		</div>
		<!-- /#wrapper -->

		<!-- Menu Toggle Script -->
		<script>
			$("#menu-toggle").click(function(e) {
				e.preventDefault();
				$("#wrapper").toggleClass("toggled");
			});
		</script>

	</body>

</html>