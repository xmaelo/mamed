<?php
	include('is_logged.php');//Vérifications des informations transmises*/
	include('is_admin.php');
	if (empty($_POST['mod_nom'])) {
           $errors[] = "Nom vide!";
        }elseif(empty($_POST['mod_datenaiss'])){
        	$errors[] = "Date de naissance vide!";
        } elseif(empty($_POST['mod_sexe'])){
        	$errors[] = "Sexe vide";
        } elseif(empty($_POST['mod_adresse'])){
        	$errors[] = "Adresse vide!";
        } elseif(empty($_POST['mod_telephone1'])){
        	$errors[] = "Téléphone vide!";
        } elseif (empty($_POST['mod_idspecialite'])) {
        	$errors[] = "Choisir une spécialité!";
        }elseif (empty($_POST['mod_anciennete'])) {
            $errors[] = "Ancinneté invalide!";        
        }elseif (empty($_POST['mod_idmedecin'])) {
            $errors[] = "Choisir un medécin!";        
        }elseif (empty($_POST['mod_idpersonne'])) {
            $errors[] = "Choisir un medécin!";        
        }elseif (
        	!empty($_POST['mod_nom']) 
        	&& !empty($_POST['mod_datenaiss']) 
        	&& !empty($_POST['mod_sexe']) 
        	&& !empty($_POST['mod_adresse']) 
            && !empty($_POST['mod_anciennete'])
        	&& !empty($_POST['mod_telephone1']) 
        	&& !empty($_POST['mod_idpersonne']) 
        	&& !empty($_POST['mod_idmedecin']) 
        	&& !empty($_POST['mod_idspecialite'])){ 


		/* Connect To Database*/
		require_once ("../config/db.php");//Contient les variables de configuration pour la base de données
		require_once ("../config/connexion.php");//Contient la fonction de connection à la base de données
        require_once('../functions.php'); 
			
		// escaping, additionally removing everything that could be (html/javascript-) code
		$nom=mysqli_real_escape_string($con,(strip_tags($_POST["mod_nom"],ENT_QUOTES)));
		$prenom=(isset($_POST['mod_prenom']) ? mysqli_real_escape_string($con,(strip_tags($_POST["mod_prenom"],ENT_QUOTES))) : '');
		$datenaiss=mysqli_real_escape_string($con,(strip_tags($_POST["mod_datenaiss"],ENT_QUOTES)));
		$sexe=mysqli_real_escape_string($con,(strip_tags($_POST["mod_sexe"],ENT_QUOTES)));
		$adresse=mysqli_real_escape_string($con,(strip_tags($_POST["mod_adresse"],ENT_QUOTES)));
		
		$telephone1=mysqli_real_escape_string($con,(strip_tags($_POST["mod_telephone1"],ENT_QUOTES)));
		$telephone2=(isset($_POST['mod_telephone2']) ? mysqli_real_escape_string($con,(strip_tags($_POST["mod_telephone2"],ENT_QUOTES))):'');

		$idpersonne=intval($_POST["mod_idpersonne"]);
		$idmedecin = intval($_POST["mod_idmedecin"]);
        $anciennete=intval($_POST["mod_anciennete"]);
		$idspecialite = intval($_POST['mod_idspecialite']);
        $datenaiss = date('Y-m-d', strtotime($datenaiss));
            
         //mise à jour des informations sur la personne
                $sql = "UPDATE personne SET nom = '".$nom."',  prenom = '".$prenom."', datenaiss='".$datenaiss."', sexe='".$sexe."', adresse='".$adresse."',  telephone1='".$telephone1."',  telephone2='".$telephone2."' WHERE idpersonne = '".$idpersonne."'";
                $query_update_personne = mysqli_query($con,$sql);               
                
                // mise à jour des informations sur le medecin
                    $sql2 = "UPDATE medecin SET  specialite_idspecialite ='".$idspecialite."', anciennete='".$anciennete."' WHERE idmedecin = '".$idmedecin."'";
                    $query_update_medecin = mysqli_query($con,$sql2);

                    if ($query_update_personne && $query_update_medecin){

                        $messages[] = "Données mise à jour avec succès";

                    } else{
                        $errors []= "Erreur!, réessayez.".mysqli_error($con);
                    }   

        }else{

        	$errors[] = "Erreur: Une erreur est survenue, veuillez contacter l'administrateur!";
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
