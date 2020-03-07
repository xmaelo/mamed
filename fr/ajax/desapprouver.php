<?php
	include('is_logged.php');//Vérifications des informations transmises*/


      if(isset($_SESSION['lang'])){
      $lage='langues/'.$_SESSION['lang'].'.php';
       
      require_once ('../'.$lage);
      }
      else{
        $_SESSION['lang']='Fr';
         $lage='langues/'.$_SESSION['lang'].'.php';
      
      require_once ('../'.$lage); 
      }



   	 	$json = 0;
		/* Connect To Database*/
		require_once ("../config/db.php");//Contient les variables de configuration pour la base de données
		require_once ("../config/connexion.php");//Contient la fonction de connection à la base de données

	
        $id= htmlentities($_GET['id']);
        $idpatient = htmlentities($_GET['idpatient']);
        $idmedecin = htmlentities($_GET['idmedecin']);
        $req = "UPDATE patient_has_medecin SET approbation = 0 WHERE idpatient_has_medecin = '".$id."'";

        if(mysqli_query($con, $req)){           
            
            $message =  $lang['message2'];
            $requete = "INSERT INTO message VALUES('', 'Salut', '$message', NOW(), NOW(), 0, 1, '$idpatient', '$idmedecin', 0)";
            $query_insert_message = mysqli_query($con,$requete);

             $json = 1;
        }   

        echo json_encode($json);
    


           
	

?>