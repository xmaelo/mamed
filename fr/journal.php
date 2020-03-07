<?php


	
	$date=  date('H:i');

	require_once ('compo/vendor/autoload.php');
    use \Statickidz\GoogleTranslate;

	include('is_logged.php');
	/* Connect To Database*/
	require_once ("config/db.php");
	require_once ("config/connexion.php");
	require_once ("functions.php");
	//selection du patient connecté
	$idpersonne = (isset($_GET['idpersonne']) ? $_GET['idpersonne'] : $_SESSION['idpersonne']);
	$patient = get_personne($idpersonne, 'patient');
	$diabete = get_data($patient['diabete_iddiabete'], 'diabete', 1);
	$idpatient=$patient['idpatient'];
						$nom=$patient['nom'];
						$prenom = $patient['prenom']; 
						$poids=$patient['poids'];
						$taille=$patient['taille'];
						$imc = $patient['imc'];
						$interpretation = $patient['interpretation'];
						$datenaiss = $patient['datenaiss'];
						$datenaiss = get_date_fr($datenaiss);
						$sexe = $patient['sexe'];
						$personne_urgence = $patient['nom_contact_urgence'];
						$telephone_urgence = $patient['telephone_contact_urgence'];
						$idtype_diabete = $patient['diabete_iddiabete'];
						$type_diabete = $diabete['type'];
						$telephone1 = $patient['telephone1'];
						$telephone2 = $patient['telephone2'];
						$email = $patient['email'];
						$picture = $patient['chemin'];
						$adresse = $patient['adresse'];
						$idpersonne = $patient['idpersonne'];
						$date_save=get_date_fr($patient['date_save']);
	$heure_apres_repas = get_row('unite_patient', 'heure_apres_repas', 'patient_idpatient', $idpatient);

	
	$temps = explode(':', $heure_apres_repas);
	$heure = intval($temps[0]);
	$min = intval($temps[1]);	

	if($min == 0){

		$heure -= 1;
		$min = 59;
	}else{

		$min -= 1;
	}		

	//medecin qui le suit
		$select_medecin = mysqli_query($con, "SELECT * FROM patient_has_medecin INNER JOIN medecin ON medecin_idmedecin = medecin.idmedecin INNER JOIN personne ON medecin.personne_idpersonne = personne.idpersonne AND medecin.lisible = 1 AND personne.lisible = 1 INNER JOIN specialite ON medecin.specialite_idspecialite = specialite.idspecialite AND specialite.lisible = 1 AND patient_has_medecin.patient_idpatient = '$idpatient' AND patient_has_medecin.approbation = 1");

		$medecini = mysqli_fetch_array($select_medecin); 
		//echo $medecini['anciennete'];
		//die();

		/*******boucle de anna******/
		$select_medecint = mysqli_query($con, "SELECT * FROM patient_has_medecin INNER JOIN medecin ON medecin_idmedecin = medecin.idmedecin INNER JOIN personne ON medecin.personne_idpersonne = personne.idpersonne AND medecin.lisible = 1 AND personne.lisible = 1 INNER JOIN specialite ON medecin.specialite_idspecialite = specialite.idspecialite AND specialite.lisible = 1 AND patient_has_medecin.patient_idpatient = '$idpatient'");




		// $medecin=mysqli_fetch_array($select_medecin);
		// $idphm = $medecin['idpatient_has_medecin'];
		// $idmedecin = $medecin['idmedecin'];

		$photo= mysqli_query($con, "SELECT * FROM personne WHERE idpersonne=$idpersonne");
		$phto=mysqli_fetch_array($photo);
		$phot=$phto['chemin'];
		$_SESSION['phot']=$phot;
		$_SESSION['email']=$email;
		$_SESSION['idpersonne']=$idpersonne;



	//var_dump($medecin);
	$active_journal="navbarElogeXmaelactive"; 
	$title="MaMED | Journal";
	?>


<?php 
      if(isset($_SESSION['lang'])){
      $lage='langues/'.$_SESSION['lang'].'.php';
      
      require_once ($lage);
      }
      else{
        $_SESSION['lang']='Fr';
         $lage='langues/'.$_SESSION['lang'].'.php';
      
      require_once ($lage);
      }
 ?>

<!DOCTYPE html>
<html lang="Deutch">
  <head>
    <?php include("head.php");?>
  </head> 
  <body>
	<?php
	include("navbar.php");
	?>
	
    <div class="container">
	<div class="panel panel-success h5 " style="margin-top: 40px">
		<div class="panel-heading">
		    <div class="btn-group pull-right">
				<button type='button' class="btn-outline-info float-right" data-toggle="modal" data-target="#nouvelleMesure"  style="float:right; box-shadow:  ; border-radius: 50px; padding:4px;transform: translateY(100%);"><span class="fa fa-plus" ></span> <?php echo $lang["nouvelleMesure"]; ?></button>
			</div>
			<h2 class="h2"><i class='glyphicon glyphicon-cogs'></i><?php echo $lang["journal"]; ?></h2>
		</div>
		<div class="panel-body">
			<?php 
				include("modal/editer_patient.php"); 
				include("modal/nouvelle_mesure.php"); 
				include("modal/editer_mesure.php");  
			?>
		
			<div class="row profil_patient">
		        <div class="col-xs-12 col-sm-12 col-md-12">
		            <div class="well well-sm">
		                <div class="row">
		                    <div class="col-sm-2 col-md-2">
		                        <img src="<?php if($phot!=NULL){echo $phot;} else { echo "img/avatar_2x.png";} ?>" alt="" class="img-rounded img-responsive" style="transform: translateY(20%);
		                       height: 150px;" />
		                    </div>
		                    <style type="text/css">
		                    	.policeinfo{
		                    		 font-family:'Pacifico', serif;
		                    		 line-height: 30px;
		                    	}

		                    </style>
		                          
		                    <div class="col-sm-5 col-md-5">
		                        <h3 style="color: green;" class="h3"><?php echo $nom.' '.$prenom; ?></h3>
		                        <input type="hidden" name="minute_patient" id="minute_patient" value="<?php echo $min; ?>">
		                        <input type="hidden" name="heure_patient" id="heure_patient" value="<?php echo $heure; ?>">
		                        <p style="color: #122b40" class="h4 policeinfo">
		                        	<?php echo $lang["sexe"]; ?>: <span class="data_patient"> 
		                        	<?php 




							
		                        			 echo($lang[get_sexe($sexe)]);
		                        			 //echo($lang[strtolower(get_sexe($sexe))]);
		                        			 //die();

												// $source = 'fr';
												// $target = $lang['lang'];
												// $text = get_sexe($sexe);

												// $trans = new GoogleTranslate();
												// $result = $trans->translate($source, $target, $text);

												// echo $result;
												//strtolower

									


		                        	?>
		                        		
		                        	</span>
		                        	<br />
		                        	<?php echo $lang["dateDdeNaissance"]; ?>: <span class="data_patient"> <?php echo $datenaiss; ?></span>
		                            <br />
		                            <?php echo $lang["addresse"]; ?>: <span class="data_patient"><?php echo $adresse; ?></span>
		                            <br />
		                            <?php echo $lang["tel"]; ?>: <span class="data_patient"><?php echo $telephone1; ?></span>
		                            <br />
		                            <?php echo $lang["tel2"]; ?>: <span class="data_patient"><?php echo $telephone2; ?></span>
		                            <br />
		                            <?php echo $lang["email"]; ?>: <span class="data_patient"><?php echo $email; ?></span> 
		                        </p>                        
		                    </div>

		                    <div class="col-sm-4 col-md-5" style="transform: translateY(10%);">		                        
		                        <p style="color: #122b40" class="h4 policeinfo">
		                        	<?php echo $lang["typeDeDiabete"]; ?>: <span class="data_patient"> <?php echo $lang[$type_diabete]; ?></span>
		                        	<br />
		                        	<?php echo $lang["taille"]; ?>: <span class="data_patient"> <?php echo $taille.' cm'; ?></span>
		                        	<br />
		                        	<?php echo $lang["poids"]; ?>: <span class="data_patient"> <?php echo $poids; ?></span>
		                            <br />
		                            IMC: <span class="data_patient"> <?php echo $imc; ?></span>
		                            <br />
		                            <?php echo $lang["interpretation"]; ?>: 
		                            <span class="data_patient">

		                            		<?php 

												echo $lang[$interpretation];

												// $source = 'fr';
												// $target = $lang['lang'];
												// $text = $interpretation;

												// $trans = new GoogleTranslate();
												// $result = $trans->translate($source, $target, $text);

												// echo $result;

											 ?>		
		                             		<!-- <?php echo $interpretation; ?> -->
		                             	

		                            </span>
		                            <br />
		                            <?php echo $lang["urgence"]; ?>: <span class="data_patient"> <?php echo $personne_urgence; ?></span>
		                            <br />                            
		                            <?php echo $lang["telUrgence"]; ?>: <span class="data_patient"> <?php echo $telephone_urgence; ?></span>
		                            <br />

		                        </p>
		                    </div>                   
                		</div>
                		<div class="text-center" id="div_medecin_traitant" style="font-size:1.4em; display: none;">
                			<?php 
                				// if($medecin){
                				// 	echo "<u>". $lang["medecinTraitant"].":</u><b> ".$medecin['nom']." ".$medecin['prenom']."</b>(".$medecin['libelle'].", ".$medecin['anciennete']; echo $lang['anneeEsperience'].")";
                				// }
                			 ?>
                			 <p>
                			 	
                           
                		</div>
                		 <div class="text-center" style="font-size:1.4em;" id="div_approuver">
                        	<?php 
	                        		if($medecini['approbation']){

	                        			$idphm = $medecini['idpatient_has_medecin'];
										$idmedecin = $medecini['idmedecin'];

	                        			echo "<u>". $lang["medecinTraitant"]."</u><b> ".$medecini['nom']." ".$medecini['prenom']."</b>(".$medecini['libelle'].", ".$medecini['anciennete'].$lang["anneeEsperience"].")
	                        			<button type='button' class='btn btn-default text-black' style='box-shadow:; border-radius: 50px; padding:4px;'onclick='desapprouver(".$idphm.",".$idpatient.", ".$idmedecin.")'>".$lang['couper']."</button>";

	                        			

 
	                        		}

	                        		else {
	                        		
		                        		while ($medecin=mysqli_fetch_array($select_medecint)) {

		                        					$idphm = $medecin['idpatient_has_medecin'];
													$idmedecin = $medecin['idmedecin'];



				
			                        			// echo $lang['demande'].'<b>'.$medecin['nom']." ".$medecin['prenom']."</b>(".$medecin['libelle'].", ".$medecin['anciennete']; echo $lang['anneeEsperience'].")";//
			                        			 echo $medecin['nom']." ".$medecin['prenom']."</b>(".$medecin['libelle'].", ".$medecin['anciennete']; echo $lang['anneeEsperience'].")<br>";
			                        		
			                        			echo '<br><button onclick="approuver('.$idphm.','.$idpatient.', '.$idmedecin.');" class="btn btn-success" id="btn-approuver">'.$lang['approuver'].'</button>';
			                        			echo ' ';

			                        			echo '<button onclick="clara('.$idphm.','.$idpatient.', '.$idmedecin.');" class="btn btn-danger" id="btn-del">'.$lang['suprimer'].'</button>';
			                        			echo '<br>';

			                        			//break 1;
	                        		}


			                        			
			                        		
		                        		
		                        		} 
                        	?>

                        </div>
                        <br>
                		 <!-- Split button -->
                		 <div class="text-center">
                		  <a href="#" class='btn-outline-info ' style=" border-radius: 50px; padding:4px;"title='Modifier mes infos' data-nom='<?php echo $nom;?>' data-prenom='<?php echo $prenom?>' data-datenaiss='<?php echo $datenaiss;?>' data-sexe='<?php echo $sexe;?>' data-adresse='<?php echo $adresse;?>' data-email='<?php echo $email;?>' data-telephone1='<?php echo $telephone1;?>' data-telephone2='<?php echo $telephone2;?>' data-idtype_diabete='<?php echo $idtype_diabete;?>' data-poids='<?php echo $poids;?>' data-taille='<?php echo $taille;?>' data-personne_urgence='<?php echo $personne_urgence;?>' data-telephone_urgence='<?php echo $telephone_urgence;?>' data-idpatient='<?php echo $idpatient;?>' data-idpersonne="<?php echo $idpersonne; ?>" data-appelant="<?php echo $_SESSION['role'].' test'; ?>" data-toggle="modal" data-target="#modal_editer_patient"> <i class="fa fa-edit"></i>
                		  	<?php echo $lang['modifierMesInfos']; ?></a> 
                		  </div>
                            
                        	
                                        
            		</div>

            	
            		
                			
        		</div>

        		
        		<div class="col-md-6 text-center">
        			 <?php echo $lang['rappelsControlApresRepas']; ?> 
        			 <input checked data-toggle="toggle" data-onstyle="success" data-offstyle="danger" type="checkbox" id="toggle-event_apres_repas" onclick="show1()">
        			 
					

        			<div id="console-event_apres_repas"></div>
        		</div>
        		<div class="col-md-6 text-center">
        			<?php echo $lang['alarmeHypo']; ?> 
        			<input checked data-toggle="toggle" data-onstyle="success" data-offstyle="danger" type="checkbox" id="toggle-event_preventive" onclick="show2()">
        			
        		</div>

    		</div>
    		
    		<hr>
    		<div class="row">
    			<h2 class="text-center"><i class='glyphicon glyphicon-cogs'></i><?php echo $lang['mesuresEnregistrer']; ?></h4>
	    		<form class="form-horizontal" role="form" id="datos_cotizacion">
					
					<div class="form-group">
						<label for="q" class="col-md-2 control-label"><?php echo $lang['creneauDateHeure']; ?></label>
						<div class="col-md-5">
							<input type="text" class="form-control" id="q" placeholder="<?php echo $lang['creneauDateHeure']; ?>" onkeyup='load(1);'>
						</div>
						<div class="col-md-3">
							<button type="button" class="btn btn-default" onclick='load(1);'>
								<span class="fa fa-search" ></span> <?php echo $lang['rechercher']; ?>
							</button>				
							<span id="loader"></span>
						</div>					
					</div>
				</form>
								
	  			<div id="resultats"></div>
	  			<!-- Charger les données AJAX-->
				<div class='outer_div'></div>
				<!-- Charger les données AJAX -->
  			</div>
		</div>	
	 
	</div>
	
	

	<?php
	include("footer.php");
	?>
	<?php if ($lang['langue']=='Fr'): ?>
	 <script type="text/javascript">
		var confirme="Voulez vous supprimer cette mesure?";
	</script>
	<?php elseif($lang['langue']=='Deutch'): ?>
	 <script type="text/javascript">
		var confirme="Möchten Sie diese Maßnahme löschen?";
	</script>
	<?php elseif($lang['langue']=='Eng'): ?>
	 <script type="text/javascript">
		var confirme="Do you want to delete this measure";
	</script>
	<?php endif; ?>

	
	<script type="text/javascript" src="js/journal.js"></script> 

	<script type="text/javascript" src="js/chrono.js"></script>

	<style type="text/css">
		.data_patient{

		  font-weight: bold;
		}
	</style>

	<script type="text/javascript">
		function approuver(id, idpatient, idmedecin){			
			
			$.ajax({
				url: "ajax/approuver.php?id="+id+"&idpatient="+idpatient+"&idmedecin="+idmedecin,
			    beforeSend: function(objet){
			
					$("#btn-approuver").html('Approbation...<img src="./img/ajax-loader.gif">');							
				},
				success: function(data){	
							
					if(data == 1){
						$("#btn-approuver").html('Approuver');
						$("#div_approuver").fadeOut();
						$("#div_medecin_traitant").fadeIn();
						window.location.reload();
					}else{

						alert('Une erreur est survenue, veuillez contacter l\'administrateur!');
						$("#btn-approuver").html('Approuver');
					}					
				 }
			});
				
		}

		function desapprouver(id, idpatient, idmedecin) {

			$.ajax({
				url: "ajax/desapprouver.php?id="+id+"&idpatient="+idpatient+"&idmedecin="+idmedecin,
			    beforeSend: function(objet){
			
					$("#btn-approuver").html('Approbation...<img src="./img/ajax-loader.gif">');							
				},
				success: function(data){	
							
					if(data == 1){
						$("#btn-approuver").html('Approuver');
						$("#div_approuver").fadeOut();
						$("#div_medecin_traitant").fadeIn();
						window.location.reload();
					}else{

						alert('Une erreur est survenue, veuillez contacter l\'administrateur!');
						$("#btn-approuver").html('Approuver');
					}					
				 }
			});

		}
 
		function clara(id, idpatient, idmedecin) {

			$.ajax({
				url: "ajax/clara.php?id="+id+"&idpatient="+idpatient+"&idmedecin="+idmedecin,
			    beforeSend: function(objet){
			
					$("#btn-del").html('Delete...<img src="./img/ajax-loader.gif">');							
				},
				success: function(data){	
							
					if(data == 1){
						$("#btn-approuver").hide();
						$("#div_approuver").hide();
						$("#div_medecin_traitant").hide();
						window.location.reload();
					}else{

						alert('Une erreur est survenue, veuillez contacter l\'administrateur!');
						$("#btn-approuver").html('Approuver');
					}					
				 }
			});

		}


	$(".tableau_dynamique").DataTable(); 
	</script>

<?php if($lang['langue']=='Fr'): ?>
	<script type="text/javascript">
		var var1 = 'Veuillez entez une date valide';
		var var2 ='Heure de control hypoglycemie Modifiée avec succes';
		var var3 ="Heure de rappel contole Modifiée avec succes";
	</script>
<?php elseif($lang['langue']=='Eng'):  ?>
	 <script type="text/javascript">
	 	var var1 = 'Please enter a valid date';
		var var2 ='Hypoglycemia control time Modified successfully';
		var var3="Recall Time Contol Successfully Changed";
	 </script>
<?php elseif($lang['langue']=='Deutch'):  ?>
	 <script type="text/javascript">
	 	var var1 = 'Bitte geben Sie ein gültiges Datum ein';
		var var2 ='Kontrollzeit für Hypoglykämie Erfolgreich geändert';
		var var3="Rückrufzeitkontrolle erfolgreich geändert";
	 </script>
<?php endif; ?>



		<script type="text/javascript" src='js/getTime.js'></script>
		<script type="text/javascript"> 


			$('#alarmSet').hide(); 
			$('#alarmSetCat').hide();


			function show1() {


				if($('#alarmSet').length == 0) {

					$('#toggle-event_apres_repas').after($('<form method="post" action="saveHours.php" id="alarmSet" class="formCatrine1"><input type="time" name="startstop"  id="alarmTime"/> <input type="submit" id="alarmButton" value="Valider" onclick="onCatrine()" class="btn btn-info"/></form>'					
                    ));

					} 
				else {
						$('#alarmSet').remove();

				}

			}

				function show2() {


				if($('#alarmSetCat').length == 0) {

					$('#toggle-event_preventive').after($('<form method="post" action="saveHoursH.php" id="alarmSetCat" class="formCatrine1"><input type="time" name="startstopc"  id="alarmTimeC"/> <input type="submit" id="alarmButton" value="Valider" onclick="onCatrine2()" class="btn btn-info"/></form>'					
                    ));

					}
				else {
						$('#alarmSetCat').remove();

				}
	        			
				   		 	

						   
							
					

				// var check = $('#toggle-event_apres_repas').val();
				// alert(check);

				// if(!check=="on"){
				// 	$('#put').show();
				// }

				// else {
				// 	$('#put').hide();
				// }

			}
			
			// alert(typeof(check));

			// if($('#toggle-event_apres_repas').is(':checked')) {

				
			//alert(check);
			// }
			// else {

			// }



		


						// }

			// 		else {
			// 			e.preventDefault();
			// 			alert('Veuillez choisir une date valide');

			// }

			
			// $('#cAutre').show();




			

	
	</script>





<!-- 
	<script type="text/javascript">
		function setAlarm() {
			var ms = document.getElementById('alarmTime').valueAsNumber;
			if(isNaN(ms)) {
				alert('Entrez une date valide');
				return;
			}
			var alarm = new Date(ms);
			var alarmTime = new Date(alarm.getUTCFullYear(), 
				alarm.getUTCMonth(), alarm.getUTCDate(), alarm.getUTCHours(), alarm.getUTCMinutes(), alarm.getUTCSeconds());
			var differencesInMs = alarmTime.getTime() - ( new Date()).getTime();
			if(differencesInMs < 0) {
				alert('La date indiquez est deja passée');
				return;
			}

		}
	</script> -->
	
  </body>
</html>


