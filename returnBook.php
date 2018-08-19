<?php 

require("lib.php");
if ($_SERVER["REQUEST_METHOD"] == "POST"){
	if (isLogin() && getDesig() == 2){
		if (!empty($_POST['issue_id']) && isIssueId($_POST['issue_id'])){
			$conn = getConnection();
			$sql = "DELETE FROM issue_details WHERE issue_id = ".$_POST['issue_id'];
			if (mysqli_query($conn, $sql)) echo "Successfully Completed";
			else echo "Error occured";
		} else echo "Invalid Issue Id";
	} else echo "Not authorised";
} else echo "Unknown request";

?>