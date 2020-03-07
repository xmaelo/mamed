
<?php  
header("Access-Control-Allow-Origin: *");

	 if($_SERVER['REQUEST_METHOD'] !== 'POST') {
	 	echo json_encode(array('status' => false));
	 	exit;
	 }

	 $postdata = file_get_contents("php://input");
	
	 $data = json_decode($postdata, true);

	 $idmesure = intval($_GET['idmesure']);

	 $idpatient = intval($_GET['id']);


	 	require_once('../../../fr/config/db.php'); 
		require_once('../../../fr/config/connexion.php'); 
	//require_once('../../../fr/config/fonctions.php'); 
		require_once('../../../fr/functions.php'); 

			$retours = '0000';

	 			$select = "SELECT * from mesure_patient WHERE patient_idpatient = '$idpatient' AND mesure_idmesure = '$idmesure'";

	 			$execute = mysqli_query($con, $select);

	 			$result = mysqli_fetch_array($execute);
	 			$etat = $result['etat'];

	 			if($etat=='1'){
	 				$etat='0';
	 			}
	 			elseif($etat=='0'){
	 				$etat = '1';
	 			}




	 			 $sql = "UPDATE mesure_patient SET etat = '$etat' WHERE patient_idpatient = '$idpatient' AND mesure_idmesure = '$idmesure'";
                $query_update_mesure_patient = mysqli_query($con,$sql);


                if($query_update_mesure_patient){
                	$retours = 'success';
                }

                echo json_encode($retours);