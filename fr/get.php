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
  
     
  header('location:login.php');


 ?>