<?php  
header("Access-Control-Allow-Origin: *");

	 if($_SERVER['REQUEST_METHOD'] !== 'POST') {
	 	echo json_encode(array('status' => false));
	 	exit;
	 }

	 $postdata = file_get_contents("php://input");
	
	 $data = json_decode($postdata, true);

	 //$operator = $_GET['operator'];

	 $idpersonne = intval($_GET['id']);

 
	 	require_once('../../../fr/config/db.php'); 
		require_once('../../../fr/config/connexion.php'); 
	//require_once('../../../fr/config/fonctions.php'); 
		require_once('../../../fr/functions.php'); 


			$retours =array();


			$ajax = mysqli_query($con, "SELECT * from patient WHERE personne_idpersonne = $idpersonne");

			$get = mysqli_fetch_array($ajax);

			

			//$value =  $get[$operator];
			//var_dump($get['activeRepas']);


			//$ajax = mysqli_query($con, "UPDATE patient set $operator=!$value WHERE personne_idpersonne = $idpersonne");

			if ($ajax) {
				//$retours='success';
				$retours['activeRepas'] = $get['activeRepas'];
				$retours['activeHypo'] = $get['activeHypo'];
			}
			else{
				$retours['null']='error http foundation response';
			}

			echo json_encode($retours);