	<?php
		if (isset($con))
		{
	?>
	<!-- Modal -->
	<div class="modal fade" id="validation" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close close_form" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<span style="font-weight: bold; font-size: 1.5em;" class="modal-title" id="myModalLabel"><i class='fa fa-edit'></i>Validation de l'adresse email <span class="obligatoire">*</span> sont obligatoires)
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" method="post" id="form_validation_email" name="nom_patient">
			<div id="resultat_ajax"></div>
			  <div class="form-group">
			  <!-- Nom du patient-->
				<label for="nom_patient" class="col-md-2 control-label">Nom<span class="obligatoire">*</span></label>
				<div class="col-sm-10">
				  <input type="text" class="form-control" id="nom_patent" name="nom_patient" required>
				</div>
			  </div>  
			  <div class="form-group">	
			  	<label for="prenom_patient" class="col-md-2 control-label">Prénom</label>
				<div class="col-md-4">
				  <input type="text" class="form-control" id="prenom_patient" name="prenom_patient">
				</div>
			 
				<label for="ddn_patient" class="col-md-2 control-label">DDN<span class="obligatoire">*</span></label>
				<div class="col-md-4">
				  <input type="text" class="form-control datepicker" placeholder="JJ/MM/AAAA" id="ddn_patient" name="datenaiss_patient" pattern="(0[1-9]|1[0-9]|2[0-9]|3[01])/(0[1-9]|1[012])/[0-9]{4}" placeholder="dd/mm/yyyy" required>
				</div>
			 </div>
			 <div class="form-group"> 
				<label for="sexe_patient" class="col-sm-2 control-label">Sexe<span class="obligatoire">*</span></label>
				<div class="col-sm-4">
				  <select id="sexe_patient" name="sexe_patient" class="form-control" required>
				  	<option disabled selected>Choisir</option>
				  	<option value="F">Féminin</option>
				  	<option value="M">Masculin</option>
				  </select>
				</div>
			  
				<label for="adress_patient" class="col-md-2 control-label">Adresse<span class="obligatoire">*</span></label>
				<div class="col-sm-4">
				  <input type="text" class="form-control" id="adresse_patient" name="adresse_patient" required>
				</div>
			  </div>

			  <div class="form-group">
			  <!-- Nom du patient-->
				<label for="email_patient" class="col-md-2 control-label">Email<span class="obligatoire">*</span></label>
				<div class="col-sm-10">
				  <input type="email" class="form-control" id="email_patient" name="email_patient" required>
				</div>
			  </div>  

			  <div class="form-group">
				<label for="password_patient" class="col-sm-2 control-label">Mot de passe<span class="obligatoire">*</span></label>
				<div class="col-md-4">
				  <input type="password" class="form-control" id="password_patient" name="password_patient" required>
				</div>
			  
				<label for="confirmation_password" class="col-sm-2 control-label">Confirmation<span class="obligatoire">*</span></label>
				<div class="col-md-4">
				  <input type="password" class="form-control" id="confirmation_password" name="confirmation_password">
				</div>
			  </div>

			  <div class="form-group">
				<label for="telephone1_patient" class="col-sm-2 control-label">Téléphone1<span class="obligatoire">*</span></label>
				<div class="col-md-4">
				  <input type="text" class="form-control" id="telephone1_patient" name="telephone1_patient" required>
				</div>
			  
				<label for="telephone2_patient" class="col-sm-2 control-label">Téléphone2</label>
				<div class="col-md-4">
				  <input type="text" class="form-control" id="telephone2_patient" name="telephone2_patient">
				</div>
			  </div>

			  <div class="form-group">
				<label for="categoria" class="col-sm-2 control-label">Type de diabète<span class="obligatoire">*</span></label>
				<div class="col-sm-10">
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
				<label for="poids_patient" class="col-sm-2 control-label">Poids<span class="obligatoire">*</span></label>
				<div class="col-md-4">
				  <input type="text" class="form-control" id="poids_patient" name="poids_patient" required>
				</div>
			  
				<label for="taille_patient" class="col-sm-2 control-label">Taille(cm)<span class="obligatoire">*</span></label>
				<div class="col-md-4">
				  <input type="Number" min="50" max="400" class="form-control" id="taille_patient" name="taille_patient" required>
				</div>
			  </div>

			  <div class="form-group">
			  <!-- Nom du patient-->
				<label for="personne_urgence" class="col-md-2 control-label">Personne d'urgence<span class="obligatoire">*</span></label>
				<div class="col-md-4">
				  <input type="text" class="form-control" id="personne_urgence" name="personne_urgence" required>
				</div>
			  
			  <!-- Nom du contactpatient-->
				<label for="telephone_urgence" class="col-md-2 control-label">Téléphone urgence<span class="obligatoire">*</span></label>
				<div class="col-md-4">
				  <input type="text" class="form-control" id="telephone_urgence" name="telephone_urgence" required>
				</div>
			  </div>  
			
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-warning close_form" data-dismiss="modal">Annuler</button>
			<button type="submit" class="btn btn-primary" id="btn_save_patient">Enregistrer</button>
		  </div>
		  </form>
		</div>
	  </div>
	</div>
	<?php
		}
	?>