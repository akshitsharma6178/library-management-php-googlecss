<?php 

require("lib.php");
if (!isLogin()) header("location: index.php");
$desig = getDesig();
if ($desig != 2 && $desig != 1) header("location: index.php");

?>
<!DOCTYPE html>
<html>
	<head>
		<title>Library Management</title>
		<?php getIncludes(); ?>
	</head>
	<body>
		<?php getNavBar("Manage Request"); ?>

		<!-- getting all the requests -->
		<?php $req = getRequests(); ?>

		<div class="container">
			<div class="row">
				<div class="col s12 m6">
					<blockquote>
						<h4>Issue Requests</h4>
					</blockquote>
				</div>
				<div class="col s12 m6">
					<div class="card-panel green lighten-1 white-text">
						<center>
							<h5>Total number of requests</h5>
							<h4><?php echo count($req); ?></h4>
						</center>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col s12">
					<table class="striped centered">

						<thead>
							<tr>
								<th data-field="req_id">Request ID</th>
								<th data-field="name">Name</th>
								<th data-field="user">User ID</th>
								<th data-field="book_name">Book Name</th>
								<th data-field="actions">Actions</th>
							</tr>
						</thead>

						<script type="text/javascript">
							function refresh(){
								document.location.href = document.location.href; 
							}
							function acceptReq(user, id){
								if (confirm("Are you sure you want to accept?") == true){
									$.post(
										"issueBook.php",
										{
											"user" : user,
											"req_id" : id
										},
										function (data, status){
											alert(data);
										}
									);
									refresh();
								}
							}
							function deleteReq(id){
								if (confirm("Are you sure you want to decline?") == true){
									$.post(
										"delReq.php",
										{
											"req_id" : id
										},
										function (data, status){
											alert(data)
										}
									);
									refresh();
								}
							}
						</script>

						<tbody>
							<?php 
							foreach ($req as $value) {		
							?>
							<tr>
								<td><?php echo $value['req_id']; ?></td>
								<td><?php echo $value['name']; ?></td>
								<td><?php echo $value['user']; ?></td>
								<td><?php echo $value['book_name']; ?></td>
								<td>
									<button class="waves-effect waves-light btn" onclick="acceptReq(<?php echo "'".$value['user']."', '".$value['req_id']."'"; ?>)">Accept</button>
									<button class="waves-effect waves-light btn red lighten-1" onclick="deleteReq('<?php echo $value['req_id']; ?>')">Decline</button>
								</td>
							</tr>
							<?php } ?>
						</tbody>

					</table>
				</div>
			</div>
		</div>

		<?php include_once("footer.php"); ?>
	</body>
</html>