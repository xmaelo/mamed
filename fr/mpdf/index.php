
<?php 

require __DIR__.'/vendor/autoload.php';

use Spipu\Html2Pdf\Html2Pdf;

require_once ('../compo/vendor/autoload.php');
use \Statickidz\GoogleTranslate;


ob_start();
?>

<?php 
			session_start();
				$idpersonne=$_SESSION['idpersonne'];


				 if(isset($_SESSION['lang'])){
			      $lage='langues/'.$_SESSION['lang'].'.php';
			      
			      require_once ('../'.$lage);
			      }
			      else{
			        $_SESSION['lang']='Fr';
			         $lage='langues/'.$_SESSION['lang'].'.php';
			      
			      require_once ('../'.$lage);
			      }


					require_once ("../config/db.php");
					require ("../config/connexion.php");
					require_once ("../functions.php");



						/*
							Catrine la fonction qui cheque les valeurs
						*/

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

						/*
							EndOfCatrine
						*/
					
							//$id=intval($_GET['id']);
					$queryt = "SELECT * from clinique where 1";

						  $getData = mysqli_query($con, $queryt);

						  $result = mysqli_fetch_array($getData);

						  $logo = $result['logo'];


						  $nom_clinique = $result['nom_clinique'];
						  //$email = $result['email'];
						  $telephone = $result['telephone'];
						  $site_web = $result['site_web'];
						  $info_suplementaire = $result['info_suprementaire'];



					$photo= mysqli_query($con, "SELECT * FROM personne WHERE idpersonne=$idpersonne");
					$phto=mysqli_fetch_array($photo);

					$phot=$phto['chemin'];
					$nom=$phto['nom'];
					$prenom=$phto['prenom'];
					$email=$phto['email'];
					$adresse=$phto['adresse'];
					$telephone1=$phto['telephone1'];
					$telephone2=$phto['telephone2'];
					// $email=$phto['email'];
					$sexe=$phto['sexe'];
					$datenaiss=$phto['datenaiss'];
					$data="<br><br>".$lang['entete'];
					$pa="<img src='../".$phot."'width='200' height='200'/>";

					///patient getInfos

					$catrine= mysqli_query($con, "SELECT * FROM patient WHERE personne_idpersonne=$idpersonne");
					$cat=mysqli_fetch_array($catrine);
					$poids=$cat['poids'];
					$taille=$cat['taille'];
					$imc=$cat['imc'];
					$interpretation=$cat['interpretation'];
					$nom_contact_urgence=$cat['nom_contact_urgence'];
					$telephone_contact_urgence=$cat['telephone_contact_urgence'];
					$id = $cat['diabete_iddiabete'];

					$diabete = mysqli_query($con, "SELECT * FROM diabete WHERE iddiabete=$id");
					$typeD = mysqli_fetch_array($diabete);
					$type=$typeD['type'];
					$description=$typeD['description'];

					/*
						Recherche du contenu d'impression catrine*********
					*/


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

						$requete = "SELECT DISTINCT journal.date_save as date_save FROM journal
						INNER JOIN patient ON journal.patient_idpatient = patient.idpatient
		 				INNER JOIN personne ON patient.personne_idpersonne = personne.idpersonne
		 				AND patient.lisible = 1
		 				AND personne.lisible = 1
		 				AND journal.lisible = 1
		 				AND idpersonne = '$idpersonne'";

		 				$sql = $requete." ORDER BY journal.date_save DESC";
		 				$query = mysqli_query($con, $sql);

		 				
						// var_dump($query);
						// die();

		




 ?>
					<style type="text/css">
						table { width:100%; }
						.table
							{
							    border-collapse: collapse; /* Les bordures du tableau seront collées (plus joli) */
							}
						.td
							{
							    border: 1px solid black;
							   
							}
						.t
							{
							    
							    background-color:rgb(195, 195, 195);
							    text-decoration: white;
							}
					</style>

 										
					<page backtop="10mm" backleft="5mm" backright="5mm"> 
						<!-- <div style="margin-left: 600px; width: 150px;height: 50px">
							<img src="../img/1vgB.jpeg" width='80' height='80'>
					    <p style="margin-right: 60px">info@mamed.care</p> -->
					    <!-- </div> -->

					    <div style="margin-top: -30px;text-align: center">
							<img src="../<?php if(!$logo==NULL) { '../img/Zy29.jpg'; } else { echo '../img/logo-maMED.jpeg'; } ?>" width='80' height='80' float="right">
					    </div>
					    <p style="text-align: center;"><?php 
						    if ($telephone) {echo $telephone; } 
						    if ($site_web) { echo ' / '.$site_web;} 
					    ?></p>

					    <div style="margin-top: -45px">
						<p style="text-align: center;"><?php echo $data; if ($nom_clinique)
						{ echo " / ".$nom_clinique;}?><hr><br></p>
						<table>
							<tr>
								<td></td>
								
							</tr>
							<tr>
								<td rowspan=0 style="width: 35%"><?php echo $pa; ?></td>
								<td style="width:30%"> <h4><?php echo $nom; ?> <?php echo $prenom; ?><hr></h4>									
									<b><?php echo $lang['sexe']; ?>:</b> 
									<?php 

												// $source = 'fr';
												// $target = $lang['lang'];
												// $text = get_sexe($sexe);

												// $trans = new GoogleTranslate();
												// $result = $trans->translate($source, $target, $text);

												echo $lang[get_sexe($sexe)];

									?>
									<br>
									<b><?php echo $lang["email"]; ?>:</b> <?php echo $email; ?>
									<br>
									<b><?php echo $lang["dateDdeNaissance"]; ?>:</b> <?php echo $datenaiss;  ?>
									<br>
									<b><?php echo $lang["addresse"]; ?></b>: <?php echo $adresse; ?>
									<br>
									<b><?php echo $lang["tel"]; ?>:</b> <?php echo $telephone1; ?>
									<br>
									<b><?php echo $lang["tel2"]; ?>:</b> <?php echo $telephone2; ?>
								</td>

								<td style="height: 220px;">
									<br>
									<br><br><br>
		                       
									<b><?php echo $lang["typeDeDiabete"]; ?>:</b> 

									<?php 

												// $source = 'fr';
												// $target = $lang['lang'];
												// $text = $type;

												// $trans = new GoogleTranslate();
												// $result = $trans->translate($source, $target, $text);

												echo $lang[$type];


									


									?>
									<br>
									<b><?php echo $lang["taille"]; ?>: </b><?php echo $taille; ?> cm
									<br>
									<b><?php echo $lang["poids"]; ?>: </b><?php echo $poids; ?>
									<br>
									<b>IMC:</b> <?php echo $imc; ?>
									<br>
									<b><?php echo $lang["interpretation"]; ?>:</b> 
									<?php 

												// $source = 'fr';
												// $target = $lang['lang'];
												// $text = $interpretation;

												// $trans = new GoogleTranslate();
												// $result = $trans->translate($source, $target, $text);

												echo $lang[$interpretation];
										
									?>
									<br>
									<b><?php echo $lang["urgence"]; ?>:</b> <?php echo $nom_contact_urgence; ?>
									<br>
									<b><?php echo $lang["telUrgence"]; ?>:</b> <?php echo $telephone_contact_urgence; ?>


									
								</td>

							</tr>
						</table>
						<br><br><br>
						<table class="table">

						<tr>
							<td class="td t" style="width: 12%"><?php echo $lang['dates']; ?></td>
							<?php 
								while ($row=mysqli_fetch_array($mesures)){ 
								array_push($idmesures, $row['idmesure']);	
							?>
								
								<td class="td t" style="width: 11%"><?php echo $lang[$row['libelle']]; ?></td>
								
							<?php }?>				
						</tr>

						<?php 
							while ($dates=mysqli_fetch_array($query)) {

								echo '<tr>';	
									echo '<td style="height: 25px" class="td">'.$dates['date_save'].'</td> <br>';	

									foreach ($idmesures as $idmesure) {
										$dataa = find_valeur($dates['date_save'], $idmesure, $idpersonne);

										echo '<td  class="td">'.$dataa.'</td> <br>';
										//check_valeur($data);	

									}
								echo '</tr>';
							}
							?>
						
					</table>
				</div>

					  <page_footer> 
     					<p style="text-align: center"><?php echo $lang['developperPar']; ?> <b>KTC-CENTER:</b> <a href="#"><i>https://kamer-center.net/</i>
</a> </p>

   					 </page_footer>

					</page>


		
<?php

$content=ob_get_clean();
					
					

				

				$html2pdf = new Html2Pdf();
				$html2pdf->writeHTML($content);
				ob_end_clean();
				$html2pdf->output('doc.pdf');
 ?>
