<?php 
  include('is_logged.php');
  include('is_admin.php');
  /* Connect To Database*/
  require_once ("config/db.php");
  require_once ("config/connexion.php");
  require 'flash/vendor/plasticbrain/php-flash-messages/src/FlashMessages.php';
  $active_param="navbarElogeXmaelactive"; 
  $title="Utilisateurs | Simple Stock";




  /*******myOncePhpByCatrine****/

  $query = "SELECT * from clinique where 1";

  $getData = mysqli_query($con, $query);

  $result = mysqli_fetch_array($getData);

  $logo = $result['logo'];


  $nom_clinique = $result['nom_clinique'];
  //$email = $result['email'];
  $telephone = $result['telephone'];
  $site_web = $result['site_web'];
  $info_suplementaire = $result['info_suprementaire'];
  
  
?>
<?php if(isset($_SESSION['dat'])): ?>
  <?php unset($_SESSION['dat']) ?>
    <script type="text/javascript">
      window.location.reload();
    </script>
<?php endif; ?>



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
  <style type="text/css">
    .hr-primary{
                background-image: -webkit-linear-gradient(left, rgba(66,133,244,.8), rgba(66, 133, 244,.6), rgba(0,0,0,0));
              }
    .hr-success{
                background-image: -webkit-linear-gradient(left, rgba(15,157,88,.8), rgba(15, 157, 88,.6), rgba(0,0,0,0));
              }
  </style>
  </head>
  <body>
  <?php
  include("navbar.php");
  ?> 
    <div class="container">
      <div class="panel panel-success" style="margin-top: 40px;">
        <div class="panel-heading">
          <h4><i class='fa fa-search'></i> <?php echo $lang['reglages']; ?></h4>

          <div class="panel-body">
          <div class="row col-md-12">
            <section class="panel">
              <div class="form">
                <span id="resultat_ajax_preferences"></span>
                
                  <!-- l'alarme -->
                  <legend><?php echo $lang['infoCliniq']; ?></legend>

                    <div>

                      <?php 
                           if(isset($_SESSION['data']))
                            {
                              
                                $msg = new \Plasticbrain\FlashMessages\FlashMessages();
       
                                // Add a few messages
                                $msg->success($lang['infosDejamiseajour']);
                                // $msg->success('This is a success message');
                                // $msg->warning('This is a warning message');
                                // $msg->error('This is an error message');
                                 
                                // Display the messages
                                $msg->display();
                                unset($_SESSION['data']);
                            }
                       ?>
                    </div>

              
                      <br>
                      <label class="col-md-2"><?php  echo $lang['nom de la clinique']; ?></label>
                      <div class="col-md-3">
                        <input class="form-control col-md-5 nom_clinique" type="text"  value="<?php echo $nom_clinique; ?>" style="width: 100%;">
                      </div>
                      <div class="col-md-3">
                        <button type="button" onclick="catrine1('nom_clinique')"  class="btn btn-info cat1" style="width: 100%;"><?php  echo $lang['modifier']; ?></button>
                      </div><br>
                      <hr class="hr-success" style="margin-left: 0px">                      
                   

                    
                      
                      <label class="col-md-2"><?php  echo $lang['logo']; ?></label>
                      <div class="col-md-3">
                      
                       <img src="<?php if(!$logo==NULL) { echo $logo; } else { echo 'img/logo-maMED.jpeg'; } ?>" width="80" height="80" style = "transform: translateY(-10px);" >
                     
                        
                      
                      </div>
                       <div class="col-md-3">
                        <a href="#"  title='Editer le logo' data-toggle="modal" data-target="#modal_logo">
                          <button type="submit" class="btn btn-info" style="width: 100%;" >
                            <?php  echo $lang['modifier']; ?>
                          </button>
                        </a> 
                      </div>
                      <br><br>
                

                      <hr class="hr-success" style="margin-left: 0px">  

                    

                    <label class="col-md-2"><?php  echo $lang['phone']; ?></label>
                      <div class="col-md-3">
                        <input class="form-control col-md-5 telephone" type="number"  value="<?php echo $telephone; ?>" style="width: 100%;">
                      </div>
                      <div class="col-md-3">
                        <button type="button" onclick="catrine1('telephone')" class="btn btn-info" style="width: 100%;"><?php  echo $lang['modifier']; ?></button>
                      </div><br>
                      <hr class="hr-success" style="margin-left: 0px">                      
                    </div>

                    <label class="col-md-2"><?php  echo $lang['siteWeb']; ?></label>
                      <div class="col-md-3">
                        <input class="form-control col-md-5 site_web" type="text"  value="<?php echo $site_web; ?>" style="width: 100%;">
                      </div>
                      <div class="col-md-3">
                        <button type="button" onclick="catrine1('site_web')" class="btn btn-info" style="width: 100%;"><?php  echo $lang['modifier']; ?></button>
                      </div><br>
                      <hr class="hr-success" style="margin-left: 0px">                      
                  
                    <label class="col-md-2"><?php  echo $lang['autreInfoss']; ?></label>
                      <div class="col-md-3">
                        <input class="form-control col-md-5 info_suprementaire" type="text"  value="<?php echo $info_suplementaire; ?>" style="width: 100%;">
                      </div>
                      <div class="col-md-3">
                        <button type="button" onclick="catrine1('info_suprementaire')" class="btn btn-info" style="width: 100%;"><?php  echo $lang['modifier']; ?></button>
                      </div><br><br>
                      <hr class="hr-success" style="margin-left: 0px">                      
                    </div>



                     

                      <div class="modal fade" id="modal_logo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                        <div class="modal-dialog" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                              <h4 class="modal-title" id="myModalLabel"><i class='fa fa-edit'></i><?php echo $lang['changementLogo']; ?> </h4>
                              </div>

                              <form class="form-horizontal" method="post" id="logo" name="logo" method="post" action="ajaxPreference.php">
                              <div class="modal-body">
                              
                               
                                <div class="form-group">
                                <label for="user_password_new3" class="col-sm-4 control-label"><?php echo $lang['nouveauLogo']; ?></label>
                                <div class="col-sm-8">
                                  <input type="file" class="form-control" id="logoId" name="logoId" required>                      
                                </div>
                                </div>
                              
                                         
                        </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-warning" id="annuler" data-dismiss="modal"><?php echo $lang['annuler']; ?></button>
                        <button type="submit" class="btn btn-primary" onclick='setInterval("window.location.reload()", 400);' id="btn_modifier_password"><?php echo $lang['miseAjour']; ?></button>
                        </div>
                        </form>
                      </div>
                      </div>
                    </div>

                    </div>
                            </div>



                        
              </div>

            </section>
          </div>


    </div>
  </div>


 

<?php
  include("footer.php");
  ?>
  <script type="text/javascript">
    
/************************************ajaxStartForResolveTheProblemByCatrine******************/

      function catrine1(source) {

        var provider = '.'+source;
        //console.log(provider);
        var val = $(provider).val();
        // console.log(val);

         $.ajax({           
            url: 'ajaxPreference.php?cat='+val+'&id='+source,                              
            success: function(data) { 
                if(data == 1) {

                  window.location.reload();
                  
                }       
              }
        });
         //console.log('fait');
      }


  /****************blogSpecificatedForUploadFileTypeLogoByAdmistratorPoweredByCatrine****************/

   $('#logo').on('submit', function (e) {
                    // On empêche le navigateur de soumettre le formulaire
                    e.preventDefault();
             
                    var $form = $(this);
                    var formdata = (window.FormData) ? new FormData($form[0]) : null;
                    var data = (formdata !== null) ? formdata : $form.serialize();
                    var vrai=true;

                    
                    

                    $.ajax({
                        url: $form.attr('action'),
                        type: $form.attr('method'),
                        contentType: false, // obligatoire pour de l'upload
                        processData: false, // obligatoire pour de l'upload
                        dataType: 'json', // selon le retour attendu
                        data: data,
                        success: function(i) {

                            if(i==''){

                              window.location.reload();
                                

                            }else{
                              

                               
                                
                                
                                
                            }
                        },

                    });
                  
                   
                });

  



   /************************************endOfAjaxByCatrine**************************************/


  </script>


  
  


  </body>

</html>