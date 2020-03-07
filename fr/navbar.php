	<?php
    if(isset($_SESSION['role'])){

      $role = $_SESSION['role'];

  		if (isset($title))
  		{
       include('functions_nav.php'); 
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



<nav class="navbar navbar-default bg-info">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header" id="top_target">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
     <input type="hidden" id="id" name="" value="<?php echo $_SESSION['idpersonne']; ?>"> 
    </div>
     <?php if($role == 'Administrateur'){ ?>
    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
      <li class="<?php if (isset($active_accueil)){echo $active_accueil.' btn-outline-infoElogeXmaelactive';}?>   btn-outline-infoElogeXmael">
          <a href="accueil.php"><i class='fa fa-home'></i> <?php echo $lang['accueil']; ?></a>
        </li>        
    		<li class="<?php if (isset($active_patients)){echo $active_patients.' btn-outline-infoElogeXmaelactive';}?>  btn-outline-infoElogeXmael">
          <a href="patients.php"><i class='fa fa-ambulance'></i> <?php echo $lang['patients']; ?> </a>
        </li>
        <li class="<?php if (isset($active_medecins)){echo $active_medecins.' btn-outline-infoElogeXmaelactive';}?>   btn-outline-infoElogeXmael">
          <a href="medecins.php"><i class='fa fa-user-md'></i> <?php echo $lang['medecins']; ?></a>
        </li>
    		<li class="<?php if (isset($active_users)){echo $active_users.' btn-outline-infoElogeXmaelactive';}?>   btn-outline-infoElogeXmael">
          <a href="users.php"><i  class='fa fa-users'> </i> <?php echo $lang['utilisateurs']; ?> </a>
        </li>
        <li class="<?php if (isset($active_param)){echo $active_users.' btn-outline-infoElogeXmaelactive';}?>   btn-outline-infoElogeXmael">
          <a href="reglage.php"><i  class='fa fa-cogs'> </i> <?php echo $lang['reglages']; ?> </a>

        <!-- </li> <li class="<?php if (isset($active_param)){echo $activePatient.' btn-outline-infoElogeXmaelactive';}?>   btn-outline-infoElogeXmael">
          <a href="reglage.php"><i  class='fa fa-cogs'> </i> <?php echo $lang['reglages']; ?> </a>
        </li> 
            -->
        
      </ul>
      <ul class="nav navbar-nav navbar-right">  
        <li>
            <a href="faq.php" target='_blank'><i  class='fa fa-question-circle'></i> FAQ</a>
          </li>      
		    <li>
        <li>
            <a href="apropos.php" target='_blank'><i class='fa fa-institution'></i> <?php echo $lang['aPreoposDeNous']; ?> </a>
          </li>      
        <li>
          <a href="login.php?logout" id="disconnect"><i class='fa fa-power-off'></i> <?php echo $lang['quitter']; ?></a>
        </li>
      </ul>
    </div><!-- /.navbar-collapse -->

   <?php  }else if ($role == "Medecin") { 
        
        $nbre = count_message($_SESSION['idpersonne'], 'medecin');
    ?>

    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
      <li class="<?php if (isset($active_patients)){echo $active_patients.' btn-outline-infoElogeXmaelactive';}?>   btn-outline-infoElogeXmael">
          <a href="mespatients.php"><i class='fa fa-ambulance'></i> <?php echo $lang['mesPatients']; ?></a>
        </li>               
        <li class="<?php if (isset($active_messages)){echo $active_messages.' btn-outline-infoElogeXmaelactive';}?>   btn-outline-infoElogeXmael">
          <a href="messages_medecin.php">
          <i class='fa fa-envelope'></i > <?php echo $lang['messages']; ?>
           
          
          <span class="badge bg-important" id="badge_medecin"><?php if($nbre != 0 ) echo $nbre;  ?></span>

          </a>
        </li>
      </ul>
      <ul class="nav navbar-nav navbar-right">  
        <li>
            <a href="faq.php" target='_blank'><i  class='fa fa-question-circle'></i> FAQ</a>
          </li>      
		    
        <li>
            <a href="apropos.php" target='_blank'><i class='fa fa-institution'></i> <?php echo $lang['aPreoposDeNous']; ?></a>
          </li>      
        <li>
          <a href="login.php?logout" onclick="alerte()" id="disconnect"><i class='fa fa-power-off'></i> <?php echo $lang['quitter']; ?></a>
        </li>
      </ul>
    </div><!-- /.navbar-collapse -->
   <?php }else{

      //$nbre = count_message($_SESSION['idpersonne'], 'patient');
    ?>
        
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li class="<?php if (isset($active_journal)){echo $active_journal.' btn-outline-infoElogeXmaelactive';}?>   btn-outline-infoElogeXmael">
          <a href="journal.php"><i class='fa fa-book'></i> <?php echo $lang['monJournal']; ?> </a>
        </li>  
        <!-- <li class="<?php if (isset($active_mesures)){echo $active_mesures;}?>">
          <a href="mesures.php"><i class='glyphicon glyphicon-screenshot'></i> Mésures</a>
        </li> -->
        <li class="<?php if (isset($active_donnees)){echo $active_donnees.' btn-outline-infoElogeXmaelactive';}?>  btn-outline-infoElogeXmael">
          <a href="donnees.php"><i class='fa fa-list'></i> <?php echo $lang['donnees']; ?></a>
        </li>               
        <li class="<?php if (isset($active_messages)){echo $active_messages.' btn-outline-infoElogeXmaelactive';}?> btn-outline-infoElogeXmael">
          <a href="messages.php" id="item_message_patient"><i class='fa fa-envelope'></i> <?php echo $lang['messages']; ?>
            <span class="badge bg-important" id="badge_patient"></span>
          </a>
        </li>
        <li class="<?php if (isset($active_preferences)){echo $active_preferences.' btn-outline-infoElogeXmaelactive';}?> btn-outline-infoElogeXmael">
          <a href="preferences.php"><i class='fa fa-cogs'></i> <?php echo $lang['preferences']; ?></a>
        </li>
      </ul>
       <ul class="nav navbar-nav navbar-right">  
        <li>
            <a href="faq.php" target='_blank'><i  class='fa fa-question-circle'></i> FAQ</a>
          </li>      
		    <li>
        <li>
            <a href="apropos.php" target='_blank'><i class='fa fa-institution'></i> <?php echo $lang['aPreoposDeNous']; ?></a>
          </li>      
        <li>
          <a href="login.php?logout" onclick="alerte()" id="disconnect"><i class='fa fa-power-off'></i> <?php echo $lang['quitter']; ?> </a>
        </li>
      </ul>
    </div><!-- /.navbar-collapse -->
      
    <?php  } ?>
    
  </div><!-- /.container-fluid -->
</nav>
 
	<?php
		}

   } 
	?>
  <script type="text/javascript">
    alerte() {
      alert 'cliquez';
    }
  </script>

  
  