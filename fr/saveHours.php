<?php 


	include('is_logged.php');
	/* Connect To Database*/
	require_once ("config/db.php");
	require_once ("config/connexion.php");
	require_once ("functions.php");

	$idpersonne = $_SESSION['idpersonne'];


		if ($_POST['startstop']) {
			$heure = $_POST['startstop'];
			$ajax = mysqli_query($con, "UPDATE patient set heures='".$heure."' WHERE personne_idpersonne = $idpersonne");

			if($ajax) {  
				echo 'success';
			}
			
		}
		else {
			echo 'Entrez une heure valide';
		}

		

 ?>