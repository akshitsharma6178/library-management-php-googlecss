<?php 

require("lib.php");
if (!isLogin()) header("location: index.php");
$desig = getDesig();
if ($desig != 2 && $desig != 1) header("location: index.php");
$err = "";
$arr = array();
if (isset($_GET['search_by']) || isset($_GET['search'])){
	if (empty($_GET['search_by'])) $err = "Please select valid search type";
	else if (empty($_GET['search'])) $err = "Please enter something to search";
	else {
		$column = "";
		switch ($_GET['search_by']) {
			case 'id':
				$column = "user";
				break;
			case 'name':
				$column = "name";
				break;
			default:
				$err = "Invalid search query";
				break;
		}
		if ($err == ""){
			$sql = "SELECT name, user FROM student_details WHERE $column LIKE '%".$_GET['search']."%'";
			$conn = getConnection();
			$res = mysqli_query($conn, $sql);
			while($row = mysqli_fetch_assoc($res))
				array_push($arr, array(
					"name" => $row['name'],
					"user" => $row['user']
				));
			$sql = "SELECT name, user FROM teacher_details WHERE $column LIKE '%".$_GET['search']."%'";
			$res = mysqli_query($conn, $sql);
			while ($row = mysqli_fetch_assoc($res))
				array_push($arr, array(
					"name" => $row['name'],
					"user" => $row['user']
				));
		} 
	}
}

?>
<!DOCTYPE html>
<html>
	<head>
		<title>Library Management</title>
		<?php getIncludes(); ?>
	</head>
	<body>
		<script type="text/javascript">
			$(document).ready(function(){
				$('select').material_select();
			});
		</script>
		<?php getNavBar("Issuer Management"); ?>

		<div class="container">
			<div class="row">
				<div class="col s12 m6">
					<blockquote>
						<h3>Issuer Management</h3>
					</blockquote>
				</div>
				<?php if ($err != ""){ ?>
				<div class="col s12 m6">
					<div class="card-panel red lighten-1 white-text">
						<?php echo $err; ?>
					</div>
				</div>
				<?php } ?>
			</div>
			<div class="row">
				<div class="col s12">
					<form action="" method="GET">
						<div class="row">
							<div class="col s6 m4">
								<div class="input-field">
									<select name="search_by">
										<option value="NULL" disabled selected>--SELECT--</option>
										<option value="id">User ID</option>
										<option value="name">Name</option>
									</select>
									<label>Search By</label>
								</div>	
							</div>
							<div class="col s6 m4">
								<div class="input-field">
									<input type="text" name="search">
									<label>Search What</label>
								</div>	
							</div>
							<div class="col s12 m4">
								<center>
									<button class="btn waves-effect waves-light">Search</button>
								    <a href="new_user.php" class="waves-effect waves-light btn"><i class="material-icons right">add</i>Add New User</a>
								</center>
							</div>
                             
						</div>
					</form>
				</div>
			</div>
			<div class="row">
				<table class="striped centered responsive-table">
					<thead>
						<tr>
							<th>S.no</th>
							<th>User ID</th>
							<th>Name</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<?php 
						$cnt = 1;
						foreach ($arr as $value) { 
						?>
						<tr>
							<td><?php echo $cnt++; ?></td>
							<td><?php echo $value['user']; ?></td>
							<td><?php echo $value['name']; ?></td>
							<td>
								<button class="btn waves-effect waves-light">Details</button>
							</td>
						</tr>
						<?php } if (sizeof($arr) == 0 && $err == "" && isset($_GET['search_by']) && isset($_GET['search'])){ ?>
						<tr>
							<td colspan="4">
								<h5>No result found</h5>
							</td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>

		<?php include_once("footer.php"); ?>
	</body>
</html>