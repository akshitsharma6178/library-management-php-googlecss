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
		<?php getNavBar("Staff"); ?>

		<div class="container">
			<div class="row">
				<div class="col s6">
					<blockquote>
						<h3>Staff Details</h3>
					</blockquote>
				</div>
			</div>
			<div class="row">
				<div class="col s12 m6">
					<div class="card-panel grey lighten-5 z-depth-1">
						<div class="card-content">
							<div class="row">
								<div class="col s4">
									<img src="images/dummy_profile.png" class="circle responsive-img">
								</div>
								<div class="col s8">
									<h5>Name Surname</h5>
									<h6>Designation</h6>
									<h6>Absent/present</h6>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col s12 m6">
					<div class="card-panel grey lighten-5 z-depth-1">
						<div class="card-content">
							<div class="row">
								<div class="col s4">
									<img src="images/dummy_profile.png" class="circle responsive-img">
								</div>
								<div class="col s8">
									<h5>Name Surname</h5>
									<h6>Designation</h6>
									<h6>Absent/present</h6>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col s12 m6">
					<div class="card-panel grey lighten-5 z-depth-1">
						<div class="card-content">
							<div class="row">
								<div class="col s4">
									<img src="images/dummy_profile.png" class="circle responsive-img">
								</div>
								<div class="col s8">
									<h5>Name Surname</h5>
									<h6>Designation</h6>
									<h6>Absent/present</h6>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col s12 m6">
					<div class="card-panel grey lighten-5 z-depth-1">
						<div class="card-content">
							<div class="row">
								<div class="col s4">
									<img src="images/dummy_profile.png" class="circle responsive-img">
								</div>
								<div class="col s8">
									<h5>Name Surname</h5>
									<h6>Designation</h6>
									<h6>Absent/present</h6>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<?php include_once("footer.php"); ?>
	</body>
</html>