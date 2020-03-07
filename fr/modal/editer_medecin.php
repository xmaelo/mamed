	<?php
		if (isset($con))
		{
	?>
	<!-- Modal -->
	<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close close_form" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel"><i class='fa fa-edit'></i> <?php echo $lang['editerMed']; ?></h4>
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" method="post" id="form_editer_medecin" name="editer_medecin">
			<div id="resultat_ajax2"></div>
			  <div class="form-group">
				<label for="mod_nom" class="col-sm-2 control-label"><?php echo $lang['nom']; ?><span class="obligatoire">*</span></label>
				<div class="col-sm-10">
				  <input type="text" class="form-control" id="mod_nom" name="mod_nom"  required>
					<input type="hidden" name="mod_idmedecin" id="mod_idmedecin">							  
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
				<label for="mod_idspecialite" class="col-md-2 control-label"><?php echo $lang['specialite']; ?><span class="obligatoire">*</span></label>
				<div class="col-md-4">
					<select class='form-control' name='mod_idspecialite' id='mod_idspecialite' required>
							<?php 
							$query_specialite=mysqli_query($con,"select * from specialite where lisible = 1 order by libelle");
							while($rw=mysqli_fetch_array($query_specialite))	{
								?>
							<option value="<?php echo $rw['idspecialite'];?>"><?php echo $rw['libelle'];?></option>			
								<?php
							}
							?>
					</select>			  
				</div>
			 
				<label for="mod_anciennete" class="col-md-2 control-label"><?php echo $lang['ancien']; ?><span class="obligatoire">*</span></label>
				<div class="col-md-4">
				  <input type="number" class="form-control" min="1" max="100" id="mod_anciennete" name="mod_anciennete" required>
				</div>
			  </div>				
			
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-warning close_form" data-dismiss="modal"><?php echo $lang['annuler']; ?></button>
			<button type="submit" class="btn btn-primary" id="mise_a_jour_medecin"><?php echo $lang['miseAjour']; ?></button>
		  </div>
		  </form>
		</div>
	  </div>
	</div>
	<?php
		}
	?>

	