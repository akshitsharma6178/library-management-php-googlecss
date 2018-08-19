<?php 

require("lib.php");
if ($_SERVER['REQUEST_METHOD'] == "POST"){
	if (!empty($_POST['req_id']) && isReqId($_POST['req_id'])){
		if (delReq($_POST['req_id'])) echo "Deleted Successfully";
		else echo "Unable to delete request";
	} else echo "Invalid Rquest Id";
} else echo "Unknown request";

?>