<?php 
	header("Access-Control-Allow-Origin: *");

		  // if($_SERVER['REQUEST_METHOD'] !== 'POST') {
		  // 	echo json_encode(array('status' => false));
		  // 	exit;
		  // }

		$postdata = file_get_contents("php://input");
		
		 $data = json_decode($postdata, true);

		 //$idpersonne = $data['idpers'];
		 $idpersonne = intval($_GET['id']);
		 $q = $_GET['q'];
	




		 $retours = array(); 

		 //$password = $data['pass'];

	session_start();//session starter for this user

	require_once('../../../fr/config/db.php'); 
	require_once('../../../fr/config/connexion.php'); 
	//require_once('../../../fr/config/fonctions.php'); 
	require_once('../../../fr/functions.php'); 



	$requete = "SELECT distinct * FROM journal 
		 				INNER JOIN mesure ON mesure_idmesure = mesure.idmesure 
		 				INNER JOIN patient ON journal.patient_idpatient = patient.idpatient 
		 				AND patient.lisible = 1 
		 				AND journal.lisible = 1 
		 				AND journal.patient_idpatient = '$idpersonne'";

		 if ( $_GET['q'] == "undefined" || $_GET['q'] == "" )
		 {

		 }

		 else 
		{
			
			$requete = $requete." AND mesure.libelle LIKE '%".$q."%' OR journal.date_save LIKE '%".$q."%' OR journal.heure LIKE '%".$q."%'";
		}

		$sql = $requete."ORDER By journal.date_save, journal.heure DESC";
		//var_dump($sql);
		$query = mysqli_query($con, $sql);

		$n = 0; 
		$arr = array();
		while ($row=mysqli_fetch_array($query))
		{
			$retours[$n]['insuline1'] = $row['insuline'];
			$retours[$n]['libelle'] = $row['libelle'];
			$retours[$n]['valeur'] =  $row['valeur'].' '.get_unite($row['idpatient']);
			$retours[$n]['insuline'] = $row['insuline'].' / '.$row['insuline2']; 
			$retours[$n]['insuline2'] = $row['insuline2'];
			

			$retours[$n]['value'] =  $row['valeur'];


			$retours[$n]['pression_arterielle'] = $row['pression_arterielle']; 
			$retours[$n]['hba1c'] = $row['hba1c'];
			$retours[$n]['acetone']= $row['acetone'];
			$retours[$n]['notes'] = $row['notes'];
			$retours[$n]['idjournal'] = $row['idjournal'];
			$retours[$n]['idmesure'] = $row['idmesure'];
			$retours[$n]['date'] = date('d-m-Y', strtotime($row['date_save'])).' '.$row['heure'];
			$n++;
		}

		echo json_encode($retours);