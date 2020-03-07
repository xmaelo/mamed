<?php if(isset($_SESSION['role']) && $_SESSION['role'] != 'Medecin'){

	header('Location: ../accueil.php');
	} ?>