
	
	<?php
	include('is_logged.php');//Vérifications des informations transmises*/
	if (version_compare(PHP_VERSION, '5.3.7', '<')) {
   	 	exit("Sorry, Simple PHP Login does not run on a PHP version smaller than 5.3.7 !");
	} else if (version_compare(PHP_VERSION, '5.5.0', '<')) {
	    // if you are using PHP 5.3 or PHP 5.4 you have to include the password_api_compatibility_library.php
	    // (this library adds the PHP 5.5 password hashing functions to older versions of PHP)
	    require_once("../libraries/password_compatibility_library.php");
	}

	$erreur = false;

	if (empty($_GET['val'])) {
           $erreur = true;
        }elseif (!empty($_GET['val'])){



		/* Connect To Database*/
		require_once ("../config/db.php");//Contient les variables de configuration pour la base de données
		require_once ("../config/connexion.php");//Contient la fonction de connection à la base de données
        require_once('../functions.php'); 
		
        $idpatient = intval($_GET['val']);


        $requete = "UPDATE message set etat = 1 WHERE patient_idpatient = '$idpatient' AND expediteur = 0";
        $query_update_message = mysqli_query($con,$requete);

    
     }   

        //var_dump($requete);
        if (!$query_update_message){ 
            $erreur = true;			
        }	

        echo json_encode($erreur);
           
	