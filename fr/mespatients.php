<?php


	
	include('is_logged.php');
	include('is_medecin.php');
	/* Connect To Database*/
	require_once ("config/db.php");
	require_once ("config/connexion.php");
	
	$active_patients="navbarElogeXmaelactive";
	$title="MaMED | Patients suivis";
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
      	$id = $_SESSION['idpersonne'];
        $sql = "SELECT idmedecin FROM medecin WHERE personne_idpersonne = $id";
                        

        $query = mysqli_query($con,$sql);

                       

     $medecinid = mysqli_fetch_array($query)[0];
     $_SESSION['medecinid'] = $medecinid;

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
	<div class="panel panel-success" style="margin-top: 40px;">
		<div class="panel-heading">
		    <div class="btn-group pull-right">
		    	<a style="margin-right: 10px;" class="btn btn-default" id="btn_imprimer"
                   href="rapport-patients-suivis.php" target="_blank" title="Imprimer la liste des patients">
                    <span class="fa fa-print"></span> <?php echo $lang['imprimer']; ?>
                </a>
				<a class="btn bg-info" href="suivre_patient.php" id="suivre_patient"><span class="fa fa-plus"></span> <?php echo $lang['suivreUnNouveauPatient']; ?></a>
			</div>
			<h4><i class='fa fa-search'></i> <?php echo $lang['listeDePatientsSuivis']; ?></h4>
		</div>
		<div class="panel-body">
		
			
			
			<?php
				//include("modal/ajouter_medecin_patient.php");
				//include("modal/editer_patient.php");

				
			?>
			<form class="form-horizontal" role="form" id="datos_cotizacion">
				
						<div class="form-group row">
							<label for="q" class="col-md-2 control-label"><?php echo $lang['nom']; ?></label>
							<div class="col-md-5">
								<input type="text" class="form-control" id="q" placeholder="<?php echo $lang['nomDuPatient']; ?>" onkeyup='load(1);'>
							</div>
							<div class="col-md-3">
								<button type="button" class="btn bg-info" onclick='load(1);'>
									<span class="fa fa-search" ></span> <?php echo $lang['rechercher']; ?></button>
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
	<?php if ($lang['langue']=='Fr'): ?>
	 <script type="text/javascript"> 
		var confirme="Voulez vous supprimer ce patient?";
		var confirme1="Voulez vous arrêter de suivre ce patient?";
		var chargement='Chargement...';
	</script>
	<?php elseif($lang['langue']=='Deutch'): ?>
	 <script type="text/javascript">
		var confirme="Möchten Sie diesen Patienten löschen?";
		var confirme1="Möchten Sie diesem Patienten nicht mehr folgen?";
		var chargement ='Laden...';
	</script>
	<?php elseif($lang['langue']=='Eng'): ?>
	 <script type="text/javascript">
		var confirme="Do you want to delete this patients";
		var confirme1="Do you want to stop following this patient?";
		var chargement = 'Loading';
	</script>
	<?php endif; ?>

	
	<script type="text/javascript" src="js/medecin_patient.js"></script>
  </body>
</html>

</script>

  <?php if(isset($_GET['clara'])): ?>

     	<script type="text/javascript">
     		alert('Can not print an empty list');
     	</script>
     <?php endif; ?>