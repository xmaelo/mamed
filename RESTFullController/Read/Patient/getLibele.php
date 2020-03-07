<?php  

header("Access-Control-Allow-Origin: *");

	 if($_SERVER['REQUEST_METHOD'] !== 'POST') {
	 	echo json_encode(array('status' => false));
	 	exit;
	 }

	 $postdata = file_get_contents("php://input");
	
	 $data = json_decode($postdata, true);

	 //$idpersonne = $data['idpers'];
	 //$idpersonne = intval($_GET['id']);



	 $retours = array(); 

	 //$password = $data['pass'];

session_start();//session starter for this user

require_once('../../../fr/config/db.php'); 
require_once('../../../fr/config/connexion.php'); 
//require_once('../../../fr/config/fonctions.php'); 
require_once('../../../fr/functions.php'); 

$get=mysqli_query($con,"SELECT *  from mesure");
$n=0;

	while ($result=mysqli_fetch_array($get)) {
		$retours[$n]['libelle']=$result['libelle'];
		$retours[$n]['idmesure']=$result['idmesure'];
		$n++;
	}

	echo json_encode($retours);
