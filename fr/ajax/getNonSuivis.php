<?php

	include('is_logged.php');
	/* Connect To Database*/
	//include('is_logged.php');
	include('is_admin.php');
	/* Connect To Database*/
	require_once ("../config/db.php");
	require_once ("../config/connexion.php");
	require_once ("../functions.php");
	 include 'pagination.php'; 

	  if(isset($_SESSION['lang'])){
      $lage='langues/'.$_SESSION['lang'].'.php';
      
      require_once ('../'.$lage);
      }
      else{
        $_SESSION['lang']='Fr';
         $lage='langues/'.$_SESSION['lang'].'.php';
      
      require_once ('../'.$lage);
      }

          $query = 			"SELECT distinct * from personne, patient_has_medecin, patient
							 where patient_has_medecin.approbation = 1
							 and patient.lisible=1
							 and patient.idpatient = patient_has_medecin.patient_idpatient
							 and personne.idpersonne = patient.personne_idpersonne";
         
    	// if(isset($_GET['q'])) {
    	// 	$q = $_GET['q'];
    	// 	$query = $query." AND personne.nom LIKE '%".$q."%'";
    	// }

    	

    $execute1 = mysqli_query($con, $query);

    $chaine = '7777777711111111111';

    while ($row=mysqli_fetch_array($execute1)){


    	$chaine .= ','.$row['patient_idpatient'];

    }
   


    $query2 =      " SELECT distinct * from personne, patient 
    					where  patient.personne_idpersonne = personne.idpersonne
    					and  patient.idpatient not in ($chaine)
    					and patient.lisible = 1"; 
    $query21 =      " SELECT count(*) as numrows from personne, patient 
    					where  patient.personne_idpersonne = personne.idpersonne
    					and  patient.idpatient not in ($chaine)
    					and patient.lisible = 1";

   	if(isset($_GET['q'])) {
    		$q = $_GET['q'];
    		$query2 = $query2." AND personne.nom LIKE '%".$q."%'";
    		$query21 = $query21." AND personne.nom LIKE '%".$q."%'";
    	}

    	$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
		$per_page = 10; //how much records you want to show
		$adjacents  = 4; //gap between pages after number of adjacents
		$offset = ($page - 1) * $per_page;


		$count_query = mysqli_query($con, $query21);

		$row = mysqli_fetch_array($count_query);

		//var_dump($rows);

		//$numrows=10;

		

		//$reload = './clientes.php';

		if ($row) {
			$numrows = $row['numrows'];
			$total_pages = ceil($numrows/$per_page);
			$reload = './clientes.php';
			
		}


	$query2 = $query2." ORDER BY personne.nom LIMIT $offset,$per_page";
    $execute = mysqli_query($con,$query2);

   // $execute = mysqli_fetch_array($execute2);

    //var_dump($execute3);

    //die();


    //$data = mysqli_fetch_array($execute);

 	//$numrows=10;

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
					<th class="text-center"><?php echo $lang['nom'].' '.$lang['et'].' '.$lang['prenom']; ?></th>
					<th class="text-center"><?php echo $lang['sexe']; ?></th>
                                        
					<th class="text-center"><?php echo $lang['poids']; ?>(Kg)</th>
					<th class="text-center"><?php echo $lang['taille']; ?> </th>
					<th class="text-center"><?php echo $lang['imc']; ?> (Kg.m-²)</th>
					<th class="text-center"><?php echo $lang['interpretation']; ?> </th>
					<!-- // <th><?php echo $lang['inscription']; ?></th> -->
					<th class="text-center"><?php echo $lang['dateAjout'] ?></th>

                                        				 
				</tr> 
				<?php $n = 1;
					  $m=0;
				while ($row=mysqli_fetch_array($execute)){
						$idpatient=$row['idpatient']; 
						$nom=$row['nom'];
						$prenom = $row['prenom'];
						//$type_diabete=$row['type'];
						$poids=$row['poids'];
						$taille=$row['taille'];
						$imc = $row['imc'];
						$interpretation = $row['interpretation'];
						$datenaiss = $row['datenaiss'];
						$datenaiss = date('d/m/Y', strtotime($row['datenaiss']));
						$sexe = $row['sexe'];
						$personne_urgence = $row['nom_contact_urgence'];
						$telephone_urgence = $row['telephone_contact_urgence'];
						//$idtype_diabete = $row['iddiabete'];
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
						<td class="text-center"><?php echo $poids; ?></td>
						<td class="text-center"><?php echo $taille; ?></td>
						<td class="text-center"><?php echo $imc; ?></td>
						<td class="text-center" <?php if($imc >= 25) echo 'style="color:red;"'; ?>><?php 
						echo $lang[$interpretation]; ?>
							
						</td>
						<td class="text-center"><?php echo $date_save;?></td>
                                             
                <div class="btn-group-md">

								
			</div>					
			
						
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