<?php
	include('is_logged.php');
	include('is_admin.php');
	/* Connect To Database*/
	require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("config/connexion.php");//Contiene funcion que conecta a la base de datos
	
	$active_medecins="navbarElogeXmaelactive";
	$title="MaMED | Medécins";
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
	<div class="panel panel-success" style="margin-top: 40px;" >
		<div class="panel-heading">
		    <div class="btn-group pull-right">
				<button type='button' class="btn bg-info" data-toggle="modal" data-target="#nouveauMedecin"><span class="fa fa-plus" ></span> <?php echo $lang['newMedecin']; ?></button>
			</div>
			<h4><i class='fa fa-search'></i> <?php echo $lang['rechercherMedecin']; ?></h4>

			<h4><i class='fa fa-error'></i>



				<?php if($lang['langue']=='Fr'): ?>

					<script type="text/javascript">
						var chargement= 'Chargement...';
						var arrondissement = "Choisir un arrondissement";
						var departement = "Choisir un département";
						var confirme ="Voulez vous supprimer ce medécin?";
					</script>

					<?php if (isset($_GET['valide'])): ?>
							<?php if ($_GET['valide'] == 'ok'): ?>
								<script type="text/javascript">
									alert('Medecin enregistré avec succèss!');
								</script>
							<?php elseif ($_GET['valide']=='erreur'): ?>
								<script type="text/javascript">
									alert('Erreur lors de l\'enregistrement veuillez contacter le service technique!');
								</script>
							<?php elseif ($_GET['valide']=='contactezadmin'): ?>
								<script type="text/javascript">
									alert('Erreur lors de l\'enregistrement veuillez contacter l\'administrateur!');
								</script>
							<?php else: ?>

							<?php endif; ?>
					<?php endif; ?>
				<?php elseif ($lang['langue']=='Eng'): ?>
					<script type="text/javascript">

						var chargement='Loading...';
						var arrondissement = "Choose a borough";
						var departement = "Choose a department";
						var confirme="Do you want to remove this doctor?";
					</script>
					<?php if (isset($_GET['valide'])): ?>
							<?php if ($_GET['valide'] == 'ok'): ?>
								<script type="text/javascript">
									alert('Medecin successfully registered!');
								</script>
							<?php elseif ($_GET['valide']=='erreur'): ?>
								<script type="text/javascript">
									alert('Error during registration please contact technical service!');
								</script>
							<?php elseif ($_GET['valide']=='contactezadmin'): ?>
								<script type="text/javascript">
									alert('Error during registration please contact the administrator!');
								</script>
							<?php else: ?>

							<?php endif; ?>
					<?php endif; ?>
				<?php elseif ($lang['langue']=='Deutch'): ?>
					<script type="text/javascript">
						var chargement='Laden...';
						var arrondissement = "Wählen Sie einen Bezirk aus";
						var departement = "Wählen Sie eine Abteilung aus";
						var confirme="Möchten Sie diesen Arzt löschen?";
					</script>
					<?php if (isset($_GET['valide'])): ?>
							<?php if ($_GET['valide'] == 'ok'): ?>
								<script type="text/javascript">
									alert('Medecin erfolgreich registriert!');
								</script>
							<?php elseif ($_GET['valide']=='erreur'): ?>
								<script type="text/javascript">
									alert('Fehler bei der Anmeldung wenden Sie sich bitte an den technischen Service!');
								</script>
							<?php elseif ($_GET['valide']=='contactezadmin'): ?>
								<script type="text/javascript">
									alert('Fehler bei der Anmeldung wenden Sie sich bitte an den Administrator!');
								</script>
							<?php else: ?>

							<?php endif; ?>
					<?php endif; ?>
				<?php endif; ?>


			</h4>
		</div>
		<div class="panel-body">
		
			
			
			<?php
				include("modal/nouveau_medecin.php"); 
				include("modal/editer_medecin.php");
			?>
			<form class="form-horizontal" role="form" id="datos_cotizacion">
				
						<div class="form-group row">
							<label for="q" class="col-md-2 control-label"><?php echo $lang['nom']; ?></label>
							<div class="col-md-5">
								<input type="text" class="form-control" id="q" placeholder="<?php echo $lang['nom']; ?>" onkeyup='load(1);'>
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
	<script type="text/javascript" src="js/clara.js"></script>	
	<script type="text/javascript" src="js/medecin.js"></script>
	<script type="text/javascript" src="js/catrine.js"></script>
  </body>
</html>


						