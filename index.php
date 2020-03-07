
<?php 
header('location:fr/index.php'); 
 ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>maMED</title>
    <link rel="stylesheet" href="fr/css/bootstrap.min.css">
   <link rel="stylesheet" href="fr/css/custom.css">
    <link rel="stylesheet" href="fr/css/style_gestock.css">
    <link rel="stylesheet" href="fr/css/login.css">
    <link rel="stylesheet" href="fr/css/index.css">
    <link rel="stylesheet" href="fr/js/daterangepicker/daterangepicker.css">
    <script src="js/bootstrap-wysiwyg.js"></script> 
    <link rel=icon href='img/logo-maMED.png' sizes="32x32" type="image/gif">
</head>
<body>	
 <div class="container">
        
        <div class="text-center element">
            <form action="fr/index.php" method="post">
            
            	<input class="btn btn-default"  style="margin-right: 5%;" src="img/gif/fr.gif" name="catFrench"  type="submit" value="français"> 
    			<input class="btn btn-default" src="img/gif/de.gif" value="allemand"  type="submit"  name="catAll">
                <!-- <button name="allemand" class="btn btn-default" href="de/index.php"><img src="img/gif/de.gif" value="anglais"> Anglais</button> -->
            </form>
        </div>

        
            

    </div><!-- /container -->

  </body>

  <style type="text/css">
	  	.element {
	  margin-top: 50vh; /* poussé de la moitié de hauteur de viewport */
	  transform: translateY(-50%); /* tiré de la moitié de sa propre hauteur */
	}
  </style>
</html>
