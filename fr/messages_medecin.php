<?php
	include('is_logged.php');
	include('is_medecin.php');
	/* Connect To Database*/
	require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("config/connexion.php");//Contiene funcion que conecta a la base de datos
	
	$active_messages="navbarElogeXmaelactive";
	$title="MaMED | Messages";
	
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
		    <div class="btn-group pull-right">
				
			</div>
			<i class='fa fa-envelope'></i><span style="font-weight: bold; font-size: 1.5em;"> <?php  echo $lang['messages'] ?> </span>  <span class="badge_medecin bg-important"><?php echo   $nbre; ?></span> <?php echo $lang['nouveauMessages'] ?>
		</div>
		<div class="panel-body">			
						
			<form id="form_message_patient" method="POST" action="">		

							

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
		var confirme="Voulez vous supprimer cette discussion?";
	
	</script>
	<?php elseif($lang['langue']=='Deutch'): ?>
	 <script type="text/javascript">
		var confirme="Möchten Sie diese Diskussion löschen ?";

	</script>
	<?php elseif($lang['langue']=='Eng'): ?>
	 <script type="text/javascript">
		var confirme="Do you want to delete this discussion ?";
	
	</script>
	<?php endif; ?>


	<script type="text/javascript" src="js/messages_medecin.js"></script>
	
	</body> 

</html>

