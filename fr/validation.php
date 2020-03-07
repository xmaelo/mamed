<?php 
 
  session_start();
  //session_destroy();
  //session_destroy();
  
  if (!isset($_SESSION['user_login_status'])){

    header("location: login.php");
    exit();
  }elseif(isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] == 1){

    header("location: accueil.php");
  }else{  
       
// checking for minimum PHP version
if (version_compare(PHP_VERSION, '5.3.7', '<')) {
    exit("Sorry, Simple PHP Login does not run on a PHP version smaller than 5.3.7 !");
} else if (version_compare(PHP_VERSION, '5.5.0', '<')) {
    // if you are using PHP 5.3 or PHP 5.4 you have to include the password_api_compatibility_library.php
    // (this library adds the PHP 5.5 password hashing functions to older versions of PHP)
    require_once("libraries/password_compatibility_library.php");
}

// include the configs / constants for the database connection
require_once("config/db.php");
require_once("config/connexion.php");
$errors = array();
$messages = array();
// load the login class




    $login = $_SESSION['login'];
    $code_base = $_SESSION['code'];
    $idusers = $_SESSION['idusers'];

      if(isset($_SESSION['lang'])){
            $lage='langues/'.$_SESSION['lang'].'.php';
            
            
            }
            else{
              $_SESSION['lang']='Fr';
               $lage='langues/'.$_SESSION['lang'].'.php';
            
            

            }
            //var_dump($lage);


     require_once ($lage);  
   



    if(isset($_POST['validation'])){

      $code = $email=mysqli_real_escape_string($con,(strip_tags($_POST["code"],ENT_QUOTES)));
      if($code == $code_base){

        $sql = "UPDATE users SET etat = 1 WHERE idusers = '$idusers'";
        if(mysqli_query($con,$sql)){

          echo $_SESSION['user_login_status'] = 1;

          header('Location:accueil.php'); 

        }else{

          //var_dump($sql);
          $errors[] = "Erreur lors de la validation! veuillez ressayer plus tard.";
        }
        
      }else{

        $errors[] = "Code de validation incorrect!";
      }
    }


  
  

?>
  <!DOCTYPE html>
<html lang="fr">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no"/>
  <title>MaMED | Validation</title>
  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
  <!-- CSS  -->
   <link href="css/login.css" type="text/css" rel="stylesheet" media="screen,projection"/>
   <link rel=icon href='img/logo-maMED.png' sizes="32x32" type="image/png">
</head>
<body>  
 <div class="container">
        <div class="card card-container">
        <div style="text-align:center; size: 1.3em; font-weight: bold;"><?php echo $lang['code']; ?></div>
            <img id="profile-img" class="profile-img-card" src="img/1vgB.jpeg" />
            <p id="profile-name" class="profile-name-card" style="color:Green;"><?php echo $lang['messagesValidate']; ?></p>
            <form method="post" accept-charset="utf-8" action="" name="form_validation" autocomplete="off" role="form" class="form-signin">
      <?php
        // show potential errors / feedback (from login object)
        
          if ($errors) {
            ?>
            <div class="alert alert-danger alert-dismissible" role="alert">
                <strong>Erreur!</strong> 
            
            <?php 
            foreach ($errors as $error) {
              echo $error;
            }
            ?>
            </div>
            <?php
          }
          if ($messages) {
            ?>
            <div class="alert alert-success alert-dismissible" role="alert">
                <strong>Info!</strong>
            <?php
            foreach ($messages as $message) {
              echo $message;
            }
            ?>
            </div> 
            <?php 
          }
        
        ?>
                <span id="reauth-email" class="reauth-email"></span>
                <input class="form-control" placeholder="adresse email" name="email" type="email" value="<?php echo $login; ?>" readonly="" required>
                <input class="form-control"  name="code" type="text" autofocus=""  value="" autocomplete="off" required>
                <button type="submit" class="btn btn-lg btn-success btn-block btn-signin" name="validation" id="submit"><?php echo $lang['validate']; ?></button>               
            </form><!-- /form -->
            
        </div><!-- /card-container -->
    </div><!-- /container -->
     <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <!-- Latest compiled and minified JavaScript -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>

  </body>
</html>
<?php } ?>
