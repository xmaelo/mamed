<?php  
header("Access-Control-Allow-Origin: *");

	 if($_SERVER['REQUEST_METHOD'] !== 'POST') {
	 	echo json_encode(array('status' => false));
	 	exit;
	 }

	 $postdata = file_get_contents("php://input");
	
	 $data = json_decode($postdata, true);

	 $creneau = intval($data['creneau']);
	 $valeur = $data['valuer'];
	 $insuline = $data['insuline1'];
	 $insuline2 = $data['insuline2'];
	 $pression_arterielle = $data['pression_arterielle'];
	 $acetone = $data['acetone'];
	 $notes = $data['notes'];
	 $hba1c = $data['hba1c'];

	 //$password = $data['pass'];

	 $idpatient = intval($_GET['id']);

session_start();//session starter for this user

$json='hjhjh';

require_once('../../../fr/config/db.php'); 
require_once('../../../fr/config/connexion.php'); 
//require_once('../../../fr/config/fonctions.php'); 
require_once('../../../fr/functions.php'); 

	        $date_save = date("Y-m-d");

            $req = "INSERT INTO journal VALUES(NULL, NOW(), '$creneau', '$valeur', '$insuline', '$insuline2', '$pression_arterielle', '$acetone', '$hba1c', '$notes', '$date_save', 1, '$idpatient')";

          // var_dump($req);
            if(mysqli_query($con, $req)){

                $json='succes';
            }

            echo json_encode($json);