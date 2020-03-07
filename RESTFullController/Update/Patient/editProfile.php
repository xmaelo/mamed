<?php  
header("Access-Control-Allow-Origin: *");

	 if($_SERVER['REQUEST_METHOD'] !== 'POST') {
	 	echo json_encode(array('status' => false));
	 	exit;
	 }

	require_once('../../../fr/config/db.php'); 
	require_once('../../../fr/config/connexion.php'); 
//require_once('../../../fr/config/fonctions.php'); 
	require_once('../../../fr/functions.php'); 

				$postdata = file_get_contents("php://input");
	
	 			$data = json_decode($postdata, true);

	 			$idpersonne = intval($_GET['id']);
	 			$idpatient = intval($_GET['idpatient']);
	 			$nom = $data['nom'];
	 			$prenom = $data['prenom'];
	 			$datenaiss = $data['datenaiss'];
	 			$sexe = $data['sexe'];
	 			$adresse = $data['adresse'];
	 			$telephone1 = $data['tel'];
	 			$telephone2 = $data['tel2'];
	 			//$nomphoto = $data['nomphoto'];
	 			$poids = intval($data['poids']);
	 			$taille = intval($data['taille']);
	 			$taille = intval($data['taille']);
	 			//$interpretation = $data['interpretation'];
	 			$nom_contact_urgence = $data['nom_contact_urgence'];
	 			$telephone_contact_urgence = $data['telephone_contact_urgence'];

	 			$iddiabete = intval($data['diabete_iddiabete']);

				$imc = calcul_IMC($poids, $taille);
				$interpretation = interpretation_IMC($imc);

session_start();//session starter for this user

$json='';




			$nomphoto = '';
        	$json='';

        	 function getNom(){
	             	$characts    = 'abcdefghijklmnopqrstuvwxyz';
				    $characts   .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
				    $characts   .= '1234567890';
				    $code_aleatoire      = '';
				 
				    for($i=0;$i < 4;$i++)
				    {
				        $code_aleatoire .=substr($characts,rand()%(strlen($characts)),1);
				    }

				    return $code_aleatoire;
	             }
	             $nomphoto = '';
	             if($nomphoto == ""){
								$nomphoto = "img/avatar_2x.png";
					}
				// else{									
				// 		$file_tmp_name=$_FILES['mod_picture']['tmp_name'];
				// 		$extension = pathinfo($nomphoto, PATHINFO_EXTENSION);
				// 		$extensions_autorisees = array('jpg', 'jpeg', 'gif', 'png','JPG');
				// 			if (in_array($extension, $extensions_autorisees))
				// 			{
				// 				$nomphoto = 'img/'.getNom().'.'.$extension;
				// 				move_uploaded_file($file_tmp_name,"../$nomphoto");
				// 			}
				// 			else
				// 			{
				// 				$nomphoto = "img/avatar_2x.png";
				// 			}
				






				$sql = "UPDATE personne SET nom = '".$nom."',  prenom = '".$prenom."', datenaiss='".$datenaiss."', sexe='".$sexe."', adresse='".$adresse."',  telephone1='".$telephone1."',  telephone2='".$telephone2."', chemin='".$nomphoto."' WHERE idpersonne = '".$idpersonne."'";
            	$query_update_personne = mysqli_query($con,$sql);     

            	///2nd requete

            	$sql2 = "UPDATE patient SET  poids ='".$poids."', taille = '".$taille."',  imc= '".$imc."', interpretation='".$interpretation."', nom_contact_urgence='".$nom_contact_urgence."', 	telephone_contact_urgence='".$telephone_contact_urgence."', diabete_iddiabete = '".$iddiabete."' WHERE idpatient = '".$idpatient."'";
            		$query_update_patient = mysqli_query($con,$sql2);


            	if ($query_update_personne && $query_update_patient){

						//$messages[] = "Données mise à jour avec succès";

						$json = 'success';

					}


				echo json_encode($json);

