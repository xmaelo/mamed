	<?php
		if (isset($con))
		{
	?>
	<!-- Modal -->
	<div class="modal fade" id="nouveauMedecin" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document" style="width: 50%;">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close close_form" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<span style="font-weight: bold; font-size: 1.5em;" class="modal-title" id="myModalLabel"><i class='fa fa-plus'></i> 
				<?php echo $lang['enteteMed']; ?>
		  </div>
		  <div class="modal-body">


			<form class="form-horizontal" method="post" action="ajax/nouveau_medecin.php" id="form_nouveau_medecin" name="nom_medecin" enctype="multipart/form-data">
			<div id="resultat_ajax"></div>
			  <div class="form-group">
			  <!-- Nom du medecin-->
				<label for="nom_medecin" class="col-md-2 control-label"><?php echo $lang['nom']; ?><span class="obligatoire">*</span></label>
				<div class="col-sm-10">
				  <input type="text" class="form-control" id="nom_patent" name="nom_medecin" required>
				</div>
			  </div>  
			  <div class="form-group">	
			  	<label for="prenom_medecin" class="col-md-2 control-label"><?php echo $lang['prenom']; ?></label>
				<div class="col-md-4">
				  <input type="text" class="form-control" id="prenom_medecin" name="prenom_medecin">
				</div>
			 
				<label for="ddn_medecin" class="col-md-2 control-label"><?php echo $lang['dateDdeNaissance']; ?><span class="obligatoire">*</span></label>
				<div class="col-md-4">
				  <input type="date" class="form-control" placeholder="JJ/MM/AAAA" id="ddn_medecin" name="datenaiss_medecin" pattern="(0[1-9]|1[0-9]|2[0-9]|3[01])/(0[1-9]|1[012])/[0-9]{4}" placeholder="dd/mm/yyyy" required>
				</div>
			 </div>
                         <!-- Sexe et Région-->
                            <div class="form-group"> 
                                <label for="sexe_medecin" class="col-sm-2 control-label"><?php echo $lang['sexe']; ?><span class="obligatoire">*</span></label> 
				<div class="col-sm-4">
				  <select id="sexe_medecin" name="sexe_medecin" class="form-control" required>
				  	<option disabled selected><?php echo $lang['choisir']; ?></option>
				  	<option value="F"><?php echo $lang['feminin']; ?></option>
				  	<option value="M"><?php echo $lang['masculin']; ?></option>
				  </select>
				</div>
			  
				<label for="region_medecin" class="col-sm-2 control-label"><?php echo $lang['region']; ?><span class="obligatoire">*</span></label>
				<div class="col-sm-4">
				  <select id="region_medecin" name="region_medecin" class="form-control" required>
				  	<option disabled selected><?php echo $lang['choisirUneRegion']; ?></option>
				  	<?php 
                                            $regions = mysqli_query($con, "SELECT * FROM region WHERE lisible = 1 ORDER BY region");
                                            while($region = mysqli_fetch_array($regions)){
                                        ?>
                                        <option value="<?php echo $region['idregion']; ?>"><?php echo utf8_encode($region['region']); ?></option>   
                                        <?php
                                            }
                                        ?>
				  </select>
				</div>                                    
                               
			    </div>
                         <!-- Département et arrondissement-->
			 <div class="form-group"> 
				 <label for="departement_medecin" class="col-sm-2 control-label"><?php echo $lang['departement']; ?><span class="obligatoire">*</span></label>
				<div class="col-sm-4">
                                  <div id="loader_departement"></div>
				  <select id="departement_medecin" name="departement_medecin" class="form-control" required>
				  	<option disabled selected><?php echo $lang['choisirUnDepartement']; ?></option>
				  </select>
				</div>
                                
                                 <label for="arrondissement_medecin" class="col-sm-2 control-label"><?php echo $lang['arrondissement']; ?><span class="obligatoire">*</span></label>
				<div class="col-sm-4">
                                  <div id="loader_arrondissement"></div>  
				  <select id="arrondissement_medecin" name="arrondissement_medecin" class="form-control" required>
				  	<option disabled selected><?php echo $lang['choisirUnArrondissement']; ?></option>
				  </select>
				</div>
			  </div>

			  <div class="form-group">
			  <!-- Nom du medecin-->
				<label for="email_medecin" class="col-md-2 control-label"><?php echo $lang['email']; ?><span class="obligatoire">*</span></label>
				<div class="col-sm-4">
				  <input type="email" class="form-control" id="email_medecin" name="email_medecin" required>
				</div>
                                
                                
				<label for="adress_medecin" class="col-md-2 control-label"><?php echo $lang['addresse']; ?><span class="obligatoire">*</span></label>
				<div class="col-sm-4">
				  <input type="text" class="form-control" id="adresse_medecin" name="adresse_medecin" required>
				</div>
			  </div>  

			  <div class="form-group">
				<label for="password_medecin" class="col-sm-2 control-label"><?php echo $lang['motDePasse']; ?><span class="obligatoire">*</span></label>
				<div class="col-md-4">
				  <input type="password" class="form-control" id="password_medecin" name="password_medecin" required>
				</div>
			  
				<label for="confirmation_password" class="col-sm-2 control-label"><?php echo $lang['confirmation']; ?><span class="obligatoire">*</span></label>
				<div class="col-md-4">
				  <input type="password" class="form-control" id="confirmation_password" name="confirmation_password">
				</div>
			  </div>

			  <div class="form-group">
				<label for="telephone1_medecin" class="col-sm-2 control-label"><?php echo $lang['telephone1']; ?><span class="obligatoire">*</span></label>
				<div class="col-md-4">
				  <input type="text" class="form-control" id="telephone1_medecin" name="telephone1_medecin" required>
				</div>
			  
				<label for="telephone2_medecin" class="col-sm-2 control-label"><?php echo $lang['telephone2']; ?></label>
				<div class="col-md-4">
				  <input type="text" class="form-control" id="telephone2_medecin" name="telephone2_medecin">
				</div>
			  </div>

			  <div class="form-group">
				<label for="categoria" class="col-sm-2 control-label"><?php echo $lang['specialite']; ?><span class="obligatoire">*</span></label>
				<div class="col-sm-4">
					<select class='form-control' name='specialite' id='specialite' required>
						<option value="<?php echo $lang['selectionner']; ?>"></option>
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

				<label for="anciennete_medecin" class="col-md-2 control-label"><?php echo $lang['ancien']; ?><span class="obligatoire">*</span></label>
				<div class="col-md-4">
				  <input type="number" min="1" max="100" class="form-control" id="anciennete_medecin" name="anciennete_medecin" required>
				</div>

			  </div>
			  <div class="form-group">
				 <label for="mod_picture" class="col-md-2 control-label"><?php echo $lang['photo']; ?>:</label>
				 <div class="col-md-4">
					  <input type="file"  id="mod_picture" name="mod_picture">
				 </div>
			 </div>
			
		  </div>
		  <div class="modal-footer">
                      <button type="button" id="annuler" class="btn btn-warning close_form" data-dismiss="modal"><?php echo $lang['annuler']; ?></button>
			<button type="submit" class="btn btn-primary" id="btn_save_medecin"><?php echo $lang['enregistrer']; ?></button>
		  </div>
		  </form>
		</div>
	  </div>
	</div>
	<?php
		}
	?>