<?php 
header("Access-Control-Allow-Origin: *");

	
	 $postdata = file_get_contents("php://input");
	
	 $data = json_decode($postdata, true);

	 //$idpersonne = $data['idpers'];
	 $idpatient = intval($_GET['id']);
	 $idmedecin = intval($_GET['idM']);
	 $message = $data['input'];

	  //$q = $_GET['q'];



	 $retours = array(); 

	 //$password = $data['pass'];

session_start();//session starter for this user
$json;

require_once('../../../fr/config/db.php'); 
require_once('../../../fr/config/connexion.php'); 
//require_once('../../../fr/config/fonctions.php'); 
require_once('../../../fr/functions.php'); 

		$sujet = 'Salut';
        $requete = "INSERT INTO message VALUES(NULL, '$sujet', '$message', NOW(), NOW(), 0, 1, '$idpatient', '$idmedecin', 0)";
        $query_insert_message = mysqli_query($con,$requete);

        if($query_insert_message){
        	$json='succes';
        }

        echo json_encode($json);
