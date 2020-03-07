



<?php

	//include('is_logged.php');
	//include('is_medecin.php');
	/* Connect To Database*/
	// require_once ("config/db.php");
	// require_once ("config/connexion.php");
	//require_once ("functions.php");


		// session_start();

		//   if(isset($_SESSION['lang'])){
		// 	      $lage='langues/'.$_SESSION['lang'].'.php';
			      
			      
		// 	      }
		// 	      else{
		// 	        $_SESSION['lang']='Fr';
		// 	         $lage='langues/'.$_SESSION['lang'].'.php';
			      
			      

		// 	      }
		// 	      //var_dump($lage);


		//  require_once ($lage);
			/*Ma methode catrine*/

		//var_dump($lang["seConnecter"]);

		 //require_once ($lage);
			/*Ma methode catrine*/

		//var_dump($lang["seConnecter"]);
			



function calcul_IMC($poids, $taille){

		return round(($poids/pow($taille/100, 2)), 1);
	}

function interpretation_IMC($imc){

	


		$interpretation = "";
		if($imc < 16.5){
		

				$interpretation = "Denutrition";
			


		}elseif($imc < 18.5 && $imc >=16.5){


				$interpretation = "Maigreur";
			

			

		}elseif($imc < 25 && $imc >= 18.5){


		

				$interpretation = "Corpulence normale";
			
		
		}elseif($imc < 30 && $imc >=25){

			
				$interpretation = "Surpoids";
			

			

		}elseif($imc < 35 && $imc >= 30){

			

				$interpretation = "Obesite modere";
			


			

		}elseif($imc < 40 && $imc >= 35){

			

				$interpretation = "Obesite severe";
			

			

		}elseif ($imc >= 40) {

			
 
				$interpretation = "Obesite morbide ou massive";
			
			
		}

		return $interpretation;
	}

	function send_mail($nom, $email, $code){
					
			$sujet = "Validation de votre adresse email";

			$message = "<html><body>";                                     

            $message="Merci d'avoir intégré MaMED, votre code de confirmation est: <b>".$code."</b>";    	 
            $message .= "</body></html>";
                   
            $header = "From: MaMED <info@kamer-center.net >\r\n";
            $header .= "Content-Type: text/html; charset=\"UTF-8\"\r\n";

            try{                        
                mail($email, $sujet, $message, $header);
                return true;
                                            
            }catch(Exception $ex){
                
                return false;
            }
	}
        
          function insert($table, $data){
    global $con;
    $req = "INSERT INTO $table";
    $champ = array();
    $valeur = array();
    
    foreach($data as $key => $line){
        $champ[] = $key;
        $valeur[] = "'$line'";
    }
    
    $colonne = implode($champ, ',');
    $donnees = implode($valeur, ',');
    
    $req = "INSERT INTO {$table}($colonne) VALUES($donnees)";
    
    return mysqli_query($con, $req);
  }
  