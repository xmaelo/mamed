<?php


	include('is_logged.php');
	/* Connect To Database*/
	require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("config/connexion.php");//Contiene funcion que conecta a la base de datos
	require_once ("functions.php");
	
	$active_preferences="navbarElogeXmaelactive";
	$title="MaMED | Préférences";

		$patient = get_personne($_SESSION['idpersonne'], 'patient');
		$idpatient = $patient['idpatient'];
		$query_unites = mysqli_query($con, "SELECT * FROM unite");
		$unite_patient = get_all_row('unite_patient', 'patient_idpatient', $idpatient);
		$query_mesures = mysqli_query($con, "SELECT * FROM mesure_patient INNER JOIN mesure ON mesure_idmesure = idmesure AND patient_idpatient = '$idpatient'");
		$query_alarme = mysqli_query($con, "SELECT * FROM alarme");
		$email = $_SESSION['login'];
		//$id=$_SESSION['id'];
		
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
<html lang="fr">
  <head>
    <?php include("head.php");?>
  </head>
  <body>
	<?php
	include("navbar.php");
	?>
	<?php include("modal/modaledit.php");?>
	
    <div class="container">
	<div class="panel panel-success" style="margin-top: 40px">
		<div class="panel-heading">
		    <div class="btn-group pull-right">
				
			</div>
			<h4><i class='glyphicon glyphicon-cogs'></i><?php echo $lang['mesPreferences']; ?></h4> 
		</div>
		<div class="panel-body">
			<div class="row col-md-12">
				<section class="panel">
					<div class="form">
						<span id="resultat_ajax_preferences"></span>
						<form class="form-horizontal" id="form_save_preferences" method="post" action="">
							<!-- l'alarme -->
							<legend><?php echo $lang['alarme']; ?></legend>
							<div class="form-group">                              
								 <?php echo $lang['activerRappelsControlApresRepas']; ?> 
        			 				<input checked data-toggle="toggle" data-onstyle="success" data-offstyle="danger" type="checkbox" id="toggle-event_apres_repas" onclick ="catrine1()">

		                        <div class="col-md-6 text-center">
				        			<?php echo $lang['activerAlarmeHypo']; ?> 
				        			<input checked data-toggle="toggle" data-onstyle="success" data-offstyle="danger" type="checkbox" id="toggle-event_preventive" onclick="catrine2()">
				        			
				        		</div>
			                </div>

			                <!-- Les unités -->
			                <legend><?php echo $lang['unites']; ?></legend>
			                <div class="form-group">
			                	<?php 
								 	while ($unites=mysqli_fetch_array($query_unites)) {
								?>
									 	<label class="col-md-4"><input type="radio" name="unite" value="<?php echo $unites['idunite']; ?>" <?php if($unites['idunite'] == $unite_patient['unite_idunite']) echo "checked"; ?>> <?php echo $unites['libelle']; ?>
									 	</label>

								<?php		
									}
								?>
			                </div>	

			                <!-- Les mesures -->
			                <legend><?php echo $lang['mesures']; ?></legend>
							<div class="form-group col-md-12" >
								<table class="table table-responsive table-bordered">
								  <?php 
									while($mesures = mysqli_fetch_array($query_mesures)){
								  ?>
										<tr>
											<td><?php  echo $lang[$mesures['libelle']]; ?></td>
											<td align="center">
												<input type="checkbox" value="<?php echo $mesures['idmesure']; ?>" name="mesure[]" <?php if ($mesures['etat']) echo "checked"; ?>>
											</td>
										</tr>
								  <?php
									}
								  ?>								
								</table>
							</div>				
							
							<!-- Le bouton d'enregistrement des paramètres -->
							<div class=" form-group text-center">
									<input type="submit" class="btn btn-success" name="btn_save_preferences" value="<?php echo $lang['enregistrer']; ?>">
							</div>
						</form>	
					</div>	

					<br />
					<legend><?php  echo $lang['profilUtilisateur']; ?></legend>
					<div class="form-group">
						
						<label class="col-md-1"><?php  echo $lang['email']; ?></label>
						<div class="col-md-3">
							<input class="form-control col-md-5" type="email" readonly="" value="<?php echo $email; ?>" style="width: 100%;">
						</div>
						<div class="col-md-3">
							<button type="button" class="btn btn-info" style="width: 100%;"><?php  echo $lang['modifier']; ?></button>
						</div>
						<div class="col-md-3">
							<a type="button" class="btn btn-warning" data-toggle="modal" data-target="#myModal3" style="width: 100%;"><?php echo $lang['modifierLeMotDePasse']; ?></a>
						</div>
						
					</div>

				</section>
			</div>
		

				<div id="resultats"></div><!-- Charger les données AJAX-->
				<div class='outer_div'></div><!-- Charger les données AJAX -->
			
		
	
			
			
			
  </div>
</div>
		 
	</div>
      <br><br>
	<?php
	include("footer.php");
	?>

	<script type="text/javascript">
		$(".timepicker").timepicker({
                  showInputs: false,
                  showMeridian: false,
                  minuteStep: 30
                });


       $( "#form_save_preferences" ).submit(function( event ) { 
		  $('#btn_save_preferences').attr("disabled", true);
		  
		 var parametres = $(this).serialize();
			 $.ajax({
					type: "POST",
					url: "ajax/save_preferences.php",
					data: parametres,
					 beforeSend: function(objet){
					 	$('#resultat_ajax_preferences').html('<img src="./img/ajax-loader.gif">');				
					  },
					success: function(data){

						$("#resultat_ajax_preferences").html(data);
						$('#btn_save_preferences').attr("disabled", false);

				  }
			});
	  event.preventDefault();
	})



		/*$(':radio').click(function(){
			var $check = $(this);

			if(this.checked){ // si 'checkAll' est coché
                  $check.val(1);
                }else{ // si on décoche 'checkAll'
                  $check.val(0);
            }
 
            alert($check.val());
		})*/




	</script>

 <?php if(isset($_GET['p']) && $lang['langue']=='Fr'): ?>
 	<script type="text/javascript">
 		alert('Mot de passe modifier avec success');
 		var chargement = 'chargement....';
 	</script>
 <?php elseif(isset($_GET['p']) && $lang['langue']=='Eng'): ?>
 	<script type="text/javascript">alert('Password change successfully');var chargement ='loanding ......'; </script>
 <?php elseif(isset($_GET['p']) && $lang['langue']=='Deutch'): ?>
 	<script type="text/javascript">alert('Passwortänderung erfolgreich');var chargement ='laden .....' </script>
 <?php endif; ?>

 <script type="text/javascript">

 	function catrine1() {

 							//console.log('cliquez');

 							$.ajax({

		                        url: 'alarmeStop1.php',
		                        //type: $form.attr('method'),
		                        //contentType: false, // obligatoire pour de l'upload
		                        //processData: false, // obligatoire pour de l'upload
		                        dataType: 'json', // selon le retour attendu
		                        //data: data,
		                        //success: function(data) {

		                           // if(data=='success'){

		                              //alert('Heure modifier avec succes');
		                                

		                          //  }else{
		                                                       
		                                //alert('Il y\'a eu une erreur');
		                        //
		                    });

		                  
 	}



 	function catrine2() {

 							//console.log('cliquez');

 							$.ajax({

		                        url: 'alarmeStop2.php',
		                        //type: $form.attr('method'),
		                        //contentType: false, // obligatoire pour de l'upload
		                        //processData: false, // obligatoire pour de l'upload
		                        dataType: 'json', // selon le retour attendu
		                        //data: data,
		                        //success: function(data) {

		                           // if(data=='success'){

		                              //alert('Heure modifier avec succes');
		                                

		                          //  }else{
		                                                       
		                                //alert('Il y\'a eu une erreur');
		                        //
		                    });
 	}
 </script>

 

  </body>
</html>


