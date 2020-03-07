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

					$retours['idpatient'] =	$idpatient=$patient['idpatient'];
					$retours['nom'] =	$nom=$patient['nom'];
					$retours['prenom'] =	$prenom = $patient['prenom']; 
					$retours['poids'] =	$poids=$patient['poids'];
					$retours['taille'] =	$taille=$patient['taille'];
					$retours['imc'] =	$imc = $patient['imc'];
					$retours['interpretation'] =	$interpretation = $patient['interpretation'];
											$datenaiss = $patient['datenaiss'];
					$retours['datenaiss'] =	$datenaiss = get_date_fr($datenaiss);
											$sexe = $patient['sexe'];
					$retours['nom_contact_urgence'] =	$personne_urgence = $patient['nom_contact_urgence'];
					$retours['telephone_contact_urgence'] =   $telephone_urgence = $patient['telephone_contact_urgence'];
					$retours['diabete_iddiabete'] =	$idtype_diabete = $patient['diabete_iddiabete'];
					$retours['type'] =	$type_diabete = $diabete['type'];
					$retours['tel'] =	$telephone1 = $patient['telephone1'];
					$retours['tel2'] =	$telephone2 = $patient['telephone2'];
					$retours['email'] =	$email = $patient['email'];
					$retours['chemin'] =	$picture = $patient['chemin'];
					$retours['adresse'] =	$adresse = $patient['adresse'];
					$retours['idpersonne'] =	$idpersonne = $patient['idpersonne'];
					$retours['date_save'] =	$date_save=get_date_fr($patient['date_save']);
					$retours['heure_apres_repas'] =	$heure_apres_repas = get_row('unite_patient', 'heure_apres_repas', 'patient_idpatient', $idpatient);
					$retours['approbation'] = '00';

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



	    $retours['sexe'] = get_sexe($sexe);


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
		                        					$idphm = $medecin['idpatient_has_medecin'];

		                        					$retours[$idphm]['idphm']= $idphm = $medecin['idpatient_has_medecin'];
													$retours[$idphm]['idmedecin'] = $idmedecin = $medecin['idmedecin'];

													$retours[$idphm]['medeciniNom'] = $medecin['nom'];
													$retours[$idphm]['medeciniPrenom'] = $medecin['prenom'];
													$retours[$idphm]['libelle'] = $medecin['libelle'];
													$retours[$idphm]['anciennete'] = $medecin['anciennete'];
													$retours['approbation'] = 'Nok';

											$n++;
				
			                        		
	                        			}
	                        		}


	                        		echo json_encode($retours); //data return to ionicApp by catrine

