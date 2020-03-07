<?php
	include('is_logged.php');
	/* Connect To Database*/
	require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("config/connexion.php");//Contiene funcion que conecta a la base de datos
	
	$active_messages="navbarElogeXmaelactive"; 
	$title="MaMED | Messages";
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
			    <div class="btn-group pull-right">
					
				</div>
                            <i class='glyphicon glyphicon-cogs'></i><span style="font-weight: bold; font-size: 1.5em;"><?php echo $lang['messages']; ?> </span>   <span class="badge_patient bg-important"></span> <?php echo $lang['nouveauMessages']; ?>
			</div>
			<div class="panel-body">
				<div class="form-group row">
					<label for="q" class="col-md-2 control-label"><?php echo $lang['rechercher']; ?></label>
					<div class="col-md-5">
						<input type="text" class="form-control" id="q" placeholder="<?php echo $lang['rechercher']; ?>" onkeyup='load(1);'>
					</div>
					<div class="col-md-3">								
						<span id="loader"></span>
					</div>			
				</div>

				<form id="form_message_patient" method="POST" action="">		
					<div class="box span4" onTablet="span6" onDesktop="span4">	
						<div class="box-content">
							<div id="resultats"></div><!-- Charger les données AJAX-->
							<div class='outer_div'></div><!-- Charger les données AJAX -->

							<div class="chat-form">
								<textarea type="text" class="form-control" id="message_patient" name="message_patient" required placeholder="écrire un message..."> </textarea><br>
								<div class="text-right">
									<button type="submit" id="btn_message_patient" class="btn btn-info"><?php echo $lang['envoyer']; ?></button>
								</div>
								
							</div>	
						</div>
					</div><!--/span-->
				</form>
			</div>	
			</div>
		</div>			
	</div>



	<?php 
		include("footer.php");
	?> 
	<script type="text/javascript" src="js/messages.js"></script> 
  </body>
</html>

<script>
    //fonction d'envoi des messages 
    $("#form_message_patient").submit(function( event ) {
     var parametres = $(this).serialize();
     event.preventDefault();
       $.ajax({
          type: "POST",
          url: "ajax/nouveau_message_patient.php",
          data: parametres,
           beforeSend: function(objet){
            $('#btn_message_patient').html('Envoyer <img src="../img/ajax-loader.gif">');            
            },
          success: function(data){
          $("#resultat_ajax").html(data);
          $('#btn_message_patient').html('Envoyer');
          
          $('#message_patient').val(''); 
          load(1);
          }
      });
      
    })

</script>