	<?php
		if (isset($con))
		{
	?>
	<!-- Modal -->

  <div class="modal fade" id="nouveau_patient" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document" style="width: 60%;">
    		<div class="modal-content" >

          <form class="form-horizontal text-center" method="post" id="form_nouveau_patient" name="nom_patient" >
            <div class="modal-header">
    			    <button type="button" class="close close_form" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
    			    <span style="font-weight: bold; font-size: 1.5em;" class="modal-title" id="myModalLabel">
                <i class='fa fa-plus'></i><?php echo $lang['modal']; ?>
            </div>
            <div class="modal-body">
              <!-- Affichage des resultats du traitement du formulaire-->
              <div id="resultat_ajax"></div>                           
              <!-- Nom du patient et prenom du patient-->
                                            
      				<div class="col-md-12 text-left">
                 
      				  <div class="col-md-6 md-form">
    				      <input type="text" class="form-control" id="nom_patent" name="nom_patient" style="font-size: 18px;font-weight: bold" required>
                  <label for="nom_patient" class="col-md-1 control-label" style="font-size: 18px;font-weight: bold"><?php echo $lang['nom']; ?><span class="obligatoire">*</span></label>
    				    </div>

    			  	  
        				<div class="col-md-6 md-form">
        				  <input type="text" class="form-control" id="prenom_patient" name="prenom_patient" style="font-size: 18px;font-weight: bold">
                  <label for="prenom_patient" class="col-md-2 control-label" style="font-size: 18px;font-weight: bold"><?php echo $lang['prenom']; ?></label>
        				</div>
              </div> 
                               
                                
                                <!-- Sexe et date de naissance-->
            			
            <div class="col-md-12">
              
                <h4><b><i><?php echo $lang['DSA']; ?></i></b></h4>
                <hr>
             
             
      				<div class="col-md-4">
      				  <select id="sexe_patient" style="font-size: 16px;font-weight: bold" name="sexe_patient" class="form-control" required>
      				  	<option disabled selected><?php echo $lang['choisirSexe']; ?></option>
      				  	<option value="F"><?php echo $lang['feminin']; ?></option>
      				  	<option value="M"><?php echo $lang['masculin']; ?></option>
      				  </select>
      				</div>

             <!--  <div class="col-md-6 md-form">
                <input type="text" class="form-control datepicker" id="prenom_patient" name="prenom_patient" 
                pattern="(0[1-9]|1[0-9]|2[0-9]|3[01])/(0[1-9]|1[012])/[0-9]{4}" style="font-size: 18px;font-weight: bold">
                <label for="ddn_patient" class="col-md-2 control-label" style="font-size: 18px;font-weight: bold">DDN</label>
              </div> -->
            
                                    
            
    				<div class="col-md-4">
    				  <input type="date" class="form-control datepicker" id="ddn_patient" name="datenaiss_patient" pattern="(0[1-9]|1[0-9]|2[0-9]|3[01])/(0[1-9]|1[012])/[0-9]{4}"  required>
    				</div>


            <div class="col-md-4 md-form" style="transform: translateY(-48%);">
              <input type="text" class="form-control" id="adresse_patient" name="adresse_patient" style="font-size: 16px;font-weight: bold" required>
              <label for="adress_patient" style="font-size: 16px;font-weight: bold" class="col-md-2 control-label"><?php echo $lang['addresse']; ?><span class="obligatoire">*</span></label>
            </div>
          </div>
          <div class="col-md-12">
            <h4><b><i><?php echo $lang['localisation']; ?></i></b></h4>
            <hr>
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
            <div class="col-md-4">
              <div id="loader_departement"></div>
              <select id="departement_patient" name="departement_patient" class="form-control" required>
                <option disabled selected><?php echo $lang['choisirUnDepartement']; ?></option> 
              </select>
            </div>
            <div class="col-md-4">
              <div id="loader_arrondissement"></div>  
              <select id="arrondissement_patient" name="arrondissement_patient" class="form-control" required>
                <option disabled selected><?php echo $lang['choisirUnArrondissement']; ?></option>
              </select>
            </div>
            
          </div>
          <div class="col-md-12">
            <hr>
            <h4><b><i><?php echo $lang['contact']; ?></i></b></h4>


            <div class="col-md-4 md-form">
              <input type="email" class="form-control" id="email_patient"style="font-size: 16px;font-weight: bold" name="email_patient" required>
              <label for="email_patient" class="col-md-3 control-label"style="font-size: 16px;font-weight: bold"><?php echo $lang['email']; ?><span class="obligatoire">*</span></label>
            </div>

            
            <div class="col-md-4 md-form">
              <input type="text" class="form-control" id="telephone1_patient" style="font-size: 16px;font-weight: bold"name="telephone1_patient" required>
              <label for="telephone1_patient" class="col-md-2 control-label"style="font-size: 16px;font-weight: bold"><?php echo $lang['telephone1']; ?><span class="obligatoire">*</span></label>
            </div>

           
            <div class="col-md-4 md-form">
              <input type="text" class="form-control" id="telephone2_patient"style="font-size: 16px;font-weight: bold" name="telephone2_patient">
              <label for="telephone2_patient" class="col-md-2 control-label"style="font-size: 16px;font-weight: bold"><?php echo $lang['telephone2']; ?></label>
            </div>
                               
            
          </div>
          <div class="col-md-12">
            <h4><b><i><?php echo $lang['securite']; ?></i></b></h4>
            <hr>
           
            <div class="col-md-6 md-form">
              <input type="password" class="form-control" id="password_patient"style="font-size: 16px;font-weight: bold" name="password_patient" required>
               <label for="password_patient" class="col-md-3 control-label"style="font-size: 16px;font-weight: bold"><?php echo $lang['motDePasse']; ?><span class="obligatoire">*</span></label>
            </div>
            
           
            <div class="col-md-6 md-form">
              <input type="password" class="form-control" id="confirmation_password" style="font-size: 16px;font-weight: bold"name="confirmation_password">
              <label for="confirmation_password" class="col-md-2 control-label"style="font-size: 16px;font-weight: bold"><?php echo $lang['confirmation']; ?><span class="obligatoire">*</span></label>
            </div>
          </div>

          <div class="col-md-12">
            <h4 ><b><i><?php echo $lang['infoMedicale']; ?></i></b></h4>
            <hr>
             <div class="col-md-4">
                <select class='form-control' name='diabete' id='diabete' required>
                        <option value=""><?php echo $lang['selectionnerUnTypeDeDiabete']; ?></option>
                                <?php 
                                $query_type=mysqli_query($con,"select * from diabete where lisible = 1 order by type");
                                while($rw=mysqli_fetch_array($query_type))  {
                                        ?>
                                <option value="<?php echo $rw['iddiabete'];?>"><?php echo $rw['type'];?></option>     
                                        <?php
                                }
                                ?>
                </select>       
            </div>

            <div class="col-md-4 md-form"style="transform: translateY(-48%);">
              <input type="text" class="form-control" id="poids_patient"style="font-size: 16px;font-weight: bold" name="poids_patient" required>
              <!-- <label for="poids_patient" class="col-md-1 control-label"style="font-size: 16px;font-weight: bold"><?php echo $lang['poids']; ?><span class="obligatoire">*</span></label> -->
              <label for="poids_patient" class="col-md-3 control-label"style="font-size: 16px;font-weight: bold"><?php echo $lang['poids']; ?><span class="obligatoire">*</span></label>
            </div>

            
            <div class="col-md-4 md-form"style="transform: translateY(-48%);">
              <input type="text" min="50" max="400" class="form-control"style="font-size: 16px;font-weight: bold" id="taille_patient" name="taille_patient" required>
              <label for="taille_patient" class="col-md-2 control-label"style="font-size: 16px;font-weight: bold"><?php echo $lang['taille']; ?><span class="obligatoire">*</span></label>
            </div>
            
          </div>
          <div class="col-md-12">
            <h4><b><i><?php echo $lang['autreInfos']; ?></i></b></h4>
            <hr>

              <div class="col-md-6 md-form">
                <input type="text" class="form-control" id="personne_urgence" name="personne_urgence"style="font-size: 16px;font-weight: bold" required>
              <label for="personne_urgence"  class="col-md-4 control-label" style="font-size: 16px;font-weight: bold"><?php echo $lang['personneDurgence']; ?><span class="obligatoire">*</span></label>
              </div>
        <!-- Nom du contactpatient-->
              <div class="col-md-6 md-form">
                <input type="text" class="form-control" id="telephone_urgence"style="font-size: 16px;font-weight: bold" name="telephone_urgence" required>
              <label for="telephone_urgence" class="col-md-4 control-label"style="font-size: 16px;font-weight: bold"><?php echo $lang['telephoneDurgence']; ?><span class="obligatoire">*</span></label>
              </div>

          </div>

                                  <button type="button" class="btn-outline-info close_form" data-dismiss="modal"
                                  style="border-radius: 50px; padding:4px" ><?php echo $lang['annuler']; ?></button>
                                  <button type="submit" class="btn-outline-green" id="btn_save_patient"
                                  style="border-radius: 50px; padding:4px"><?php echo $lang['enregistrer']; ?></button>
                       
        </div>    			                                             
                                 <!-- arrondissement et adresse-->
                          
                        
                            
    		  </form>
    		</div>
    	  </div>
    	</div>
	<?php
		}
	?>