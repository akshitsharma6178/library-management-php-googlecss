<?php 

/*

designation code are as follows
	1 -> Admin
	2 -> Library Staff
	3 -> Teacher
	4 -> Student

*/

require("credential.php");
session_start();

//uncomment it after debbugging
//error_reporting(false);

//function to get the essential frontend libraries
function getIncludes(){
?>
	<link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<script type="text/javascript" src="js/jquery.min.js"></script>
	<script type="text/javascript" src="js/materialize.min.js"></script>
<?php
}

//function to get the top navigation bar with a given title
function getnavBar($title){
?>
	<nav>
		<div class="nav-wrapper">
			<a href="index.php" class="brand-logo left" style="margin-right:20px"><?php echo $title ?></a>
			<ul id="nav-mobile" class="right">
				<li>
					<a href="books.php">Books</a>
				</li>
				<li>
					<a href="staff.php">Library Staff</a>
				</li>
				<li>
					<a href="rules.php">Rules</a>
				</li>
				<?php if (isLogin()){ ?>
					<script type="text/javascript">
						$(".dropdown-button").dropdown();
					</script>
					<li>
						<a class="dropdown-button" href="#!" data-activates="logged-in-dropdown"> Welcome, <?php echo getName(); ?> <i class="material-icons right">arrow_drop_down</i></a>
					</li>
				<?php } else { ?>
					<li>
						<a href="#login-modal" class="modal-trigger">Login</a>
					</li>
				<?php } ?>
			</ul>
		</div>
	</nav>

	<!-- login modal -->
	<div id="login-modal" class="modal">
		<div class="modal-content">
			<div class="row">
				<div class="col s12">
					<form action="login_auth.php" method="POST">
						<div class="input-field">
							<label for="user">Username</label>
							<input type="text" name="user" id="user">							
						</div>
						<div class="input-field">
							<label for="pass">Password</label>
							<input type="password" name="pass" id="pass">
						</div>
						<input type="hidden" name="redirect" value="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
						<button class="btn waves-green">Login</button>
						<p>
							<?php 

							if (isset($_POST['login_err'])) echo $_POST['login_err'];

							?>
						</p>
					</form>
				</div>
			</div>
		</div>
		<div class="modal-footer center">
			
		</div>
	</div>

	<!-- logged in user panel -->
	<ul id="logged-in-dropdown" class="dropdown-content">
		<li><a href="dashboard.php">Dashboard</a></li>
		<li><a href="logout.php">Logout</a></li>
	</ul>

	<script type="text/javascript">
		$(document).ready(function(){
			$('.modal-trigger').leanModal();
		});
	</script>
<?php
}

function getConnection(){
	return mysqli_connect('localhost', 'root','', 'library');
}

//given password should be hashed
function checkLogin($user, $pass){
	if ($user === "" || $pass === "") return false;
	$conn = getConnection();
	$sql = "SELECT pass FROM login WHERE user = '$user'";
	$res = mysqli_fetch_assoc(mysqli_query($conn, $sql));
	mysqli_close($conn);
	if ($res['pass'] == $pass) return true;
	return false;
}

//password should be stored in hashed format
function isLogin(){
	if (!empty($_SESSION['user']) && !empty($_SESSION['pass'])){
		$user = $_SESSION['user'];
		$pass = $_SESSION['pass'];
		if (checkLogin($user, $pass)) return true;
		return false;
	} else return false;
}

//checks whether the user exists or not
function userExists($user){
	$conn = getConnection();
	$sql = "SELECT COUNT(*) FROM login WHERE user = '$user'";
	$cnt = mysqli_fetch_assoc(mysqli_query($conn, $sql))['COUNT(*)'];
	return $cnt > 0? true : false;
}

//method returning the name of the current logged in user else it will return an empty string
function getName(){
	if (!empty($_SESSION['user']) && !empty($_SESSION['pass']) && isLogin()){
		$user = $_SESSION['user'];
		$conn = getConnection();
		$sql = "SELECT desig FROM login WHERE user = '$user'";
		$res = mysqli_fetch_assoc(mysqli_query($conn, $sql));
		switch ($res['desig']) {
			case 1:
				$table = "admin_details";
				break;
			case 2:
				$table = "staff_details";
				break;
			case 3:
				$table = "teacher_details";
				break;
			case 4:
				$table = "student_details";
				break;			
		}
		$sql = "SELECT name FROM $table WHERE user = '$user'";
		$res = mysqli_fetch_assoc(mysqli_query($conn, $sql));
		return $res['name'];
	} else return "";
}

//returns the designation of the current logged in user
function getDesig(){
	if (isLogin()){
		$conn = getConnection();
		$sql = "SELECT desig FROM login WHERE user = '".$_SESSION['user']."'";
		$res = mysqli_fetch_assoc(mysqli_query($conn, $sql));
		return $res['desig'];
	} else return "";
}

//get designation in string format
function getDesigString(){
	$desig = getDesig();
	switch ($desig) {
		case 1: return "Administrator";
		case 2: return "Library Staff";
		case 3: return "Teacher";
		case 4: return "Student";
		default: return "";
	}
}

//getting the vault size if the logged in user is either teacher or student
function getVaultSize(){
	$desig = getDesig();
	if (isLogin() && $desig > 2){
		if ($desig == 3) $table = "teacher_details";
		else if ($desig  == 4) $table = "student_details";
		$conn = getConnection();
		$sql = "SELECT vault FROM $table WHERE user = '".$_SESSION['user']."'";
		$res = mysqli_fetch_assoc(mysqli_query($conn, $sql));
		return $res['vault'];
	} return "";
}

//getting the current issued books if the logged in user is either teacher or student
function getCurrentIssue(){
	$desig = getDesig();
	if (isLogin() && $desig > 2){
		$conn = getConnection();
		$sql = "SELECT COUNT(*) FROM issue_details WHERE user = '".$_SESSION['user']."'";
		$res = mysqli_fetch_assoc(mysqli_query($conn, $sql));
		return $res['COUNT(*)'];
	} return "";
}

//function to return the array containig the book ids of all the books issued
function getIssuedBooks($user){
	$desig = getDesig();
	if (isLogin() && $desig > 2){
		$arr = array();
		$conn = getConnection();
		$sql = "SELECT book_id FROM issue_details WHERE user = '$user'";
		$res = mysqli_query($conn, $sql);
		while ($row = mysqli_fetch_assoc($res)){
			array_push($arr, $row['book_id']);
		}
		return $arr;
	} else return array();
}

//function get all the issued books with all the details of issue
function getAllIssuedBooks(){
	$desig = getDesig();
	if (isLogin() && $desig == 2){
		$arr = array();
		$conn = getConnection();
		$dateToday = date("y-m-d");
		// for students
		$sql = "SELECT issue_id, issue_details.user, last_date, student_details.name, book_name FROM issue_details, student_details, books WHERE issue_details.user = student_details.user AND books.book_id = issue_details.book_id AND last_date >= '$dateToday'";
		$res = mysqli_query($conn, $sql);
		while ($row = mysqli_fetch_assoc($res)) {
			array_push($arr, array(
				"issue_id" => $row['issue_id'],
				"user" => $row['user'],
				"designation" => "Student",
				"name" => $row['name'],
				"book_name" => $row['book_name'],
				"last_date" => $row['last_date']
			));
		}
		//for teachers
		$sql = "SELECT issue_id, issue_details.user, last_date, teacher_details.name, book_name FROM issue_details, teacher_details, books WHERE issue_details.user = teacher_details.user AND books.book_id = issue_details.book_id AND last_date >= '$dateToday'";
		$res = mysqli_query($conn, $sql);
		while ($row = mysqli_fetch_assoc($res)) {
			array_push($arr, array(
				"issue_id" => $row['issue_id'],
				"user" => $row['user'],
				"designation" => "Teacher",
				"name" => $row['name'],
				"book_name" => $row['book_name'],
				"last_date" => $row['last_date']
			));
		}
		return $arr;
	} return array();
}

//function to return number of books requested
function getCurrentRequest(){
	$desig = getDesig();
	if (isLogin() && $desig > 2){
		$conn = getConnection();
		$dateToday = date("y-m-d");
		$sql = "SELECT COUNT(*) FROM request WHERE user = '".$_SESSION['user']."' AND last_date >= '$dateToday'";
		$res = mysqli_fetch_assoc(mysqli_query($conn, $sql));
		return $res['COUNT(*)'];
	} return "";
}

//function to return fine dues if logged in user is a student or a teacher
function getDues(){
	$desig = getDesig();
	if (isLogin() && $desig > 2){
		$conn = getConnection();
		$dateToday = date("y-m-d");
		$sql = "SELECT COUNT(*) FROM request WHERE user = '".$_SESSION['user']."' AND last_date < '$dateToday'";
		$amount = mysqli_fetch_assoc(mysqli_query($conn, $sql))['COUNT(*)'] * 100;
		$sql = "SELECT COUNT(*) FROM issue_details WHERE user = '".$_SESSION['user']."' AND last_date < '$dateToday'";
		$amount += mysqli_fetch_assoc(mysqli_query($conn, $sql))['COUNT(*)'] * 500;
		return $amount;
	} else return "";
}

//function for library staff to get the due fines details
function getDueDetails(){
	$desig = getDesig();
	if (isLogin() && $desig == 2){
		$conn = getConnection();
		$arr = array();
		$dateToday = date("y-m-d");
		$sql = "SELECT user, issue_id FROM issue_details WHERE last_date < '$dateToday'";
		$res = mysqli_query($conn, $sql);
		while ($row = mysqli_fetch_assoc($res)){
			$desig = mysqli_fetch_assoc(mysqli_query($conn, "SELECT desig FROM login WHERE user = '".$row['user']."'"))['desig'];
			$name = mysqli_fetch_assoc(mysqli_query($conn, "SELECT name FROM ".($desig==3?"teacher_details":$desig==4?"student_details":"")." WHERE user = '".$row['user']."'"))['name'];
			array_push($arr, array(
				"user" => $row['user'],
				/*
				Reason Code:
					1-> late return
					2-> false request
				*/
				"reason" => 1,
				"name" => $name,
				"id" => $row['issue_id']
			));
		}
		$sql = "SELECT req_id, user FROM request WHERE last_date < '$dateToday'";
		$res = mysqli_query($conn, $sql);
		while ($row = mysqli_fetch_assoc($res)) {
			$desig = mysqli_fetch_assoc(mysqli_query($conn, "SELECT desig FROM login WHERE user = '".$row['user']."'"))['desig'];
			$name = mysqli_fetch_assoc(mysqli_query($conn, "SELECT name FROM ".($desig==3?"teacher_details":$desig==4?"student_details":"")." WHERE user = '".$row['user']."'"))['name'];
			array_push($arr, array(
				"user" => $row['user'],
				//reason code defined above
				"reason" => 2,
				"name" => $name,
				"id" => $row['req_id']
			));
		}
		return $arr;
	} else return array();
}

//get book details based on their id
function getBook($id){
	$conn = getConnection();
	$sql = "SELECT * FROM books WHERE book_id = $id";
	$res = mysqli_fetch_assoc(mysqli_query($conn, $sql));
	return array(
		"title" => $res['book_name'],
		"isbn" => $res['isbn'],
		"volume" => $res['volume'],
		"writer" => $res['writer'],
		"publisher" => $res['pub'],
		"pages" => $res['pages'],
		"description" => $res['desc']
	);
}

//checks whether book id exist or not
function bookExists($book_id){
	$conn = getConnection();
	$sql = "SELECT COUNT(*) FROM books WHERE book_id = $book_id";
	$cnt = mysqli_fetch_assoc(mysqli_query($conn, $sql))['COUNT(*)'];
	return $cnt > 0? true : false;
}

//function to check whether the book is available or not
function isBookAvail($book_id){
	if (isLogin()){
		$conn = getConnection();
		$dateToday = date("y-m-d");
		$sql = "SELECT COUNT(*) FROM request WHERE book_id = $book_id AND last_date >= '$dateToday'";
		$cnt = mysqli_fetch_assoc(mysqli_query($conn, $sql))['COUNT(*)'];
		if ($cnt > 0) return false;
		$sql = "SELECT COUNT(*) FROM issue_details WHERE book_id = $book_id";
		$cnt = mysqli_fetch_assoc(mysqli_query($conn, $sql))['COUNT(*)'];
		if ($cnt > 0) return false;
		return true;
	} else return false;
}

//function to add request for the current logged in user if the user is a student or teacher
/*
	time before request to expire
	teacher -> 4 days after request is made
	student -> 2 days after request is made
*/
function addReq($book_id){
	$desig = getDesig();
	if (isLogin() && $desig > 2){
		$dateToday = date('y-m-d');
		$dateReturn = date("y-m-d",strtotime($desig==3?"+4 day":"+2 day", strtotime($dateToday)));
		$conn = getConnection();
		$sql = "INSERT INTO `request`(`user`, `book_id`, `req_date`, `last_date`) VALUES ('".$_SESSION['user']."','$book_id','$dateToday','$dateReturn')";
		if (mysqli_query($conn, $sql)) return true;
		return false;
	} return false;
}

//function to accept the request and issue the book based on the request id
/*
	time allotted after the book is issued
	teacher -> 21 days
	student -> 7 days
*/
function issueReq($req_id){
	$desig = getDesig();
	if (isLogin() && $desig < 3){
		$conn = getConnection();
		$sql = "SELECT user FROM request WHERE req_id = $req_id";
		$user = mysqli_fetch_assoc(mysqli_query($conn, $sql))['user'];
		$dateToday = date("y-m-d");
		$dateReturn = date("y-m-d", strtotime($desig==3?"+21 day":"+7 day", strtotime($dateToday)));
		$sql = "SELECT book_id FROM request WHERE req_id = $req_id";
		$book_id = mysqli_fetch_assoc(mysqli_query($conn, $sql))['book_id'];
		$sql = "INSERT INTO `issue_details`(`user`, `book_id`, `req_date`, `last_date`) VALUES ('$user','$book_id','$dateToday','$dateReturn')";
		if (mysqli_query($conn, $sql)){
			$sql = "DELETE FROM request WHERE req_id = $req_id";
			mysqli_query($conn, $sql);
			return true;
		}
		return false;
	} return false;
}

//delete the req from the database based on the request id
function delReq($req_id){
	$desig = getDesig();
	if (isLogin() && ($desig == 2 || $desig == 1)){
		$conn = getConnection();
		$sql = "DELETE FROM request WHERE req_id = $req_id";
		if (mysqli_query($conn, $sql)) return true;
		return false;
	} return false;
}

//check whether request id exists or not
function isReqId($req_id){
	$desig = getDesig();
	if (isLogin() && ($desig == 2 || $desig == 1)){
		$conn = getConnection();
		$sql = "SELECT COUNT(*) FROM request WHERE req_id = $req_id";
		$cnt = mysqli_fetch_assoc(mysqli_query($conn, $sql))['COUNT(*)'];
		return $cnt>0;
	} return false;
}

//check whether issue id exists or not
function isIssueId($issue_id){
	$desig = getDesig();
	if (isLogin() && ($desig == 2 || $desig == 1)){
		$conn = getConnection();
		$sql = "SELECT COUNT(*) FROM issue_details WHERE issue_id = $issue_id";
		$cnt = mysqli_fetch_assoc(mysqli_query($conn, $sql))['COUNT(*)'];
		return $cnt>0;
	} return false;
}

//get request data, returns the array containing specific data as keys
function getRequests(){
	$desig = getDesig();
	if (isLogin() && ($desig == 2 || $desig == 1)){
		$conn = getConnection();
		$dateToday = date("y-m-d");
		$sql = "SELECT * FROM request WHERE last_date >= '$dateToday'";
		$res = mysqli_query($conn, $sql);
		$arr = array();
		while ($row = mysqli_fetch_assoc($res)){			
			$sql = "SELECT desig FROM login WHERE user = '".$row['user']."'";
			$desig = mysqli_fetch_assoc(mysqli_query($conn, $sql))['desig'];
			switch ($desig) {
				case 3:
					$table = "teacher_details";
					break;
				case 4:
					$table = "student_details";
					break;
			}
			$sql = "SELECT name FROM $table WHERE user = '".$row['user']."'";
			$name = mysqli_fetch_assoc(mysqli_query($conn, $sql))['name'];
			$sql = "SELECT book_name FROM books WHERE book_id = ".$row['book_id']."";
			$book_name = mysqli_fetch_assoc(mysqli_query($conn, $sql))['book_name'];
			array_push($arr, array(
				"req_id" => $row['req_id'],
				"name" => $name,
				"user" => $row['user'],
				"book_name" => $book_name
			));
		}
		return $arr;
	} return array();
}

//logout function which just simply destroys the session
function logout(){
	session_unset();
	session_destroy();
}

?>