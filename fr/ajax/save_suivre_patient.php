<?php
	include('is_logged.php');
    include('is_medecin.php');
	if (version_compare(PHP_VERSION, '5.3.7', '<')) {
   	 	exit("Sorry, Simple PHP Login does not run on a PHP version smaller than 5.3.7 !");
	} else if (version_compare(PHP_VERSION, '5.5.0', '<')) {
	    // if you are using PHP 5.3 or PHP 5.4 you have to include the password_api_compatibility_library.php
	    // (this library adds the PHP 5.5 password hashing functions to older versions of PHP)
	    require_once("../libraries/password_compatibility_library.php");
	}
	$erreur = false;
	$message = "";

	if (empty($_POST['idmedecin'])) {
           $message = "Sélectionner un medecin!";
           $erreur = true;
        }elseif(empty($_POST['idpatient'])){
        	$message = "selectionner un patient!";
        	$erreur = true;
        } elseif (
        	!empty($_POST['idmedecin']) 
        	&& !empty($_POST['idpatient'])){


		/* Connect To Database*/
		require_once ("../config/db.php");//Contient les variables de configuration pour la base de données
		require_once ("../config/connexion.php");//Contient la fonction de connection à la base de données
        require_once('../functions.php'); 
			
		// escaping, additionally removing everything thant could be (html/javascript-) code
		$date_save = date('Y-m-d');
                $idmedecin=intval($_POST["idmedecin"]);
		$idpatient=intval($_POST["idpatient"]);
        
        	//insertion des informations sur la personne
           	$sql = "INSERT INTO patient_has_medecin VALUES(NULL, '$idpatient', '$idmedecin', false, '$date_save')";
           		//print_r($sql);
            	$query_new_personne_insert = mysqli_query($con,$sql);

            	//var_dump($sql);
            	if ($query_new_personne_insert){
            		
            		$messages= "Opération effectuée avec succès";
            		$erreur = false;
            	}else{

            		$message = "Erreur 47, Une erreur est survenue, veuillez contacter l'administrateur: ".  mysqli_error($con);
            		$erreur = true;
            	}	
            
        }else{

        	$message = "Erreur 53, Une erreur est survenue, veuillez contacter l'administrateur: ".mysqli_error($con);
        	$erreur = true;
        }    
           
	if (isset($erreur) && isset($message)){
			
		if($erreur){

			echo $message;
		}else{

			echo $erreur;
		}	
	}

?>