
<?php 

	include('is_logged.php');
	/* Connect To Database*/
	require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("config/connexion.php");//
 
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

<p style="text-align: center">
	<h4><?php echo $lang['encours']; ?></h4> <b><i>support@mamed.care
</p></i></b>