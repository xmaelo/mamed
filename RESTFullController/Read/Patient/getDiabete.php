<?php  
header("Access-Control-Allow-Origin: *");

	 if($_SERVER['REQUEST_METHOD'] !== 'POST') {
	 	echo json_encode(array('status' => false));
	 	exit;
	 }

	 $postdata = file_get_contents("php://input");
	
	 $data = json_decode($postdata, true);

	 //$idpersonne = $data['idpers'];
	 //$idpersonne = intval($_GET['id']);



	 $retours = array();  

	 //$password = $data['pass'];

session_start();//session starter for this user

require_once('../../../fr/config/db.php'); 
require_once('../../../fr/config/connexion.php'); 
//require_once('../../../fr/config/fonctions.php'); 
require_once('../../../fr/functions.php'); 


$query_type=mysqli_query($con,"select * from diabete where lisible = 1 order by type");
			
							$i=0;
							while($rw=mysqli_fetch_array($query_type))	{

								$retours[$i]['iddiabete'] = $rw['iddiabete'];
								$retours[$i]['type'] = $rw['type'];
								$i++;
							}


							echo json_encode($retours);