<?php
		if (isset($con)) 
		{
	?>
	<!-- Modal -->
        <div class="modal fade" id="nouveau_patient" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"> 
	  <div class="modal-dialog" role="document" style="width: 80%;">
		<div class="modal-content" >
                    <form class="form-horizontal" method="post" id="form_nouveau_patient" name="nom_patient">
                    <div class="modal-header">
			<button type="button" class="close close_form" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<span style="font-weight: bold; font-size: 1.5em;" class="modal-title" id="myModalLabel"><i class='fa fa-plus'></i><?php echo $lang['modal']; ?>
                    </div>
                    <div class="modal-body">
                            <!-- Affichage des resultats du traitement du formulaire-->
                            <div id="resultat_ajax"></div>                           
                            <!-- Nom du patient et prenom du patient-->
                            <div class="form-group">                                
				<label for="nom_patient" class="col-md-2 control-label"><?php echo $lang['nom']; ?><span class="obligatoire">*</span></label>
				<div class="col-md-4">
				  <input type="text" class="form-control" id="nom_patent" name="nom_patient" required>
				</div>
			 
			  	<label for="prenom_patient" class="col-md-2 control-label"><?php echo $lang['prenom']; ?></label>
				<div class="col-md-4">
				  <input type="text" class="form-control" id="prenom_patient" name="prenom_patient">  
				</div>
                            </div>
                            
                            <!-- Sexe et date de naissance-->
                            <div class="form-group"> 
				<label for="sexe_patient" class="col-md-2 control-label"><?php echo $lang['sexe']; ?><span class="obligatoire">*</span></label>
				<div class="col-md-4">
				  <select id="sexe_patient" name="sexe_patient" class="form-control" required>
				  	<option disabled selected><?php echo $lang['choisir']; ?></option>
				  	<option value="F"><?php echo $lang['feminin']; ?></option>
				  	<option value="M"><?php echo $lang['masculin']; ?></option>
				  </select>
				</div>
                                
                                <label for="ddn_patient" class="col-md-2 control-label"><?php echo $lang['dateDdeNaissance']; ?><span class="obligatoire">*</span></label>
				<div class="col-md-4">
				  <input type="date" class="form-control datepicker" placeholder="JJ/MM/AAAA" id="ddn_patient" name="datenaiss_patient" pattern="(0[1-9]|1[0-9]|2[0-9]|3[01])/(0[1-9]|1[012])/[0-9]{4}" placeholder="dd/mm/yyyy" required>
				</div>
			  </div>
                            
                            <!-- Région et département-->
                            <div class="form-group"> 
				<label for="region_patient" class="col-md-2 control-label"><?php echo $lang['region']; ?><span class="obligatoire">*</span></label>
				<div class="col-md-4">
				  <select id="region_patient" name="region_patient" class="form-control" required>
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
                                    
                                <label for="departement_patient" class="col-md-2 control-label"><?php echo $lang['departement']; ?><span class="obligatoire">*</span></label>
				<div class="col-md-4">
                                  <div id="loader_departement"></div>
				  <select id="departement_patient" name="departement_patient" class="form-control" required>
				  	<option disabled selected><?php echo $lang['choisirUnDepartement']; ?></option>
				  </select>
				</div>
			    </div>
                            
                             <!-- arrondissement et adresse-->
                            <div class="form-group"> 
				<label for="arrondissement_patient" class="col-md-2 control-label"><?php echo $lang['arrondissement']; ?><span class="obligatoire">*</span></label>
				<div class="col-md-4">
                                  <div id="loader_arrondissement"></div>  
				  <select id="arrondissement_patient" name="arrondissement_patient" class="form-control" required>
				  	<option disabled selected><?php echo $lang['choisirUnArrondissement']; ?></option>
				  </select>
				</div>
                                
                                <label for="adress_patient" class="col-md-2 control-label"><?php echo $lang['addresse']; ?><span class="obligatoire">*</span></label>
				<div class="col-md-4">
				  <input type="text" class="form-control" id="adresse_patient" name="adresse_patient" required>
				</div>
			    </div>
                                
                            <!-- Email-->	
                            <div class="form-group">

                                  <label for="email_patient" class="col-md-2 control-label"><?php echo $lang['email']; ?><span class="obligatoire">*</span></label>
                                  <div class="col-md-10">
                                    <input type="email" class="form-control" id="email_patient" name="email_patient" required>
                                  </div>
                            </div>  
                            
                            <!-- mot de passe et confirmation -->
                            <div class="form-group">
				<label for="password_patient" class="col-md-2 control-label"> <?php echo $lang['motDePasse']; ?><span class="obligatoire">*</span></label>
				<div class="col-md-4">
				  <input type="password" class="form-control" id="password_patient" name="password_patient" required>
				</div>
			  
				<label for="confirmation_password" class="col-md-2 control-label"><?php echo $lang['confirmation']; ?><span class="obligatoire">*</span></label>
				<div class="col-md-4">
				  <input type="password" class="form-control" id="confirmation_password" name="confirmation_password">
				</div>
                             </div>
                            
                            <!-- téléphone 1 et 2 -->
                            <div class="form-group">
                                  <label for="telephone1_patient" class="col-md-2 control-label"><?php echo $lang['telephone1']; ?><span class="obligatoire">*</span></label>
                                  <div class="col-md-4">
                                    <input type="text" class="form-control" id="telephone1_patient" name="telephone1_patient" required>
                                  </div>

                                  <label for="telephone2_patient" class="col-md-2 control-label"><?php echo $lang['telephone2']; ?></label>
                                  <div class="col-md-4">
                                    <input type="text" class="form-control" id="telephone2_patient" name="telephone2_patient">
                                  </div>
                            </div>
                            
                            <!-- type de diabète-->
                            <div class="form-group">
                                  <label for="type_diabete" class="col-md-2 control-label">
                                    <?php echo $lang['typeDeDiabete']; ?>



                                    <span class="obligatoire">*</span></label>
                                  <div class="col-md-10">
                                          <select class='form-control' name='diabete' id='diabete' required>
                                                  <option value=""><?php echo $lang['selectionnerUnType']; ?></option>
                                                          <?php 
                                                          $query_type=mysqli_query($con,"select * from diabete where lisible = 1 order by type");
                                                          while($rw=mysqli_fetch_array($query_type))	{
                                                                  ?>
                                                          <option value="<?php echo $rw['iddiabete'];?>">

                                                            <?php echo $rw['type'];?>
                                                              
                                                            </option>			
                                                                  <?php
                                                          }
                                                          ?>
                                          </select>			  
                                  </div>
                            </div>

                            <!-- Poids et taille -->
                            <div class="form-group">
                                  <label for="poids_patient" class="col-md-2 control-label"><?php echo $lang['poids']; ?><span class="obligatoire">*</span></label>
                                  <div class="col-md-4">
                                    <input type="text" class="form-control" id="poids_patient" name="poids_patient" required>
                                  </div>

                                  <label for="taille_patient" class="col-md-2 control-label"><?php echo $lang['taille']; ?><span class="obligatoire">*</span></label>
                                  <div class="col-md-4">
                                    <input type="Number" min="50" max="400" class="form-control" id="taille_patient" name="taille_patient" required>
                                  </div>
                            </div>
                            
                            <!-- personne d'urgence et son téléphone-->
                            <div class="form-group">
                            <!-- Nom du patient-->
                                  <label for="personne_urgence" class="col-md-2 control-label"><?php echo $lang['personneDurgence']; ?><span class="obligatoire">*</span></label>
                                  <div class="col-md-4">
                                    <input type="text" class="form-control" id="personne_urgence" name="personne_urgence" required>
                                  </div>

                            <!-- Nom du contactpatient-->
                                  <label for="telephone_urgence" class="col-md-2 control-label"><?php echo $lang['telephoneDurgence']; ?><span class="obligatoire">*</span></label>
                                  <div class="col-md-4">
                                    <input type="text" class="form-control" id="telephone_urgence" name="telephone_urgence" required>
                                  </div>
                            </div> 
                        </div>
                    
                        <div class="modal-footer">
                              <button type="button" class="btn btn-warning close_form" data-dismiss="modal" ><?php echo $lang['annuler']; ?></button>
                              <button type="submit" class="btn btn-primary" id="btn_save_patient"><?php echo $lang['enregistrer']; ?></button>
                        </div>
		  </form>
		</div>
	  </div>
	</div>
	<?php
		}
	?>