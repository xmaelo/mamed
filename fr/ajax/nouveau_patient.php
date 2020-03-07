<?php
	//include('is_logged.php');//Vérifications des informations transmises*/

	if (version_compare(PHP_VERSION, '5.3.7', '<')) {
   	 	exit("Sorry, Simple PHP Login does not run on a PHP version smaller than 5.3.7 !");
	} else if (version_compare(PHP_VERSION, '5.5.0', '<')) {
	    // if you are using PHP 5.3 or PHP 5.4 you have to include the password_api_compatibility_library.php
	    // (this library adds the PHP 5.5 password hashing functions to older versions of PHP)
	    require_once("../libraries/password_compatibility_library.php");
	}
       //include('../is_logged.php'); 

    session_start(); 
      if(isset($_SESSION['lang'])){
      $lage='langues/'.$_SESSION['lang'].'.php';  
      
      require_once ('../'.$lage);
      }
      else{
        $_SESSION['lang']='Fr';
         $lage='langues/'.$_SESSION['lang'].'.php';
      
      require_once ('../'.$lage);
      }
	if (empty($_POST['nom_patient'])) {
           $errors[] = $lang['Nom vide!'];
        }elseif(empty($_POST['datenaiss_patient'])){
        	$errors[] = $lang['Date de naissance vide !'];
        } elseif(empty($_POST['sexe_patient'])){
        	$errors[] = $lang['Sexe vide'];
        } elseif(empty($_POST['adresse_patient'])){
        	$errors[] = $lang['Adresse vide!'];
        }  elseif(empty($_POST['region_patient'])){
        	$errors[] = $lang['Région vide!'];
        } elseif(empty($_POST['departement_patient'])){
        	$errors[] = $lang['Département vide!'];
        } elseif(empty($_POST['arrondissement_patient'])){
        	$errors[] = $lang['Arrondissement vide!'];
        }elseif(empty($_POST['email_patient'])){
        	$errors[] = $lang['Email vide!'];
        } elseif(empty($_POST['password_patient'])){
        	$errors[] = $lang['Mot de passe vide!'];
        } elseif(empty($_POST['confirmation_password'])){
        	$errors[] = $lang['Confirmation vide!'] ;
        } elseif(empty($_POST['poids_patient'])){
        	$errors[] = $lang['Poids vide!'];
        } elseif(empty($_POST['taille_patient'])){
        	$errors[] = $lang['Taille vide!'];
        } elseif(empty($_POST['telephone1_patient'])){
        	$errors[] = $lang['Téléphone vide!'];
        } elseif(empty($_POST['personne_urgence'])){
        	$errors[] = $lang['Personne d\'urgence vide!'];
        } elseif(empty($_POST['telephone_urgence'])){
        	$errors[] = $lang['Téléphone contact d\'urgence vide!'] ;
        } elseif (empty($_POST['diabete'])) {
        	$errors[] = $lang['Choisir un type de diabète!'];
        } elseif($_POST['password_patient'] != $_POST['confirmation_password']){
        	$errors[] = $lang['Les mots de passe sont differents!'] ;
        } elseif(strlen($_POST['password_patient']) < 6){
        	$errors[] = $lang['Le mot de passe doit être de 6 caractères minimum!'];
        } elseif(strlen($_POST['email_patient']) > 64 || strlen($_POST['email_patient']) < 10){
        	$errors[] = $lang['Email invalide'];
        } elseif(!filter_var($_POST['email_patient'], FILTER_VALIDATE_EMAIL)){
            $errors[] = $lang['Format incorrect pour l\'adresse email!'] ;
        }elseif(strpos($_POST['email_patient'], '@yopmail.')){
        	$errors[] = $lang['L\'adresse email n\'est pas valide!'] ;
        }elseif (!is_numeric($_POST['poids_patient'])) {
            $errors[] = $lang['Valeur invalide pour le poids'] ;
        }elseif ($_POST['poids_patient'] <= 0) {
            $errors[] =$lang['Valeur négative pour le poids!']; 
        }elseif (
        	!empty($_POST['nom_patient']) 
        	&& !empty($_POST['datenaiss_patient']) 
        	&& !empty($_POST['sexe_patient']) 
        	&& !empty($_POST['adresse_patient'])
                && !empty($_POST['region_patient'])
                && !empty($_POST['departement_patient'])
                && !empty($_POST['arrondissement_patient'])
        	&& !empty($_POST['email_patient'])
        	&& filter_var($_POST['email_patient'], FILTER_VALIDATE_EMAIL)
        	&& strlen($_POST['email_patient']) <= 64
        	&& strlen($_POST['email_patient']) >= 10
        	&& !empty($_POST['password_patient'])
        	&& !empty($_POST['confirmation_password']) 
        	&& !empty($_POST['poids_patient']) 
        	&& !empty($_POST['taille_patient']) 
        	&& !empty($_POST['telephone1_patient']) 
        	&& !empty($_POST['diabete']) 
        	&& !empty($_POST['personne_urgence']) 
        	&& !empty($_POST['telephone_urgence'])
            && !strpos($_POST['email_patient'], '@yopmail.')
        	&& $_POST['password_patient'] === $_POST['confirmation_password']){ 



		/* Connect To Database*/
		require_once ("../config/db.php");//Contient les variables de configuration pour la base de données
		require_once ("../config/connexion.php");//Contient la fonction de connection à la base de données
        require_once('../function_no_login.php');

   
  
			
		// escaping, additionally removing everything that could be (html/javascript-) code
		$nom=mysqli_real_escape_string($con,(strip_tags(strtoupper($_POST["nom_patient"]),ENT_QUOTES)));
		$prenom=(isset($_POST['prenom_patient']) ? mysqli_real_escape_string($con,(strip_tags(ucfirst(strtolower($_POST["prenom_patient"])),ENT_QUOTES))) : '');
		$datenaiss=mysqli_real_escape_string($con,(strip_tags($_POST["datenaiss_patient"],ENT_QUOTES)));
		$sexe=mysqli_real_escape_string($con,(strip_tags($_POST["sexe_patient"],ENT_QUOTES)));
		$adresse=mysqli_real_escape_string($con,(strip_tags($_POST["adresse_patient"],ENT_QUOTES)));
		$region_idregion = intval($_POST['region_patient']);	
                $departement_iddepartement = intval($_POST['departement_patient']);
                $arrondissement_idarrondissement = intval($_POST['arrondissement_patient']);
		$email=mysqli_real_escape_string($con,(strip_tags($_POST["email_patient"],ENT_QUOTES)));
		$telephone1=mysqli_real_escape_string($con,(strip_tags($_POST["telephone1_patient"],ENT_QUOTES)));
		$telephone2=(isset($_POST['telephone2_patient']) ? mysqli_real_escape_string($con,(strip_tags($_POST["telephone2_patient"],ENT_QUOTES))):'');
		$poids=mysqli_real_escape_string($con,(strip_tags($_POST["poids_patient"],ENT_QUOTES)));
		$taille=mysqli_real_escape_string($con,(strip_tags($_POST["taille_patient"],ENT_QUOTES)));
		$nom_contact_urgence=mysqli_real_escape_string($con,(strip_tags($_POST["personne_urgence"],ENT_QUOTES)));
                $etat = 0;
		$telephone_contact_urgence=mysqli_real_escape_string($con,(strip_tags($_POST["telephone_urgence"],ENT_QUOTES)));
		$password=$_POST["password_patient"];
		$date_save=date("Y-m-d");
		$iddiabete = intval($_POST['diabete']);
                $datenaiss = date('Y-m-d', strtotime($datenaiss));
                //hashage du mot de passe
                $password_hash = password_hash($password, PASSWORD_DEFAULT);
                
                //calcul de l'IMC
                $imc = calcul_IMC($poids, $taille);
                //interpretation de l'IMC
                $interpretation = interpretation_IMC($imc);

                // check if  email address already exists
                $sql = "SELECT * FROM personne WHERE (email = '" . $email . "' OR telephone1='".$telephone1."') AND lisible = 1";
                $query_check_user_name = mysqli_query($con,$sql);
		$query_check_user=mysqli_num_rows($query_check_user_name);

                if ($query_check_user == 1) { //l'adresse email ou le tele phone existe deja
                    
                    $errors[] = "L'adresse email/téléphone 1 ont déja été utilisés!";
                    
                }else{
                // si c n'existe pas                
                    $code = uniqid(); //genration du code unique 
                    //envoi du mail
                   if(send_mail($nom, $email, $code)) {
                   // 
                    //insertion des informations sur la personne
                    $sql = "INSERT INTO personne VALUES(NULL, '$nom', '$prenom', '$datenaiss', '$sexe', "
                        . "'$region_idregion', '$departement_iddepartement', '$arrondissement_idarrondissement', "
                        . "'$adresse', '$email', '$telephone1', '$telephone2', '', '$date_save', true, NULL)";
                    $query_new_personne_insert = mysqli_query($con, $sql);//execution

                    //var_dump($sql);
                    if ($query_new_personne_insert){ //si l'insertion a reussi
                        //reccuperation de l'id de la personne
            		$idpersonne = 0;
            		$sql2 = mysqli_query($con,"select last_insert_id() as idpersonne from personne where lisible = 1");
            		while($rw=mysqli_fetch_array($sql2)){
            			$idpersonne = $rw['idpersonne'];
            		}	
                        
            		//insertion des informations sur le diabete
            		$sql3 = "INSERT INTO patient VALUES(NULL, '$poids', '$taille', '$imc','$interpretation', '$nom_contact_urgence', '$telephone_contact_urgence', 1, '$date_save', 1, $iddiabete, $idpersonne,'12:00:00','12:00:00',1,1)";
            		$query_new_patient_insert = mysqli_query($con,$sql3);

            		if($query_new_patient_insert){ // si l'insertion a reussi     
                                session_start();
                            if(isset($_SESSION['role']) && $_SESSION['role']=='Administrateur'){
                                $etat = 1;
                            }
                            //insertion du nouveau user                        
                            $sql4 = "INSERT INTO users VALUES(NULL, '$email', '$password_hash', '$etat', '$date_save', 1, $idpersonne, 'Patient', '$code')";
                            $query_new_user_insert = mysqli_query($con,$sql4);   
                                
                            if($query_new_user_insert){ //si l'insetion du nouveau user a reussit
                                    //reccuperation de l'id du nouveau user
                                    $idusers = 0;
                                    $sql5 = mysqli_query($con,"select last_insert_id() as idusers from users where lisible = 1");
                                    while($rw=mysqli_fetch_array($sql5)){
                                        $idusers = $rw['idusers'];
                                    }   
                                //Insertion de l'unite par defaut pour ce patient                                
                                $idunite = 0;
                                $idpatient = 0; //reccuperationd  de l'id du patient
                                $req = mysqli_query($con,"select max(idpatient) as idpatient from patient");
                                while($rws=mysqli_fetch_array($req)){
                                    $idpatient = $rws['idpatient'];
                                }   
                                 //reccuperation de id de l'unité de mesure
                                $req2 =  mysqli_query($con,"select min(idunite) as idunite from unite");
                                while($rw=mysqli_fetch_array($req2)){
                                    $idunite = $rw['idunite'];
                                }
                                
                                //insertion des unités patient
                                $req3 = "INSERT INTO unite_patient VALUES(NULL, '$idpatient', '$idunite', '01:30:00', '04:00:00')";
                                //selection des differentes mesures pour le patient
                                
                                $mesure_patient = mysqli_query($con,"select idmesure from mesure");
                                while($rw=mysqli_fetch_array($mesure_patient)){
                                    $idmesure = $rw['idmesure'];
                                    //insertion des mesures pour le nouveau patient
                                    $req4 = "INSERT INTO mesure_patient VALUES(NULL, $idpatient, $idmesure, 1)";
                                    //var_dump($req4);
                                    $insert_patient_mesure = mysqli_query($con, $req4);  
                                } 
                                // var_dump($req3);
                                if(mysqli_query($con,$req3)){                                    
                                    
                                    if($etat == 0){
                                         
                                         // write user data into PHP SESSION (a file on your server)
                                        $_SESSION['idusers'] = $idusers;
                                        $_SESSION['role'] = 'Patient';
                                        $_SESSION['idpersonne'] = $idpersonne;
                                        $_SESSION['login'] = $email;
                                        $_SESSION['nom'] = $nom;
                                        $_SESSION['prenom'] = $prenom;
                                        $_SESSION['user_login_status'] = 0;
                                        $_SESSION['code'] = $code;
                                        $_SESSION['etat'] = 0;
                                        
                                       echo "<script type='text/javascript'>document.location.replace('./validation.php');</script>";
                                    }else{
                                        
                                        $messages[] = $lang['Patient enrégistré avec succès'];
                                    }
                                       
                                 }else{

                                $errors[] = $lang['Erreur 213 : Une erreur est survenue lors de l\'enregistrement de l\'unité patient, veuillez contacter l\'administrateur:'].''.mysqli_error($con).'<br>';
                                ;

                                }

                                
                            }else{ //si l'insertion du nouveau user a echoué
                                $errors[] = $lang['Erreur 204: Une erreur est survenue lors de l\'enregistrement du patient, veuillez contacter l\'administrateur: '].''.mysqli_error($con).'<br>';
                                
                            }
      

                        }else{ // si l'insertion du patient a echoué
                            $errors[] =  $lang['Erreur 204: Une erreur est survenue lors de l\'enregistrement du patient, veuillez contacter l\'administrateur: '].''.mysqli_error($con).'<br>';

                            
                        }

                    }else{ // si l'insertion de la personne a echoué
                        $errors[] =  $lang['Erreur 204: Une erreur est survenue lors de l\'enregistrement du patient, veuillez contacter l\'administrateur: '].''.mysqli_error($con).'<br>';

                    }

             }  //fin d'envoi de mail	
            }

        }else{

            $errors[] = $lang['Erreur 204: Une erreur est survenue lors de l\'enregistrement du patient, veuillez contacter l\'administrateur: '].''.mysqli_error($con).'<br>';
        }    

        if (isset($errors)){
			
            ?>
			<div class="alert alert-danger" role="alert">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
                                <strong><u><?php echo $lang['Erreurs!']; ?></u></strong> <br>
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