
<!-- <link href="css/sb-admin-2.min.css" rel="stylesheet"> -->
<script src="js/sb-admin-2.min.js"></script>
<?php	

	include('is_logged.php');
	/* Connect To Database*/
	require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("config/connexion.php");//Contiene funcion que conecta a la base de datos
        
	//include('functions.php');
	include('functions.php');
	$active_accueil="navbarElogeXmaelactive"; 
	

	if(isset($_SESSION['role'])){

		if($_SESSION['role'] == 'Medecin'){
			$title="Mes patients| MaMED";
			header('Location: mespatients.php'); 

		}else if($_SESSION['role'] == 'Patient'){
			$title="Journal| MaMED";
			header('Location: journal.php');
		}else{
			$title="Tableau de bord | MaMED";
			require_once ("tableau_bord.php");
			$nbre_patient = compter('patient', 'lisible', 1);
			$patient_connecte = compter('connexion', 'role', 'Patient');
			//$nbre_medecin = compter('medecin', 'lisible', 1);
			$requete = "SELECT count(*) as nombre from medecin where lisible = 1";
			$query = mysqli_query($con, $requete);
			$nbreMedecin = mysqli_fetch_array($query);
			$nbre_medecin=$nbreMedecin['nombre'];
		
			

			$medecin_connecte = compter('connexion', 'role', 'Medecin');

			$nbre_user = compter('users', 'lisible', 1);
			$user_connecte = compter('connexion', 'etat', 1);
                        $patient_suivi = compter('patient_has_medecin', 'approbation', 1);
                        
                        insert('table', array('id'=>1, 'nom'=>'sandjo'));


?>  

<?php 
      if(isset($_SESSION['lang'])){
      $lage='langues/'.$_SESSION['lang'].'.php';
      
      require_once ($lage);
      }
      else{
        $_SESSION['lang']='Fr';
         $lage='langues/'.$_SESSION['lang'].'.php';
      
      require_once ($lage);
      }
 ?>

<!DOCTYPE html>
<html lang="fr">
  <head>
    <?php include("head.php");?>
   
  </head>
  <body>
	<?php
	include("navbar.php");
	?>

	
	
    <div class="container col-md-12"  id="main-content" >
	<div class="panel-transparent" style="transform: translateY(40px);">
		<div class="panel-heading text-center">		    
			<span style="font-weight: bold; font-size: 2em; color: white;"><i class="fa fa-dashboard "></i> <?php echo $lang['tableauDeBord']; ?></span>
		</div>
		<div class="panel-body">
                    <!-- stat patient -->
                    	<div class="row col-md-12" >
			    <div class="col-md-3 col-md-3 col-sm-12 col-xs-12">
				<a href="patients.php" style="color:white;">
                                    <div class="info-box " style="border-radius: 40px;background-image: linear-gradient(-225deg, #CBBACC 0%, #2580B3 100%);" >
					<i class="fa fa-ambulance" ></i>
                                        <div class="count"><?php echo $nbre_patient; ?></div>
                                        <div class="title"><span style="color:white;"><?php echo $lang['patientsEnregistres']; ?> </span></div>						
                                    </div><!--/.info-box-->	
					</a>			
				</div><!--/.col-->

				
				<div class="col-md-3 col-md-3 col-sm-12 col-xs-12">
					<a style="color:white;">		
						<div class="info-box " style="border-radius: 40px;background-image: linear-gradient(120deg, #a1c4fd 0%, #c2e9fb 100%);">
									<i class="fa fa-user-circle"></i>
									<div class="count"><?php echo $patient_connecte; ?></div>
									<div class="title"><?php echo $lang['patientsConnectes']; ?></div>						
								</div><!--/.info-box-->		
					</a>	
				</div><!--/.col-->	
				
				<div class="col-md-3 col-md-3 col-sm-12 col-xs-12">
					<a style="color:white;" href="patientSuivis.php" id="cherche">		
						<div class="info-box" style="border-radius: 40px;background-image: linear-gradient(to top, #30cfd0 0%, #330867 100%);">
									<i class="fa fa-user"></i>
									<div class="count"><?php echo $patient_suivi; ?></div>
									<div class="title"><?php echo $lang['patientsSuivis']; ?></div>						
								</div><!--/.info-box-->		
					</a>	
				</div><!--/.col-->


                                
                                <div class="col-md-3 col-md-3 col-sm-12 col-xs-12">
					<a style="color:white;" href="patientNonSuivis.php">		
						<div class="info-box" style="border-radius: 40px;background-image: linear-gradient(to right, #eea2a2 0%, #bbc1bf 19%, #57c6e1 42%, #b49fda 79%, #7ac5d8 100%);">
									<i class="fa fa-user"></i>
									<div class="count"><?php echo $nbre_patient - $patient_suivi; ?></div>
									<div class="title"><?php echo $lang['patientsNonSuivis']; ?></div>						
								</div><!--/.info-box-->		
					</a>	
				</div><!--/.col-->

                        </div><!--/.row-->
			<!-- stat medecins -->
                        <div class="row col-md-12">
			    <div class="col-md-3 col-md-3 col-sm-12 col-xs-12">
				<a href="patients.php" style="color:white;">
                                    <div class="info-box" style="border-radius: 40px;background-image: linear-gradient(45deg, #8baaaa 0%, #ae8b9c 100%);">
					<i class="fa fa-user-md"></i>
					<div class="count"><?php echo $nbre_medecin; ?></div>
                                        <div class="title"><span style="color:white;"><?php echo $lang['medecinsEnregistres']; ?></span></div>						
                                    </div><!--/.info-box-->	
					</a>			
				</div><!--/.col-->
				
				<div class="col-md-3 col-md-3 col-sm-12 col-xs-12">
					<a style="color:white;">		
						<div class="info-box" style="border-radius: 40px;background-image: linear-gradient(to right, #3ab5b0 0%, #3d99be 31%, #56317a 100%);">
									<i class="fa fa-user-md"></i>
									<div class="count"><?php echo $medecin_connecte; ?></div>
									<div class="title"><?php echo $lang['medecinsConnectes']; ?></div>						
								</div><!--/.info-box-->		
					</a>	
				</div><!--/.col-->	
                                
				<div class="col-md-3 col-md-3 col-sm-12 col-xs-12" >
					<a style="color:white;" href="users.php">		
						<div class="info-box" style="border-radius: 40px;background-image: linear-gradient(-20deg, #616161 0%, #9bc5c3 100%);">
									<i class="fa fa-users"></i>
									<div class="count"><?php echo $nbre_user; ?></div>
									<div class="title"><?php echo $lang['utilisateursEnregistres']; ?></div>						
								</div><!--/.info-box-->		
					</a>	
				</div>
                                
				<div class="col-md-3 col-md-3 col-sm-12 col-xs-12" >
					<a style="color:white;">		
						<div class="info-box " style="border-radius: 40px;background-image: linear-gradient(-225deg, #22E1FF 0%, #1D8FE1 48%, #625EB1 100%);">
									<i class="fa fa-user-circle" ></i>
									<div class="count"><?php echo $user_connecte; ?></div>
									<div class="title"><?php echo $lang['utilisateursConnectes']; ?></div>						
								</div><!--/.info-box-->		
					</a>	
				</div><!--/.col-->
                                
                                <!--/.col-->

                        </div><!--/.row-->
		<!--	<div class="row-fluid">
				
				<div class="span4 statbox green" onTablet="span6" onDesktop="span4">
					<div class="boxchart"><span  style="font-size: 1.3em; "> Patients enrégistrés</span></div>
					<div class="number"><?php echo $nbre_patient; ?></div>
					<div class="title"><?php echo $patient_connecte; ?> Connecté(s)</div>
					<div class="footer">
						<a href="patients.php" title="Visualiser">Visualiser</a>
					</div>	
				</div>
				<div class="span4 statbox red" onTablet="span6" onDesktop="span4">
					<div class="boxchart"><span  style="font-size: 1.3em; "> Médecins enrégistrés</span></div>
					<div class="number"><?php echo $nbre_medecin; ?></div>
					<div class="title"><?php echo $medecin_connecte; ?> Connecté(s)</div>
					<div class="footer">
						<a href="medecins.php" title="Visualiser">Visualiser</a>
					</div>
				</div>
				<div class="span4 statbox yellow" onTablet="span6" onDesktop="span4">
					<div class="boxchart">Utilisateurs enrégistrés</div>
					<div class="number"><?php echo $nbre_user; ?></div>
					<div class="title"><?php echo $user_connecte; ?> Connecté(s)</div>
					<div class="footer">
						<a href="users.php" title="Visualiser">Visualiser</a>
					</div>
				</div>			
			</div>
		 -->
	
	
			
			
	<script type="text/javascript" src="js/clara.js"></script>		
  </div>
</div>
		 
	</div>
	<?php
	include("footer.php");
	?>

  </body>
</html>
<script>

		
	$(document).ready(function(){
			
		
	});


    $('.cherche').on('click', function(e){
        //$('.loader').show();
        e.preventDefault();
        var $cible = $(this);
        target = $cible.attr('href');
        $('#main-content').load(target);
    });



		


</script>

<?php 
	
		}
	}	
 ?>