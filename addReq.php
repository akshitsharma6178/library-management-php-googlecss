<?php 

require("lib.php");
if (isLogin()){
	if (getDesig() > 2){
		if ($_SERVER['REQUEST_METHOD'] == "POST"){
			if (!empty($_POST['book_id'])){
				if (isBookAvail($_POST['book_id'])){
					if (getCurrentIssue() + getCurrentRequest() < getVaultSize()){
						if (addReq($_POST['book_id'])) echo "Successfully Requested";
						else echo "Error Occurred";
					} else echo "Vault size exceeded";
				} else echo "Book is not available";
			} else echo "Parameters error";
		} else header("location: index.php");
	} else echo "Unknown Exception";
} else echo "Please login first";

?>