<?php

	include('is_logged.php');
	include('is_admin.php');
	/* Connect To Database*/
	require_once ("../config/db.php");
	require_once ("../config/connexion.php");
	
	$action = (isset($_REQUEST['action']) && $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
	if (isset($_GET['id'])){
		$id=intval($_GET['id']);
		$query=mysqli_query($con, "SELECT * from personne where idpersonne='".$id."'");
		$count=mysqli_num_rows($query);
		if ($count>=0){
			if ($delete1=mysqli_query($con,"UPDATE personne set lisible = 0 where idpersonne='".$id."'")){
				$delete2 = mysqli_query($con, "UPDATE patient set lisible = 0 where personne_idpersonne = '".$id."'");
				$delete3 = mysqli_query($con, "UPDATE user set lisible = 0 where personne_idpersonne = '".$id."'");
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
		 $requete = "SELECT * FROM patient INNER JOIN personne ON patient.personne_idpersonne = personne.idpersonne INNER JOIN diabete ON patient.diabete_iddiabete = diabete.iddiabete AND personne.lisible = 1 AND patient.lisible = 1 AND diabete.lisible = 1 ";

		 $req_count = "SELECT count(*) AS numrows FROM patient INNER JOIN personne ON patient.personne_idpersonne = personne.idpersonne INNER JOIN diabete ON patient.diabete_iddiabete = diabete.iddiabete AND personne.lisible = 1 AND patient.lisible = 1 AND diabete.lisible = 1 ";

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
			<div class="table-responsive">
			  <table class="table table-bordered table-hover table-stripped">
				<tr  class="success">
					<th>#</th>
					<th><?php echo $lang['nom'].' '.$lang['et'].' '.$lang['prenom']; ?></th>
					<th><?php echo $lang['sexe']; ?></th>
					<th><?php echo $lang['typeDeDiabete']; ?></th>
					<th><?php echo $lang['poids']; ?>(Kg)</th>
					<th><?php echo $lang['taille']; ?> </th>
					<th><?php echo $lang['imc']; ?> (Kg.m-²)</th>
					<th><?php echo $lang['interpretation']; ?> </th>
					<th><?php echo $lang['dates']; ?> </th>	
					<th><?php echo $lang['actions']; ?> </th>						
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
						
					?>
				<a>	<tr>
						<td><?php echo $n++; ?></td>
						<td><?php echo $nom.' '.$prenom; ?></td>
						<td class="text-center"><?php echo $sexe; ?></td>
						<td><?php echo $type_diabete; ?></td>
						<td class="text-center"><?php echo $poids; ?></td>
						<td class="text-center"><?php echo $taille; ?></td>
						<td class="text-center"><?php echo $imc; ?></td>
						<td class="text-center" <?php if($imc >= 25) echo 'style="color:red;"'; ?>><?php echo $interpretation; ?></td>
						<td class="text-center"><?php echo $date_save;?></td>
						
					<td class='text-right'>
						<!-- bouton pour visualiser -->
						<a href="#" class='btn btn-default' title='Afficher le journal' data-nom='<?php echo $nom;?>' data-prenom='<?php echo $prenom?>' data-datenaiss='<?php echo $datenaiss;?>' data-sexe='<?php echo $sexe;?>' data-adresse='<?php echo $adresse;?>' data-email='<?php echo $email;?>' data-telephone1='<?php echo $telephone1;?>' data-telephone2='<?php echo $telephone2;?>' data-idtype_diabete='<?php echo $idtype_diabete;?>' data-poids='<?php echo $poids;?>' data-taille='<?php echo $taille;?>' data-personne_urgence='<?php echo $personne_urgence;?>' data-telephone_urgence='<?php echo $telephone_urgence;?>' data-idpatient='<?php echo $idpatient;?>' data-idpersonne="<?php echo $idpersonne; ?>" data-toggle="modal" data-target="#myModal3"><i class="fa fa-barcode"></i></a> 

						<!-- bouton pour modifier -->
						<a href="#" class='btn btn-success' title='Editer le patient' data-nom='<?php echo $nom;?>' data-prenom='<?php echo $prenom?>' data-datenaiss='<?php echo $datenaiss;?>' data-sexe='<?php echo $sexe;?>' data-adresse='<?php echo $adresse;?>' data-email='<?php echo $email;?>' data-telephone1='<?php echo $telephone1;?>' data-telephone2='<?php echo $telephone2;?>' data-idtype_diabete='<?php echo $idtype_diabete;?>' data-poids='<?php echo $poids;?>' data-taille='<?php echo $taille;?>' data-personne_urgence='<?php echo $personne_urgence;?>' data-telephone_urgence='<?php echo $telephone_urgence;?>' data-idpatient='<?php echo $idpatient;?>' data-idpersonne="<?php echo $idpersonne; ?>" data-appelant="<?php echo $_SESSION['role']; ?>" data-toggle="modal" data-target="#modal_editer_patient"><i class="fa fa-edit"></i></a> 
						<!-- bouton pour supprimer -->
						<a href="#" class='btn btn-danger' title='Supprimer le patient' onclick="eliminar('<?php echo $idpersonne; ?>')"><i class="fa fa-trash"></i> </a>
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