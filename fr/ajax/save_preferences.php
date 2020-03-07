<?php
	include('is_logged.php');//Vérifications des informations transmises*/
	if (version_compare(PHP_VERSION, '5.3.7', '<')) {
   	 	exit("Sorry, Simple PHP Login does not run on a PHP version smaller than 5.3.7 !");
	} else if (version_compare(PHP_VERSION, '5.5.0', '<')) {
	    // if you are using PHP 5.3 or PHP 5.4 you have to include the password_api_compatibility_library.php
	    // (this library adds the PHP 5.5 password hashing functions to older versions of PHP)
	    require_once("../libraries/password_compatibility_library.php");
	}

	if (empty($_POST['heure_apres_repas'])) {
           $errors[] = "Heure après repas vide!!";
        }elseif(empty($_POST['alarme_preventive'])){
        	$errors[] = "Alarme préventive hypoglycémie vide!";
        } elseif(empty($_POST['unite'])){
            $errors[] = "Choisir une unité!";
        } elseif (
        	!empty($_POST['heure_apres_repas']) 
        	&& !empty($_POST['alarme_preventive']) 
            && !empty($_POST['idpatient'])
        ){



		/* Connect To Database*/
		require_once ("../config/db.php");//Contient les variables de configuration pour la base de données
		require_once ("../config/connexion.php");//Contient la fonction de connection à la base de données
        require_once('../functions.php'); 

        $mesures = mysqli_query($con, "SELECT idmesure FROM mesure");
        
			
		// escaping, additionally removing everything that could be (html/javascript-) code
		$heure_apres_repas = mysqli_real_escape_string($con,(strip_tags($_POST["heure_apres_repas"],ENT_QUOTES)));
		
		$alarme_preventive=mysqli_real_escape_string($con,(strip_tags($_POST["alarme_preventive"],ENT_QUOTES)));
        $unite = $_POST['unite'];
        $idpatient = intval($_POST['idpatient']);

      if(isset($_SESSION['lang'])){
      $lage='langues/'.$_SESSION['lang'].'.php';
      
      require_once ('../'.$lage);
      }
      else{
        $_SESSION['lang']='Fr';
         $lage='langues/'.$_SESSION['lang'].'.php';
      
      require_once ('../'.$lage);
      }


        if(isset($_POST['mesure'])){

            $mesure_patient = $_POST['mesure'];

            //var_dump($mesure_patient);

            while ($mesure = mysqli_fetch_array($mesures)) {
                
               $idmesure = $mesure['idmesure'];
                if(in_array($idmesure, $mesure_patient)){

                    $mes = 1;
                   
                }else{

                    $mes = 0;
                }

                 $sql = "UPDATE mesure_patient SET etat='$mes' WHERE patient_idpatient = '$idpatient' AND mesure_idmesure = '$idmesure'";
                $query_update_mesure_patient = mysqli_query($con,$sql);

               // var_dump($sql);     
                }

        } 

        

        /*if (isset($_POST['mesure'])) {            

            foreach ($_POST['mesure'] as $mes) {
                
                $sql = "UPDATE mesure_patient SET etat='$mes' WHERE patient_idpatient = '$idpatient'";
                    $query_update_mesure_patient = mysqli_query($con,$sql);
                    var_dump($sql);
            }
        }*/

        $sql2 = "UPDATE unite_patient SET unite_idunite = '$unite', heure_apres_repas = '$heure_apres_repas', alarme_preventive='$alarme_preventive' WHERE patient_idpatient = '$idpatient'";
        $query_update_unite_patient = mysqli_query($con,$sql2);


        //var_dump($sql2);
        if ($query_update_unite_patient){            		
           
            $messages[] = $lang['Enregistrement effectue avec succes'];			
        }else{

            $errors[] = "Unité: Une erreur est survenue, veuillez contacter l'administrateur!";

        }
       
     }else{

        $errors[] = "Paramètres incorrects, veuillez contacter l'administrateur!";
     }       	
           
	if (isset($errors)){
			
			?>
			<div class="alert alert-danger" role="alert">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
					<strong>Error!</strong> 
					<?php
						foreach ($errors as $error) {
								echo $error;
							}
						?>
			</div>
			<?php
			}
			if (isset($messages)){
				
				?>
				<div class="alert alert-success" role="alert">
						<button type="button" class="close" data-dismiss="alert">&times;</button>
						<strong><?php echo $lang['info']; ?> !</strong>
						<?php
							foreach ($messages as $message) {
									echo $message;
								}
							?>
				</div>
				<?php
			}

?>