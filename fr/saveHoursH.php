<?php 

include('is_logged.php');
	/* Connect To Database*/
	require_once ("config/db.php");
	require_once ("config/connexion.php");
	require_once ("functions.php");

	$idpersonne = $_SESSION['idpersonne'];


		if ($_POST['startstopc']) {
			$heure = $_POST['startstopc'];
			$ajax = mysqli_query($con, "UPDATE patient set heuresH='".$heure."' WHERE personne_idpersonne = $idpersonne");

			if($ajax) {
				echo 'success';
			}
			
		}
		else {
			echo 'Entrez une heure valide';
		}

 ?>