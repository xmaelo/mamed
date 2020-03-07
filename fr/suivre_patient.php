<?php
	
	include('is_logged.php');
	include('is_medecin.php');
	/* Connect To Database*/
	require_once ("config/db.php");
	require_once ("config/connexion.php");
	
	$active_patients="navbarElogeXmaelactive";
	$title="MaMED | Patients";
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
	<div class="panel panel-success" style="margin-top: 40px">
		<div class="panel-heading">
		    
			<h4><i class='fa fa-search'></i> <?php  echo $lang['Rechercher un patient à suivre'];?></h4>
		</div>
		<div class="panel-body">
		
			
			
			<?php
				//include("modal/details_journal.php");
				
			?>
			<form class="form-horizontal" role="form" id="datos_cotizacion">
				
						<div class="form-group row">
							<label for="q" class="col-md-2 control-label"><?php echo $lang['nom']; ?></label>
							<div class="col-md-5">
								<input type="text" class="form-control" id="q" placeholder="<?php echo $lang['nom']; ?>" onkeyup='load(1);'>
							</div>
							<div class="col-md-3">
								<button type="button" class="btn btn-default" onclick='load(1);'>
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
	<script type="text/javascript" src="js/suivre_patient.js"></script>
  </body>
</html>
