
<?php  
header("Access-Control-Allow-Origin: *");

	 if($_SERVER['REQUEST_METHOD'] !== 'POST') {
	 	echo json_encode(array('status' => false));
	 	exit;
	 }

	 $postdata = file_get_contents("php://input");
	
	 $data = json_decode($postdata, true);

	 $creneau = intval($data['creneau']);
	 $valeur = $data['value'];
	 $insuline = $data['insuline1'];
	 $insuline2 = $data['insuline2'];
	 $pression_arterielle = $data['pression_arterielle'];
	 $acetone = $data['acetone'];
	 $notes = $data['notes'];
	 $hba1c = $data['hba1c'];

	 //$password = $data['pass'];

	 $idjournal = intval($_GET['id']);

session_start();//session starter for this user

$json='';

require_once('../../../fr/config/db.php'); 
require_once('../../../fr/config/connexion.php'); 
//require_once('../../../fr/config/fonctions.php'); 
require_once('../../../fr/functions.php'); 

	
	


	  $req = "UPDATE journal SET mesure_idmesure = '$creneau', valeur = '$valeur', insuline = '$insuline', insuline2 = '$insuline2', pression_arterielle = '$pression_arterielle', acetone = '$acetone', hba1c = '$hba1c', notes = '$notes' WHERE idjournal = '$idjournal'";



	 if(mysqli_query($con, $req)){
	 	$json = 'succes';
	 }

	 echo json_encode($json);