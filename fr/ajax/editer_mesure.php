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
        }elseif(empty($_POST['mod_idjournal'])){
            $errors[] = "Aucun journal sélectionner!";
        } elseif(empty($_POST['mod_valeur'])){
        	$errors[] = "Veuillez entrer une valeur!";
        } elseif(empty($_POST['mod_insuline'])){
        	$errors[] = "Insuline vide";
        } elseif(empty($_POST['mod_pression_arterielle'])){
        	$errors[] = "Presssion arterielle vide!";
        } elseif (!is_numeric($_POST['mod_valeur'])) {
            $errors[] = "Valeur invalide!";
        } elseif (!is_numeric($_POST['mod_insuline'])) {
            $errors[] = "Insuline invalide!";
        }elseif (
        	!empty($_POST['creneau']) 
        	&& !empty($_POST['mod_valeur']) 
        	&& !empty($_POST['mod_insuline']) 
        	&& !empty($_POST['mod_pression_arterielle']) 
            && is_numeric($_POST['mod_valeur'])
            && is_numeric($_POST['mod_insuline'])
        	){



    		/* Connect To Database*/
    		require_once ("../config/db.php");//Contient les variables de configuration pour la base de données
    		require_once ("../config/connexion.php");//Contient la fonction de connection à la base de données
            require_once('../function_no_login.php'); 
    			
    		// escaping, additionally removing everything that could be (html/javascript-) code
    		$creneau=intval($_POST['creneau']);
            $idjournal =mysqli_real_escape_string($con,(strip_tags($_POST["mod_idjournal"],ENT_QUOTES)));

            $insuline2 = '';
            if(isset($_POST['mod_insuline2']) && is_numeric($_POST['mod_insuline2'])){

                $insuline2 = mysqli_real_escape_string($con,(strip_tags($_POST["mod_insuline2"],ENT_QUOTES)));
            }
    		
    		$insuline=mysqli_real_escape_string($con,(strip_tags($_POST["mod_insuline"],ENT_QUOTES)));
    		$valeur=mysqli_real_escape_string($con,(strip_tags($_POST["mod_valeur"],ENT_QUOTES)));
    		$acetone=(isset($_POST['mod_acetone']) ? mysqli_real_escape_string($con,(strip_tags($_POST["mod_acetone"],ENT_QUOTES))):'');

    		$pression_arterielle=mysqli_real_escape_string($con,(strip_tags($_POST["mod_pression_arterielle"],ENT_QUOTES)));

    		$hba1c=(isset($_POST['mod_hba1c']) ? mysqli_real_escape_string($con,(strip_tags($_POST["mod_hba1c"],ENT_QUOTES))):'');
    		
    		$notes=(isset($_POST['mod_notes']) ? mysqli_real_escape_string($con,(strip_tags($_POST["mod_notes"],ENT_QUOTES))):'');

	        $date_save = date("Y-m-d");

            $req = "UPDATE journal SET mesure_idmesure = '$creneau', valeur = '$valeur', insuline = '$insuline', insuline2 = '$insuline2', pression_arterielle = '$pression_arterielle', acetone = '$acetone', hba1c = '$hba1c', notes = '$notes' WHERE idjournal = '$idjournal'";

           // var_dump($req);
            if(mysqli_query($con, $req)){

                $messages[] = "Mesure modifiée avec succès";
            }else{

                $errors[] = "Une erreur est survenue lors de la mise à jour, veuillez contacter l'administrateur";
            }


		
			
        }else{

        	$errors[] = "Certaines valeurs n'ont pas été renseignées!";
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