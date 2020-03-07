<?php

	include('is_logged.php');
	//include('is_patient.php');
	/* Connect To Database*/
	require_once ("../config/db.php");
	require_once ("../config/connexion.php");
	require_once ("../functions.php");

      if(isset($_SESSION['lang'])){
      $lage='langues/'.$_SESSION['lang'].'.php';

      require_once ('../'.$lage);
      }
      else{
        $_SESSION['lang']='Fr';
         $lage='langues/'.$_SESSION['lang'].'.php';
      
      require_once ('../'.$lage);
      }

	function check_valeur($valeur){
		if($valeur != 0){

			if($valeur > 2){

				echo "<td><span style='color:red;'>".$valeur."</span></td>";
			}else if($valeur < 0.6){
				echo "<td><span style='color:green;'>".$valeur."</span></td>";
			}
		}else{

			echo '<td>-</td>';
		}

		
	}

	function find_valeur($date, $idmesure, $idpersonne){
		global $con;
		$req = "SELECT DISTINCT valeur FROM journal 
					INNER JOIN patient ON journal.patient_idpatient = patient.idpatient
		 			INNER JOIN personne ON patient.personne_idpersonne = personne.idpersonne
		 			AND patient.lisible = 1
		 			AND personne.lisible = 1
		 			AND journal.lisible = 1
		 			AND idpersonne = '$idpersonne'
		 			AND journal.date_save = '$date'
		 			AND journal.mesure_idmesure = '$idmesure'";
		 			//var_dump($req);
		 			
			$data = mysqli_query($con, $req); 	
			$rw = mysqli_fetch_array($data);	
			return $rw['valeur'];
	}


	
	$action = (isset($_REQUEST['action']) && $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
	if (isset($_GET['id'])){
		$id=intval($_GET['id']);
		$query=mysqli_query($con, "SELECT * from mesure_patient where idmesure_patient ='".$id."'");
		$count=mysqli_num_rows($query);
		if ($count>=0){
			if ($delete1=mysqli_query($con,"UPDATE mesure_patient set lisible = 0 where idpersonne='".$id."'")){
				$delete2 = mysqli_query($con, "UPDATE patient set lisible = 0 where personne_idpersonne = '".$id."'");
				$delete3 = mysqli_query($con, "UPDATE user set lisible = 0 where personne_idpersonne = '".$id."'");
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
			  <strong><?php echo $lang['error']; ?>!</strong> <?php echo $lang['malTourner']; ?>. 
			</div>
			<?php
		}
	}

	if($action == 'ajax'){
		 $q_debut = get_date_SQL(mysqli_real_escape_string($con,(strip_tags($_REQUEST['q_debut'], ENT_QUOTES))));
	     $q_fin = get_date_SQL(mysqli_real_escape_string($con,(strip_tags($_REQUEST['q_fin'], ENT_QUOTES))));

		$idpersonne = $_SESSION['idpersonne'];

		$requete = "SELECT DISTINCT journal.date_save as date_save FROM journal
						INNER JOIN patient ON journal.patient_idpatient = patient.idpatient
		 				INNER JOIN personne ON patient.personne_idpersonne = personne.idpersonne
		 				AND patient.lisible = 1
		 				AND personne.lisible = 1
		 				AND journal.lisible = 1
		 				AND idpersonne = '$idpersonne'";	

		 $req_count = "SELECT count(*) AS numrows FROM journal
		 				INNER JOIN patient ON journal.patient_idpatient = patient.idpatient
		 				INNER JOIN personne ON patient.personne_idpersonne = personne.idpersonne
		 				AND patient.lisible = 1
		 				AND personne.lisible = 1
		 				AND journal.lisible = 1
		 				AND idpersonne = '$idpersonne' ";

		if ( $_GET['q_debut'] != "" AND $_GET['q_fin'] != "")
		{	
			$requete = $requete." AND journal.date_save BETWEEN '$q_debut' AND '$q_fin'";
			$req_count = $req_count." AND journal.date_save BETWEEN '$q_debut' AND '$q_fin'";
		}

		//$sWhere.=" order by nom_contact_urgence";
		include 'pagination.php'; //include pagination file
		//pagination variables
		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
		$per_page = 10; //how much records you want to show
		$adjacents  = 4; //gap between pages after number of adjacents
		$offset = ($page - 1) * $per_page;
		//Count the total number of row in your table*/
		//$req = "SELECT count(*) AS numrows FROM $sTable  $sWhere";
		$count_query   = mysqli_query($con, $req_count);
		//var_dump($req_count);
		$row= mysqli_fetch_array($count_query);
		$numrows = $row['numrows'];
		$total_pages = ceil($numrows/$per_page);
		$reload = './donnees.php';
		$sql = $requete." ORDER BY journal.date_save DESC";
		//var_dump($sql);
		$query = mysqli_query($con, $sql);
		//loop through fetched data
		if ($numrows>0){
	
		//Creneaux du patient
			$req_mesure = "SELECT libelle, idmesure FROM mesure_patient 
							INNER JOIN  mesure ON mesure_patient.mesure_idmesure = mesure.idmesure
							INNER JOIN patient ON mesure_patient.patient_idpatient = patient.idpatient
							INNER JOIN personne ON patient.personne_idpersonne = personne.idpersonne
							AND patient.lisible = 1
							AND personne.lisible = 1
							AND mesure_patient.etat = 1
							AND personne.idpersonne = '$idpersonne'";
			$mesures = mysqli_query($con, $req_mesure);		
			$idmesures = array();			
			?>
			<div class="table-responsive">
			  <table class="table">
				<tr  class="success">
					<th><?php echo $lang['dates']; ?></th>

					
					<?php 
						while ($row=mysqli_fetch_array($mesures)){ 
						array_push($idmesures, $row['idmesure']);	
					?>
						
						<th><?php echo $lang[$row['libelle']]; ?></th>
						
					<?php }?>			
				</tr>

				<?php 
					while ($dates=mysqli_fetch_array($query)) {

						echo '<tr>';	
							echo '<td width="100">'.$dates['date_save'].'</td>';	
							foreach ($idmesures as $idmesure) {
								$data = find_valeur($dates['date_save'], $idmesure, $idpersonne);
								check_valeur($data);	

							}
						echo '</tr>';
					}
					?>
				<tr>
					<td colspan=10><span class="pull-right">
					<?php
					 echo paginate($reload, $page, $total_pages, $adjacents);
					?></span></td>
				</tr>
			  </table>
			</div>
			<?php
		}else{

			echo $lang['Aucune donnée enrégistrée!!!'];
		}
	}
?>
<style type="text/css">
	th, td{
		text-align: center;
		display: table-cell;
  		vertical-align: middle;
	}
</style>