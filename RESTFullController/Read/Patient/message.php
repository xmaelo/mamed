<?php 
header("Access-Control-Allow-Origin: *");

	
	 $postdata = file_get_contents("php://input");
	
	 $data = json_decode($postdata, true);

	 //$idpersonne = $data['idpers'];
	 $idpatient = intval($_GET['id']);

	  $q = $_GET['q'];



	 $retour = array(); 

	 //$password = $data['pass'];

session_start();//session starter for this user

require_once('../../../fr/config/db.php'); 
require_once('../../../fr/config/connexion.php'); 
//require_once('../../../fr/config/fonctions.php'); 
require_once('../../../fr/functions.php'); 

	 $requete = "SELECT idmessage, sujet, message, idpatient, expediteur, medecin_idmedecin, message.etat as etat, heure, message.date_save as date_save FROM message 
		 				INNER JOIN patient ON patient_idpatient = patient.idpatient
		 				AND patient.lisible = 1 
		 				AND message.lisible = 1 
		 				AND message.patient_idpatient = '$idpatient' ";


		
		 if ( $_GET['q'] == "undefined" || $_GET['q'] == "" )
		 {

		 }

		 else
		{
			
			$requete = $requete." AND mesure.libelle LIKE '%".$q."%' OR journal.date_save LIKE '%".$q."%' OR journal.heure LIKE '%".$q."%'";
		}


		$sql = $requete." ORDER By message.date_save, message.heure";
		//var_dump($sql);
		$query = mysqli_query($con, $sql);

		$n =0;
		while ($row=mysqli_fetch_array($query)){
						$retour[$n]['idmessage'] = $idmessage = $row['idmessage'];
						$retour[$n]['etat'] = $etat=$row['etat'];
						$retour[$n]['expediteur'] = $expediteur = $row['expediteur'];
						$retour[$n]['objet'] = $objet = $row['sujet'];
						$retour[$n]['message'] = $message = $row['message'];
						$retour[$n]['idmedecin'] = $idmedecin=$row['medecin_idmedecin'];
						$retour[$n]['idpatient'] = $idpatient = $row['idpatient'];
						$retour[$n]['heure'] = $heure = $row['heure'];
						$retour[$n]['date_save'] = $date_save=get_date_fr($row['date_save']);
						$retour[$n]['medecin'] = $medecin = get_medecin($idmedecin);

						$reqest = "SELECT * FROM medecin, personne WHERE idmedecin=$idmedecin AND personne.idpersonne=medecin.personne_idpersonne";
						$queryMed = mysqli_query($con, $reqest);
						$PhotM=mysqli_fetch_array($queryMed);
						$retour[$n]['phott'] = $phott='http://localhost/mamed/fr/'.$PhotM['chemin'];

					



		$n++;


		}

		echo json_encode($retour);



		