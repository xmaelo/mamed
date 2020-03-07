	<?php
		if (isset($con))
		{
			$req = "SELECT * FROM mesure_patient INNER JOIN mesure ON mesure_idmesure = idmesure 		AND patient_idpatient = '$idpatient'
						AND mesure_patient.etat = 1";
					
			$mesures=mysqli_query($con, $req);
			//var_dump($mesures);
	?>
	<!-- Modal -->
	<div class="modal fade" id="editerMesure" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close close_form" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<span style="font-weight: bold; font-size: 1.5em;" class="modal-title" id="myModalLabel"><i class='fa fa-edit'></i><?php echo $lang['editerMesure']; ?>
			</span> ( <?php echo $lang['leChampsAvec*SontObligatoires']; ?> )
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" method="post" id="form_editer_mesure" name="form_editer_mesure">
			<div id="resultat_ajax_mesure"></div>
			  <div class="form-group">
			  <input type="hidden" name="mod_idjournal" id="mod_idjournal">
			  <!-- créneau-->
				<label for="creneau" class="col-md-2 control-label"><?php echo $lang['creneau']; ?><span class="obligatoire">*</span></label> 
				<div class="col-sm-10">
				 <select id="mod_idmesure" name="creneau" class="form-control" required>
				  	<option disabled selected><?php echo $lang['selectionner']; ?></option>
				  	<!-- <option><?php echo $lang['auLever']; ?> </option>
				  	<option><?php echo $lang['avantLePetitDejeuner']; ?> </option>
				  	<option><?php echo $lang['avantLeDejeuner']; ?> </option>
				  	<option><?php echo $lang['apresLeDejeuner']; ?> </option>
				  	<option><?php echo $lang['avantLeDiner']; ?> </option>
				  	<option><?php echo $lang['apresLeDiner']; ?> </option>
				  	<option><?php echo $lang['auCoucher']; ?> </option> -->
				   <?php while ($mesure = mysqli_fetch_array($mesures)){
				  	?>
				  		<option value="<?php echo $mesure['idmesure'] ?>"><?php echo $lang[$mesure['libelle']]; ?></option>
				  	<?php
				  	} ?> 
				  </select>
				</div>
			  </div>  
			  <div class="form-group">	
			  	<label for="valeur" class="col-md-2 control-label"><?php echo $lang['valeur']; ?><span class="obligatoire">*</span></label>
				<div class="col-md-10">
				  <input type="text" class="form-control" id="mod_valeur" name="mod_valeur" placeholder="Valeur" required>
				</div>
			 </div>
			 <div class="form-group">
				<label for="insuline" class="col-md-2 control-label"><?php echo $lang['insuline']; ?><span class="obligatoire">*</span></label>
				<div class="col-md-10">
				  <input type="text" class="form-control" placeholder="Insuline" id="mod_insuline" name="mod_insuline" required>
				</div>
			 </div>

			 <div class="form-group"> 
				<label for="insuline2" class="col-md-2 control-label"><?php echo $lang['insuline']; ?>2</label>
				<div class="col-md-10">
				  <input type="text" class="form-control" placeholder="Insuline2" id="mod_insuline2" name="mod_insuline2">
			 	</div>
			 </div>	

			  <div class="form-group">				
				  <label for="pression" class="col-md-2 control-label"><?php echo $lang['pressionArterielle']; ?><span class="obligatoire">*</span></label>
				  <div class="col-md-10">
					  <input type="text" class="form-control" id="mod_pression_arterielle" name="mod_pression_arterielle" placeholder="Pression artérielle" required>
				  </div>
			  </div>

			  <div class="form-group">
			  <!-- Acétone -->
				<label for="acetone" class="col-md-2 control-label"><?php echo $lang['acetone']; ?></label>
				<div class="col-md-10">
				  <input type="text" class="form-control" id="mod_acetone" placeholder="acetone" name="mod_acetone">
				</div>
			  </div>  

			  <div class="form-group">
				<label for="hba1c" class="col-sm-2 control-label"><?php echo $lang['hba1c']; ?></label>
				<div class="col-md-10">
				  <input type="text" class="form-control" id="mod_hba1c" name="mod_hba1c" placeholder="hba1c">
				</div>
			  </div>

			  <div class="form-group">
				<label for="notes" class="col-sm-2 control-label"><?php echo $lang['notes']; ?></label>
				<div class="col-md-10">
				  <textarea id="mod_notes" class="form-control" name="mod_notes"></textarea>
				</div>
			  </div>
			  
			  <div class="modal-footer">
				<button type="button" class="btn btn-warning close_form" data-dismiss="modal"><?php echo $lang['annuler']; ?></button>
				<button type="submit" class="btn btn-primary" id="btn_editer_mesure"><?php echo $lang['enregistrer']; ?></button>
			  </div>
		  </form>
		</div>
	  </div>
	</div>
  </div>
	<?php
		}
	?>
