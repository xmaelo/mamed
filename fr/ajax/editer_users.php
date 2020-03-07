<?php
include('is_logged.php');
include('is_admin.php');
if (version_compare(PHP_VERSION, '5.3.7', '<')) {
    exit("Sorry, Simple PHP Login does not run on a PHP version smaller than 5.3.7 !");
} else if (version_compare(PHP_VERSION, '5.5.0', '<')) {
    // if you are using PHP 5.3 or PHP 5.4 you have to include the password_api_compatibility_library.php
    // (this library adds the PHP 5.5 password hashing functions to older versions of PHP)
    require_once("../libraries/password_compatibility_library.php");
}		
		if (empty($_POST['new_email'])){
			$errors[] = "Nouvelle adresse vide";
		} elseif (empty($_POST['confirmer_email'])){
			$errors[] = "Adresse de confirmation vide";
		}elseif (empty($_POST['idusers'])){
			$errors[] = "Utilisateur invalide";
		}elseif (empty($_POST['idpersonne'])){
			$errors[] = "utilisateur invalide2";
		}elseif ($_POST['new_email'] != $_POST['confirmer_email']) {
            $errors[] = "La nouvelle adresse est différente de l'adresse de confirmation!";
        } elseif (!filter_var($_POST['new_email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Adresse email invalide!";
        } elseif (
			!empty($_POST['new_email'])
			&& !empty($_POST['confirmer_email'])
			&& !empty($_POST['idusers'])
			&& !empty($_POST['idpersonne'])
            && $_POST['new_email'] === $_POST['confirmer_email']
            && filter_var($_POST['new_email'], FILTER_VALIDATE_EMAIL)
          )
         {
            require_once ("../config/db.php");
			require_once ("../config/connexion.php");
				
                $new_email = mysqli_real_escape_string($con,(strip_tags($_POST["new_email"],ENT_QUOTES)));

				$idusers=intval($_POST['idusers']);
				$idpersonne=intval($_POST['idpersonne']);	
               	
	               	// check if  email address already exists
	            $sql = "SELECT * FROM personne WHERE email = '" . $new_email . "' AND lisible = 1";
	            $query_check_user_name = mysqli_query($con,$sql);
				$query_check_user=mysqli_num_rows($query_check_user_name);

				if ($query_check_user == 1) {
	                    $errors[] = "Cette adresse email est déja utilisée!";
	            }else{

	            	// write new user's data into database
                    $sql2 = "UPDATE users SET login='".$new_email."' WHERE idusers='".$idusers."';";
                    $query_update = mysqli_query($con,$sql2);

                    // if user has been added successfully
                    if ($query_update) {
                    	//mise a jour sur la personne        
                    	 $sql3 = "UPDATE personne SET email='".$new_email."' WHERE idpersonne='".$idpersonne."'";            	
                    	$query_update2 = mysqli_query($con,$sql3);
                    	
                    	if($query_update2){
                    		$_SESSION['login'] = $new_email;
                    		$messages[] = "Utilisateur mise à jour avec succès.";
                    	}                        
                    } else {
                        $errors[] = "Erreur lors de la mise à jour de l'utilisateur. Veuillez contacter l'administrateur";
                    }
	            }

	        } else {
	            $errors[] = "Erreur lors de la mise à jour de l'utilisateur. Veuillez contacter l'administrateur.";
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
						<strong>Succès!</strong>
						<?php
							foreach ($messages as $message) {
									echo $message;
								}
							?>
				</div>
				<?php
			}

?>