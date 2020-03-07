	<?php
		if (isset($con))
		{
	?>
	<!-- Modal -->
	<div class="modal fade" id="modal_editer_patient" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close close_form" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel"><i class='fa fa-edit'></i> <?php echo $lang['edietrPatient']; ?></h4>
		  </div>
		  <div class="modal-body">

			<form class="form-horizontal" method="post" action="ajax/editer_patient.php" id="form_editer_patienttt" name="editer_patienttt" enctype="multipart/form-data">
			<div id="resultat_ajax2"></div>
			  <div class="form-group">
				<label for="mod_nom" class="col-sm-2 control-label"><?php echo $lang['nom']; ?><span class="obligatoire">*</span></label>
				<div class="col-sm-10">
				  <input type="text" class="form-control" id="mod_nom" name="mod_nom"  required>
					<input type="hidden" name="mod_idpatient" id="mod_idpatient">							  
					<input type="hidden" name="mod_idpersonne" id="mod_idpersonne">
					
				</div>
			  </div>			   			 
			  <div class="form-group">
				<label for="mod_prenom" class="col-sm-2 control-label"><?php echo $lang['prenom']; ?></label>
				<div class="col-sm-4">
				  <input type="text" class="form-control" id="mod_prenom" name="mod_prenom">
				</div>

				<label for="mod_datenaiss" class="col-sm-2 control-label"><?php echo $lang['dateDdeNaissance']; ?><span class="obligatoire">*</span></label>
				<div class="col-sm-4">
				  <input type="text" class="form-control datepicker" id="mod_datenaiss" name="mod_datenaiss" pattern="(0[1-9]|1[0-9]|2[0-9]|3[01])/(0[1-9]|1[012])/[0-9]{4}" placeholder="dd/mm/yyyy" required>
				</div>
			  </div>
			  <div class="form-group">
				<label for="mod_sexe" class="col-sm-2 control-label"><?php echo $lang['sexe']; ?><span class="obligatoire">*</span></label>
				<div class="col-sm-4">
				  <select id="mod_sexe" name="mod_sexe" class="form-control" required>
				  	<option value="F"><?php echo $lang['feminin']; ?></option>
				  	<option value="M"><?php echo $lang['masculin']; ?></option>
				  </select>
				</div>

				<label for="mod_adesse" class="col-sm-2 control-label"><?php echo $lang['addresse']; ?><span class="obligatoire">*</span></label>
				<div class="col-sm-4">
				  <input type="text" class="form-control" id="mod_adresse" name="mod_adresse" required>
				</div>
			  </div>
			  <div class="form-group">
				<label for="mod_telephone1" class="col-sm-2 control-label"><?php echo $lang['telephone1']; ?><span class="obligatoire">*</span></label>
				<div class="col-sm-4">
				  <input type="text" class="form-control" id="mod_telephone1" name="mod_telephone1" required>
				</div>

				<label for="mod_telephone2" class="col-sm-2 control-label"><?php echo $lang['telephone2']; ?></label>
				<div class="col-sm-4">
				  <input type="text" class="form-control" id="mod_telephone2" name="mod_telephone2">
				</div>
			  </div>
			  <div class="form-group">
				<label for="mod_idtype_diabete" class="col-sm-2 control-label"><?php echo $lang['typeDeDiabete']; ?><span class="obligatoire">*</span></label>
				<div class="col-sm-10">
					<select class='form-control' name='mod_idtype_diabete' id='mod_idtype_diabete' required>
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
				<label for="mod_poids" class="col-sm-2 control-label"><?php echo $lang['poids']; ?><span class="obligatoire">*</span></label>
				<div class="col-md-4">
				  <input type="text" class="form-control" id="mod_poids" name="mod_poids" required>
				</div>
			  
				<label for="mod_taille" class="col-sm-2 control-label"><?php echo $lang['taille']; ?><span class="obligatoire">*</span></label>
				<div class="col-md-4">
				  <input type="Number" min="50" max="400" class="form-control"  id="mod_taille" name="mod_taille" required>
				</div>
			  </div>
			 <div class="form-group">
			  <!-- Nom du patient-->
				<label for="mod_personne_urgence" class="col-md-2 control-label"><?php echo $lang['personneDurgence']; ?><span class="obligatoire">*</span></label>
				<div class="col-md-4">
				  <input type="text" class="form-control" id="mod_personne_urgence" name="mod_personne_urgence" required>	
				</div>
			  
			  <!-- Nom du contactpatient-->
				<label for="mod_telephone_urgence" class="col-md-2 control-label"><?php echo $lang['telephoneDurgence']; ?><span class="obligatoire">*</span></label>
				<div class="col-md-4">
				  <input type="text" class="form-control" id="mod_telephone_urgence" name="mod_telephone_urgence" required>

				</div>
			</div>
			<!-- <div class="form-group">

				<label for="pass" class="col-md-2 control-label"><?php echo $lang['newPassword']; ?></label>
				<div class="col-md-4">
				  <input type="password" class="form-control" id="pass" name="pass" placeholder="<?php echo $lang['newPassword']; ?>">	
				</div>
			  
				<label for="pass" class="col-md-2 control-label"><?php echo $lang['confirmation']; ?></label>
				<div class="col-md-4">
				  <input type="password" class="form-control" id="confPass" name="confPass" placeholder="<?php echo $lang['confirmation']; ?>">

				</div>


				
			 </div>   -->
			 
			 <input type="hidden" name="appelant" id="mod_appelant" value="0">
			 <div class="form-group">
				 <label for="mod_picture" class="col-md-2 control-label"><?php echo $lang['photo']; ?>:</label>
				 <div class="col-md-4">
					  <input type="file"  id="mod_picture" name="mod_picture">
				 </div>
			 </div>
			  

			
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-warning close_form" data-dismiss="modal"><?php echo $lang['annuler']; ?></button>
			<button type="submit" class="btn btn-primary" id="mise_a_jour_patient"><?php echo $lang['miseAjour']; ?></button>
		  </div>
		  </form>
		</div>
	  </div>
	</div>
	<?php
		}
	?>

	