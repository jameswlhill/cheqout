<?php
require_once("../lib/utilities.php");
?>
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
					<li class="link login">
						<a href="#">Login</a>
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
