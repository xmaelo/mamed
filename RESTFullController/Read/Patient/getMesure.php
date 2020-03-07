<?php  
header("Access-Control-Allow-Origin: *");

	 if($_SERVER['REQUEST_METHOD'] !== 'POST') {
	 	echo json_encode(array('status' => false));
	 	exit;
	 }

	 $postdata = file_get_contents("php://input");
	
	 $data = json_decode($postdata, true);

	 //$idpatient = $data['id'];
	 $idpatient = intval($_GET['id']);

	 
session_start();//session starter for this user

require_once('../../../fr/config/db.php'); 
require_once('../../../fr/config/connexion.php'); 
//require_once('../../../fr/config/fonctions.php'); 
require_once('../../../fr/functions.php'); 



	 $retours = array();  

	 //$password = $data['pass'];


$query_mesures = mysqli_query($con, "SELECT * FROM mesure_patient INNER JOIN mesure ON mesure_idmesure = idmesure AND patient_idpatient = '$idpatient'");
$i=0;

	while($mesures = mysqli_fetch_array($query_mesures)){

		$retours[$i]['libelle']=$mesures['libelle'];
		$retours[$i]['idmesure']=$mesures['idmesure'];

		if ($mesures['etat']){
			$retours[$i]['checked'] = '1';
		}
		else
		{
			$retours[$i]['checked'] = '0';
		}

		$i++;
								 
	}
	echo json_encode($retours);