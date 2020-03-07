<?php

	include('is_logged.php');
	include('is_medecin.php');
	/* Connect To Database*/
	require_once ("../config/db.php");
	require_once ("../config/connexion.php");
	require_once ("../functions.php");
	$idpersonne = $_SESSION['idpersonne'];
	$medecin = get_personne($idpersonne, 'medecin');
	$idmedecin = $medecin['idmedecin'];
	$action = (isset($_REQUEST['action']) && $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';

      if(isset($_SESSION['lang'])){
      $lage='langues/'.$_SESSION['lang'].'.php';
      
      require_once ('../'.$lage);
      }
      else{
        $_SESSION['lang']='Fr';
         $lage='langues/'.$_SESSION['lang'].'.php';
      
      require_once ('../'.$lage);
      }


	if (isset($_GET['id'])){
		$id=intval($_GET['id']);
		$query=mysqli_query($con, "SELECT * from message where idmessage ='".$id."' AND lisible = 1");
		$count=mysqli_num_rows($query);
		if ($count>=0){
			if ($delete1=mysqli_query($con,"UPDATE message set lisible = 0 where idmessage ='".$id."'")){
				
			?>
				<div class="alert alert-success alert-dismissible" role="alert">
				  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button> 
				  <strong><?php  echo $lang['info']; ?> !</strong> <?php echo $lang['donneesSuprimer']; ?>.
				</div>
			<?php 
				}else {
			?>
				<div class="alert alert-danger alert-dismissible" role="alert">
				  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				  <strong><?php  echo $lang['error']; ?> !</strong> <?php echo $lang['desolerquelchose']; ?>.
				</div>
			<?php			
			}
			
		} else {
			?>
			<div class="alert alert-danger alert-dismissible" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong><?php  echo $lang['error']; ?> !</strong> <?php echo $lang['impossibleDeSuprimerCeMessage']; ?>
			</div>
			<?php
		}
		
		
		
	}
	if($action == 'ajax'){
		// escaping, additionally removing everything that could be (html/javascript-) code
         $q = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q'], ENT_QUOTES)));

         $req = "SELECT DISTINCT patient_idpatient as idpatient, nom, prenom, personne_idpersonne FROM message
         		INNER JOIN patient ON patient_idpatient = patient.idpatient
         		INNER JOIN personne ON personne_idpersonne = personne.idpersonne
         		AND patient.lisible = 1
         		AND personne.lisible = 1
		 		AND medecin_idmedecin = '$idmedecin'";
		 //var_dump($req);		
		 $reqs = mysqli_query($con, $req);


		  $reqss = "SELECT DISTINCT patient_idpatient as idpatient, nom, prenom, personne_idpersonne FROM message
         		INNER JOIN patient ON patient_idpatient = patient.idpatient
         		INNER JOIN personne ON personne_idpersonne = personne.idpersonne
         		AND patient.lisible = 1
         		AND personne.lisible = 1
		 		AND medecin_idmedecin = '$idmedecin'";
		 //var_dump($req);		
		 $reqss = mysqli_query($con, $reqss);	
		  $q= mysqli_fetch_array($reqss);
		  $t=$q['personne_idpersonne'];
		  

		  $req_cout = "SELECT * FROM personne WHERE idpersonne=$t";
		$photo  = mysqli_query($con, $req_cout);
		if($photo)
		{
			
		$photPatient=mysqli_fetch_array($photo);
		$phot=$photPatient['chemin'];
		}
		 
		 
		 

		  $reqMed = "SELECT * FROM personne WHERE idpersonne=$idpersonne";
		$photoM  = mysqli_query($con, $reqMed);
		$photMed=mysqli_fetch_array($photoM);
		 $photMedecin=$photMed['chemin'];


		 
		 
		 

		 //fonction qui compte les messages d'un patient donné
		 function count_message_patient($idpatient, $idmedecin){
			global $con;

			$req = "SELECT count(*) as nbre FROM message
				WHERE medecin_idmedecin = '$idmedecin'
				AND expediteur = 0
				AND etat = 0
				AND lisible = 1
				AND patient_idpatient = '$idpatient'";
			//var_dump($req);	
			$query = mysqli_query($con, $req);
			$rw = mysqli_fetch_array($query);
			$value = $rw['nbre'];
			return $value;
		}	

		function get_message($idpatient, $idmedecin){
			global $con;
		 	$requete = "SELECT idmessage, sujet, message, expediteur, message.etat as etat, heure, message.date_save as date_save FROM message 		 				
		 				WHERE message.lisible = 1 
		 				AND message.medecin_idmedecin = '$idmedecin' 
		 				AND message.patient_idpatient = '$idpatient'
		 				ORDER By message.date_save, message.heure";
		 				//var_dump($requete);
		 				$query = mysqli_query($con, $requete);
		 				return $query;
		}

				while ($patient=mysqli_fetch_array($reqs)){

						$messages = get_message($patient['idpatient'], $idmedecin);

						$idpatient = $patient['idpatient'];
						$nom = $patient['nom'].' '.$patient['prenom'];
				?>
			<form class="form_send_message_medecin" method="post" action="">	
				<span class="resultat_ajax"></span>
				<div class="box span4" onTablet="span6" onDesktop="span4">
					<div class="box-header" style="height:40px;" >
						<i class="fa fa-user"></i><span class="break"></span> <?php echo substr($nom, 0, 12); if(count_message_patient($idpatient, $idmedecin) != 0) echo "  <span class='badge bg-important'>".count_message_patient($idpatient, $idmedecin)."</span>"; 
							?>
						<div class="box-icon">
							<a href="<?php echo $idpatient; ?>" class="btn-minimize" ><i class="fa fa-chevron-down"></i></a>
							
						</div>
					</div>
					<div class="box-content" style="display: none;">
						<ul class="chat">
				<?php	$n = 0;	
						while ($row = mysqli_fetch_array($messages)) {
							$idmessage = $row['idmessage'];
							$etat=$row['etat'];
							$expediteur = $row['expediteur'];
							$message = $row['message'];
							$heure = $row['heure'];
							$date_save=get_date_fr($row['date_save']);		
						?>
						
							<?php if(!$expediteur){ ?>
							<li class="left">
							<img class="avatar"  src=" <?php if($phot) { echo $phot;}else {echo 'img/avatar_x.png';} ?>">
								<span class="message"><span class="arrow"></span>
									<span class="from"></span>
									<span class="time"><b> <?php echo $date_save.' '.$lang['a'].' '.$heure; ?></b></span>
									<span class="text">
										<?php echo trim($message); ?>
									</span>
								</span>	                                  
							</li>


							<?php }else{ ?>
							
							<li class="right">
							<img class="avatar"  src=" <?php if($photMedecin) { echo $photMedecin;} else { echo 'img/avatar.jpg';} ?>">

								<span class="message"><span class="arrow"></span>
									<span class="from"><b><?php echo $lang['moiLe'] ?> </b></span>
									<span class="time"><b> <?php echo $date_save.' '.$lang['a'].' '.$heure; ?></b></span>
									<span class="text">
										<?php echo trim($message); ?>
									</span>
								</span>	                                  
							</li>
							
							<?php } 
								if($n==0){
							?>
									<input type="hidden" name="idpatient" value="<?php echo $idpatient; ?>">		
									<input type="hidden" name="idmedecin" value="<?php echo $idmedecin; ?>">
							<?php } ?>		
							
							<input type="hidden" name="idmessage" value="<?php echo $idmessage; ?>">
						
						<?php 
								$n++; 
							} 

						?>
						</ul>
						<div class="chat-form">
						<!--	<textarea class="form-control message_medecin" name="message_medecin" required></textarea> <br>-->
                             <textarea type="text" class="form-control message_medecin" name="message_medecin" required placeholder="<?php echo $lang['ecrireMessage']; ?>..."></textarea><br>
							<div class="text-right">
								<button type="submit" class="btn_send_message_medecin btn btn-info"><?php echo $lang['envoyer'] ?></button>
							</div>
								
						</div>	
					</div>
				</div>		

		</form>							

			<?php
		}
?>
			
<?php

	
}	
?>

<script type="text/javascript">
/*	$('.btn-close').click(function(e){
    e.preventDefault();
    $(this).parent().parent().parent().fadeOut();
  });*/
 
  $('.btn-minimize').click(function(e){
    e.preventDefault();
    var $btn = $(this);
    var $target = $(this).parent().parent().next('.box-content');
    if($target.is(':visible')) $('i',$(this)).removeClass('fa-chevron-down').addClass('fa-chevron-down');
    else             $('i',$(this)).removeClass('fa-chevron-down').addClass('fa-chevron-up');    	
    $target.slideToggle();

    var val = $btn.attr('href');
    $.ajax({

                url:'ajax/marquer_comme_lu.php',
                data:'val='+val,
                dataType:'json',
                success:function(json){
                     
                     if(json != true){
                     	var nbre = $btn.parent().parent().find('.badge').html();
                     	if(nbre != 0){
                     		$btn.parent().parent().find('.badge').hide();
	                     	var a = $('.badge_medecin').html() - nbre;
	                     	$('.badge_medecin').html(a);
	                     	$btn.parent().parent().find('.badge').html(0)
                     		if(a == 0){
                     			$('.badge_medecin').hide();
                     		}
                     	}
                     	
                     }
                }
            });       

  });

  $( ".form_send_message_medecin" ).submit(function( event ) {
    event.preventDefault();
    var $target = $(this).children().find('.message_medecin');
    var $form = $(this);
     $form.children().find('.btn_send_message_medecin').html('Envoi <img src="../img/ajax-loader.gif">')
      var parametres = $(this).serialize();
       $.ajax({
          type: "POST",
          url: "ajax/save_message_medecin.php",
          data: parametres,
           beforeSend: function(objet){
            $form.children().find(".resultat_ajax").html("Envoi en cours...");
            },
          success: function(data){
         	$form.children().find('.chat').append(data);
          	$form.children().find('.btn_send_message_medecin').html('Envoyer')
          	$form.children().find(".resultat_ajax").html("");
          	$form.children().find('.message_medecin').val("");
          }
      });
  })

</script>
