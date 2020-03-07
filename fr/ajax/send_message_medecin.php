<?php
	include('is_logged.php');//Vérifications des informations transmises*/
	if (version_compare(PHP_VERSION, '5.3.7', '<')) {
   	 	exit("Sorry, Simple PHP Login does not run on a PHP version smaller than 5.3.7 !");
	} else if (version_compare(PHP_VERSION, '5.5.0', '<')) {
	    // if you are using PHP 5.3 or PHP 5.4 you have to include the password_api_compatibility_library.php
	    // (this library adds the PHP 5.5 password hashing functions to older versions of PHP)
	    require_once("../libraries/password_compatibility_library.php");
	}

	if (empty($_POST['idpatient'])) {
           $errors[] = "Veuillez choisir un patient!";
        }elseif(empty($_POST['idmedecin'])){
        	$errors[] = "Medécin vide!";
        }elseif(empty($_POST['message'])){
            $errors[] = "Veuillez remplir le message!";
        }elseif (
        	!empty($_POST['idpatient']) 
        	&& !empty($_POST['idmedecin']) 
        ){



		/* Connect To Database*/
		require_once ("../config/db.php");//Contient les variables de configuration pour la base de données
		require_once ("../config/connexion.php");//Contient la fonction de connection à la base de données
        require_once('../functions.php'); 

               
			
		
		
		$message = trim(mysqli_real_escape_string($con,(strip_tags($_POST["message"],ENT_QUOTES))));
        $sujet =  "Salut";
        $idpatient = intval($_POST['idpatient']);
        $idmedecin = intval($_POST['idmedecin']);


        $requete = "INSERT INTO message VALUES(NULL, '$sujet', '$message', NOW(), NOW(), 0, 1, '$idpatient', '$idmedecin', 1)";
        $query_insert_message = mysqli_query($con,$requete);
       var_dump($requete);
        if ($query_insert_message){ 
            $messages[] = "Message envoyé avec succès!";			
        }else{
            $errors[] = "Erreur 48, Une erreur est survenue pendant l'envoi du message, veuillez réessayer plus tard: ".mysqli_error($con);
        }
       
     }else{

        $errors[] = "Paramètres incorrects, veuillez contacter l'administrateur!";
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