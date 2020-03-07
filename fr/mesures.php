<?php
	include('is_logged.php');
	/* Connect To Database*/
	require_once ("config/db.php");
	require_once ("config/connexion.php");
	require_once ("functions.php");
	//selection du patient connecté
	$patient = get_personne($_SESSION['idpersonne'], 'patient');

	$active_mesures="active";
	$title="MaMED | Mésures";
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
	<div class="panel panel-success">
		<div class="panel-heading">
		    <div class="btn-group pull-right">
				
			</div>
			<h4><i class='glyphicon glyphicon-cogs'></i>Mésures</h4>
		</div>
		<div class="panel-body">
		
			<div class="row">
				<?php var_dump($patient); ?>
			</div>

			<form class="form-horizontal" role="form" id="datos_cotizacion">
								
				
			</form>
				<div id="resultats"></div><!-- Charger les données AJAX-->
				<div class='outer_div'></div><!-- Charger les données AJAX -->
			
		
	
			
			
			
  </div>
</div>
		 
	</div>

	<?php
	include("footer.php");
	?>
	<script type="text/javascript" src="js/preferences.js"></script>
  </body>
</html>
