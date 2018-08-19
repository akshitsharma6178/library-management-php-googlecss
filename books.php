<?php 

require("lib.php");

$books = array();
$err = "";
if (!empty($_GET['search_type']) && !empty($_GET['search']) && isset($_GET['search_req'])){
	$type = $_GET['search_type'];
	$search = $_GET['search'];
	switch ($type) {
		case 'title':
			$col = "book_name";
			break;
		case 'isbn':
			$col = "isbn";
			break;
		case 'writer':
			$col = "writer";
			break;
		case 'publisher':
			$col = "pub";
			break;
	}
	$conn = getConnection();
	$sql = "SELECT book_id FROM books WHERE $col LIKE '%$search%'";
	$res = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_assoc($res)){
		array_push($books, $row['book_id']);
	}
} else {
	if (isset($_GET['search_req'])){
		if (empty($_GET['search_type'])) $err = "Please select a search type";
		else if (empty($_GET['search'])) $err = "PLease tell something to search";
	}
}
$desig = getDesig();

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
				$('.modal-trigger').leanModal();
			});
		</script>
		<?php getNavBar("Books"); ?>

		<div class="container">
			<div class="row">
				<div class="col s6">
					<blockquote>
						<h3>Search for Books</h3>
					</blockquote>	
				</div>
				<?php if ($err != ""){ ?>
					<div class="col s6">
						<div class="card-panel red lighten-1 white-text">
							<?php echo $err ?>
						</div>
					</div>
				<?php } ?>
			</div>
			<form>
				<div class="row">
					<div class="col l4 m6 s12">
						<div class="input-field">
							<!-- initialised in document ready function -->
							<select name="search_type">
								<option value="NULL" disabled selected>--Select--</option>
								<option value="title">Title</option>
								<option value="isbn">ISBN</option>
								<option value="writer">Writer</option>
								<option value="publisher">Publisher</option>
							</select>
							<label>
								Search By
							</label>
						</div>
					</div>
					<div class="col l4 m6 s12">
						<div class="input-field">
							<input type="text" name="search">
							<label>Search What</label>
						</div>
					</div>
					<div class="col l4 m12 s12">
						<center>
							<button class="btn waves-effect waves-light" type="submit" name="search_req">Search</button>
							<?php if ($desig == 2 || $desig == 1){ ?>
							<a href="book_edit.php" class="waves-effect waves-light btn"><i class="material-icons right">add</i>Add New</a>
							<?php } ?>
						</center>
					</div>

				</div>
			</form>

			<!-- search result area -->

			<?php if ($desig > 2){ ?>
			<script type="text/javascript">
				function reqBook(book_id){
					if (confirm("Are you sure you want to request this book?") == true){
						$.post (
							"addReq.php",
							{
								"book_id": book_id
							},
							function (data, status){
								alert(data);
								window.location.href = window.location.href;
							}
						);
					}
				}
			</script>
			<?php } else if ($desig == 2 || $desig == 1) { ?>
			<script type="text/javascript">
				function issueBook(user, book_id){
					if (confirm("Are you sure you want to issue this book?") == true){
						$.post(
							"issueBook.php",
							{
								"book_id" : book_id,
								"user" : user
							},
							function (data, status){
								alert(data);
								window.location.href = window.location.href;
							}
						);								
					}
				}
			</script>
			<?php } ?>
			<div id="username_modal" class="modal">
				<div class="modal-content">
					<div class="input-field">
						<input type="text" id="book_id">
						<label>Book ID</label>
					</div>
					<div class="input-field">
						<input type="text" id="issue_user">
						<label>Username</label>
					</div>
				</div>
				<div class="modal-footer">
					<a class="modal-action modal-close waves-effect waves-green btn-flat" onclick="issueBook(document.getElementById('issue_user').value, document.getElementById('book_id').value)">Issue</a>
				</div>
			</div>


			<?php if (!empty($_GET['search_type']) && !empty($_GET['search'])){ ?>
				<div class="row">
					<?php
					$empty = true;
					foreach($books as $book_id){ 
						$empty = false;
						$book = getBook($book_id);
					?>

					<div class="col s12 m6 l3">
						<div class="card">
							<div class="card-images waves-effect waves-block waves-light">
								<img class="activator respomsive-img" src="images/dummy_profile.png" width="100%">
							</div>
							<div class="card-content">
								<span class="card-title activator grey-text text-darken-4"><?php echo $book['title']; ?><i class="material-icons right">more_vert</i></span>
								<p>By: <?php echo $book['writer']; ?></p>
								<p>
									<?php if ($desig > 2){ ?>
									<button class="btn waves-effect waves-light" <?php echo !isBookAvail($book_id)?"disabled":""; ?> onclick="reqBook('<?php echo $book_id; ?>');" id="<?php echo $book_id; ?>">Request</button>
									<?php } else if ($desig == 2 || $desig == 1){ ?>
									<a href="<?php echo "book_edit.php?book_id=".$book_id; ?>"><button class="btn waves-effect waves-light">Edit</button></a>
									<button class="btn waves-effect waves-light modal-trigger" <?php echo !isBookAvail($book_id)?"disabled":"data-target='username_modal'"; ?> onclick="document.getElementById('book_id').value = '<?php echo $book_id; ?>'">Issue</button>
									<?php } ?>
								</p>
							</div>
							<div class="card-reveal">
								<span class="card-title activator grey-text text-darken-4"><?php echo $book['title']; ?><i class="material-icons right">more_vert</i></span>
								<p>By: <?php echo $book['writer']; ?></p>
								<p>ISBN: <?php echo $book['isbn']; ?></p>
								<p>Publisher: <?php echo $book['publisher']; ?></p>
								<p>Pages: <?php echo $book['pages']; ?></p>
							</div>
						</div>
					</div>
					<?php 
					} 
					if ($empty){
						echo "<tr><td colspan=\"9\"><h5>No Result found</h5></td></tr>";
					}
					?>

				</div>	
			<?php } ?>

		</div>

		<?php include_once("footer.php"); ?>
	</body>
</html>