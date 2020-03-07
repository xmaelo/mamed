<?php 

	include('is_logged.php');
	/* Connect To Database*/
	require_once ("config/db.php");
	require_once ("config/connexion.php");
	require_once ("functions.php");

	$idpersonne = $_SESSION['idpersonne'];

	// var_dump($idpersonne);
	// die();


			
			$ajax = mysqli_query($con, "SELECT * from patient WHERE personne_idpersonne = $idpersonne");

			$get = mysqli_fetch_array($ajax);

			$value =  $get['activeHypo'];
			//var_dump($get['activeRepas']);


			$ajax = mysqli_query($con, "UPDATE patient set activeHypo=!$value WHERE personne_idpersonne = $idpersonne");

			if ($ajax) {
				//$return = 
			}



 ?>