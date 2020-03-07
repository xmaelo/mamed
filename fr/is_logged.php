<?php
	
	session_start();
	if (!isset($_SESSION['user_login_status'])){

		header("location: login.php");
		exit();
	}elseif(isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1){   
        header("location: validation.php");
		exit;
    }
 ?>   