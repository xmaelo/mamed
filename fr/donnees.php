<?php
	include('is_logged.php');
	/* Connect To Database*/
	require_once ("config/db.php");
	require_once ("config/connexion.php");
	require_once ("functions.php");
	//selection du patient connecté
	$patient = get_personne($_SESSION['idpersonne'], 'patient');

	$active_donnees="navbarElogeXmaelactive";
	$title="MaMED | Données";
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
    <link rel="stylesheet" href="libraries/datepicker/datepicker3.css">
  </head>
  <body>
	<?php
	include("navbar.php");
	?>
	
    <div class="container">
	<div class="panel panel-success" style="margin-top: 40px">
		<div class="panel-heading">
		    <div class="btn-group pull-right">
				
			</div>
			<h4><i class='glyphicon glyphicon-cogs'></i> <?php echo $lang['donneesEnregistrees'] ?></h4>
			<div class="text-right">
				<a class="btn btn-default" href="mpdf/index.php" target="_blank"><i class="fa fa-print"></i> <?php echo $lang['imprimerGenererPdf'] ?></a>
				<a href="mailto:admin@gmail.com" class="btn btn-warning"><i class="fa fa-envelope"></i> <?php echo $lang['transfererParMail'] ?></a>
			</div>
		</div>
		<div class="panel-body">
		
			<div class="row">
				
			</div>

			<form class="form-horizontal" role="form" id="datos_cotizacion">
				
				<div class="form-group row">
					<label for="q" class="col-md-2 control-label"><?php echo $lang['dateDeDebut'] ?><span class="obligatoire">*</span></label>
					<div class="col-md-3">
						<input type="date" class="form-control" id="date_debut" placeholder="jj/mm/aaaa" pattern="(0[1-9]|1[0-9]|2[0-9]|3[01])/(0[1-9]|1[012])/[0-9]{4}" required>
					</div>
					<label for="q2" class="col-md-2 control-label"><?php echo $lang['dateDeFin'] ?><span class="obligatoire">*</span></label>
					<div class="col-md-3">
						<input type="date" class="form-control " id="date_fin" placeholder="jj/mm/aaaa" pattern="(0[1-9]|1[0-9]|2[0-9]|3[01])/(0[1-9]|1[012])/[0-9]{4}" required>
					</div>

					<div class="col-md-2">
						<button type="button" class="btn btn-success" id="btn_filtrer_donnees"

							<?php if($lang['langue']=='Fr'): ?>
						 	onclick="if($('#date_debut').val() !='' && $('#date_fin').val() != ''){
							load(1);
							}{
								alert('Dates invalides');
								}
							 "
							<?php elseif($lang['langue']=='Deutch'): ?> 
							onclick="if($('#date_debut').val() !='' && $('#date_fin').val() != ''){
							load(1);
							}{
								alert('ungültige Daten');
								}
							 "
							<?php elseif($lang['langue']=='Eng'): ?> 
							onclick="if($('#date_debut').val() !='' && $('#date_fin').val() != ''){
							load(1);
							}{
								alert('invalid dates');
								}
							 "
								<?php endif; ?>

							
								>



							<span class="fa fa-search" ></span> <?php echo $lang['filtrer'] ?>
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
	<?php if ($lang['langue']=='Fr'): ?>
	 <script type="text/javascript">
		var confirme="Voulez vous supprimer cette donnée?";
		var chargement='Chargement...';
	</script>
	<?php elseif($lang['langue']=='Deutch'): ?>
	 <script type="text/javascript">
		var confirme="Möchten Sie seine Daten löschen?";
		var chargement='Laden...'; 
	</script>
	<?php elseif($lang['langue']=='Eng'): ?>
	 <script type="text/javascript">
		var confirme="Do you want to delete the data? ";
		var chargement='Loading';
	</script>
	<?php endif; ?>
	
	<?php
	include("footer.php");
	?>
	<script type="text/javascript" src="js/donnees.js"></script>
	<script src="libraries/datepicker/bootstrap-datepicker.js"></script>
	<script src="libraries/datepicker/locales/bootstrap-datepicker.fr.js" charset="UTF-8"></script>

  </body>
</html>
