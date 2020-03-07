<?php 

	include('is_logged.php');
	/* Connect To Database*/
	require_once ("config/db.php");
	require_once ("config/connexion.php");
	require_once ("functions.php");


//session_start();

$idpersonne = $_SESSION['idpersonne'];

	$ajax = mysqli_query($con, "SELECT * FROM patient WHERE personne_idpersonne = $idpersonne");

	$array = mysqli_fetch_array($ajax);

	$time = $array['heures'];

	//var_dump($time);
	echo $time;

	// echo json_encode($time);









 ?>