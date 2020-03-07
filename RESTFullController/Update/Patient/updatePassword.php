<?php  
header("Access-Control-Allow-Origin: *");

	 if($_SERVER['REQUEST_METHOD'] !== 'POST') {
	 	echo json_encode(array('status' => false));
	 	exit;
	 }

	 $postdata = file_get_contents("php://input");
	
	 $data = json_decode($postdata, true);

	 //$idpatient = $data['id'];
	 //$idpatient = intval($_GET['id']);

	 $login = $_GET['login'];
	 $nouveau = $data['nouveau'];
	 $repeatNouveau = $data['repeat'];

	 if($nouveau != $repeatNouveau)
	 {
	 	echo json_encode('Les mots de passe ne sont pas identiques');
	 	exit;
	 }

	 
session_start();//session starter for this user

require_once("password_compatibility_library.php");
require_once('../../../fr/config/db.php'); 
require_once('../../../fr/config/connexion.php'); 
//require_once('../../../fr/config/fonctions.php'); 
require_once('../../../fr/functions.php'); 



	 //$retours = array(); 

		$json = 'null';


	 $user_password_hash = password_hash($nouveau, PASSWORD_DEFAULT); 

	  $sql = "UPDATE users SET password='".$user_password_hash."' WHERE login='".$login."'";
      $query = mysqli_query($con,$sql);

      if($query){
      	$json = 'success';
      }
      	echo json_encode($json);