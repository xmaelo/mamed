<?php 
header("Access-Control-Allow-Origin: *");


	
	 $postdata = file_get_contents("php://input"); 
	 
	 $data = json_decode($postdata, true);

	 //$idpersonne = $data['idpers'];
	 $idpatient = intval($_GET['idpatient']);
	 $id = intval($_GET['id']);
	 $idmedecin = intval($_GET['idmedecin']);

	 // $q = $_GET['q'];



	 $retours = array(); 

	 //$password = $data['pass'];

session_start();//session starter for this user
$json = 0;

require_once('../../../fr/config/db.php'); 
require_once('../../../fr/config/connexion.php'); 
//require_once('../../../fr/config/fonctions.php'); 
require_once('../../../fr/functions.php');  

  $req = "UPDATE patient_has_medecin SET approbation = 0 WHERE idpatient_has_medecin = '".$id."'";
        // $req = "UPDATE patient_has_medecin SET approbation = 1 WHERE idpatient_has_medecin = '".$id."'";

         if(mysqli_query($con, $req)){           
            
            $message =  'Votre demande de suivis a été annuler, vous ne pouvez plus désormais suivre ce patient';
            $requete = "INSERT INTO message VALUES('', 'Salut', '$message', NOW(), NOW(), 0, 1, '$idpatient', '$idmedecin', 0)";
            $query_insert_message = mysqli_query($con,$requete);

             $json = 1;
        }  

        echo json_encode($json);