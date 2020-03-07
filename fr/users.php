<?php	
	include('is_logged.php');
	include('is_admin.php');
	/* Connect To Database*/
	require_once ("config/db.php");
	require_once ("config/connexion.php");
	$active_users="navbarElogeXmaelactive";	
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
		<!--
		    <div class="btn-group pull-right"> 
				<button type='button' class="btn btn-success" data-toggle="modal" data-target="#myModal"><span class="fa fa-plus" ></span> Nouvel utilisateur</button>
			</div>
		-->	
			<h4><i class='fa fa-search'></i> <?php echo $lang['searchUsers']; ?></h4>
		</div>			
			<div class="panel-body">
			<?php
			//include("modal/nouveau_users.php");
			include("modal/editer_users.php");
			include("modal/modifier_password.php");
			?>
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
<script>
$( "#form_add_user" ).submit(function( event ) {
  $('#btn-sauvegarder').attr("disabled", true);
  
 var parametres = $(this).serialize();
	 $.ajax({
			type: "POST",
			url: "ajax/nuevo_usuario.php",
			data: parametres,
			 beforeSend: function(objet){
				$("#resultats_ajax").html("Chargement...");
			  },
			success: function(data){
			$("#resultats_ajax").html(data);
			$('#guardar_data').attr("disabled", false);
			load(1);
		  }
	});
  event.preventDefault();
})

$( "#editer_users" ).submit(function( event ) {
  $('#actualiser_data').attr("disabled", true);
  
 var parametres = $(this).serialize();
	 $.ajax({
			type: "POST",
			url: "ajax/editer_users.php",
			data: parametres,
			 beforeSend: function(objet){
				$("#resultats_ajax2").html("Chargement...");
			  },
			success: function(data){
			$("#resultats_ajax2").html(data);
			$('#actualiser_data').attr("disabled", false);
			load(1);
		  }
	});
  event.preventDefault();
})

$( "#editer_password" ).submit(function( event ) {
  $('#btn_modifier_password').attr("disabled", true);
  
 var parametres = $(this).serialize();
	 $.ajax({
			type: "POST",
			url: "ajax/editer_password.php",
			data: parametres,
			 beforeSend: function(objet){
				$("#resultats_ajax3").html("Chargement...");
			  },
			success: function(data){			
                        if(data.indexOf('alert-danger') == -1){
                            efface_formulaire();
			}
                        $("#resultats_ajax3").html(data);
			$('#btn_modifier_password').attr("disabled", false);
			load(1);
		  }
	});
  event.preventDefault();
})
	function get_user_id(id){
            $("#mod_id_user").val(id);
	}

	function obtenir_data(id){
			var idusers = id;
			var old_email = $("#old_email"+id).val();
			var idpersonne = $("#idpersonne"+id).val();

			$("#old_email").val(old_email);
			$("#idusers").val(idusers);
			$("#idpersonne").val(idpersonne);
			
		}
                
                $('#annuler').on('click', function(e){
                    e.preventDefault();
                    afface_formulaire();
                })
         function efface_formulaire(){
             $('#editer_password')[0].reset();
         }
</script>