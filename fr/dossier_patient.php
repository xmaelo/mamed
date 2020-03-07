<?php
	include('is_logged.php');
	/* Connect To Database*/
	require_once ("config/db.php");
	require_once ("config/connexion.php");
	require_once ("functions.php");
        $active_patients="navbarElogeXmaelactive";
	$title="MaMED | Dossier patient";
	if(isset($_GET['idpersonne'])){ 
		$idpersonne = $_GET['idpersonne'];
		$medecin = get_personne($_SESSION['idpersonne'], 'medecin');
		$idmedecin = $medecin['idmedecin'];
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
		$adresse = $patient['adresse'];
		$idpersonne = $patient['idpersonne'];
		$date_save=get_date_fr(
		$patient['date_save']);
		$heure_apres_repas = get_row('unite_patient', 'heure_apres_repas', 'patient_idpatient', $idpatient);
		
		$temps = explode(':', $heure_apres_repas);
		$heure = intval($temps[0]);
		$min = intval($temps[1]);

		$req_count = "SELECT * FROM personne WHERE idpersonne=$idpersonne";
		$photo  = mysqli_query($con, $req_count);
		$photPatient=mysqli_fetch_array($photo);
		$phot=$photPatient['chemin'];
		

		if($min == 0){

			$heure -= 1;
			$min = 59;
		}else{

			$min -= 1;
		}	



		  if(isset($_SESSION['lang'])){
			      $lage='langues/'.$_SESSION['lang'].'.php';
			      
			      
			      }
			      else{
			        $_SESSION['lang']='Fr';
			         $lage='langues/'.$_SESSION['lang'].'.php';
			      
			      

			      }
			      //var_dump($lage);


		 require_once ($lage);	


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

	
    <div class="container">
	<div class="panel panel-success" style="margin-top: 40px">
		<div class="panel-heading">
			<?php if(!isset($_GET['catrine'])): ?>
			    <div class="btn-group pull-right">
					<button  type='button' class="btn bg-info" data-toggle="modal" data-idpatient="<?php echo $idpatient; ?>" data-idmedecin="<?php echo $idmedecin; ?>" data-patient="<?php echo $nom.' '.$prenom; ?>" data-email="<?php echo $email; ?>" data-target="#modal_message_medecin" title="ecrire au patient"><span class="glyphicon glyphicon-envelope" ></span> 
						<?php echo $lang['sendMessage']; ?>
					</button>
				</div>
			<?php endif; ?>
			<h4><i class='glyphicon glyphicon-cogs'></i> <?php echo $lang['journalPatient']; ?> "<?php echo $nom.' '.$prenom; ?>"</h4>
		</div>
		<div class="panel-body">
		<?php include("modal/modal_message_medecin.php"); ?>

			<div class="row profil_patient">
		        <div class="col-xs-12 col-sm-12 col-md-12">
		            <div class="well well-sm">
		                <div class="row">
		                    <div class="col-sm-2 col-md-2">
		                        <img src="<?php if($phot) { echo $phot;} else { echo 'img/avatar_2x.png';} ?>" alt="" class="img-rounded img-responsive" />
		                    </div>
		                    <div class="col-sm-5 col-md-5">
		                        <h4 style="color: green;"><?php echo $nom.' '.$prenom; ?></h4>
		                        <input type="hidden" name="minute_patient" id="minute_patient" value="<?php echo $min; ?>">
		                        <input type="hidden" name="heure_patient" id="heure_patient" value="<?php echo $heure; ?>">
                                        <p style="color: #122b40">
		                        	<?php echo $lang['sexe']; ?>  <span class="data_patient"> <?php echo $lang[get_sexe($sexe)]; ?></span>
		                        	<br />
		                        	<?php echo $lang['dateDdeNaissance']; ?>  <span class="data_patient"> <?php echo $datenaiss; ?></span>
		                            <br />
		                            <?php echo $lang['addresse']; ?>  <span class="data_patient"><?php echo $adresse; ?></span>
		                            <br />
		                            <?php echo $lang['tel']; ?>  <span class="data_patient"><?php echo $telephone1; ?></span>
		                            <br />
		                            <?php echo $lang['tel2']; ?>  <span class="data_patient"><?php echo $telephone2; ?></span>
		                            <br />
		                            <?php echo $lang['email']; ?>  <span class="data_patient"><?php echo $email; ?></span>
		                        </p>                        
		                    </div>
		                    <div class="col-sm-4 col-md-4">		                        
		                        <p style="color: #122b40">
		                        	<?php echo $lang['typeDeDiabete']; ?>  <span class="data_patient"> <?php echo $lang[$type_diabete]; ?></span>
		                        	<br />
		                        	<?php echo $lang['taille']; ?>  <span class="data_patient"> <?php echo $taille.' cm'; ?></span>
		                        	<br />
		                        	<?php echo $lang['poids']; ?>  <span class="data_patient"> <?php echo $poids; ?></span>
		                            <br />
		                            <?php echo $lang['imc']; ?>  <span class="data_patient"> <?php echo $imc; ?></span>
		                            <br />
		                           <?php echo $lang['interpretation']; ?>  <span class="data_patient"> <?php echo $lang[$interpretation]; ?></span>
		                            <br />
		                            <?php echo $lang['urgence']; ?>  <span class="data_patient"> <?php echo $personne_urgence; ?></span>
		                            <br />                            
		                            <?php echo $lang['telephoneDurgence']; ?>  <span class="data_patient"> <?php echo $telephone_urgence; ?></span>
		                            <br />
		                        </p>
		                    </div>                   
                		</div>
                		 <!-- Split button -->
                        
            		</div>
        		</div>

        	</div>	
    		
    		<hr>
    		<div class="row">
    			<h2 class="text-center"><i class='glyphicon glyphicon-cogs'></i> <?php echo $lang['mesureSave']; ?></h4>
	    		<form class="form-horizontal" role="form" id="datos_cotizacion">
					
					<div class="form-group">
						<label for="q" class="col-md-2 control-label"><?php echo $lang['creneauDateHeure']; ?></label>
						<div class="col-md-5">
							<input type="text" class="form-control" id="q" placeholder="<?php echo $lang['creneauDateHeure']; ?>" onkeyup='load(1);'>
							<input type="hidden" name="idpersonne" value="<?php echo $idpersonne; ?>" id="petient_idpersonne">
						</div>
						<div class="col-md-3">
							<button type="button" class="btn bg-info" onclick='load(1);'>
								<span class="fa fa-search" ></span> <?php echo $lang['rechercher']; ?>
							</button>				
							<span id="loader"></span>
						</div>					
					</div>
				</form>
								
	  			<div id="resultats"></div><!-- Charger les données AJAX-->
				<div class='outer_div'></div><!-- Charger les données AJAX -->
  			</div>
		</div>		 
	</div>

	<?php
	include("footer.php");
	?>
	<script type="text/javascript" src="js/dossier_patient.js"></script>
	<style type="text/css">
		.data_patient{

		  font-weight: bold;
		}
	</style>

	
  </body>
</html>


<script>
    $('#annuler').click(function(){
		efface_formulaire();
 })

	function efface_formulaire() {
            $('form')[0].reset();
	}
</script>
<?php }else{

		header('location: ../accueil.php');

	} ?>