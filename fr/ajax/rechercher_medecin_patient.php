<?php

	include('is_logged.php');
	include('is_medecin.php');

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
 
       
	$action = (isset($_REQUEST['action']) && $_REQUEST['action'] != NULL)?$_REQUEST['action']:'';
	if (isset($_GET['id'])){
		$id=intval($_GET['id']);
		$query=mysqli_query($con, "SELECT * from patient where idpatient='".$id."'");
		$count=mysqli_num_rows($query);
		if ($count>=0){
			if ($delete1=mysqli_query($con,"DELETE FROM patient_has_medecin WHERE patient_idpatient ='".$id."'")){
				
			?>
				<div class="alert alert-success alert-dismissible" role="alert">
				  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				  <strong><?php echo $lang['info'] ?> !</strong> <?php echo $lang['voulezVousArretezDeSuivre']; ?>
				</div>
			<?php 
			}else {
			?>
				<div class="alert alert-danger alert-dismissible" role="alert">
				  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				  <strong><?php echo $lang['error'] ?> !</strong> <?php echo $lang['desolerPatient']; ?>
				</div>
			<?php			
			}
			
		} else {
			?>
			<div class="alert alert-danger alert-dismissible" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong><?php echo $lang['error'] ?> !</strong> <?php echo $lang['impossib']; ?> 
			</div>
			<?php
		}
		
		
		
	}
	if($action == 'ajax'){
		// escaping, additionally removing everything that could be (html/javascript-) code
		//echo $_SESSION['idpersonne'];
         $q = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q'], ENT_QUOTES)));
		$medecin = get_personne($_SESSION['idpersonne'], 'medecin');
		//var_dump($medecin);
		$idmedecin = $medecin['idmedecin'];
		 $requete = "SELECT * FROM patient_has_medecin 
		 		INNER JOIN patient ON patient_idpatient = patient.idpatient		 		
		 		INNER JOIN personne ON patient.personne_idpersonne = personne.idpersonne 
		 		INNER JOIN diabete ON patient.diabete_iddiabete = diabete.iddiabete 
		 		AND personne.lisible = 1 
		 		AND patient.lisible = 1 
		 		AND diabete.lisible = 1 
		 		AND patient_has_medecin.medecin_idmedecin = $idmedecin ";

		 $req_count = "SELECT count(*) AS numrows FROM patient_has_medecin 
		 		INNER JOIN patient ON patient_idpatient = patient.idpatient		 		
		 		INNER JOIN personne ON patient.personne_idpersonne = personne.idpersonne 
		 		INNER JOIN diabete ON patient.diabete_iddiabete = diabete.iddiabete 
		 		AND personne.lisible = 1 
		 		AND patient.lisible = 1 
		 		AND diabete.lisible = 1 
		 		AND patient_has_medecin.medecin_idmedecin = $idmedecin ";

		if ( $_GET['q'] != "" )
		{
			/*$sWhere = "WHERE (";
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				$sWhere .= $aColumns[$i]." LIKE '%".$q."%' OR ";
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';*/

			$requete = $requete." AND personne.nom LIKE '%".$q."%' OR personne.prenom LIKE '%".$q."%' ";

			$req_count = $req_count." AND personne.nom LIKE '%".$q."%' OR personne.prenom LIKE '%".$q."%' ";
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
		$reload = './clientes.php';
		//main query to fetch the data
		//$sql="SELECT * FROM  $sTable $sWhere LIMIT $offset,$per_page";
		$sql = $requete." ORDER BY personne.nom LIMIT $offset,$per_page";
		//var_dump($sql);
		$query = mysqli_query($con, $sql);
		//loop through fetched data
		if ($numrows>0){
			
			?>
			<div class="table-responsive">
			  <table class="table">
				<tr  class="success">
					<th>#</th>
					<th><?php echo $lang['nom']; ?> et <?php echo $lang['prenom']; ?></th>
					<th><?php echo $lang['sexe']; ?></th>
					<th><?php echo $lang['typeDeDiabete']; ?></th>
					<th><?php echo $lang['poids']; ?>(Kg)</th>
					<th><?php echo $lang['taille']; ?>(cm)</th>
					<th>IMC(Kg.m-²)</th>
					<th><?php echo $lang['interpretation']; ?></th>
					<th><?php echo $lang['dates']; ?></th>
					<th><?php echo $lang['actions']; ?></th>					
				</tr>
				<?php $n = 1;
				while ($row=mysqli_fetch_array($query)){
						$idpatient=$row['idpatient'];
						$nom=$row['nom'];
						$prenom = $row['prenom'];
						$type_diabete=$row['type'];
						$poids=$row['poids'];
						$taille=$row['taille'];
						$imc = $row['imc'];
						$interpretation = $row['interpretation'];
						$datenaiss = $row['datenaiss'];
						$datenaiss = date('d/m/Y', strtotime($row['datenaiss']));
						$sexe = $row['sexe'];
						$personne_urgence = $row['nom_contact_urgence'];
						$telephone_urgence = $row['telephone_contact_urgence'];
						$idtype_diabete = $row['iddiabete'];
						$telephone1 = $row['telephone1'];
						$telephone2 = $row['telephone2'];
						$email = $row['email'];
						$adresse = $row['adresse'];
						$idpersonne = $row['idpersonne'];
						$date_save= date('d/m/Y', strtotime($row['date_save']));
						$approbation = $row['approbation'];
						
					?>
				<a>	<tr>
						<td><?php echo $n++; ?></td>
						<td><?php echo $nom.' '.$prenom; ?></td>
						<td class="text-center"><?php echo $sexe; ?></td>
						<td><?php echo $type_diabete; ?></td>
						<td class="text-center"><?php echo $poids; ?></td>
						<td class="text-center"><?php echo $taille; ?></td>
						<td class="text-center"><?php echo $imc; ?></td>
						<td class="text-center" <?php if($imc >= 25) echo 'style="color:red;"'; ?>>



							<?php echo  $lang [$interpretation]; ?></td>
						<td class="text-center"><?php echo $date_save;?></td>
						
					<td class='text-center'>
						<!-- bouton pour visualiser -->
						<?php 

							if($approbation){
						?>		
								<a href="dossier_patient.php?idpersonne=<?php echo $idpersonne; ?>" class='btn btn-info'  title='Afficher le journal'><i class="fa fa-folder-open"></i></a>
						
								<a href="#" class='btn btn-warning' title='Arrêter de suivre' onclick="arreter_suivre('<?php echo $idpatient; ?>')"><i class="fa fa-remove"></i> </a>

						<?php
							}else{
						?>			
								<span style="color: blue;"><?php echo $lang['enAttenteApprobation']; ?></span>
						<?php		
							}
						 ?>
						
					</td>
						
					</tr>
					<?php
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
		}
	}
?>
<style type="text/css">
	th{
		text-align: center;
	}
</style>