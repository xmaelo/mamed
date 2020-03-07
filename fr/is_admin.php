<?php if(isset($_SESSION['role']) && $_SESSION['role'] != 'Administrateur'){

	header('Location: accueil.php');
	} ?>