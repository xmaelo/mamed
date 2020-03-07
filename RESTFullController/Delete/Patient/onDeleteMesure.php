<?php 
header("Access-Control-Allow-Origin: *");


	
	 $postdata = file_get_contents("php://input"); 
	 
	 $data = json_decode($postdata, true);

	 //$idpersonne = $data['idpers'];
	 //$idpatient = intval($_GET['idpatient']);
	 $id = intval($_GET['id']);
	 //$idmedecin = intval($_GET['idmedecin']);

	 // $q = $_GET['q'];



	 $retours = array(); 

	 //$password = $data['pass'];

session_start();//session starter for this user
$json = 0;

require_once('../../../fr/config/db.php'); 
require_once('../../../fr/config/connexion.php'); 
//require_once('../../../fr/config/fonctions.php'); 
require_once('../../../fr/functions.php');  


$delete1=mysqli_query($con,"UPDATE journal set lisible = 0 where idjournal='".$id."'");

	if($delete1){
		$json='succes';
	}
	
	echo json_encode($json);