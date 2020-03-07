<?php  
header("Access-Control-Allow-Origin: *");

	 if($_SERVER['REQUEST_METHOD'] !== 'POST') {
	 	echo json_encode(array('status' => false));
	 	exit;
	 }

	require_once('../../../fr/config/db.php'); 
	require_once('../../../fr/config/connexion.php'); 
//require_once('../../../fr/config/fonctions.php'); 
	require_once('../../../fr/functions.php'); 

				$postdata = file_get_contents("php://input");
	
	 			$data = json_decode($postdata, true);



