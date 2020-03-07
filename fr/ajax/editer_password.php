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
		if (empty($_POST['mod_id_user'])){
			$errors[] = "ID vide";
		}  elseif (empty($_POST['user_password_new3']) || empty($_POST['user_password_repeat3'])) {
            $errors[] = "Mot de passe vide";
        } elseif ($_POST['user_password_new3'] !== $_POST['user_password_repeat3']) {
            $errors[] = "Les deux mots de passe ne correspondent pas.";
        }  elseif (
			 !empty($_POST['mod_id_user'])
			&& !empty($_POST['user_password_new3'])
            && !empty($_POST['user_password_repeat3'])
            && ($_POST['user_password_new3'] === $_POST['user_password_repeat3'])
        ) {
                	/* Connect To Database*/
            require_once ("../config/db.php");
            require_once ("../config/connexion.php");
            $user_id=intval($_POST['mod_id_user']);
            $user_password = $_POST['user_password_new3'];

             if(isset($_SESSION['lang'])){
		      $lage='langues/'.$_SESSION['lang'].'.php';
		      
		      require_once ('../'.$lage);
		      }
		      else{
		        $_SESSION['lang']='Fr';
		         $lage='langues/'.$_SESSION['lang'].'.php';
		      
		      require_once ('../'.$lage);
		      }
				
                // crypt the user's password with PHP 5.5's password_hash() function, results in a 60 character
                // hash string. the PASSWORD_DEFAULT constant is defined by the PHP 5.5, or if you are using
                // PHP 5.3/5.4, by the password hashing compatibility library
				$user_password_hash = password_hash($user_password, PASSWORD_DEFAULT);
					
               
					// write new user's data into database
                    $sql = "UPDATE users SET password='".$user_password_hash."' WHERE idusers='".$user_id."'";
                    $query = mysqli_query($con,$sql);

                    // if user has been added successfully
                    if ($query) {
                        $messages[] = $lang['modifierr'];
                    } else {
                        $errors[] = "Désolé, l'enregistrement a échoué. S'il vous plaît revenez en arrière et essayez à nouveau. ".mysqli_error($con);
                    }
                
            
        } else {
            $errors[] = "Une erreur inconnue est survenue.";
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
						<strong>Cool !</strong>
						<?php
							foreach ($messages as $message) {
									echo $message;
								}
							?>
				</div>
				<?php
			}

?>