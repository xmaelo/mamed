
<?php  
header("Access-Control-Allow-Origin: *");

	 if($_SERVER['REQUEST_METHOD'] !== 'POST') {
	 	echo json_encode(array('status' => false));
	 	exit;
	 }

	 $postdata = file_get_contents("php://input");
	
	 $data = json_decode($postdata, true);

	 $idunite = intval($_GET['idunite']);

	 $idpatient = intval($_GET['id']);


	 	require_once('../../../fr/config/db.php'); 
		require_once('../../../fr/config/connexion.php'); 
	//require_once('../../../fr/config/fonctions.php'); 
		require_once('../../../fr/functions.php'); 

			$retours = '0000';


			  $sql2 = "UPDATE unite_patient SET unite_idunite = '$idunite' WHERE patient_idpatient = '$idpatient'";
        	  $query_update_unite_patient = mysqli_query($con,$sql2);

        	  if($query_update_unite_patient){
        	  	$retours="success";
        	  }

        	  echo json_encode($retours);