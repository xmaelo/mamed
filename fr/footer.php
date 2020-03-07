<div class="navbar  bg-info navbar-fixed-bottom" >
      <input type="hidden" id ="role" name="role" value="<?php echo $_SESSION['role']; ?>">
    <div class="container" style="float: center">
      <p class="navbar-text col-ls-12" style="margin: auto;">&copy <?php echo date('Y');?> - MaMED.
          by <a href="http://kamer-center.net" target="_blank" style="color: #ecf0f1">KTC Center</a>          
      </p>
   </div>
      <div style="float: right; display: none;" id="scrollToTop"><a href="#" class="btn btn-success" id="btn_up" title="Aller plus haut"><i class="fa fa-arrow-up"></i></a></div>
</div>
<script src="js/datatables/jquery.dataTables.min.js"></script>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="js/datatables/dataTables.bootstrap.min.js"></script>
<!-- iCheck -->
<script src="libraries/iCheck/icheck.min.js"></script>
 <!-- datepicker -->
<script src="libraries/datepicker/bootstrap-datepicker.js"></script>
<script src="libraries/datepicker/locales/bootstrap-datepicker.fr.js" charset="UTF-8"></script>
<!--  data-toggle-->
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
    <script src="js/daterangepicker/moment.min.js"></script>
    <script src="js/daterangepicker/daterangepicker.js"></script>
      <!-- datepicker -->


<!-- Timepicker -->
<script src="libraries/timepicker/bootstrap-timepicker.min.js"></script>
<!-- ceditor -->
<script src="libraries/ckeditor/ckeditor.js"></script>
<script type="text/javascript">

    $('#disconnect').on('click', function(e){
      e.preventDefault();
      var target = $(this).attr('href');
      if(window.confirm('voulez-vous vraiment quitter?')){
        var id = <?php echo $_SESSION['idusers']; ?>;
        var url = 'ajax/deconnexion.php?id='+id;
        $.ajax({
          url:url,
          success:function(objet){
            document.location.replace(target);
          }
        })
        
      }
    })

 
    $(window).scroll(function() {
        if ($(window).scrollTop() == 0) {
            $('#scrollToTop').fadeOut("fast");
        } else {
            if ($('#scrollToTop').length == 0) {
                $('#scrollToTop').show();
            }
            $('#scrollToTop').fadeIn("fast");
        }
    });
    $('body').on('click', '#scrollToTop a', function(event) {
        event.preventDefault();
        $('html,body').animate({
            scrollTop: 0
        }, 'slow');
    });


      function find_new_message(){  
       

         $.ajax({
     
            url: "ajax/nbre_message.php",
         
 
            ifModified:true,
            success: function(content){
                
                if(content != 0){

                  $('.bg-important').html(content);
                 // alert(content)
                }
            }
        });
        setTimeout(find_new_message,3000); 
      }       

      find_new_message();

</script>



  <!-- <script type="text/javascript " src="../assets/js/jquery-3.3.1.min.js "></script> -->
    <!-- Bootstrap tooltips -->
    <!-- <script type="text/javascript " src="assets/js/popper.min.js "></script> -->
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
    <script  type="text/javascript">
        // $(document).ready(function() {
            // $('[data-toggle="tooltip "]').tooltip();
        // });
        // Material Select Initialization
        // $(document).ready(function() {
        //     $('.mdb-select').material_select();
        // });

        // $(document).ready(function(){
        //     $('[data-toggle="tooltip "]').tooltip();
        // });

        // $(document).ready(function() {  
        //     $('#example').DataTable();
        //       $('.dataTables_length').addClass('bs-select');
        //     $('.dataTables_wrapper').find('label').each(function() {
        //         $(this).parent().append($(this).children());
        //     });
        //     $('.dataTables_filter').find('input').each(function() {
        //         $('input').attr("placeholder", " ");
        //         $('input').removeClass('form-control-sm');
        //     });
        //     $('.dataTables_length').addClass('ml-4 d-flex flex-row');
        //     $('.dataTables_filter').addClass('');
        //     $('select').addClass('mdb-select');
        //     $('.mdb-select').material_select();
        //     $('.mdb-select').removeClass('form-control form-control-sm');
        //     $('.dataTables_filter').find('label').show();
        //     // Data Picker Initialization
        // $('.datepicker').pickadate();
        // });
  
    </script>

<!-- nos script -->

<!-- DataTables -->


<script type="text/javascript">
  $(".tableau_dynamique").DataTable();
</script>

