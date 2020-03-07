<?php



require_once __DIR__ . '/mpdf/vendor/autoload.php';
use Spipu\Html2Pdf\Html2Pdf;
	
	/* Connect To Database*/
				session_start();
				$idpersonne=$_SESSION['idpersonne'];

				function catrine() {

					global $idpersonne;
					require_once ("config/db.php");
					require ("config/connexion.php");
					require_once ("functions.php");

					
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

					$pa="moiii";
					$data = $pa;
					$data .=$nom;
					$data .=$prenom;
					$data .=$email;
					$data .=$adresse;
					$data .=$telephone1;
					// var_dump($data);
					// die();

					return $data;

		

					}

				$html = catrine();
				// var_dump(catrine());
				// die();
	

			

			$mpdf = new \Mpdf\Mpdf();
			$mpdf->WriteHTML($html);
			$mpdf->Output();
 ?>
