<?php 

require("lib.php");
if ($_SERVER['REQUEST_METHOD'] == "POST"){
	$redirect = isset($_POST['redirect'])?$_POST['redirect']:"index.php";
	if (isLogin()){
		header("location: $redirect");
	} else {
		if (!empty($_POST['user']) && !empty($_POST['pass'])){
			if (checkLogin($_POST['user'], hash("md5",$_POST['pass']))){
				$_SESSION['user'] = $_POST['user'];
				$_SESSION['pass'] = hash("md5", $_POST['pass']);
				header("location: $redirect");
			} else
				header("location: $redirect?err=wrong%20user%20id%20or%20password");
		} else {
			header("location: $redirect?err=unknown%20error");
		}
	}
} else {
	//header("location: index.php");
	echo "here";
}

?>