<?php 

require("lib.php");
if ($_SERVER['REQUEST_METHOD'] == "POST"){
	if (isLogin() && getDesig() == 2){
		if (!empty($_POST['user']) && userExists($_POST['user'])){
			$err = "";
			if (!empty($_POST['req_id']) && isReqId($_POST['req_id'])){
				if(issueReq($_POST['req_id'])) echo "Success";
				else echo "Unable to process";
				exit();
			} else $err = "Invalid request id";
			if (!empty($_POST['book_id']) && bookExists($_POST['book_id']) && isBookAvail($_POST['book_id'])){
				$conn = getConnection();
				$dateToday = date("y-m-d");
				$dateReturn = date("y-m-d", strtotime("+7 days", strtotime($dateToday)));
				$sql = "INSERT INTO `issue_details`(`user`, `book_id`, `req_date`, `last_date`) VALUES ('".$_POST['user']."','".$_POST['book_id']."','$dateToday','$dateReturn')";
				if (mysqli_query($conn, $sql)) echo "Successfully Issued";
				else echo "Unable to issue";
				exit();
			} else  $err = "Book not Available";
			echo $err;
		} else echo "Invalid User";
	} else echo "Not Authorised";	
} else echo "Parameters error";

?>