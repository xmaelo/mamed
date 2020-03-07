

<?php
     

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
  
      include('fileInclu.php');
      header('location:login.php');
  //aucun des deux cas precedents
  //redirection vers la page de login

?>