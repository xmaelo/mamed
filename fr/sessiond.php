<?php 
include('is_logged.php');
	//include('is_medecin.php');
	/* Connect To Database*/
	require_once ("config/db.php");
	require_once ("config/connexion.php");
	require_once ("functions.php");

	session_destroy();

 ?>