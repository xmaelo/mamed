<?php
	//include('is_logged.php');//Vérifications des informations transmises*/

	if (version_compare(PHP_VERSION, '5.3.7', '<')) {
   	 	exit("Sorry, Simple PHP Login does not run on a PHP version smaller than 5.3.7 !");
	} else if (version_compare(PHP_VERSION, '5.5.0', '<')) {
	    // if you are using PHP 5.3 or PHP 5.4 you have to include the password_api_compatibility_library.php
	    // (this library adds the PHP 5.5 password hashing functions to older versions of PHP)
	    require_once("../libraries/password_compatibility_library.php");
	}

	if (empty($_POST['creneau'])) {
           $errors[] = "Veuillez choisir un créneau!";
        }elseif(empty($_POST['idpatient'])){
            $errors[] = "Aucun patient!";
        } elseif(empty($_POST['valeur'])){
        	$errors[] = "Veuillez entrer une valeur!";
        } elseif(empty($_POST['insuline'])){
        	$errors[] = "Insuline vide";
        } elseif(empty($_POST['pression_arterielle'])){
        	$errors[] = "Presssion arterielle vide!";
        } elseif (!is_numeric($_POST['valeur'])) {
            $errors[] = "Valeur invalide!";
        } elseif (!is_numeric($_POST['insuline'])) {
            $errors[] = "Insuline invalide!";
        }elseif (
        	!empty($_POST['creneau']) 
        	&& !empty($_POST['valeur']) 
        	&& !empty($_POST['insuline']) 
        	&& !empty($_POST['pression_arterielle'])        	
            && is_numeric($_POST['valeur'])
            && is_numeric($_POST['insuline']) 
        	){



    		/* Connect To Database*/
    		require_once ("../config/db.php");//Contient les variables de configuration pour la base de données
    		require_once ("../config/connexion.php");//Contient la fonction de connection à la base de données
            require_once('../function_no_login.php'); 
    			
    		// escaping, additionally removing everything that could be (html/javascript-) code
    		$creneau=intval($_POST['creneau']);
                $idpatient=intval($_POST["idpatient"]);

                $insuline2 = floatval($_POST["insuline2"]);
            
    		
    		$insuline=  floatval($_POST["insuline"]);
    		$valeur=  floatval($_POST["valeur"]);
    		$acetone=floatval($_POST["acetone"]);
    		$pression_arterielle=mysqli_real_escape_string($con,(strip_tags($_POST["pression_arterielle"],ENT_QUOTES)));		
    		$hba1c=  floatval($_POST["hba1c"]);
    		
    		$notes=mysqli_real_escape_string($con,(strip_tags($_POST["notes"],ENT_QUOTES)));

	        $date_save = date("Y-m-d");

               $req = "INSERT INTO journal VALUES(NULL, NOW(), '$creneau', '$valeur', '$insuline', '$insuline2', '$pression_arterielle', '$acetone', '$hba1c', '$notes', '$date_save', 1, '$idpatient')";

          // var_dump($req);
            if(mysqli_query($con, $req)){

                $messages[] = "Mesure ajoutée avec succès";
            }else{

                $errors[] = "Erreur 70, Une erreur est survenue lors de l'enregistrement, veuillez contacter l'administrateur ".  mysqli_error($con);
            }


		
			
        }else{

        	$errors[] = "Erreur78, Une erreur est survenue, veuillez contacter l'administrateur! second ".  mysqli_error($con);
        }    
           
	if (isset($errors)){
			
			?>
			<div class="alert alert-danger" role="alert">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
					<strong>Erreur!</strong> 
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
						<strong>Info !</strong>
						<?php
							foreach ($messages as $message) {
									echo $message;
								}
							?>
				</div>
				<?php
			}

?>