<?php	
	session_start();
	if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
        
        if(!isset($_SESSION['etat']) AND $_SESSION['etat'] != 0){

        	header("location: ../login.php");
        }else{
	
        	header("location: ../validation.php");
        }
		
        
    }
?>    