<?php
$PAGE_TITLE = "Home - Cheqout";
require_once("../lib/utilities.php");
?>
<body class="full">
<div class="row">
	<section class="side-panel col-md-3">
		<?php require_once("../lib/sidebar.php"); ?>
	</section>
</div>
<!-- Page Content -->
<div class="container">
	<div class="row">
		<div class="col-md-6 col-sm-12">
			<h1>CHEQ US OUT!</h1>
			<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Magni, iusto, unde, sunt incidunt id sapiente
				rerum soluta voluptate harum veniam fuga odit ea pariatur vel eaque sint sequi tenetur eligendi.</p>
			<button type="button" class="btn btn-default">Shop</button>
			<button type="button" class="btn btn-default">Sign Up</button>
		</div>
	</div>
	<!-- /.row -->
</div>
	<form id='register' action='../lib/register.php' method='post' accept-charset='UTF-8'>
		<label for='email' >Email Address*:</label>
		<input type='text' name='email' id='email' maxlength="256" />
		<label for='password' >Password*:</label>
		<input type='password' name='password' id='password' maxlength="128" />
		<label for='password2' >Retype Password*:</label>
		<input type='text' name='password2' id='password2' maxlength="128" />
		<input type='submit' name='Submit' value='Submit' />
	</form>
	<script type="text/javascript">
		jQuery(
			function() {
				jQuery("#register")
					.dialog(
					{
						bgiframe: true,
						autoOpen: false,
						height: auto,
						modal: true
					}
				);
				jQuery('body')
					.bind(
					'click',
					function(e){
						if(
							jQuery('#register').dialog('isOpen')
							&& !jQuery(e.target).is('.ui-dialog, a')
							&& !jQuery(e.target).closest('.ui-dialog').length
						){
							jQuery('#register').dialog('close');
						}
					}
				);
			}
		);
	</script>
	<a href="#" onclick="jQuery('#register').dialog('open'); return false">Sign up</a>

<!-- /.container -->

</body>
