<?php  
header("Access-Control-Allow-Origin: *");

	 if($_SERVER['REQUEST_METHOD'] !== 'POST') {
	 	echo json_encode(array('status' => false));
	 	exit;
	 }

	 $postdata = file_get_contents("php://input");
	
	 $data = json_decode($postdata, true);

	 //$operator = $_GET['operator'];

	  $idpatient = intval($_GET['id']);


	 	require_once('../../../fr/config/db.php'); 
		require_once('../../../fr/config/connexion.php'); 
	//require_once('../../../fr/config/fonctions.php'); 
		require_once('../../../fr/functions.php');
		 //require_once("password_compatibility_library.php");



		 $requete = "UPDATE message set etat = 1 WHERE patient_idpatient = '$idpatient' AND expediteur = 1";
        $query_update_message = mysqli_query($con,$requete);

    
        

        //var_dump($requete);
     	$erreur='null';
        if ($query_update_message){ 
            $erreur = '0';			
        }	

        echo json_encode($erreur);