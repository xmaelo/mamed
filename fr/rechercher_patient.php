<?php

	require_once ('../compo/vendor/autoload.php');
	use \Statickidz\GoogleTranslate;
	include('is_logged.php');
	include('is_admin.php');
	/* Connect To Database*/
	require_once ("../config/db.php");
	require_once ("../config/connexion.php");
	require_once ("../functions.php");
	
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
		$query=mysqli_query($con, "SELECT * from personne where idpersonne='".$id."'");
		$count=mysqli_num_rows($query);
		if ($count>=0){
			if ($delete1=mysqli_query($con,"UPDATE personne set lisible = 0 where idpersonne='".$id."'")){
				$delete2 = mysqli_query($con, "UPDATE patient set lisible = 0 where personne_idpersonne = '".$id."'");
				$delete3 = mysqli_query($con, "UPDATE user set lisible = 0 where personne_idpersonne = '".$id."'");
			?>
				<div class="alert alert-success alert-dismissible" role="alert">
				  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				  <strong><?php echo $lang['info']; ?> !</strong> <?php echo $lang['donneesSuprimer']; ?>.
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
			  <strong><?php echo $lang['error']; ?> !</strong> <?php echo $lang['malTourner']; ?>. 
			</div>
			<?php
		}
		
		
		
	}
	if($action == 'ajax'){
		// escaping, additionally removing everything that could be (html/javascript-) code
            $q = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q'], ENT_QUOTES)));
            $valeur =mysqli_real_escape_string($con,(strip_tags($_REQUEST['select_filtre_autre'], ENT_QUOTES)));
            $champ =mysqli_real_escape_string($con,(strip_tags($_REQUEST['filtre'], ENT_QUOTES)));
            $debut =mysqli_real_escape_string($con,(strip_tags($_REQUEST['date_debut'], ENT_QUOTES)));
            $fin =mysqli_real_escape_string($con,(strip_tags($_REQUEST['date_fin'], ENT_QUOTES)));
            $aColumns = array('nom', 'prenom', 'sexe');
            $sTable = "patient";
            $sWhere = "";
            
                $sWhere = "WHERE (";
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				$sWhere .= $aColumns[$i]." LIKE '%".$q."%' OR ";
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';
                       // var_dump($champ);
                        
		 
                 $query_body =  " INNER JOIN personne ON personne_idpersonne = idpersonne "
                         . " INNER JOIN diabete ON diabete_iddiabete = iddiabete"
                         . " INNER JOIN region ON region_idregion = idregion "
                         . " INNER JOIN departement ON departement_iddepartement = iddepartement "
                         . " INNER JOIN arrondissement ON arrondissement_idarrondissement = idarrondissement "
                         . " AND personne.lisible = 1"
                         . " AND patient.lisible = 1 "
                         . " AND diabete.lisible = 1 "
                         . " AND region.lisible = 1"
                         . " AND departement.lisible = 1"
                         . " AND arrondissement.lisible = 1  ";

		if ( $_GET['q'] != "" )
		{
			/*$sWhere = "WHERE (";
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				$sWhere .= $aColumns[$i]." LIKE '%".$q."%' OR ";
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';*/

			$query_body = $query_body." AND personne.nom LIKE '%".$q."%'";

			//$req_count = $req_count." AND personne.nom LIKE '%".$q."%' OR personne.prenom LIKE '%".$q."%' ";
		} elseif ($valeur){
                    if($champ == 'region' || $champ == 'departement' || $champ == 'arrondissement'){
                        $query_body .=" AND personne.".$champ."_id".$champ."= $valeur";
                    }else{
                        $query_body .=" and $champ ='$valeur'";
                   }                        
                }elseif($debut && $fin and $debut < $fin){
                    
                    $query_body .= " AND date_naissance BETWEEN '$debut' AND '$fin' ";
                }
                
		$query_body.=" order by nom ASC";
                
                //requete mère
                $requete = "SELECT distinct * FROM patient ".$query_body;
                //print_r($requete);
                //comptage du nombre d'occurence
		$req_count = "SELECT COUNT(*) as numrows FROM patient ".$query_body;
                //print_r($req_count);
		include 'pagination.php'; //include pagination file
		//pagination variables
		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
		$per_page = 10; //how much records you want to show
		$adjacents  = 4; //gap between pages after number of adjacents
		$offset = ($page - 1) * $per_page;
		//Count the total number of row in your table*/
		//$req = "SELECT count(*) AS numrows FROM $sTable  $sWhere";
		$count_query   = mysqli_query($con, $req_count);
		$row= mysqli_fetch_array($count_query);
		//var_dump($row);
		$numrows = $row['numrows'];
		$total_pages = ceil($numrows/$per_page);
		$reload = './patients.php';
		//main query to fetch the data
		//$sql="SELECT * FROM  $sTable $sWhere LIMIT $offset,$per_page";
		$sql = $requete;//." LIMIT $offset, $per_page";
		//print_r($sql);
		$querys='';
		$query = mysqli_query($con, $sql);
		$querys = mysqli_query($con, $sql);
		//loop through fetched data
		if ($numrows>0){
			 
				# code...
			// $row=mysqli_fetch_all($query, MYSQLI_ASSOC);
			// for ($i=0; $i < 10; $i++) {
			// $rows=$row[$i];
			// var_dump($rows['nom_contact_urgence']);
			
			// }
			// $rowd=mysqli_fetch_all($querys);
			// var_dump($rowd);
			// die();
			?>
<div class="table-responsive" style="width:100">
            <table class="table table-condensed">
				<tr  class="success">
					<th>#</th>
					<th><?php echo $lang['nom'].' '.$lang['et'].' '.$lang['prenom']; ?></th>
					<th><?php echo $lang['sexe']; ?></th>
                                        <th><?php echo $lang['typeDeDiabete']; ?></th>
					<th><?php echo $lang['poids']; ?>(Kg)</th>
					<th><?php echo $lang['taille']; ?> </th>
					<th><?php echo $lang['imc']; ?> (Kg.m-²)</th>
					<th><?php echo $lang['interpretation']; ?> </th>
					<th><?php echo $lang['inscription']; ?></th>
                                        <th><?php echo $lang['region']; ?> </th>
                                        <th><?php echo $lang['departement']; ?> </th>
                                        <th><?php echo $lang['arrondissement']; ?></th>
					<th><?php echo $lang['actions']; ?> </th>					
				</tr> 
				<?php $n = 1;
					  $m=0;
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
						$chemin=$row['chemin'];

						
					?>
				<a>	<tr>
						<td><?php echo $n++; ?></td>
						<td width="50"><?php echo $nom.' '.$prenom; ?></td>
						<td class="text-center"><?php echo $lang[get_sexe($sexe)]; ?></td>
						<td class="text-center">

							<?php 

							

								// $source = 'fr';
								// $target = $lang['lang'];
								// $text = $type_diabete;

								// $trans = new GoogleTranslate();
								// $result = $trans->translate($source, $target, $text);

								echo $lang[$type_diabete];

							 ?>								
						</td>
						<td class="text-center"><?php echo $poids; ?></td>
						<td class="text-center"><?php echo $taille; ?></td>
						<td class="text-center"><?php echo $imc; ?></td>
						<td class="text-center" <?php if($imc >= 25) echo 'style="color:red;"'; ?>><?php 
						echo $lang[$interpretation]; ?>
							
						</td>
						<td class="text-center"><?php echo $date_save;?></td>
                                                <td class="text-center"><?php echo $row['region'];?></td>
                                                <td class="text-center"><?php echo $row['departement'];?></td>
                                                <td class="text-center"><?php echo $row['arrondissement'];?></td> 
						
					<td class='text-right'>
                <div class="btn-group-md">

						<!-- bouton pour visualiser -->
						<a href="dossier_patient.php?idpersonne=<?php echo $idpersonne; ?>&catrine=dulciné" class='btn btn-default' title='Afficher le journal'><i class="fa fa-barcode"></i></a> 

						<!-- bouton pour modifier -->
						<a href="#" class='btn btn-success' title='Editer le patient' data-nom='<?php echo $nom;?>' data-prenom='<?php echo $prenom?>' data-datenaiss='<?php echo $datenaiss;?>' data-sexe='<?php echo $sexe;?>' data-adresse='<?php echo $adresse;?>' data-email='<?php echo $email;?>' data-telephone1='<?php echo $telephone1;?>' data-telephone2='<?php echo $telephone2;?>' data-idtype_diabete='<?php echo $idtype_diabete;?>' data-poids='<?php echo $poids;?>' data-taille='<?php echo $taille;?>' data-personne_urgence='<?php echo $personne_urgence;?>' data-telephone_urgence='<?php echo $telephone_urgence;?>' data-chemin="<?php echo $chemin; ?>" data-idpatient='<?php echo $idpatient;?>' data-idpersonne="<?php echo $idpersonne; ?>" data-appelant="<?php echo $_SESSION['role']; ?>" data-toggle="modal" data-target="#modal_editer_patient"><i class="fa fa-edit"></i></a> 
						<!-- bouton pour supprimer -->
						<a href="#" class='btn btn-danger' title='Supprimer le patient' onclick="elimina('<?php echo $idpersonne; ?>')"><i class="fa fa-trash"></i> </a>
</div>					
</td>
						
					</tr>
					<?php
				$m++;
				
				}
				?>
				<tr>
					<td colspan=13><span class="pull-right">
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



