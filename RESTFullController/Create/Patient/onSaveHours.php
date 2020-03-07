<?php 
header("Access-Control-Allow-Origin: *");


	
	 $postdata = file_get_contents("php://input"); 
	 
	 $data = json_decode($postdata, true);

	 //$idpersonne = $data['idpers'];
	 //$idpatient = intval($_GET['idpatient']);
	 $idpersonne = intval($_GET['idpersonne']);
	// $idmedecin = intval($_GET['idmedecin']);

	 // $q = $_GET['q'];



	 $retours = array(); 

	 //$password = $data['pass'];

session_start();//session starter for this user
$json = 0;

require_once('../../../fr/config/db.php'); 
require_once('../../../fr/config/connexion.php'); 
//require_once('../../../fr/config/fonctions.php'); 
require_once('../../../fr/functions.php');  

	$heure = $_GET['startstop'];
			$ajax = mysqli_query($con, "UPDATE patient set heuresH='".$heure."' WHERE personne_idpersonne = $idpersonne");

			if($ajax) {  
					$json = 'success';
				}
				
			
			else {
				$json =  'Entrez une heure valide';
			}


			echo json_encode($json);