<?php 

include('is_logged.php');
	/* Connect To Database*/
require_once ("config/db.php");
require_once ("config/connexion.php");
require_once ("functions.php");


// var_dump($pdo);
// die();

	$ajax1 = $pdo->query('SELECT * FROM patient, personne WHERE patient.personne_idpersonne = personne.idpersonne');

		/*selectElementFromPatientToCompare*/
			$elle = mysqli_query($con, "SELECT * from patient WHERE personne_idpersonne = $idpersonne");

			$get = mysqli_fetch_array($elle);

			$value =  $get['activeRepas'];

		/*endOfSelect*/

	//$execut = $ajax1->execute();

	$all=$ajax1->fetchAll(PDO::FETCH_OBJ);
//echo date('H:i:s');

	foreach( $all as $heure) {

		$timebase = $heure->heures;//.'<br>              ';
		// echo getType($timebase);
		// $date =explode(':', date('H:i:s'));
		$dates =explode(':', date('H:i:s'));
		// echo $heurePresen=$date[0].':'.$date[1].':00';
		// echo getType($heurePresen);
		$heurePresent=$dates[0].':'.$dates[1].':00';
		// $heurePresentt='12:00:00<br>';
		
		// $timebase='12:00:00';


		if ($timebase == date('H:i:s') && $value == 1)
		 	{
		 		
				$mail = $heure->email;
				//echo $mail;
				//echo $timebase;
				$name = $heure->nom.' '.$heure->prenom;
				$message="prenez votre répas il est l'heure; n'est jamais l'oublier";

				$content="From: Mamed Care \nEmail: info@kamer-center.net \nMessage: $message";
				$recipient = $mail;
				$mailheader = "From:info@kamer-center.net \r\n";
				$subject = "Email de rapel de control de répas";
				//echo $timebase;
			
				
				$clara = mail($recipient,$subject, $content, $mailheader);//or die("Error!");

				
			 }
		
	}








