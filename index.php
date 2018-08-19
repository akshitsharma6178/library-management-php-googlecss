<?php 

require("lib.php");

?>
<!DOCTYPE html>
<html>
	<head>
		<title>Library Management</title>
		<?php getIncludes(); ?>
	</head>
	<body>
		<?php getNavBar("Home"); ?>

		<script type="text/javascript">
			$(document).ready(function(){
				$('.parallax').parallax();
			});
		</script>

		<style type="text/css">
			.parallax-container {
				height:400px;
			}
		</style>

		<div class="parallax-container">
			<div class="parallax">
				<img src="images/parallax_bg.jpg" width="100%">
			</div>
			<div class="row" style="height:75px;"></div>
			<div class="row">
				<div class="col s6 offset-s3 center">
					<div class="card-panel black-text text-darken-2">
						<h2 class="header flow-text">
							Libraries are the thin red lines between civilization and barbarism
						</h2>
						<p class="right-align">-Neil Gaiman</p>
					</div>
				</div>
			</div>
		</div>

		<div class="container section white">
			<div class="row">
				<div class="col l4 s12">
					<div class="card blue-grey darken-1">
						<div class="card-content white-text">
							<span class="card-title">Title 1</span>
							<p>
								Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
								tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
								quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
								consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
								cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
								proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
							</p>
						</div>
						<div class="card-action">
							<a href="#">Learn More</a>
						</div>
					</div>
				</div>
				<div class="col l4 s12">
					<div class="card blue-grey darken-1">
						<div class="card-content white-text">
							<span class="card-title">Title 1</span>
							<p>
								Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
								tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
								quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
								consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
								cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
								proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
							</p>
						</div>
						<div class="card-action">
							<a href="#">Learn More</a>
						</div>
					</div>
				</div>
				<div class="col l4 s12">
					<div class="card blue-grey darken-1">
						<div class="card-content white-text">
							<span class="card-title">Title 1</span>
							<p>
								Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
								tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
								quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
								consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
								cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
								proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
							</p>
						</div>
						<div class="card-action">
							<a href="#">Learn More</a>
						</div>
					</div>
				</div>
			</div>
		</div>

		<?php include_once("footer.php"); ?>
	</body>
</html>