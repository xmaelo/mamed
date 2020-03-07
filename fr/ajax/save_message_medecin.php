<?php
	include('is_logged.php');//Vérifications des informations transmises*/
	//include('notifications.php');
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
        } elseif(empty($_POST['message_medecin'])){
            $errors[] = "Veuillez remplir le message!";
        }elseif (
        	!empty($_POST['idpatient']) 
        	&& !empty($_POST['idmedecin']) 
            && !empty($_POST['message_medecin'])
        ){



		/* Connect To Database*/
		require_once ("../config/db.php");//Contient les variables de configuration pour la base de données
		require_once ("../config/connexion.php");//Contient la fonction de connection à la base de données
        require_once('../functions.php'); 

               
			
		
		
		$message = trim(mysqli_real_escape_string($con,(strip_tags($_POST["message_medecin"],ENT_QUOTES))));
        $idpatient = intval($_POST['idpatient']);
        $idmedecin = intval($_POST['idmedecin']);

        $heure = date("H:i:s");
        $date_save = date('Y-m-d');

        $requete = "INSERT INTO message VALUES(NULL, 'Salut', '$message', '$date_save', '$heure', 0, 1, '$idpatient', '$idmedecin', 1)";
        $query_insert_message = mysqli_query($con,$requete);
       // var_dump($requete);
        if ($query_insert_message){ 
            $messages[] = "Message envoyé avec succès!";	
           // notifications();
        }else{
            $errors[] = "Une erreur est survenue pendant l'envoi du message, veuillez réessayer plus tard!";
        }
       
     }else{

        $errors[] = "Paramètres incorrects, veuillez contacter l'administrateur!";
     }       	
           
		if (isset($messages)){
				
				?>
				<li class="right">
					<img class="avatar"  src="../img/avatar_2x.png">
					<span class="message">
						<span class="arrow"></span>
						<span class="from"><b>Moi le </b></span>					
						<span class="time"><b> <?php echo $date_save.' à '.$heure; ?></span>
						<br />
						<span class="text">
							<?php echo $message; ?>						
						</span>
					</span>	   				                               
				</li>	
				<?php
			}

?>