<?php
	include('is_logged.php');//Vérifications des informations transmises*/
    include('is_admin.php');
	if (version_compare(PHP_VERSION, '5.3.7', '<')) {
   	 	exit("Sorry, Simple PHP Login does not run on a PHP version smaller than 5.3.7 !");
	} else if (version_compare(PHP_VERSION, '5.5.0', '<')) {
	    // if you are using PHP 5.3 or PHP 5.4 you have to include the password_api_compatibility_library.php
	    // (this library adds the PHP 5.5 password hashing functions to older versions of PHP)
	    require_once("../libraries/password_compatibility_library.php");
	}

	if (empty($_POST['nom_medecin'])) {
           $errors[] = "Nom vide!";
        }elseif(empty($_POST['datenaiss_medecin'])){
        	$errors[] = "Date de naissance vide!";
        } elseif(empty($_POST['sexe_medecin'])){
        	$errors[] = "Sexe vide";
        } elseif(empty($_POST['adresse_medecin'])){
        	$errors[] = "Adresse vide!";
        } elseif(empty($_POST['email_medecin'])){
        	$errors[] = "Email vide!";
        } elseif(empty($_POST['password_medecin'])){
        	$errors[] = "Mot de passe vide!";
        } elseif(empty($_POST['confirmation_password'])){
            $errors[] = "Confirmation vide!";        
        } elseif(empty($_POST['telephone1_medecin'])){
        	$errors[] = "Téléphone vide!";
        } elseif (empty($_POST['specialite'])) {
        	$errors[] = "Choisir une spécialité!";
        }elseif (empty($_POST['anciennete_medecin'])) {
            $errors[] = "Ancinneté invalide!";
        }elseif($_POST['password_medecin'] != $_POST['confirmation_password']){
        	$errors[] = "Les mots de passe sont differents!";
        } elseif(strlen($_POST['password_medecin']) < 6){
        	$errors[] = "Le mot de passe doit être de 6 caractères minimum!";
        } elseif(strlen($_POST['email_medecin']) > 64 || strlen($_POST['email_medecin']) < 10){
        	$errors[] = "Email invalide";
        } elseif(empty($_POST['region_medecin'])){
        	$errors[] = "Région vide!";
        } elseif(empty($_POST['departement_medecin'])){
        	$errors[] = "Département vide!";
        } elseif(empty($_POST['arrondissement_medecin'])){
        	$errors[] = "Arrondissement vide!";
        } elseif(!filter_var($_POST['email_medecin'], FILTER_VALIDATE_EMAIL)){
        	$errors[] = "Format incorrect pour l'adresse email!";
        }elseif (
        	!empty($_POST['nom_medecin']) 
        	&& !empty($_POST['datenaiss_medecin']) 
        	&& !empty($_POST['sexe_medecin']) 
        	&& !empty($_POST['adresse_medecin']) 
        	&& !empty($_POST['email_medecin'])
        	&& filter_var($_POST['email_medecin'], FILTER_VALIDATE_EMAIL)
        	&& strlen($_POST['email_medecin']) <= 64  
        	&& strlen($_POST['email_medecin']) >= 10
        	&& !empty($_POST['password_medecin'])
        	&& !empty($_POST['confirmation_password']) 
            && !empty($_POST['anciennete_medecin'])
        	&& !empty($_POST['telephone1_medecin']) 
                && !empty($_POST['region_medecin'])
                && !empty($_POST['departement_medecin'])
                && !empty($_POST['arrondissement_medecin'])
        	&& !empty($_POST['specialite']) 
        	&& $_POST['password_medecin'] === $_POST['confirmation_password']){


            ////////les choses mise apres
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
                                $nomphoto = "img/avatar.jpg";
                    }
                else{                                   
                        $file_tmp_name=$_FILES['mod_picture']['tmp_name'];
                        $extension = pathinfo($nomphoto, PATHINFO_EXTENSION);
                        $extensions_autorisees = array('jpg', 'jpeg', 'gif', 'png');
                            if (in_array($extension, $extensions_autorisees))
                            {
                                $nomphoto = 'img/'.getNom().'.'.$extension;
                                move_uploaded_file($file_tmp_name,"../$nomphoto");
                            }
                            else
                            {
                                $nomphoto = "img/avatar.jpg";
                            }
                }



		/* Connect To Database*/
		require_once ("../config/db.php");//Contient les variables de configuration pour la base de données
		require_once ("../config/connexion.php");//Contient la fonction de connection à la base de données
        require_once('../functions.php'); 
			
		// escaping, additionally removing everything that could be (html/javascript-) code
		$nom=mysqli_real_escape_string($con,(strip_tags($_POST["nom_medecin"],ENT_QUOTES)));
		$prenom=(isset($_POST['prenom_medecin']) ? mysqli_real_escape_string($con,(strip_tags($_POST["prenom_medecin"],ENT_QUOTES))) : '');
		$datenaiss=mysqli_real_escape_string($con,(strip_tags($_POST["datenaiss_medecin"],ENT_QUOTES)));
		$sexe=mysqli_real_escape_string($con,(strip_tags($_POST["sexe_medecin"],ENT_QUOTES)));
		$adresse=mysqli_real_escape_string($con,(strip_tags($_POST["adresse_medecin"],ENT_QUOTES)));
				
		$email=mysqli_real_escape_string($con,(strip_tags($_POST["email_medecin"],ENT_QUOTES)));
		$telephone1=mysqli_real_escape_string($con,(strip_tags($_POST["telephone1_medecin"],ENT_QUOTES)));
		$telephone2=(isset($_POST['telephone2_medecin']) ? mysqli_real_escape_string($con,(strip_tags($_POST["telephone2_medecin"],ENT_QUOTES))):'');
		$region_idregion = intval($_POST['region_medecin']);	
                $departement_iddepartement = intval($_POST['departement_medecin']);
                $arrondissement_idarrondissement = intval($_POST['arrondissement_medecin']);
		$password=$_POST["password_medecin"];
        $anciennete=intval($_POST["anciennete_medecin"]);
		$date_save=date("Y-m-d");
		$idspecialite = intval($_POST['specialite']);
        $datenaiss = date('Y-m-d', strtotime($datenaiss));
		$password_hash = password_hash($password, PASSWORD_DEFAULT);
        

		// check if  email address already exists
            $sql = "SELECT * FROM personne WHERE email = '" . $email . "' AND lisible = 1";
            $query_check_user_name = mysqli_query($con,$sql);
			$query_check_user=mysqli_num_rows($query_check_user_name);

			if ($query_check_user == 1) {
                    $errors[] = "Cette adresse email est déja utilisée!";
            }else{
            	//insertion des informations sur la personne
            	$sql = "INSERT INTO personne VALUES(NULL, '$nom', '$prenom', '$datenaiss', '$sexe', '$region_idregion', '$departement_iddepartement', '$arrondissement_idarrondissement', '$adresse', '$email', '$telephone1', '$telephone2', '', '$date_save', true,'$nomphoto')";
            	$query_new_personne_insert = mysqli_query($con,$sql);

            	//var_dump($sql);
            	if ($query_new_personne_insert){
            		$idpersonne = get_last_insert_id('personne');

            		//insertion des informations sur le medecin 
            		$sql3 = "INSERT INTO medecin VALUES(NULL, 0, 1, '$date_save', 1, '$idspecialite', '$anciennete', '$idpersonne')";
            		
                       // var_dump($sql3);
                        
                        $query_new_medecin_insert = mysqli_query($con,$sql3);

            		if($query_new_medecin_insert){
            			//insertion du nouveau user
                             $code = uniqid();
            			$sql4 = "INSERT INTO users VALUES(NULL, '$email', '$password_hash', 1, '$date_save', 1, $idpersonne, 'Medecin', '$code')";
            			$query_new_user_insert = mysqli_query($con, $sql4);
                        

            			if($query_new_user_insert && $query_new_medecin_insert){
                             echo json_encode($e);
                             header('Location:../medecins.php?valide=ok');
            				
            			}else{
                        $errors []= "Erreur!, réessayez.".mysqli_error($con);
                        echo json_encode($errors);
                        header('Location:../medecins.php?valide=erreur');
                    }

            		}

            	}

                else{

            		$errors[] = "Erreur 127, Une erreur est survenue, veuillez contacter l'administrateur: ".mysqli_error($con);
                    echo json_encode($errors);
                     header('Location:../medecins.php?valide=contactezadmin');

            	}	
            }
        }
        else{

        	$errors[] = "Erreur 132, Une erreur est survenue, veuillez contacter l'administrateur: ".  mysqli_errno($con);
            echo json_encode($errors);
            header('Location:../medecins.php?valide=contactezadmin');
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