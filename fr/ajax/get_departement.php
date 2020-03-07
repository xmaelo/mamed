<?php

       
    if(isset($_GET['idregion'])){
        //recciperation de l'id de la region
        $idregion = htmlentities(intval($_GET['idregion']));
        $liste = array();
        //connecion à la base de donnée
        require_once ("../config/db.php");
	require_once ("../config/connexion.php");
        
        //selection de la liste des departement de la region choisie
        
        $departements = mysqli_query($con, "SELECT * FROM departement WHERE region_idregion = '$idregion'"
                . " AND lisible = 1 ORDER BY departement");
        while($row = mysqli_fetch_array($departements)){
            $liste[$row['iddepartement']][] = utf8_encode($row['departement']);
        }
        //var_dump($liste);
        echo json_encode($liste);
    }
?>