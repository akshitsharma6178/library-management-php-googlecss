<?php 

require("lib.php");
$desig = getDesig();
if (!isLogin() || $desig != 2) header("location: index.php");

?>
<!DOCTYPE html>
<html>
	<head>
		<title>Library Management</title>
		<?php getIncludes(); ?>
	</head>
	<body>
		<?php getNavBar("Fines"); ?>

		<script type="text/javascript">
			$(document).ready(function(){
				$('ul.tabs').tabs();
			});
		</script>

		<?php $arr = getDueDetails(); ?>

		<div class="container">
			<div class="row">
				<div class="col s12 m6">
					<blockquote>
						<h3>Fines</h3>
					</blockquote>
				</div>
				<div class="col s12 m6">
					<div class="card-panel teal white-text">
						<center>
							<h5>Total Receipts: <?php echo sizeof($arr); ?></h5>
						</center>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col s12">
					<ul class="tabs">
						<li class="tab col s4"><a href="#tab1">All</a></li>
						<li class="tab col s4"><a href="#tab2">False Request</a></li>
						<li class="tab col s4"><a href="#tab3">Late Return</a></li>
					</ul>
				</div>
				<script type="text/javascript">
					function delReq(id){
						if (confirm("Are you sure you want to continue?") == true){
							$.post(
								"delReq.php",
								{
									"req_id" : id
								},
								function (data, status){
									alert(data);
									document.location.href = document.location.href;
								}
							);
						}
					}
					function delIssue(id){
						if (confirm("Are you sure you want to continue?") == true){
							$.post(
								"returnBook.php",
								{
									"issue_id" : id
								},
								function (data, status){
									alert(data);
									document.location.href = document.location.href;
								}
							);
						}
					}
				</script>
				<div id="tab1" class="col s12">
					<table class="striped centered responsive-table">
						<thead>
							<tr>
								<th>S.No.</th>
								<th>User ID</th>
								<th>Name</th>
								<th>Reason</th>
								<th>Amount</th>
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
								<td><?php echo $value['user'] ?></td>
								<td><?php echo $value['name']; ?></td>
								<td><?php echo $value['reason']==1?"Late Return":($value['reason']==2?"False Request":""); ?></td>
								<td><?php echo $value['reason']==1?"500":($value['reason']==2?"100":""); ?></td>
								<td>
									<?php if ($value['reason'] == 2){ ?>
									<a onclick="delReq(<?php echo $value['id']; ?>)" class="btn waves-effect waves-light">Paid</a>
									<?php } else if ($value['reason'] == 1) { ?>
									<a onclick="delIssue(<?php echo $value['id']; ?>)" class="btn waves-effect waves-light">Paid and Return</a>
									<?php } ?>
								</td>
							</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
				<div id="tab2" class="col s12">
					<table class="striped centered responsive-table">
						<thead>
							<tr>
								<th>S.No.</th>
								<th>User ID</th>
								<th>Name</th>
								<th>Amount</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$cnt = 1;
							foreach ($arr as $value) {
								if ($value['reason'] == 2){
							?>
								<tr>
									<td><?php echo $cnt++; ?></td>
									<td><?php echo $value['user'] ?></td>
									<td><?php echo $value['name']; ?></td>
									<td>100</td>
									<td>
										<a onclick="delReq(<?php echo $value['id']; ?>)" class="btn waves-effect waves-light">Paid</a>
									</td>
								</tr>
							<?php 
								}
							} 
							?>
						</tbody>
					</table>
				</div>
				<div id="tab3" class="col s12">
					<table class="striped centered responsive-table">
						<thead>
							<tr>
								<th>S.No.</th>
								<th>User ID</th>
								<th>Name</th>
								<th>Amount</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$cnt = 1;
							foreach ($arr as $value) {
								if ($value['reason'] == 1){
							?>
								<tr>
									<td><?php echo $cnt++; ?></td>
									<td><?php echo $value['user'] ?></td>
									<td><?php echo $value['name']; ?></td>
									<td>500</td>
									<td>
										<a onclick="delIssue(<?php echo $value['id']; ?>)" class="btn waves-effect waves-light">Paid and Return</a>
									</td>
								</tr>
							<?php 
								}
							} 
							?>
						</tbody>
					</table>
				</div>
			</div>
		</div>

		<?php include_once("footer.php"); ?>
	</body>
</html>