<?php 

	include('is_logged.php');
	include('is_admin.php');
	/* Connect To Database*/
	require_once ("config/db.php");
	require_once ("config/connexion.php");

	

	/* getDataFunctionOfComeBackUrl*/
	$_SESSION['data']='catrine';

		if (isset($_GET['id'])) {

			$val = $_GET['cat'];
			$champs = $_GET['id'];
			$query = "UPDATE `clinique` SET `$champs`='".$val."' WHERE 1";
		//$query = "SELECT * from clinique";

			$execute = mysqli_query($con, $query);

			// $data = mysqli_fetch_array($execute);
			// var_dump($data)

			if($execute) {
				$data = 1;
			}
			else {
				$data = 'echec';
			}

			echo json_encode($data);

		}

		else {

			$nomphoto = '';
        	$e='';


        	 function getNom(){
	             	$characts    = 'abcdefghijklmnopqrstuvwxyz';
				    $characts   .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
				    $characts   .= '1234567890';
				    $code_aleatoire      = '';
				 
				    for($i=0;$i < 4;$i++)
				    {
				        $code_aleatoire .=substr($characts,rand()%(strlen($characts)),1);
				    }

				    return $code_aleatoire;
	             }
	             $nomphoto = $_FILES['logoId']['name'];
	             if($nomphoto == ""){
								$nomphoto = "img/avatar_2x.png";
					}
				else{									
						$file_tmp_name=$_FILES['logoId']['tmp_name'];
						$extension = pathinfo($nomphoto, PATHINFO_EXTENSION);
						$extensions_autorisees = array('jpg', 'jpeg', 'gif', 'png');
							if (in_array($extension, $extensions_autorisees))
							{
								$nomphoto = 'img/'.getNom().'.'.$extension;
								move_uploaded_file($file_tmp_name,"$nomphoto");
							}
							else
							{
								$nomphoto = "img/avatar_2x.png";
							}
				}

				$query = "UPDATE `clinique` SET `logo`='".$nomphoto."' WHERE 1";
				$execute = mysqli_query($con, $query);
				$_SESSION['dat']='cat';


				if($execute) {
				$data = 1;
				}
				else {
					$data = 'echec';
				}


		}

				










































 ?>