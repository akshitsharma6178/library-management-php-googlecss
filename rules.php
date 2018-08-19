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
		<?php getNavBar("Rules"); ?>

		<div class="container">
			<div class="row">
				<div class="col s6">
					<blockquote>
						<h3>Rules</h3>
					</blockquote>
				</div>
			</div>
			<div class="row">
				<div class="col s12">
					<ul class="collection with-header z-depth-2">
						<li class="collection-header"><h5>General</h5></li>
						<li class="collection-item">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod</li>
						<li class="collection-item">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod</li>
						<li class="collection-item">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod</li>
						<li class="collection-item">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod</li>
					</ul>
					<ul class="collection with-header z-depth-2">
						<li class="collection-header"><h5>Student</h5></li>
						<li class="collection-item">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod</li>
						<li class="collection-item">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod</li>
						<li class="collection-item">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod</li>
						<li class="collection-item">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod</li>
					</ul>
					<ul class="collection with-header z-depth-2">
						<li class="collection-header"><h5>Teacher</h5></li>
						<li class="collection-item">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod</li>
						<li class="collection-item">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod</li>
						<li class="collection-item">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod</li>
						<li class="collection-item">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod</li>
					</ul>
				</div>
			</div>
		</div>

		<?php include_once("footer.php"); ?>
	</body>
</html>