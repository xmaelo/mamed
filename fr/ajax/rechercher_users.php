<?php

require_once ('../compo/vendor/autoload.php');
	use \Statickidz\GoogleTranslate;
	include('is_logged.php');
	include('is_admin.php');
	/* Connect To Database*/
	require_once ("../config/db.php");
	require_once ("../config/connexion.php");



      if(isset($_SESSION['lang'])){
      $lage='langues/'.$_SESSION['lang'].'.php';
      
      require_once ('../'.$lage);
      }
      else{
        $_SESSION['lang']='Fr';
         $lage='langues/'.$_SESSION['lang'].'.php';
      
      require_once ('../'.$lage);
      }
 
	
	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
	if (isset($_GET['id'])){
		$idusers=intval($_GET['id']);
		$query=mysqli_query($con, "select * from users where idusers='".$idusers."'");
		$rw_user=mysqli_fetch_array($query);
		$count=$rw_user['idusers'];
		if ($idusers!=1){
			if ($delete1=mysqli_query($con,"DELETE FROM users WHERE idusers='".$idusers."'")){
			?>
			<div class="alert alert-success alert-dismissible" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong><?php echo $lang['info'] ?> !</strong><?php echo $lang['donneesSuprimer'] ?>  
			</div>
			<?php 
		}else {
			?>
			<div class="alert alert-danger alert-dismissible" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong><?php echo $lang['info'] ?></strong><?php echo $lang['desolerPatient'] ?>.
			</div>
			<?php
			
		}
			 
		} else {
			?>
			<div class="alert alert-danger alert-dismissible" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong><?php echo $lang['info'] ?></strong> <?php echo $lang['impossibleKim'] ?>.	
			</div>
			<?php
		}
		
		
		
	}
	if($action == 'ajax'){
		// escaping, additionally removing everything that could be (html/javascript-) code
         $q = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q'], ENT_QUOTES)));
		
		 $requete = "SELECT * FROM users INNER JOIN personne ON users.personne_idpersonne = personne.idpersonne AND users.lisible = 1 AND personne.lisible = 1";

		 $req_count = "SELECT count(*) AS numrows FROM users INNER JOIN personne ON users.personne_idpersonne = personne.idpersonne AND users.lisible = 1 AND personne.lisible = 1";

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

			$req_count = $req_count." AND personne.nom LIKE '%".$q."%'";
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
					<th>ID</th>
					<th><?php echo $lang['nom'].' '.$lang['et'].' '.$lang['prenom']; ?></th>
					<th><?php echo $lang['login'] ?></th>
					<th><?php echo $lang['role'] ?></th>
					<th><?php echo $lang['dateAjout'] ?></th>
					<th><span class="pull-right"><?php echo $lang['actions']; ?></span></th>
					
				</tr>
				<?php
				$n=1;
				while ($row=mysqli_fetch_array($query)){
						$idusers=$row['idusers'];
						$idpersonne = $row['idpersonne'];
						$noms=$row['nom'].' '.$row['prenom'];
						$login=$row['login'];
						$role = $row['role'];
						$date_save= date('d/m/Y', strtotime($row['date_save']));
						
					?>
					
					<input type="hidden" value="<?php echo $login;?>" id="old_email<?php echo $idusers; ?>">
					<!--<input type="hidden" value="<?php echo $idusers;?>" id="idusers_editer">-->
					<input type="hidden" value="<?php echo $idpersonne;?>" id="idpersonne<?php echo $idusers; ?>">
				
					<tr>
						<td><?php echo $n++; ?></td>
						<td><?php echo $noms; ?></td>
						<td ><?php echo $login; ?></td>
                        <td>

                        	<?php 

							

								// $source = 'fr';
								// $target = $lang['lang'];
								// $text = strtolower($role);

								// $trans = new GoogleTranslate();
								// $result = $trans->translate($source, $target, $text);

								echo $lang[$role];

							 ?>		




                        	
						<td><?php echo $date_save;?></td>
						
					<td ><span class="pull-right">
					<a href="#" class='btn btn-success' title='Modifier cet utilisateur' onclick="obtenir_data('<?php echo $idusers;?>');" data-toggle="modal" data-target="#myModal2"><i class="fa fa-edit"></i></a> 
					<a href="#" class='btn btn-warning' title='Modifier le mot de passe' onclick="get_user_id('<?php echo $idusers;?>');" data-toggle="modal" data-target="#myModal3"><i class="glyphicon glyphicon-cog"></i></a>

					<a <?php if($role == "Administrateur") echo 'onclick="catrineJs()"'; ?> disabled="disabled" href="#" class='btn btn-danger' title="Supprimer l'utilisateur" onclick="eliminar('<? echo $idusers; ?>')"><i class="fa fa-trash"></i> </a></span></td>
						
					</tr>
					<?php
				}
				?>
				<tr>
					<td colspan=9><span class="pull-right">
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
<script type="text/javascript">
	function catrineJs() {
		return e.preventDefault();
	}
</script>