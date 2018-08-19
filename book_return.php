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
		<?php getNavBar("Manage Returns"); ?>

		<div class="container">
			<div class="row">
				<div class="col s12 m6">
					<blockquote>
						<h4>Manage Returns</h4>
					</blockquote>
				</div>
			</div>
			
			<script type="text/javascript">
				function returnBook(id){
					if (confirm("Are you you sure you want to return?") == true){
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

			<table class="striped centered responsive-table">
				<thead>
					<tr>
						<th data-field="user">User</th>
						<th data-field="name">Name</th>
						<th data-field="designation">Designation</th>
						<th data-field="issue_id">Issue Id</th>
						<th data-field="book">Book Name</th>
						<th data-field="last_date">Last Date</th>
						<th data-field="actions">Actions</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					$issue = getAllIssuedBooks();
					foreach ($issue as $value) {
					?>
					<tr>
						<td><?php echo $value['user']; ?></td>
						<td><?php echo $value['name']; ?></td>
						<td><?php echo $value['designation']; ?></td>
						<td><?php echo $value['issue_id']; ?></td>
						<td><?php echo $value['book_name']; ?></td>
						<td><?php echo $value['last_date']; ?></td>
						<td>
							<a class="btn waves-effect wave-light" onclick="returnBook('<?php echo $value['issue_id']; ?>')">Return</a>
						</td>
					</tr>
					<?php } ?>
				</tbody>
			</table>

		</div>

		<?php include_once("footer.php"); ?>
	</body>
</html>