
	
	<?php
	include('is_logged.php');//Vérifications des informations transmises*/


	$erreur = false;


	/* Connect To Database*/
	require_once ("../config/db.php");//Contient les variables de configuration pour la base de données
	require_once ("../config/connexion.php");//Contient la fonction de connection à la base de données
    require_once('../functions.php'); 
	
    $id = intval($_GET['id']);


        $requete = "DELETE FROM connexion WHERE idusers = '$id'";
        $query = mysqli_query($con,$requete);

    
      

        //var_dump($requete);
        if (!$query_update_message){ 
            $erreur = true;			
        }	

        echo json_encode($erreur);
           
	