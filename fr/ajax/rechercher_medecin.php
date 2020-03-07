<?php

	require_once ('../compo/vendor/autoload.php');
	use \Statickidz\GoogleTranslate;

	include('is_logged.php');
	include('is_admin.php');
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


	
	$action = (isset($_REQUEST['action']) && $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
	if (isset($_GET['id'])){
		$id=intval($_GET['id']);
		$query=mysqli_query($con, "SELECT * from personne where idpersonne='".$id."'");
		$count=mysqli_num_rows($query);
		if ($count>=0){
			if ($delete1=mysqli_query($con,"UPDATE personne set lisible = 0 where idpersonne='".$id."'")){
				$delete2 = mysqli_query($con, "UPDATE medecin set lisible = 0 where personne_idpersonne = '".$id."'");
				$delete3 = mysqli_query($con, "UPDATE user set lisible = 0 where personne_idpersonne = '".$id."'");
			?>
				<div class="alert alert-success alert-dismissible" role="alert">
				  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				  <strong><?php echo $lang['info']; ?> !</strong><?php echo $lang['donneesSuprimer']; ?>.
				</div>
			<?php 
			}else {
			?>
				<div class="alert alert-danger alert-dismissible" role="alert">
				  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				  <strong><?php echo $lang['error']; ?> !</strong> <?php echo $lang['desolerquelchose']; ?>.
				</div>
			<?php			
			}
			
		} else {
			?>
			<div class="alert alert-danger alert-dismissible" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong><?php echo $lang['error']; ?> !</strong><?php echo $lang['malTournerMed']; ?> . 
			</div>
			<?php
		}
		
		
		
	}
	if($action == 'ajax'){
		// escaping, additionally removing everything that could be (html/javascript-) code
         $q = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q'], ENT_QUOTES)));
		// $aColumns = array('nom_contact_urgence');//Recherche les colonnes
		// $sTable = "medecin";
		// $sWhere = " WHERE lisible = 1";
		 $requete = "SELECT distinct * FROM medecin INNER JOIN personne ON medecin.personne_idpersonne = personne.idpersonne INNER JOIN specialite ON medecin.specialite_idspecialite = specialite.idspecialite AND personne.lisible = 1 AND medecin.lisible = 1 AND specialite.lisible = 1 ";

		 $req_count = "SELECT count(*) AS numrows FROM medecin INNER JOIN personne ON medecin.personne_idpersonne = personne.idpersonne INNER JOIN specialite ON medecin.specialite_idspecialite = specialite.idspecialite AND personne.lisible = 1 AND medecin.lisible = 1 AND specialite.lisible = 1 ";

		if ( $_GET['q'] != "" )
		{
			/*$sWhere = "WHERE (";
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				$sWhere .= $aColumns[$i]." LIKE '%".$q."%' OR ";
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';*/

			$requete = $requete." AND personne.nom LIKE '%".$q."%'";

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
			
			// var_dump(mysqli_fetch_array($query));
			// die();
			?>
			<div class="table-responsive">
			  <table class="table">
				<tr  class="success">
					<th>#</th>
					<th><?php echo $lang['nom'].' '.$lang['et'].' '.$lang['prenom']; ?></th>
					<th><?php echo $lang['sexe']; ?></th>
					<th><?php echo $lang['specialite']; ?></th>
					<th><?php echo $lang['ancien']; ?></th>					
					<th><?php echo $lang['dates']; ?></th>
					<th><?php echo $lang['actions']; ?></th>					
				</tr>
				<?php $n = 1;
				while ($row=mysqli_fetch_array($query)){
						$idmedecin=$row['idmedecin'];
						$nom=$row['nom'];
						$prenom = $row['prenom'];
						$specialite=$row['libelle'];
						$anciennete=$row['anciennete'];
						$datenaiss = date('d/m/Y', strtotime($row['datenaiss']));
						$sexe = $row['sexe'];						
						$idspecialite = $row['idspecialite'];
						$telephone1 = $row['telephone1'];
						$telephone2 = $row['telephone2'];
						$email = $row['email'];
						$adresse = $row['adresse'];
						$idpersonne = $row['idpersonne'];
						$date_save= date('d/m/Y', strtotime($row['date_save']));
						
					?>
				<a>	<tr>
						<td><?php echo $n++; ?></td>
						<td class="text-center"><?php echo $nom.' '.$prenom; ?></td>
						<td class="text-center"><?php echo $lang[get_sexe($sexe)]; ?></td>
						<td class="text-center">



							<?php 

							

								// $source = 'fr';
								// $target = $lang['lang'];
								// $text = $specialite;

								// $trans = new GoogleTranslate();
								// $result = $trans->translate($source, $target, $text);

								echo $lang[$specialite];

							 ?>		
							  
								
						</td>
						<td class="text-center"><?php echo $anciennete.' ans'; ?></td>
						<td class="text-center"><?php echo $date_save;?></td>
						
					<td class='text-right'>
						<!-- bouton pour visualiser -->
						<a href="#" class='btn btn-default' title='Détails' data-nom='<?php echo $nom;?>' data-prenom='<?php echo $prenom?>' data-datenaiss='<?php echo $datenaiss;?>' data-sexe='<?php echo $sexe;?>' data-adresse='<?php echo $adresse;?>' data-email='<?php echo $email;?>' data-telephone1='<?php echo $telephone1;?>' data-telephone2='<?php echo $telephone2;?>' data-idspecialite='<?php echo $idspecialite;?>' data-anciennete='<?php echo $anciennete;?>' data-idmedecin='<?php echo $idmedecin;?>' data-idpersonne="<?php echo $idpersonne; ?>" data-toggle="modal" data-target="#myModal3"><i class="fa fa-barcode"></i></a> 

						<!-- bouton pour modifier -->
						<a href="#" class='btn btn-success' title='Editer le medécin' data-nom='<?php echo $nom;?>' data-prenom='<?php echo $prenom?>' data-datenaiss='<?php echo $datenaiss;?>' data-sexe='<?php echo $sexe;?>' data-adresse='<?php echo $adresse;?>' data-email='<?php echo $email;?>' data-telephone1='<?php echo $telephone1;?>' data-telephone2='<?php echo $telephone2;?>' data-idspecialite='<?php echo $idspecialite;?>' data-anciennete='<?php echo $anciennete;?>' data-idmedecin='<?php echo $idmedecin;?>' data-idpersonne="<?php echo $idpersonne; ?>" data-toggle="modal" data-target="#myModal2"><i class="fa fa-edit"></i></a> 
						<!-- bouton pour supprimer -->
						<a href="#" class='btn btn-danger' title='Supprimer le medecin' onclick="eliminar('<?php echo $idpersonne; ?>')"><i class="fa fa-trash"></i> </a>
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