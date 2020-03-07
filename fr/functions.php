<?php 

//session_start();

 if(isset($_SESSION['lang'])){
      $lage='langues/'.$_SESSION['lang'].'.php';
      
      require_once ($lage);
      }
      else{
        $_SESSION['lang']='Fr';
         $lage='langues/'.$_SESSION['lang'].'.php';
      
      require_once ($lage);
      } 


function get_row($table,$row, $id, $equal){
	global $con;
	$req = "select $row from $table where $id='$equal'";
	//var_dump($req);
	$query=mysqli_query($con, $req);
	$rw=mysqli_fetch_array($query);
	$value=$rw[$row];
	return $value;
}

function get_all_row($table, $id, $equal){
	global $con;
	$req = "select * from $table where $id='$equal'";
	//var_dump($req);
	$query=mysqli_query($con, $req);
	$rw=mysqli_fetch_array($query);
	return $rw;
}

function guardar_historial($id_producto,$user_id,$fecha,$nota,$reference,$quantity){
	global $con;
	$sql="INSERT INTO historial (id_historial, id_producto, user_id, fecha, nota, referencia, cantidad)
	VALUES (NULL, '$id_producto', '$user_id', '$fecha', '$nota', '$reference', '$quantity');";
	$query=mysqli_query($con,$sql);
	
}
function agregar_stock($id_producto,$quantity){
	global $con;
	$update=mysqli_query($con,"update products set stock=stock+'$quantity' where id_producto='$id_producto'");
	if ($update){
			return 1;
	} else {
		return 0;
	}	
		
}
function eliminar_stock($id_producto,$quantity){
	global $con;
	$update=mysqli_query($con,"update products set stock=stock-'$quantity' where id_producto='$id_producto'");
	if ($update){
			return 1;
	} else {
		return 0;
	}	
		
}
function calcul_IMC($poids, $taille){

		return round(($poids/pow($taille/100, 2)), 1);
	}

	function interpretation_IMC($imc){
		$interpretation = "";
		if($imc < 16.5){

			$interpretation = "Dénutrition";

		}elseif($imc < 18.5 && $imc >=16.5){

			$interpretation = "Maigreur";

		}elseif($imc < 25 && $imc >= 18.5){

			$interpretation = "Corpulence normale";
		
		}elseif($imc < 30 && $imc >=25){

			$interpretation = "Surpoids";

		}elseif($imc < 35 && $imc >= 30){

			$interpretation = "Obésité modérée";

		}elseif($imc < 40 && $imc >= 35){

			$interpretation = "Obésité sévère";

		}elseif ($imc >= 40) {
			
			$interpretation = "Obésité morbide ou massive";
		}

		return $interpretation;
	}

	function get_personne($idpersonne, $table){

		global $con;
		$query = "select * from $table
			INNER JOIN personne ON $table.personne_idpersonne = personne.idpersonne
			AND personne.lisible = 1
			AND $table.lisible = 1
			AND personne.idpersonne = ".$idpersonne;
		$req=mysqli_query($con, $query);
		$rw=mysqli_fetch_array($req);
		
		return $rw;
	}

	function get_date_fr($date){ //fonction qui convertit la date du format SQL vers le format français
		
		if($date == ""){

			return "";
		}else{ 
			$part = explode('-', $date);

			$new_date = $part[2].'/'.$part[1].'/'.$part[0];
			return $new_date;
		}
	}

	function get_date_SQL($date){ //fonction qui convertit la date du format français vers le format SQL
		if($date == ""){

			return "";
		}else{
			$part = explode('/', $date);

			$new_date = $part[2].'-'.$part[1].'-'.$part[0];
			return $new_date;
		}
		
	}

	function get_sexe($sexe){ //fonction qui ecrit le sexe en toute lettres
		return ($sexe == 'M' ? 'Masculin' : 'Féminin');
	}

	function get_data($id, $table, $lisible=1){ //fonction qui selectionne une ligne dans une table donnée

		global $con;
		$query = "select * from $table
			WHERE id$table = $id AND lisible = $lisible";
		$req=mysqli_query($con, $query);
		$rw=mysqli_fetch_array($req);
		//var_dump($query);
		return $rw;
	}

	function get_unite($id){
		global $con;
		$req = "SELECT libelle FROM unite_patient 
					INNER JOIN unite ON unite_idunite = idunite 
					AND patient_idpatient = '$id'";
		$query=mysqli_query($con, $req);
		$rw=mysqli_fetch_array($query);
		$value=$rw['libelle'];
		return $value;			
	}

	function get_medecin($idmedecin){

		global $con;
		$query = "select * from medecin
			INNER JOIN personne ON medecin.personne_idpersonne = personne.idpersonne
			AND personne.lisible = 1
			AND medecin.lisible = 1
			AND medecin.idmedecin = ".$idmedecin;
		$req=mysqli_query($con, $query);
		$rw=mysqli_fetch_array($req);
		//var_dump($query);
		return $rw;
	}


   function insert($table, $data){
        global $con;
        $req = "INSERT INTO $table";
        $champ = array();
        $valeur = array();

        foreach($data as $key => $line){
            $champ[] = $key;
            $valeur[] = "'$line'";
        }

        $colonne = implode($champ, ',');
        $donnees = implode($valeur, ',');

        $req = "INSERT INTO $table($colonne) VALUES($donnees)";
        //var_dump($req);
        return mysqli_query($con, $req);
     }
     
     function update($table, $data, $where, $operateur, $valeur){
        global $con;
        $champ = array();

        foreach($data as $key => $line){
            $champ[] = $key."='".$line."'";
        }
        $donnees = implode($champ, ',');

        $req = "UPDATE  $table SET $donnees WHERE $where $operateur '$valeur' ";
       // var_dump($req);
        //return mysqli_query($con, $req);
     }
     


function get_last_insert_id($table){
	global $con;
	$query=mysqli_query($con,"select last_insert_id() as id from $table");
	$rw=mysqli_fetch_array($query);
	$value=$rw['id'];
	return $value;
}
  function filtre_categorie_patient(){   

   	  global $lang;   
      return  array(
          'datenaiss'=>$lang['dateDdeNaissance'], 
          'sexe'=>$lang['sexe'],
          'region'=>$lang['region'],          
          'departement'=>$lang['departement'],
          'arrondissement'=>$lang['arrondissement'],
          'adresse'=>$lang['addresse'],
          'interpretation'=>$lang['interpretation'],
          'type'=>$lang['typeDeDiabete'],
      );      
  }

?>