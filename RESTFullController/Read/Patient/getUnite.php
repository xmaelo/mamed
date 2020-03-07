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



	 $retours = array();  

	 //$password = $data['pass'];

session_start();//session starter for this user

require_once('../../../fr/config/db.php'); 
require_once('../../../fr/config/connexion.php'); 
//require_once('../../../fr/config/fonctions.php'); 
require_once('../../../fr/functions.php'); 

$query_unites = mysqli_query($con, "SELECT * FROM unite");
$unite_patient = get_all_row('unite_patient', 'patient_idpatient', $idpatient);

$i=0;
while ($unites=mysqli_fetch_array($query_unites)) {

			$retours[$i]['idunite'] = $unites['idunite'];
			$retours[$i]['libelle'] = $unites['libelle'];

			if($unites['idunite'] == $unite_patient['unite_idunite'])
			{

			$retours[$i]['checked'] = '1';

			}
			else {
			$retours[$i]['checked'] = '0';

			}
		$i++;
						
		}

	echo json_encode($retours);