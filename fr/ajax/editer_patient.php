<?php
	include('is_logged.php');//Vérifications des informations transmises*/

	
		if (empty($_POST['mod_nom'])) {
           $errors[] = "Nom vide!";
        }elseif(empty($_POST['mod_datenaiss'])){
        	$errors[] = "Date de naissance vide!";
        } elseif(empty($_POST['mod_sexe'])){
        	$errors[] = "Sexe vide";
        } elseif(empty($_POST['mod_adresse'])){
        	$errors[] = "Adresse vide!";
        }  elseif(empty($_POST['mod_poids'])){
        	$errors[] = "Poids vide!";
        } elseif(empty($_POST['mod_taille'])){
        	$errors[] = "Taille vide!";
        } elseif(empty($_POST['mod_telephone1'])){
        	$errors[] = "Téléphone vide!";
        } elseif(empty($_POST['mod_personne_urgence'])){
        	$errors[] = "Personne d'urgence vide!";
        } elseif(empty($_POST['mod_telephone_urgence'])){
        	$errors[] = "Téléphone contact d'urgence vide!";
        } elseif (empty($_POST['mod_idtype_diabete'])) {
        	$errors[] = "Choisir un type de diabète!";
        } elseif (empty($_POST['mod_idpersonne'])) {
        	$errors[] = "Choisir un patient";
        } elseif (empty($_POST['mod_idpatient'])) {
        	$errors[] = "Choisir un patient";
        }elseif (!is_numeric($_POST['mod_poids'])) {
        	$errors[] = "Valeur invalide pour le poids";
        }elseif ($_POST['mod_poids'] <= 0) {
        	$errors[] = "Valeur négative pour le poids!";
        }elseif (
        	!empty($_POST['mod_nom']) 
        	&& !empty($_POST['mod_datenaiss']) 
        	&& !empty($_POST['mod_sexe']) 
        	&& !empty($_POST['mod_adresse']) 
        	&& !empty($_POST['mod_poids']) 
        	&& !empty($_POST['mod_taille']) 
        	&& !empty($_POST['mod_telephone1']) 
        	&& !empty($_POST['mod_idtype_diabete']) 
        	&& !empty($_POST['mod_personne_urgence']) 
        	&& !empty($_POST['mod_telephone_urgence'])
        	&& !empty($_POST['mod_idpatient'])
        	&& !empty($_POST['mod_idpersonne'])){


        	//code ajouter


        	
				// 	if (isset($_POST['pass']) && isset($_POST['confPass'])) {
				// 	$pass=$_POST['pass'];
				// 	$confPass=['confPass'];
				// 	if ($pass==$confPass) {

				// 		$sq = "UPDATE personne SET password = '".$pass."'";
    //         			$query_update_password_personne = mysqli_query($con,$sq);  
						
				// 	}

				// 	else{
				// 		$e ="error";
				// 	}
				// }

        	
        	
        	$nomphoto = '';
        	$e='';


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
	             $nomphoto = $_FILES['mod_picture']['name'];
	             if($nomphoto == ""){
								$nomphoto = "img/avatar_2x.png";
					}
				else{									
						$file_tmp_name=$_FILES['mod_picture']['tmp_name'];
						$extension = pathinfo($nomphoto, PATHINFO_EXTENSION);
						$extensions_autorisees = array('jpg', 'jpeg', 'gif', 'png','JPG');
							if (in_array($extension, $extensions_autorisees))
							{
								$nomphoto = 'img/'.getNom().'.'.$extension;
								move_uploaded_file($file_tmp_name,"../$nomphoto");
							}
							else
							{
								$nomphoto = "img/avatar_2x.png";
							}
				}



				


		/* Connect To Database*/
		require_once ("../config/db.php");//Contient les variables de configuration pour la base de données
		require_once ("../config/connexion.php");//Contient la fonction de connection à la base de données
		require_once('../functions.php'); 
			
		// escaping, additionally removing everything that could be (html/javascript-) code
		$nom=mysqli_real_escape_string($con,(strip_tags($_POST["mod_nom"],ENT_QUOTES)));
		$prenom=(isset($_POST['mod_prenom']) ? mysqli_real_escape_string($con,(strip_tags($_POST["mod_prenom"],ENT_QUOTES))) : '');
		$datenaiss=mysqli_real_escape_string($con,(strip_tags($_POST["mod_datenaiss"],ENT_QUOTES)));
		$datenaiss = date('Y-m-d', strtotime($datenaiss));
		$sexe=mysqli_real_escape_string($con,(strip_tags($_POST["mod_sexe"],ENT_QUOTES)));
		$adresse=mysqli_real_escape_string($con,(strip_tags($_POST["mod_adresse"],ENT_QUOTES)));
				
		$telephone1=mysqli_real_escape_string($con,(strip_tags($_POST["mod_telephone1"],ENT_QUOTES)));
		$telephone2=(isset($_POST['mod_telephone2']) ? mysqli_real_escape_string($con,(strip_tags($_POST["mod_telephone2"],ENT_QUOTES))):'');
		$poids=mysqli_real_escape_string($con,(strip_tags($_POST["mod_poids"],ENT_QUOTES)));
		$taille=mysqli_real_escape_string($con,(strip_tags($_POST["mod_taille"],ENT_QUOTES)));
		$nom_contact_urgence=mysqli_real_escape_string($con,(strip_tags($_POST["mod_personne_urgence"],ENT_QUOTES)));

		$telephone_contact_urgence=mysqli_real_escape_string($con,(strip_tags($_POST["mod_telephone_urgence"],ENT_QUOTES)));
		$idpersonne= intval($_POST["mod_idpersonne"]);
		$idpatient = intval($_POST["mod_idpatient"]);
		$iddiabete = intval($_POST['mod_idtype_diabete']);

		$imc = calcul_IMC($poids, $taille);
		$interpretation = interpretation_IMC($imc);


				///mon peti code


				///end my peti code

            	//mise à jour des informations sur la personne
            	$sql = "UPDATE personne SET nom = '".$nom."',  prenom = '".$prenom."', datenaiss='".$datenaiss."', sexe='".$sexe."', adresse='".$adresse."',  telephone1='".$telephone1."',  telephone2='".$telephone2."', chemin='".$nomphoto."' WHERE idpersonne = '".$idpersonne."'";
            	$query_update_personne = mysqli_query($con,$sql);            	
            	
            	// mise à jour des informations sur le diabete
            		$sql2 = "UPDATE patient SET  poids ='".$poids."', taille = '".$taille."',  imc= '".$imc."', interpretation='".$interpretation."', nom_contact_urgence='".$nom_contact_urgence."', 	telephone_contact_urgence='".$telephone_contact_urgence."', diabete_iddiabete = '".$iddiabete."' WHERE idpatient = '".$idpatient."'";
            		$query_update_patient = mysqli_query($con,$sql2);

            		if ($query_update_personne && $query_update_patient){

						//$messages[] = "Données mise à jour avec succès";

						echo json_encode($e);

					} else{
						$errors []= "Erreur!, réessayez.".mysqli_error($con);
						echo json_encode($errors);
					}
            
            
        }else{

        	$errors = "Error: An error has occurred, please contact the administrator! second";
        	echo json_encode($errors);
        }    
           
	if (isset($errors)){
			
			?>
			<div class="alert alert-danger" role="alert">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
					<strong>Error!</strong> 
					<?php
						foreach ($errors as $error) {
								echo $error;
							}
						?>
			</div>
			<?php
			}
			if (isset($messages)){
				
				?>
				<div class="alert alert-success" role="alert">
						<button type="button" class="close" data-dismiss="alert">&times;</button>
						<strong>Cool !</strong>
						<?php
							foreach ($messages as $message) {
									echo $message;
								}
							?>
				</div>
				<?php
			}

?>
