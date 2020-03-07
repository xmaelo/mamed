<?php  
header("Access-Control-Allow-Origin: *");

	 if($_SERVER['REQUEST_METHOD'] !== 'POST') {
	 	echo json_encode(array('status' => false));
	 	exit;
	 }

	 $postdata = file_get_contents("php://input");
	
	 $data = json_decode($postdata, true);

	 //$operator = $_GET['operator'];

	 $idpersonne = intval($_GET['id']);


	 	require_once('../../../fr/config/db.php'); 
		require_once('../../../fr/config/connexion.php'); 
	//require_once('../../../fr/config/fonctions.php'); 
		require_once('../../../fr/functions.php'); 



		//$idpersonne = intval($_SESSION['idpersonne']);
        $role = $_GET['role'];
        $expediteur = 1;//($role == 'Medecin' ? 0 : 1 );
        $table = lcfirst('Patient');
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