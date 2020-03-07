<?php if(isset($_SESSION['role']) && $_SESSION['role'] != 'Patient'){

	header('Location: ../accueil.php');
	} 
?>