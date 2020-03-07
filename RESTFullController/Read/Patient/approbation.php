<?php 
header("Access-Control-Allow-Origin: *");

	 if($_SERVER['REQUEST_METHOD'] !== 'POST') {
	 	echo json_encode(array('status' => false));
	 	exit;
	 }

	 $postdata = file_get_contents("php://input");
	
	 $data = json_decode($postdata, true);

	 //$idpersonne = $data['idpers'];
	 $idpersonne = intval($_GET['id']);



	 $retours = array(); 

	 //$password = $data['pass'];

session_start();//session starter for this user

require_once('../../../fr/config/db.php'); 
require_once('../../../fr/config/connexion.php'); 
//require_once('../../../fr/config/fonctions.php'); 
require_once('../../../fr/functions.php'); 


						$patient = get_personne($idpersonne, 'patient');
						$diabete = get_data($patient['diabete_iddiabete'], 'diabete', 1);

					$idpatient=$patient['idpatient'];
					$nom=$patient['nom'];
					$prenom = $patient['prenom']; 
						$poids=$patient['poids'];
						$taille=$patient['taille'];
					$imc = $patient['imc'];
						$interpretation = $patient['interpretation'];
											$datenaiss = $patient['datenaiss'];
					$datenaiss = get_date_fr($datenaiss);
											$sexe = $patient['sexe'];
						$personne_urgence = $patient['nom_contact_urgence'];
					   $telephone_urgence = $patient['telephone_contact_urgence'];
						$idtype_diabete = $patient['diabete_iddiabete'];
					$type_diabete = $diabete['type'];
						$telephone1 = $patient['telephone1'];
					$telephone2 = $patient['telephone2'];
					$email = $patient['email'];
						$picture = $patient['chemin'];
						$adresse = $patient['adresse'];
						$idpersonne = $patient['idpersonne'];
					$date_save=get_date_fr($patient['date_save']);
						$heure_apres_repas = get_row('unite_patient', 'heure_apres_repas', 'patient_idpatient', $idpatient);
					

//Element de anna


		$select_medecin = mysqli_query($con, "SELECT * FROM patient_has_medecin INNER JOIN medecin ON medecin_idmedecin = medecin.idmedecin INNER JOIN personne ON medecin.personne_idpersonne = personne.idpersonne AND medecin.lisible = 1 AND personne.lisible = 1 INNER JOIN specialite ON medecin.specialite_idspecialite = specialite.idspecialite AND specialite.lisible = 1 AND patient_has_medecin.patient_idpatient = '$idpatient' AND patient_has_medecin.approbation = 1");

		$medecini = mysqli_fetch_array($select_medecin);
		//echo $medecini['anciennete'];
		//die();

		/*******boucle de anna******/
		$select_medecint = mysqli_query($con, "SELECT * FROM patient_has_medecin INNER JOIN medecin ON medecin_idmedecin = medecin.idmedecin INNER JOIN personne ON medecin.personne_idpersonne = personne.idpersonne AND medecin.lisible = 1 AND personne.lisible = 1 INNER JOIN specialite ON medecin.specialite_idspecialite = specialite.idspecialite AND specialite.lisible = 1 AND patient_has_medecin.patient_idpatient = '$idpatient'");

		$photo= mysqli_query($con, "SELECT * FROM personne WHERE idpersonne=$idpersonne");

		if($photo) {

		$phto=mysqli_fetch_array($photo);
		$phot=$phto['chemin'];
		$_SESSION['phot']=$phot;
		$_SESSION['email']=$email;
		$_SESSION['idpersonne']=$idpersonne;
		
		}



	


	    							if($medecini['approbation']){

	                        			$retours['idphm'] = $idphm = $medecini['idpatient_has_medecin'];
										$retours['idmedecin'] = $idmedecin = $medecini['idmedecin'];

										$retours['medeciniNom'] = $medecini['nom'];
										$retours['medeciniPrenom'] = $medecini['prenom'];
										$retours['libelle'] = $medecini['libelle'];
										$retours['anciennete'] = $medecini['anciennete'];
										$retours['approbation'] = 'ok';


	                        		}

	                        		else {
	                        		

		                        					
	                        			$n=0;
		                        		while ($medecin=mysqli_fetch_array($select_medecint)) { 

		                        					$retours[$n]['idphm']= $idphm = $medecin['idpatient_has_medecin'];
													$retours[$n]['idmedecin'] = $idmedecin = $medecin['idmedecin'];

													$retours[$n]['medeciniNom'] = $medecin['nom'];
													$retours[$n]['medeciniPrenom'] = $medecin['prenom'];
													$retours[$n]['libelle'] = $medecin['libelle'];
													$retours[$n]['anciennete'] = $medecin['anciennete'];
													

											$n++;
				
			                        		
	                        			}
	                        		}


	                        		echo json_encode($retours); //data return to ionicApp by catrine

