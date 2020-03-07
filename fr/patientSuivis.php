<?php 
	include('is_logged.php');
	
	require_once ("config/db.php");
	require_once ("config/connexion.php");
	
	include('functions.php');

	$query = 					"SELECT * from personne, patient_has_medecin, patient
								 where patient_has_medecin.approbation = 1
								 and patient.lisible=1
								 and patient.idpatient = patient_has_medecin.patient_idpatient
								 and personne.idpersonne = patient.personne_idpersonne";

    $execute = mysqli_query($con, $query);

    $data = mysqli_fetch_array($execute);

    $activePatients="navbarElogeXmaelactive"; 
   
	?>


<?php	
	
	include('is_admin.php');
	/* Connect To Database*/
	require_once ("config/db.php");
	require_once ("config/connexion.php");
	// $active_users="navbarElogeXmaelactive";	
	$title="Utilisateurs | Simple Stock";
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
    <div class="container">
		<div class="panel panel-success" style="margin-top: 40px;">
		<div class="panel-heading">
		
			<?php echo $lang['liste_de_patients_suivis']; ?>
		</div>			
			<div class="panel-body">
			
			<form class="form-horizontal" role="form" id="data_cotizacion">
				
						<div class="form-group row">
							<label for="q" class="col-md-2 control-label"><?php echo $lang['nom']; ?>:</label>
							<div class="col-md-5">
								<input type="text" class="form-control" id="q" placeholder="<?php echo $lang['nom']; ?>" onkeyup='load(1);'>
							</div>
							
							
							
							<div class="col-md-3">
								<button type="button" class="btn bg-info" onclick='load(1);'>
									<span class="fa fa-search" ></span> <?php echo $lang['rechercher']; ?> </button>
								<span id="loader"></span>
							</div>
							
						</div>
								
			</form>
				<div id="resultats"></div>
				<div class='outer_div'></div>
						
			</div>
		</div>

	</div>

	<?php
	include("footer.php");
	?>
	<?php if($lang['langue']=='Fr'): ?>
		<script type="text/javascript">
			var confirme = "Voulez-vous supprimer cet utilisateur?";
			var chargement='Chargement...';
		</script>
	<?php elseif($lang['langue']=='Eng'): ?>
		<script type="text/javascript">
			var confirme = "Do you want to delete this user?";
			var chargement='Loading...';
		</script>
	<?php elseif($lang['langue']=='Deutch'): ?>
		<script type="text/javascript">
			var confirme = "Möchten Sie diesen Benutzer löschen?"; 
			var chargement='Laden...';
		</script>
	<?php endif; ?>

	

	
	<script type="text/javascript" src="js/users.js"></script> 
	<script type="text/javascript" src="js/clara.js"></script>	


	
	


  </body>
</html>


     


        
	<?php
	include("footer.php");
	?>
	<script type="text/javascript" src="js/get.js"></script>
	<script type="text/javascript" src="js/clara.js"></script> 
	<!-- <script type="text/javascript" src="js/patient.js"></script> -->
