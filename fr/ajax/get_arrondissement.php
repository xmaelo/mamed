<?php

   
    
    if(isset($_GET['iddepartement'])){
        //reccuperation de l'id du departement
        $iddepartement = htmlentities(intval(($_GET['iddepartement'])));
        
        //connexion à la base de données
        
        include('../config/db.php');
        include('../config/connexion.php');
        
        //selection de la liste des arrondissements de ce département
        $liste = array();
        
        $arrondissements = mysqli_query($con, "SELECT * FROM arrondissement "
                . "WHERE departement_iddepartement = '$iddepartement'"
                . "AND lisible = 1 ORDER BY arrondissement");
        
        while($row = mysqli_fetch_array($arrondissements)){
            $liste[$row['idarrondissement']][] = utf8_encode($row['arrondissement']);
        }
        
        echo json_encode($liste);
    }