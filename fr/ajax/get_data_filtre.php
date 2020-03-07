<?php

      include('is_logged.php');//Vérifications des informations transmises*/
  include('is_admin.php');
        require_once ("../config/db.php");//Contient les variables de configuration pour la base de données
  require_once ("../config/connexion.php");//Contient la fonction de connection à la base de données

   include ('../fileInclu.php');
    if(isset($_GET['data'])){
        //reccuperation de l'id du departement
        $data = htmlentities($_GET['data']); 
        
        $liste = array();
        
        if($data == 'region' || $data == 'departement'  || $data == 'arrondissement'){
            $query = "SELECT DISTINCT id".$data.", $data FROM patient "
                    ." INNER JOIN personne on personne_idpersonne = idpersonne"
                    . " INNER JOIN $data ON ".$data."_id".$data." = id$data "                    
                    . " AND personne.lisible = 1 "
                    . " AND patient.lisible = 1"
                    . " AND ".$data.".lisible = 1 "
                    . " order by ".$data."";
            //var_dump($query);
            $selects = mysqli_query($con, $query);
            //var_dump($row = mysqli_fetch_array($selects));
           
             while($row = mysqli_fetch_array($selects)){

                      
                $value = fctRetirerAccents($row[1]);
                $liste[$row[0]][] = $value;
                //echo $row[1];
             }
        }
        elseif($data == 'adresse'){
              $query1 = "SELECT DISTINCT $data FROM patient "
                    . " INNER JOIN personne ON personne_idpersonne = idpersonne"
                    . " INNER JOIN diabete ON diabete_iddiabete = iddiabete"
                    . " AND personne.lisible = 1"
                    . " AND patient.lisible = 1"
                    . " AND diabete.lisible = 1 ORDER BY $data";
           // var_dump($query2);
            $selects21 = mysqli_query($con, $query1);
            while($row = mysqli_fetch_array($selects21)){
                $val = $row[0];

                $varMachaine = $val;
                $value='';     
                $value = fctRetirerAccents($varMachaine);

                       
                $liste[$val][] = $value;
                //var_dump($value);

             }
        }

        else{
            $query2 = "SELECT DISTINCT $data FROM patient "
                    . " INNER JOIN personne ON personne_idpersonne = idpersonne"
                    . " INNER JOIN diabete ON diabete_iddiabete = iddiabete"
                    . " AND personne.lisible = 1"
                    . " AND patient.lisible = 1"
                    . " AND diabete.lisible = 1 ORDER BY $data";
           // var_dump($query2);
            $selects2 = mysqli_query($con, $query2);
            while($row = mysqli_fetch_array($selects2)){
                $val = $row[0];
                $liste[$val][] = $lang[$val];
             }
        }

        //var_dump($liste);
        echo json_encode($liste);
    }

     function fctRetirerAccents($varMaChaine)
                        {
                            $search  = array('À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'à', 'á', 'â', 'ã', 'ä', 'å', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ð', 'ò', 'ó', 'ô', 'õ', 'ö', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ');
                            //Préférez str_replace à strtr car strtr travaille directement sur les octets, ce qui pose problème en UTF-8
                            $replace = array('A', 'A', 'A', 'A', 'A', 'A', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y', 'a', 'a', 'a', 'a', 'a', 'a', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y');

                            $varMaChaine = str_replace($search, $replace, $varMaChaine);
                            return $varMaChaine; //On retourne le résultat
                        }