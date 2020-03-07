

<?php

  require_once ('compo/vendor/autoload.php');
  use \Statickidz\GoogleTranslate;

if (isset($_GET['logout'])){
  header('location:../index.php');
}
// checking for minimum PHP version
if (version_compare(PHP_VERSION, '5.3.7', '<')) {
    exit("Sorry, Simple PHP Login does not run on a PHP version smaller than 5.3.7 !");
} else if (version_compare(PHP_VERSION, '5.5.0', '<')) {
    // if you are using PHP 5.3 or PHP 5.4 you have to include the password_api_compatibility_library.php
    // (this library adds the PHP 5.5 password hashing functions to older versions of PHP)
    require_once("libraries/password_compatibility_library.php");
}


////deplacement 


    

// include the configs / constants for the database connection
require_once("config/db.php");
require_once("config/connexion.php");
// load the login class
require_once("classes/Login.php");

// create a login object. when this object is created, it will do all login/logout stuff automatically
// so this single line handles the entire login process. in consequence, you can simply ...
$login = new Login();


// ... ask if we are logged in here:
if ($login->isUserLoggedIn() == 1) {
    // L'utilisateur est connecté et l'adresse email est confirmée
  //insertion des info du user connecté
      $role = $_SESSION['role'];


      $iduser = $_SESSION['idusers']; 
                        if($role == 'Patient'){ 
                            $connexion_role = 'P';
                        }else if($role == 'Medecin'){
                            $connexion_role = 'M';
                        }else{
                            $connexion_role = 'A';
                        }
                        $sql="INSERT INTO connexion VALUES (NULL, '$iduser', '$connexion_role', NOW(), NOW());";
                       
                        $query=mysqli_query($con,$sql);
  	                   header("location: accueil.php");
} else if($login->isUserLoggedIn() == 0){
    // l'utilisateur est connecté mais l'adresse emil n'est pas encore confirmé
    header("location: validation.php");
}else{
  //aucun des deux cas precedents
  //redirection vers la page de login

?>
<?php 
      // if(isset($_SESSION['lang'])){
      // $lage='langues/'.$_SESSION['lang'].'.php';
      
      // require_once ($lage);
      // }
      // else{
      //   $_SESSION['lang']='Fr';
      //    $lage='langues/'.$_SESSION['lang'].'.php';
      
      // require_once ($lage);
      // }
  if (isset($_POST['catrineFrench'])) {
      
      $lang="Fr";
      $_SESSION['lang']=$lang;


      }
      elseif(isset($_POST['catrineAllemande']))
      {
        $lang="Deutch";
        $_SESSION['lang']=$lang;
      }
      elseif(isset($_POST['catrineEnglish']))
      {
        $lang="Eng";
        $_SESSION['lang']=$lang;
      }
      else {
        $lang="Fr";
        $_SESSION['lang']=$lang;

      }
      

  
     
  include ('fileInclu.php');

  //include('function_no_login.php');
  //$var=$_SESSION['lang'];


 ?>

	<!DOCTYPE html>
<html lang="fr">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no"/>
  <title>MaMED | Login</title>
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="css/bootstrap.min.css">
  <!-- CSS  -->
   <link href="login.css" type="text/css" rel="stylesheet" media="screen,projection"/>
   <link rel=icon href='img/logo-maMED.png' sizes="32x32" type="image/png">
   <link rel="stylesheet" href="libraries/datepicker/datepicker3.css">

   <!-- nos link -->
    <link rel="stylesheet" href="../../assets/css/font-awesomes.css">
    <!-- Bootstrap core CSS -->
     <!-- <link href="assets/css/bootstrap.min.css" rel="stylesheet"> -->
    <!-- Material Design Bootstrap -->
    <link href="assets/css/mdb.min.css" rel="stylesheet">
    <!-- <link href="assets/css/compiled-4.5.6.min62df.css" rel="stylesheet"> -->
    <!-- Your custom styles (optional) -->
    <link href="assets/css/style.css" rel="stylesheet">
     <link href="assets/css/stylemenu.css" rel="stylesheet">
     <link href="assets/css/dataTables.bootstrap4.min.css" rel="stylesheet">
     <style type="text/css">
      
     </style>
</head>
<style type="text/css">
                .b {
                  height: 25px;
                  width: 20px;
                  font-weight: bold;
                  border-radius: 50px;
                  font-size: cover;
                }
                .french {
                  background-image:url(img/gif/fr.gif);
                   background-size: cover;
                }
                .all {
                   background-image:url(img/gif/de.gif);
                   background-size: cover;
                }
                .ang {
                   background-image:url(img/gif/gb.gif);
                   background-size: cover;
                }

</style>
<body>	
 <div class="container">
        <div class="card card-container img-responsive">
          
          <form method="post">
            
            <div class="text-center">

              <button class="btn btn-default h4  b french"  type="submit"  name="catrineFrench"></button>  
             

              <button class="btn btn-default h4 b ang"  type="submit"  name="catrineEnglish"></button>
              <button class="btn btn-default h4 b all"   type="submit"  name="catrineAllemande"></button>
              <!-- <input class="btn btn-default h3"  value="English"  type="submit"  name="catrineEnglish"> -->
              <!-- <input class="btn btn-default h3"  value="Deutsch"  type="submit"  name=""> -->
            </div>
        
          </form> 

        	<?php //include("modal/nouveau_patient.php");?>

            <img id="profile-img" class="profile-img-card" src="img/logo-maMED.jpeg" style="transform: translateX(-10%);" />
            <p id="profile-name" class="profile-name-card"></p>
            <form method="post" accept-charset="utf-8" action="login.php" name="loginform" autocomplete="off" role="form" class="form-signin">
			<?php
				// show potential errors / feedback (from login object)
				if (isset($login)) {
					if ($login->errors) {
						?>
						<div class="alert alert-danger alert-dismissible" role="alert">
						    <strong><?php echo $lang['error']; ?> !</strong> 
						
						<?php 
						foreach ($login->errors as $error) {
							echo $error;
						}
						?>
						</div>
						<?php
					}
					if ($login->messages) {
						?>
						<div class="alert alert-success alert-dismissible" role="alert">
						    <strong><?php echo $lang['info']; ?>!</strong>
						<?php
						foreach ($login->messages as $message) {
							echo $lang['infoVousAvezEteDeconnecte'];
						}
						?>
						</div> 
						<?php 
					}
				}
				?>
              


            <!-- Material form login -->


 

  <!--Card content-->
  <div class="card-body px-lg-5 pt-0">

    <!-- Form -->
    <form class="text-center" style="color: #757575;">

      <!-- Email -->
   
        <div class="md-form">
          
          <input type="email" name="email" type="email" value="" autofocus="" required class="form-control cat policeinfo" style="font-size: 18px;font-weight: bold">
          <label for="email" class=""  style="font-size: 18px;font-weight: bold"><?php echo $lang["addresseEmail"]; ?></label>
        </div>
      <br>

      <!-- Password -->
      <div class="md-form">
        <input type="password" name="password" value="" autocomplete="off" required class="form-control policeinfo" style="font-size: 18px;font-weight: bold">
        <label for="password" class="" style="font-size: 18px;font-weight: bold"><?php echo $lang["motDePasse"]; ?></label>
      </div>

      <div class="d-flex justify-content-around">
       
         
               

      <!-- Sign in button -->
      <br>

        <button class="btn btn-outline-info btn-rounded btn-block my-4 waves-effect z-depth-0  policeinfo"name="login" id="submit" style="font-size: 18px;font-weight: bold; border-radius: 50px;">
          <?php echo $lang["seConnecter"]; ?></button>
        <br>
         <a  class=" btn-signin btn-outline-info float-right policeinfo" id="btn_nouveau_patient" data-toggle="modal" data-target="#nouveau_patient" style="float:right; box-shadow:  ; border-radius: 50px; padding:4px">
        
        
        <?php echo $lang["enregistrer1"]; ?></a>
     
      </div>
    </form>
    <!-- Form -->
    <br>

  </div>
















<!-- modale -->




  <?php
    if (isset($con))
    {
  ?>
  <!-- Modal -->

  <div class="modal fade" id="nouveau_patient" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width: 60%;">
        <div class="modal-content" >

          <form class="form-horizontal text-center" method="post" id="form_nouveau_patient" name="nom_patient" >
            <div class="modal-header">
              <button type="button" class="close close_form" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
              <span style="font-weight: bold; font-size: 1.5em;" class="modal-title" id="myModalLabel">
                <i class='fa fa-plus'></i><?php echo $lang['modal']; ?>
            </div>
            <div class="modal-body">
              <!-- Affichage des resultats du traitement du formulaire-->
             <div id="resultat_ajax"></div>  
              <div>
                
                                 
              <!-- Nom du patient et prenom du patient-->
                                            
              <div class="col-md-12 text-left">
                 
                <div class="col-md-6 md-form">
                  <input type="text" class="form-control" id="nom_patent" name="nom_patient" style="font-size: 18px;font-weight: bold" required>
                  <label for="nom_patient" class="col-md-1 control-label" style="font-size: 18px;font-weight: bold"><?php echo $lang['nom']; ?><span class="obligatoire">*</span></label>
                </div>

                
                <div class="col-md-6 md-form">
                  <input type="text" class="form-control" id="prenom_patient" name="prenom_patient" style="font-size: 18px;font-weight: bold">
                  <label for="prenom_patient" class="col-md-2 control-label" style="font-size: 18px;font-weight: bold"><?php echo $lang['prenom']; ?></label>
                </div>
              </div> 
                               
                                
                                <!-- Sexe et date de naissance-->
                  
            <div class="col-md-12">
              
                <h4><b><i><?php echo $lang['DSA']; ?></i></b></h4>
                <hr>
             
             
              <div class="col-md-4">
                <select id="sexe_patient" style="font-size: 16px;font-weight: bold" name="sexe_patient" class="form-control" required>
                  <option disabled selected><?php echo $lang['choisirSexe']; ?></option>
                  <option value="F"><?php echo $lang['feminin']; ?></option>
                  <option value="M"><?php echo $lang['masculin']; ?></option>
                </select>
              </div>

             <!--  <div class="col-md-6 md-form">
                <input type="text" class="form-control datepicker" id="prenom_patient" name="prenom_patient" 
                pattern="(0[1-9]|1[0-9]|2[0-9]|3[01])/(0[1-9]|1[012])/[0-9]{4}" style="font-size: 18px;font-weight: bold">
                <label for="ddn_patient" class="col-md-2 control-label" style="font-size: 18px;font-weight: bold">DDN</label>
              </div> -->
            
                                    
            
            <div class="col-md-4">
              <input type="date" class="form-control datepicker" id="ddn_patient" name="datenaiss_patient" pattern="(0[1-9]|1[0-9]|2[0-9]|3[01])/(0[1-9]|1[012])/[0-9]{4}"  required>
            </div>


            <div class="col-md-4 md-form" style="transform: translateY(-48%);">
              <input type="text" class="form-control" id="adresse_patient" name="adresse_patient" style="font-size: 16px;font-weight: bold" required>
              <label for="adress_patient" style="font-size: 16px;font-weight: bold" class="col-md-2 control-label"><?php echo $lang['addresse']; ?><span class="obligatoire">*</span></label>
            </div>
          </div>
          <div class="col-md-12">
            <h4><b><i><?php echo $lang['localisation']; ?></i></b></h4>
            <hr>
            <div class="col-md-4">
              <select id="region_patient" name="region_patient" class="form-control" required>
                <option disabled selected><?php echo $lang['choisirUneRegion']; ?></option>
                  <?php 
                      $regions = mysqli_query($con, "SELECT * FROM region WHERE lisible = 1 ORDER BY region");
                      while($region = mysqli_fetch_array($regions)){
                      ?>
                      <option value="<?php echo $region['idregion']; ?>"><?php echo utf8_encode($region['region']); ?></option>
                      <?php
                          }
                  ?>
              </select>
            </div>
            <div class="col-md-4">
              <div id="loader_departement"></div>
              <select id="departement_patient" name="departement_patient" class="form-control" required>
                <option disabled selected><?php echo $lang['choisirUnDepartement']; ?></option> 
              </select>
            </div>
            <div class="col-md-4">
              <div id="loader_arrondissement"></div>  
              <select id="arrondissement_patient" name="arrondissement_patient" class="form-control" required>
                <option disabled selected><?php echo $lang['choisirUnArrondissement']; ?></option>
              </select>
            </div>
            
          </div>
          <div class="col-md-12">
            <hr>
            <h4><b><i><?php echo $lang['contact']; ?></i></b></h4>


            <div class="col-md-4 md-form">
              <input type="email" class="form-control" id="email_patient"style="font-size: 16px;font-weight: bold" name="email_patient" required>
              <label for="email_patient" class="col-md-3 control-label"style="font-size: 16px;font-weight: bold"><?php echo $lang['email']; ?><span class="obligatoire">*</span></label>
            </div>

            
            <div class="col-md-4 md-form">
              <input type="text" class="form-control" id="telephone1_patient" style="font-size: 16px;font-weight: bold"name="telephone1_patient" required>
              <label for="telephone1_patient" class="col-md-2 control-label"style="font-size: 16px;font-weight: bold"><?php echo $lang['telephone1']; ?><span class="obligatoire">*</span></label>
            </div>

           
            <div class="col-md-4 md-form">
              <input type="text" class="form-control" id="telephone2_patient"style="font-size: 16px;font-weight: bold" name="telephone2_patient">
              <label for="telephone2_patient" class="col-md-2 control-label"style="font-size: 16px;font-weight: bold"><?php echo $lang['telephone2']; ?></label>
            </div>
                               
            
          </div>
          <div class="col-md-12">
            <h4><b><i><?php echo $lang['securite']; ?></i></b></h4>
            <hr>
           
            <div class="col-md-6 md-form">
              <input type="password" class="form-control" id="password_patient"style="font-size: 16px;font-weight: bold" name="password_patient" required>
               <label for="password_patient" class="col-md-3 control-label"style="font-size: 16px;font-weight: bold"><?php echo $lang['motDePasse']; ?><span class="obligatoire">*</span></label>
            </div>
            
           
            <div class="col-md-6 md-form">
              <input type="password" class="form-control" id="confirmation_password" style="font-size: 16px;font-weight: bold"name="confirmation_password">
              <label for="confirmation_password" class="col-md-2 control-label"style="font-size: 16px;font-weight: bold"><?php echo $lang['confirmation']; ?><span class="obligatoire">*</span></label>
            </div>
          </div>

          <div class="col-md-12">
            <h4 ><b><i><?php echo $lang['infoMedicale']; ?></i></b></h4>
            <hr>
             <div class="col-md-4">
                <select class='form-control' name='diabete' id='diabete' required>
                        <option value=""><?php echo $lang['selectionnerUnTypeDeDiabete']; ?></option>
                                <?php 
                                $query_type=mysqli_query($con,"select * from diabete where lisible = 1 order by type");
                                while($rw=mysqli_fetch_array($query_type))  {
                                        ?>
                                <option value="<?php echo $rw['iddiabete'];?>">

                                  <?php  

              

                                    // $source = 'fr';
                                    // $target = $lang['lang'];
                                    // $text = $rw['type'];

                                    // $trans = new GoogleTranslate();
                                    // $result = $trans->translate($source, $target, $text);

                                    echo $lang[$rw['type']];

                                   ?> 
                                  <!-- <?php echo $rw['type'];?> -->
                                    

                                  </option>     
                                        <?php
                                }
                                ?>
                </select>       
            </div>

            <div class="col-md-4 md-form"style="transform: translateY(-48%);">
              <input type="text" class="form-control" id="poids_patient"style="font-size: 16px;font-weight: bold" name="poids_patient" required>
              <!-- <label for="poids_patient" class="col-md-1 control-label"style="font-size: 16px;font-weight: bold"><?php echo $lang['poids']; ?><span class="obligatoire">*</span></label> -->
              <label for="poids_patient" class="col-md-3 control-label"style="font-size: 16px;font-weight: bold"><?php echo $lang['poids']; ?><span class="obligatoire">*</span></label>
            </div>

            
            <div class="col-md-4 md-form"style="transform: translateY(-48%);">
              <input type="text" min="50" max="400" class="form-control"style="font-size: 16px;font-weight: bold" id="taille_patient" name="taille_patient" required>
              <label for="taille_patient" class="col-md-2 control-label"style="font-size: 16px;font-weight: bold"><?php echo $lang['taille']; ?><span class="obligatoire">*</span></label>
            </div>
            
          </div>
          <div class="col-md-12">
            <h4><b><i><?php echo $lang['autreInfos']; ?></i></b></h4>
            <hr>

              <div class="col-md-6 md-form">
                <input type="text" class="form-control" id="personne_urgence" name="personne_urgence"style="font-size: 16px;font-weight: bold" required>
              <label for="personne_urgence"  class="col-md-4 control-label" style="font-size: 16px;font-weight: bold"><?php echo $lang['personneDurgence']; ?><span class="obligatoire">*</span></label>
              </div>
        <!-- Nom du contactpatient-->
              <div class="col-md-6 md-form">
                <input type="text" class="form-control" id="telephone_urgence"style="font-size: 16px;font-weight: bold" name="telephone_urgence" required>
              <label for="telephone_urgence" class="col-md-4 control-label"style="font-size: 16px;font-weight: bold"><?php echo $lang['telephoneDurgence']; ?><span class="obligatoire">*</span></label>
              </div>

          </div>

                                  <button type="button" class="btn-outline-info close_form" data-dismiss="modal"
                                  style="border-radius: 50px; padding:4px" ><?php echo $lang['annuler']; ?></button>
                                  <button type="submit" class="btn-outline-green" id="btn_save_patient"
                                  style="border-radius: 50px; padding:4px"><?php echo $lang['enregistrer']; ?></button>
                       
        </div>                                                       
                                 <!-- arrondissement et adresse-->
                          
                        
                            
          </form>
        </div>
        </div>
      </div>
  <?php
    }
  ?>



<!-- modale -->






























</div>
<!-- Material form login -->
            
        </div><!-- /card-container -->
    </div><!-- /container -->

<script src="libraries/datepicker/bootstrap-datepicker.js"></script>
<script src="libraries/datepicker/locales/bootstrap-datepicker.fr.js" charset="UTF-8"></script>
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<!-- <script type="text/javascript" src="js/new_patient_login.js"></script> -->


<!-- nos csript -->
    <!-- <script type="text/javascript " src="../assets/js/jquery-3.3.1.min.js "></script> -->
    <!-- Bootstrap tooltips -->
    <script type="text/javascript " src="assets/js/popper.min.js "></script>
    <!-- Bootstrap core JavaScript -->
    <!-- <script type="text/javascript " src="../assets/js/bootstrap.min.js "></script> -->
    <!-- <script type="text/javascript " src="assets/js/bootstrap.js "></script> -->
    <!-- MDB core JavaScript -->
    <script type="text/javascript" src="assets/js/mdb.min.js "></script>
    
    <!-- <script type="text/javascript" src="../assets/js/dataTables.bootstrap4.min.js"></script> -->
    <!-- <script type="text/javascript" src="../assets/js/jquery.dataTables.min.js"></script> -->
  
    <script type="text/javascript">
        new WOW().init();
    </script>
   

<!-- nos script -->
  </body>
</html>

<?php
}
?>



 <?php 
 include('catrine.php');
 

  ?>

<script>
 
    
$('.close_form').on('click', function(e){

	$("#form_nouveau_patient")[0].reset();
})

  

$( "#form_nouveau_patient" ).submit(function( event ) {
  $('#btn_save_patient').attr("disabled", true);
  
 var parametres = $(this).serialize();
	 $.ajax({
			type: "POST",
			url: "ajax/nouveau_patient.php",
			data: parametres,
			 beforeSend: function(objet){
				$("#resultat_ajax").html("Message: Chargement...");
			  },
			success: function(data){
			$("#resultat_ajax").html(data);
			$('#btn_save_patient').attr("disabled", false);
			
			load(1);
		  }
	});
  event.preventDefault();
})

$('#annuler').on('click', function(e){

	$("#form_nouveau_patient")[0].reset();
})



</script>    