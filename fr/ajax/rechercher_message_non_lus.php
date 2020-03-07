<?php

	include('is_logged.php');
	include('is_patient.php');
	/* Connect To Database*/
	require_once ("../config/db.php");
	require_once ("../config/connexion.php");
	require_once ("../functions.php");
	$idpersonne = $_SESSION['idpersonne'];
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
				  <strong>Info!</strong> Données supprimées.
				</div>
			<?php 
				}else {
			?>
				<div class="alert alert-danger alert-dismissible" role="alert">
				  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				  <strong>Error!</strong> Désolé! quelque chose a mal tourné, essayez à nouveau.
				</div>
			<?php			
			}
			
		} else {
			?>
			<div class="alert alert-danger alert-dismissible" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong>Error!</strong> Impossible de supprimer ce message. 
			</div>
			<?php
		}
		
		
		
	}
	if($action == 'ajax'){
		// escaping, additionally removing everything that could be (html/javascript-) code
         $q = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q'], ENT_QUOTES)));
	
		 $requete = "SELECT idmessage, sujet, message, idpatient, medecin_idmedecin, message.etat as etat, heure, message.date_save as date_save FROM message 
		 				INNER JOIN patient ON patient_idpatient = patient.idpatient
		 				AND expediteur = 1 
		 				AND patient.lisible = 1 
		 				AND message.lisible = 1 
		 				AND message.patient_idpatient = '$idpatient' ";
		 				//var_dump($requete);

		 $req_count = "SELECT count(*) as numrows FROM message 
		 				INNER JOIN patient ON patient_idpatient = patient.idpatient 
		 				AND expediteur = 1 
		 				AND patient.lisible = 1 
		 				AND message.lisible = 1 
		 				AND message.patient_idpatient = '$idpatient' ";

		if ( $_GET['q'] != "" )
		{
			
			$requete = $requete." AND message.sujet LIKE '%".$q."%' OR message.date_save LIKE '%".$q."%' OR message.heure LIKE '%".$q."%'";

			$req_count = $req_count." AND message.sujet LIKE '%".$q."%' OR message.date_save LIKE '%".$q."%' OR message.heure LIKE '%".$q."%'";
		}
		//$sWhere.=" order by nom_contact_urgence";
		include 'pagination.php'; //include pagination file
		//pagination variables
		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
		$per_page = 6; //how much records you want to show
		$adjacents  = 4; //gap between pages after number of adjacents
		$offset = ($page - 1) * $per_page;
		//Count the total number of row in your table*/
		//$req = "SELECT count(*) AS numrows FROM $sTable  $sWhere";
		$count_query   = mysqli_query($con, $req_count);
		//var_dump($req_count);
		$row= mysqli_fetch_array($count_query);
		$numrows = $row['numrows'];
		$total_pages = ceil($numrows/$per_page);
		$reload = './messages.php';
		//main query to fetch the data
		//$sql="SELECT * FROM  $sTable $sWhere LIMIT $offset,$per_page";
		$sql = $requete." ORDER By message.date_save, message.heure DESC LIMIT $offset,$per_page";
		//var_dump($sql);
		$query = mysqli_query($con, $sql);
		//loop through fetched data
		if ($numrows>0){
			
			?>
			<div class="table-responsive">
			  <table class="table table-hover table-striped">
			  	<tbody>				
				<?php 
				while ($row=mysqli_fetch_array($query)){
						$idmessage = $row['idmessage'];
						$etat=$row['etat'];
						$objet = $row['sujet'];
						$message = $row['message'];
						$idmedecin=$row['medecin_idmedecin'];
						$idpatient = $row['idpatient'];
						$heure = $row['heure'];
						$date_save=get_date_fr($row['date_save']);
						$medecin = get_medecin($idmedecin);
						var_dump($medecin);
					?>
					
						<tr>
		                   <td><input type="checkbox" value="<?php echo $idmedecin; ?>"></td>		                	   
		                    <td class="mailbox-name">
		                    	<?php echo $medecin['nom'].' '.$medecin['prenom']; ?>
		                    </td>
		                    <td class="mailbox-subject">
		                    	<a href="read-mail.html">
		                    		<?php echo $objet; echo substr($message, 0, 40).'...'; ?>
		                    	</a>
		                    </td>
		                    <td class="mailbox-attachment">
		                    	<?php echo $heure; ?>
		                    </td>
		                    <td class="mailbox-date">
		                    	<?php echo $date_save; ?>		
		                    </td>
		                 </tr>

					
				}
				?>
				<tr>
					<td colspan=10><span class="pull-right">
					<?php
					 echo paginate($reload, $page, $total_pages, $adjacents);
					?></span></td>
				</tr>
				</tbody> 
			  </table>
			</div>  
			<?php
		}
	}
?>
<style type="text/css">
	th{
		text-align: center;
	}
</style>