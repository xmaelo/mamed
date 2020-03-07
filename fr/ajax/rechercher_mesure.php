<?php

	include('is_logged.php');
	include('is_patient.php');
	/* Connect To Database*/
	require_once ("../config/db.php");
	require_once ("../config/connexion.php");
	require_once ("../functions.php");
	$idpersonne = (isset($_GET['idpersonne']) ? $_GET['idpersonne'] : $_SESSION['idpersonne']);
	$patient = get_personne($idpersonne, 'patient');
	$idpatient=$patient['idpatient'];
	$action = (isset($_REQUEST['action']) && $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
	if (isset($_GET['id'])){
		$id=intval($_GET['id']);
		$query=mysqli_query($con, "SELECT * from journal where idjournal ='".$id."' AND lisible = 1");
		$count=mysqli_num_rows($query);
		if ($count>=0){
			if ($delete1=mysqli_query($con,"UPDATE journal set lisible = 0 where idjournal='".$id."'")){
				
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
			  <strong>Error!</strong> Impossible de supprimer ce patient. 
			</div>
			<?php
		}
		
		
		
	}
	if($action == 'ajax'){
		// escaping, additionally removing everything that could be (html/javascript-) code
         $q = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q'], ENT_QUOTES)));
		// $aColumns = array('nom_contact_urgence');//Recherche les colonnes
		// $sTable = "patient";
		// $sWhere = " WHERE lisible = 1";
		 $requete = "SELECT * FROM journal 
		 				INNER JOIN mesure ON mesure_idmesure = mesure.idmesure 
		 				INNER JOIN patient ON journal.patient_idpatient = patient.idpatient 
		 				AND patient.lisible = 1 
		 				AND journal.lisible = 1 
		 				AND journal.patient_idpatient = '$idpatient'";
		 				//var_dump($requete);

		 $req_count = "SELECT count(*) as numrows FROM journal 
		 				INNER JOIN mesure ON mesure_idmesure = mesure.idmesure 
		 				INNER JOIN patient ON journal.patient_idpatient = patient.idpatient 
		 				AND patient.lisible = 1 
		 				AND journal.lisible = 1  
		 				AND journal.patient_idpatient = '$idpatient'";

		if ( $_GET['q'] != "" )
		{
			
			$requete = $requete." AND mesure.libelle LIKE '%".$q."%' OR journal.date_save LIKE '%".$q."%' OR journal.heure LIKE '%".$q."%'";

			$req_count = $req_count." AND mesure.libelle LIKE '%".$q."%' OR journal.date_save LIKE '%".$q."%' OR journal.heure LIKE '%".$q."%'";
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
		$reload = './journal.php';
		//main query to fetch the data
		//$sql="SELECT * FROM  $sTable $sWhere LIMIT $offset,$per_page";
		$sql = $requete." ORDER By journal.date_save, journal.heure DESC LIMIT $offset,$per_page";
		//var_dump($sql);
		$query = mysqli_query($con, $sql);



/*
information d'integration de la langue 
*/

			      if(isset($_SESSION['lang'])){
			      $lage='langues/'.$_SESSION['lang'].'.php';
			      
			      require_once ('../'.$lage);
			     
			      }
			      else{
			        $_SESSION['lang']='Fr';
			         $lage='langues/'.$_SESSION['lang'].'.php';
			      
			      require_once ('../'.$lage);
			      }







		//loop through fetched data
		if ($numrows>0){
			
			?>
			<div class="table table-responsive">
			  <table class="table table-responsive table-advance table-bordered table-hover tableau_dynamique">
				<tr  class="success policeinfo">
					<th >#</th>
					<th ><?php echo $lang['creneau']; ?></th>
					<th ><?php echo $lang['glycemie']; ?></th>
					<th ><?php echo $lang['insuline']; ?></th>
					<th ><?php echo $lang['acetone']; ?></th>
					<th ><?php echo $lang['pa']; ?></th>
					<th ><?php echo $lang['hba1c']; ?></th>
					<th ><?php echo $lang['notes']; ?></th>
					<th ><?php echo $lang['dateEtHeure']; ?></th>					
					<th ><?php echo $lang['actions']; ?></th>					
				</tr>
				<?php $n = 1;
				while ($row=mysqli_fetch_array($query)){
					?>
				<a>	<tr class="policeinfo">
						<td class="h4"><?php echo $n++; ?></td>
						<td class="h4"><?php echo $lang[$row['libelle']]; ?></td>
						<td class="text-center"><?php echo $row['valeur'].' '.get_unite($row['idpatient']);	 ?></td>
						<td class="text-center"><?php echo $row['insuline'].' / '.$row['insuline2'];?></td>
						<td class="text-center"><?php echo $row['acetone']; ?></td>
						<td class="text-center"><?php echo $row['pression_arterielle']; ?></td>
						<td class="text-center "><?php echo $row['hba1c']; ?></td>
						<td class="text-center h4"><?php echo $row['notes']; ?></td>
						<td class="text-center h4"><?php echo date('d-m-Y', strtotime($row['date_save'])).' '.$row['heure']; ?></td>
						
					<td class='text-right'>

						<!-- bouton pour modifier -->
						<a href="#" class='btn btn-success' title='Editer cette mesure' data-idmesure='<?php echo  $row['idmesure'];?>' data-valeur='<?php echo $row['valeur'];?>' data-insuline='<?php echo $row['insuline'];?>' data-insuline2='<?php echo $row['insuline2'];?>' data-pression_arterielle='<?php echo $row['pression_arterielle'];?>' data-acetone='<?php echo $row['acetone'];?>' data-hba1c='<?php echo $row['hba1c'];?>' data-notes='<?php echo $row['notes'];?>' data-idjournal='<?php echo $row['idjournal'];?>'  data-toggle="modal" data-target="#editerMesure"><i class="fa fa-edit"></i></a> 

						<!-- bouton pour supprimer -->
						<a href="#" class='btn btn-danger' title='Supprimer cette mesure' onclick="eliminar('<?php echo $row['idjournal']; ?>')"><i class="fa fa-trash"></i> </a>
					</td>
						
					</tr>
					<?php
				}
				?>
<!-- 				<tr>
					<td colspan=10><span class="pull-right">
					<?php
					 //echo paginate($reload, $page, $total_pages, $adjacents);
					?></span></td>
				</tr> -->
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