<?php 

/**********By_Ismael_Foletia***********/

/****from Ionic ***/

header("Access-Control-Allow-Origin: *");

	 if($_SERVER['REQUEST_METHOD'] !== 'POST') {
	 	echo json_encode(array('status' => false));
	 	exit;
	 }

	 $postdata = file_get_contents("php://input");
	
	 $data = json_decode($postdata, true); 

	 $email = $data['email'];

	 $password = $data['pass'];

session_start();//session starter for this user

require_once('../../fr/config/db.php'); 
require_once('../../fr/config/connexion.php'); 
require_once('../../fr/config/fonctions.php'); 


				$sql = "SELECT *
                        FROM users
                        INNER JOIN personne ON users.personne_idpersonne = personne.idpersonne
                        AND personne.lisible = 1
                        AND users.lisible = 1                        
                        AND login = '$email'";

                $execute = mysqli_query($con, $sql);

                //$user = mysqli_fetch_array($execute);

                $retours = array();


	            if ($execute->num_rows == 1) {

	                // get result row (as an object)
	                $result_row = $execute->fetch_object();

	                // using PHP 5.5's password_verify() function to check if the provided password fits
	                // the hash of that user's password
	                if (password_verify($password, $result_row->password)) {                        
	                   
	                        // write user data into PHP SESSION (a file on your server)
	                        $_SESSION['idusers'] = $result_row->idusers;
	                        $_SESSION['idpersonne'] = $result_row->idpersonne;
	                        $_SESSION['role'] = $result_row->role;
	                        $_SESSION['login'] = $result_row->login;
	                        $_SESSION['nom'] = $result_row->nom;
	                        $_SESSION['prenom'] = $result_row->prenom;
	                        $_SESSION['user_login_status'] = $result_row->etat;
	                        $_SESSION['code'] = $result_row->code;
	                        $_SESSION['etat'] = $result_row->etat;

	                        $retours['idusers'] = $_SESSION['idusers'];
	                        $retours['idpersonne'] = $_SESSION['idpersonne'];
	                        $retours['login'] = $_SESSION['login'];
	                        $retours['role'] = $_SESSION['role'];
	                        $retours['nom'] = $_SESSION['nom'];
	                        $retours['prenom'] = $_SESSION['prenom'];
	                        $retours['user_login_status'] = $_SESSION['user_login_status'];
	                        $retours['code'] = $_SESSION['code'];
	                        $retours['etat'] = $_SESSION['etat'];
	                        $retours['error'] = 'false';

                        
	                } 


                 }

	            else 
	                {
                        $retours['error']='error';
                    }


                 echo json_encode($retours);