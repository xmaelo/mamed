<?php

	include('is_logged.php');
	include('is_patient.php');
	/* Connect To Database*/
	require_once ("../config/db.php");
	require_once ("../config/connexion.php");
	require_once ("../functions.php");
	$idpersonne = $_SESSION['idpersonne'];
	$phot=$_SESSION['phot'];


      if(isset($_SESSION['lang'])){
      $lage='langues/'.$_SESSION['lang'].'.php';
      
      require_once ('../'.$lage);
      }
      else{
        $_SESSION['lang']='Fr';
         $lage='langues/'.$_SESSION['lang'].'.php';
      
      require_once ('../'.$lage);
      }
 

	
	$patient = get_personne($idpersonne, 'patient');
	$idpatient=$patient['idpatient'];
	$action = (isset($_REQUEST['action']) && $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';

	if (isset($_GET['id'])){
		$id=intval($_GET['id']);
		$query=mysqli_query($con, "SELECT * from message where idmessage ='".$id."' AND lisible = 1");
		$count=mysqli_num_rows($query);
		if ($count>=0){
			if ($delete1=mysqli_query($con,"UPDATE message set lisible = 0 where idmessage ='".$id."'")){
				
			?>
				<div class="alert alert-success alert-dismissible" role="alert">
				  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				  <strong><?php echo $lang['info']; ?>!</strong> <?php echo $lang['donneesSuprimer']; ?>.
				</div>
			<?php 
				}else {
			?>
				<div class="alert alert-danger alert-dismissible" role="alert">
				  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				  <strong><?php echo $lang['error']; ?>!</strong> <?php echo $lang['desolerquelchose'];; ?>.
				</div>
			<?php			
			}
			
		} else {
			?>
			<div class="alert alert-danger alert-dismissible" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong><?php echo $lang['error']; ?>!</strong>  <?php echo $lang['malTourner']; ?>. 
			</div>
			<?php
		}
		
		
		
	}
	if($action == 'ajax'){
		// escaping, additionally removing everything that could be (html/javascript-) code
         $q = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q'], ENT_QUOTES)));
	
		 $requete = "SELECT idmessage, sujet, message, idpatient, expediteur, medecin_idmedecin, message.etat as etat, heure, message.date_save as date_save FROM message 
		 				INNER JOIN patient ON patient_idpatient = patient.idpatient
		 				AND patient.lisible = 1 
		 				AND message.lisible = 1 
		 				AND message.patient_idpatient = '$idpatient' ";
		 				//var_dump($requete);

		 $req_count = "SELECT count(*) as numrows FROM message 
		 				INNER JOIN patient ON patient_idpatient = patient.idpatient 
		 				AND patient.lisible = 1 
		 				AND message.lisible = 1 
		 				AND message.patient_idpatient = '$idpatient' ";

		if ( $_GET['q'] != "" )
		{
			
			$requete = $requete." AND message.message LIKE '%".$q."%' OR message.date_save LIKE '%".$q."%' OR message.heure LIKE '%".$q."%'";

			$req_count = $req_count." AND message.message LIKE '%".$q."%' OR message.date_save LIKE '%".$q."%' OR message.heure LIKE '%".$q."%'";
		}
		//$sWhere.=" order by nom_contact_urgence";
		//include 'pagination.php'; //include pagination file
		//pagination variables
		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
		$per_page = 6; //how much records you want to show
		$adjacents  = 4; //gap between pages after number of adjacents
		$offset = ($page - 1) * $per_page;

		$count_query   = mysqli_query($con, $req_count);

		$row= mysqli_fetch_array($count_query);
		$numrows = $row['numrows'];
		$total_pages = ceil($numrows/$per_page);
		$reload = './messages.php';
		//main query to fetch the data
		//$sql="SELECT * FROM  $sTable $sWhere LIMIT $offset,$per_page";
		$sql = $requete." ORDER By message.date_save, message.heure";
		//var_dump($sql);
		$query = mysqli_query($con, $sql);
		//loop through fetched data
		if ($numrows>0){
			
			// var_dump($query);
			// die();
				while ($row=mysqli_fetch_array($query)){
						$idmessage = $row['idmessage'];
						$etat=$row['etat'];
						$expediteur = $row['expediteur'];
						$objet = $row['sujet'];
						$message = $row['message'];
						$idmedecin=$row['medecin_idmedecin'];
						$idpatient = $row['idpatient'];
						$heure = $row['heure'];
						$date_save=get_date_fr($row['date_save']);
						$medecin = get_medecin($idmedecin);

						 $reqest = "SELECT * FROM medecin, personne WHERE idmedecin=$idmedecin AND personne.idpersonne=medecin.personne_idpersonne";
						 $queryMed = mysqli_query($con, $reqest);
						 $PhotM=mysqli_fetch_array($queryMed);
						 $phott=$PhotM['chemin'];
						 

						
						//var_dump($medecin);
					?>
					
						

						<ul class="chat">
						<?php if($expediteur){ ?>
							<li class="left">
							<img class="avatar"  src="<?php if($phot){ echo $phot;} else { echo 'img/avatar_2x.png';} ?>">
								<span class="message"><span class="arrow"></span>
									<span class="from"><b><?php echo $medecin['nom'].' '.$medecin['prenom']; ?> <?php echo $lang['le']; ?> </b></span>
									<span class="time"><b> <?php echo $date_save.' '.$lang['a'].' '.$heure; ?></b></span>
									<span class="text">
										<?php echo $message; ?>
									</span>
								</span>	                                  
							</li>

							<?php }else{ ?>
							
							<li class="right">
								<img class="avatar"  src="<?php if($phott){ echo $phott;} else { echo 'img/avatar.jpg';} ?>">
								<span class="message"><span class="arrow"></span>
									<span class="from"><b><?php echo $lang['moiLe']; ?> </b></span>
									<span class="time"><b> <?php echo $date_save.' '.$lang['a'].' '.$heure; ?></b></span>
									<span class="text">
										<?php echo $message; ?>
									</span>
								</span>                                  
							</li>

							<?php } ?>
							
						</ul>						

			<?php
		}
?>
			<input type="hidden" name="idpatient" id="idpatient" value="<?php echo $idpatient; ?>">		
			<input type="hidden" name="idmedecin" value="<?php echo $idmedecin; ?>">
<?php

	}
}	
?>
<script type="text/javascript">
	 
		var val = $('#idpatient').val();
        
         $.ajax({

                url:'ajax/marquer_comme_lu_patient.php',
                data:'val='+val,
                dataType:'json',
                success:function(json){
                     
                     if(json != true){
                     	
                     	$('#badge_patient').hide();
                     }
                }
            });    

</script>
