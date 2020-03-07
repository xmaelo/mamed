<?php
	include('is_logged.php');//Vérifications des informations transmises*/

    $json = 0;

	if($_SESSION['role'] != 'Administrateur'){
   	 	
		/* Connect To Database*/
		require_once ("../config/db.php");//Contient les variables de configuration pour la base de données
		require_once ("../config/connexion.php");//Contient la fonction de connection à la base de données
        require_once('../functions.php'); 
	
        $idpersonne = intval($_SESSION['idpersonne']);
        $role = $_SESSION['role'];
        $expediteur = ($role == 'Medecin' ? 0 : 1 );
        $table = lcfirst($role);
        $req = "SELECT count(*) as nbre FROM message
            INNER JOIN $table ON ".$table."_id$table = id$table
            INNER JOIN personne ON ".$table.".personne_idpersonne = idpersonne
            AND idpersonne = $idpersonne
            AND personne.lisible = 1
            AND $table.lisible = 1
            AND message.lisible = 1
            AND message.etat = 0
            AND expediteur = $expediteur";
       // var_dump($req);   
        $query = mysqli_query($con, $req);
        $rw = mysqli_fetch_array($query);
        $json = intval($rw['nbre']);
        echo json_encode($json);
  }
      



           
	

?>