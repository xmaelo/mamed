	<?php
		if (isset($con))
		{
			$req = "SELECT * FROM mesure_patient INNER JOIN mesure ON mesure_idmesure = idmesure 		AND patient_idpatient = '$idpatient'
						AND mesure_patient.etat = 1";
					
			$mesures=mysqli_query($con, $req);
			//var_dump($mesures);
	?>
	<!-- Modal -->
	<div class="modal fade" id="nouvelleMesure" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close close_form" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<span style="font-weight: bold; font-size: 1.5em;" class="modal-title" id="myModalLabel"><i class='fa fa-plus'></i><?php echo $lang['nouvelleMesure']; ?>
		</span> ( <?php echo $lang['leChampsAvec*SontObligatoires']; ?> )
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" method="post" id="form_nouvelle_mesure" name="form_nouvelle_mesure">
			<div id="resultat_ajax"></div>
			  <div class="form-group">
			  <input type="hidden" name="idpatient" value="<?php echo $idpatient; ?>">
			  <!-- créneau-->
				<label for="creneau" class="col-md-2 control-label"><?php echo $lang['creneau']; ?><span class="obligatoire">*</span></label>
				<div class="col-sm-10">
				 <select id="creneau" name="creneau" class="form-control" required>
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
				  		<option value="<?php echo $mesure['idmesure'] ?>"><?php  echo $lang[$mesure['libelle']]; ?></option>
				  	<?php
				  	} ?> 
				  </select>
				</div>
			  </div>  
			  <div class="form-group">	
			  	<label for="valeur" class="col-md-2 control-label"><?php echo $lang['valeur']; ?><span class="obligatoire">*</span></label>
				<div class="col-md-10">
				  <input type="text" class="form-control" id="valeur" name="valeur" placeholder="<?php echo $lang['valeur']; ?>" required>
				</div>
			 </div>
			 <div class="form-group">
				<label for="insuline" class="col-md-2 control-label"><?php echo $lang['insuline']; ?><span class="obligatoire">*</span></label>
				<div class="col-md-10">
				  <input type="text" class="form-control" placeholder="<?php echo $lang['insuline']; ?>" id="insuline" name="insuline" required>
				</div>
			 </div>

			 <div class="form-group"> 
				<label for="insuline2" class="col-md-2 control-label"><?php echo $lang['insuline']; ?>2</label>
				<div class="col-md-10">
				  <input type="text" pattern="[0-9]{2,3}" class="form-control" placeholder="<?php echo $lang['insuline']; ?>2" id="insuline2" name="insuline2">
			 	</div>
			 </div>	

			  <div class="form-group">				
				  <label for="pression" class="col-md-2 control-label"><?php echo $lang['pressionArterielle']; ?><span class="obligatoire">*</span></label>
				  <div class="col-md-10">
					  <input type="text" class="form-control" id="pression_arterielle" name="pression_arterielle" placeholder="00/00" pattern="[0-9]{2}[/][0-9]{2}" required>
				  </div>
			  </div>

			  <div class="form-group">
			  <!-- Acétone -->
				<label for="acetone" class="col-md-2 control-label"><?php echo $lang['acetone']; ?></label>
				<div class="col-md-10">
				  <input type="text" class="form-control" id="acetone" placeholder="<?php echo $lang['acetone']; ?>" name="acetone">
				</div>
			  </div>  

			  <div class="form-group">
				<label for="hba1c" class="col-sm-2 control-label"><?php echo $lang['hba1c']; ?></label>
				<div class="col-md-10">
				  <input type="text" class="form-control" id="hba1c" name="hba1c" placeholder="<?php echo $lang['hba1c']; ?>">
				</div>
			  </div>

			  <div class="form-group">
				<label for="notes" class="col-sm-2 control-label"><?php echo $lang['notes']; ?></label>
				<div class="col-md-10">
				  <textarea id="note" class="form-control" name="notes"></textarea>
				</div>
			  </div>
			  
			  <div class="modal-footer">
                              <button type="button" id="annuler" class="btn btn-warning close_form" data-dismiss="modal"><?php echo $lang['annuler']; ?></button>
				<button type="submit" class="btn btn-primary" id="btn_save_mesure"><?php echo $lang['enregistrer']; ?></button>
			  </div>
		  </form>
		</div>
	  </div>
	</div>
  </div>
	<?php
		}
	?>