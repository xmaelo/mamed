<?php

// include the configs / constants for the database connection
require_once("config/db.php");
require_once("config/connexion.php");

?>
	<!DOCTYPE html>
<html lang="fr">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no"/>
  <title>MaMED | Nouveau patient</title>
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
  <!-- CSS  -->
   <link href="css/login.css" type="text/css" rel="stylesheet" media="screen,projection"/>
   <link rel=icon href='img/logo-maMED.png' sizes="32x32" type="image/png">
   <link rel="stylesheet" href="libraries/datepicker/datepicker3.css">
</head>
<body>	
 <div class="container">
    <div class="row">
    <div class="col-md-2"></div>  
    	<div class="col-md-9" style="margin-top: 2%;">
         <section class="panel">
        	<header class="panel-heading"> 
        	<span style="font-weight: bold; font-size: 1.5em; color: green;" class="modal-title" id="myModalLabel"><i class='fa fa-plus'></i>Nouveau patient </span> (Les champs avec <span>*</span> sont obligatoires)
            </header>
             <form class="form-horizontal" method="post" id="form_nouveau_patient" name="nom_patient">
			<?php
				// show potential errors / feedback (from login object)
				if (isset($login)) {
					if ($login->errors) {
						?>
						<div class="alert alert-danger alert-dismissible" role="alert">
						    <strong>Erreur!</strong> 
						
						<?php 
						foreach ($login->errors as $error) {
							echo $error;
						}
						?>
						</div>
						<?php
					}
					if ($login->messages) {
						?>
						<div class="alert alert-success alert-dismissible" role="alert">
						    <strong>Info!</strong>
						<?php
						foreach ($login->messages as $message) {
							echo $message;
						}
						?>
						</div> 
						<?php 
					}
				}
				?>
               
			<div id="resultat_ajax"></div>
			 <div class="form-group">
			  <!-- Nom du patient-->
				<label for="nom_patient" class="col-md-2 control-label">Nom<span class="obligatoire">*</span></label>
				<div class="col-md-8">
				  <input type="text" class="form-control" id="nom_patent" name="nom_patient" autofocus="" required>
				</div>
			  </div>  
			  <div class="form-group">	
			  	<label for="prenom_patient" class="col-md-2 control-label">Prénom</label>
				<div class="col-md-3">
				  <input type="text" class="form-control" id="prenom_patient" name="prenom_patient">
				</div>
			 
				<label for="ddn_patient" class="col-md-2 control-label">DDN<span class="obligatoire">*</span></label>
				<div class="col-md-3">
				  <input type="text" class="form-control datepicker" placeholder="JJ/MM/AAAA" id="ddn_patient" name="datenaiss_patient" pattern="(0[1-9]|1[0-9]|2[0-9]|3[01])/(0[1-9]|1[012])/[0-9]{4}" placeholder="dd/mm/yyyy" required>
				</div>
			 </div>
			 <div class="form-group"> 
				<label for="sexe_patient" class="col-md-2 control-label">Sexe<span class="obligatoire">*</span></label>
				<div class="col-md-3">
				  <select id="sexe_patient" name="sexe_patient" class="form-control" required>
				  	<option disabled selected>Choisir</option>
				  	<option value="F">Féminin</option>
				  	<option value="M">Masculin</option>
				  </select>
				</div>
			  
				<label for="adress_patient" class="col-md-2 control-label">Adresse<span class="obligatoire">*</span></label>
				<div class="col-md-3">
				  <input type="text" class="form-control" id="adresse_patient" name="adresse_patient" required>
				</div>
			  </div>

			  <div class="form-group">
			  <!-- Nom du patient-->
				<label for="email_patient" class="col-md-2 control-label">Email<span class="obligatoire">*</span></label>
				<div class="col-md-8">
				  <input type="email" class="form-control" id="email_patient" name="email_patient" required>
				</div>
			  </div>  

			  <div class="form-group">
				<label for="password_patient" class="col-md-2 control-label">Mot de passe<span class="obligatoire">*</span></label>
				<div class="col-md-3">
				  <input type="password" class="form-control" id="password_patient" name="password_patient" required>
				</div>
			  
				<label for="confirmation_password" class="col-md-2 control-label">Confirmation<span class="obligatoire">*</span></label>
				<div class="col-md-3">
				  <input type="password" class="form-control" id="confirmation_password" name="confirmation_password">
				</div>
			  </div>

			  <div class="form-group">
				<label for="telephone1_patient" class="col-md-2 control-label">Téléphone1<span class="obligatoire">*</span></label>
				<div class="col-md-3">
				  <input type="text" class="form-control" id="telephone1_patient" name="telephone1_patient" required>
				</div>
			  
				<label for="telephone2_patient" class="col-md-2 control-label">Téléphone2</label>
				<div class="col-md-3">
				  <input type="text" class="form-control" id="telephone2_patient" name="telephone2_patient">
				</div>
			  </div>

			  <div class="form-group">
				<label for="categoria" class="col-md-2 control-label">Type de diabète<span class="obligatoire">*</span></label>
				<div class="col-md-8">
					<select class='form-control' name='diabete' id='diabete' required>
						<option value="">Sélectionner un type</option>
							<?php 
							$query_type=mysqli_query($con,"select * from diabete where lisible = 1 order by type");
							while($rw=mysqli_fetch_array($query_type))	{
								?>
							<option value="<?php echo $rw['iddiabete'];?>"><?php echo $rw['type'];?></option>			
								<?php
							}
							?>
					</select>			  
				</div>
			  </div>

			  <div class="form-group">
				<label for="poids_patient" class="col-md-2 control-label">Poids<span class="obligatoire">*</span></label>
				<div class="col-md-3">
				  <input type="text" class="form-control" id="poids_patient" name="poids_patient" required>
				</div>
			  
				<label for="taille_patient" class="col-md-2 control-label">Taille(cm)<span class="obligatoire">*</span></label>
				<div class="col-md-3">
				  <input type="Number" min="50" max="400" class="form-control" id="taille_patient" name="taille_patient" required>
				</div>
			  </div>

			  <div class="form-group">
			  <!-- Nom du patient-->
				<label for="personne_urgence" class="col-md-2 control-label">Personne d'urgence<span class="obligatoire">*</span></label>
				<div class="col-md-3">
				  <input type="text" class="form-control" id="personne_urgence" name="personne_urgence" required>
				</div>
			  
			  <!-- Nom du contactpatient-->
				<label for="telephone_urgence" class="col-md-2 control-label">Téléphone urgence<span class="obligatoire">*</span></label>
				<div class="col-md-3">
				  <input type="text" class="form-control" id="telephone_urgence" name="telephone_urgence" required>
				</div>
			  </div>  
			<div class="form-group">
				<div class="col-md-offset-4 col-md-8" >
					<button type="button" class="btn btn-default close_form" >Annuler</button>
					<button type="submit" class="btn btn-success" id="btn_save_patient">Enregistrer</button>
				</div>	
		  </div>	
		  </div>
		   
				
            </form><!-- /form -->
        
         </section>   
          </div>  
          <div class="col-md-2"></div>    
        </div><!-- /card-container -->
    </div><!-- /container -->
     <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
  <!-- datepicker -->
<script src="libraries/datepicker/bootstrap-datepicker.js"></script>
<script src="libraries/datepicker/locales/bootstrap-datepicker.fr.js" charset="UTF-8"></script>

<script type="text/javascript" src="js/new_patient_login.js"></script>
  </body>
</html>
<style type="text/css">
	.obligatoire{
		color: red;
	}
</style>