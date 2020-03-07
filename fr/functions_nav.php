<?php
function count_message($idpersonne, $table){
		global $con;
		$expediteur = ($table == 'medecin' ? 0 : 1);

		$req = "SELECT count(*) as nbre FROM message
			INNER JOIN $table ON ".$table."_id$table = id$table
			INNER JOIN personne ON personne_idpersonne = idpersonne
			AND idpersonne = $idpersonne
			AND personne.lisible = 1
			AND $table.lisible = 1
			AND message.lisible = 1
			AND message.etat = 0
			AND expediteur = $expediteur";
		//var_dump($req);	
		$query = mysqli_query($con, $req);
		$rw = mysqli_fetch_array($query);
		$value = $rw['nbre'];
		return $value;
	}
?>	