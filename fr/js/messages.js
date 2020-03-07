
  //Au chargement de la page
    $(document).ready(function(){
      load(1);
    });

    function load(page){
        var q= $("#q").val(); 

        $("#loader").fadeIn('slow');
        if(page != 1){
          // window.location.reload();
        }else{
          url = './ajax/rechercher_message_patient.php?action=ajax&page='+page+'&q='+q;

          $.ajax({
            url:url,
              beforeSend: function(objet){
              $('#loader').html('<img src="./img/ajax-loader.gif">');              
              },
            success:function(data){
              $(".outer_div").html(data).fadeIn('slow');
              $('#loader').html(''); 
            }
          })
        }     
    } 

    //Enable iCheck plugin for checkboxes
    //iCheck for checkbox and radio inputs
    $('.mailbox-messages input[type="checkbox"]').iCheck({
      checkboxClass: 'icheckbox_flat-blue',
      radioClass: 'iradio_flat-blue'
    });

    //Enable check and uncheck all functionality
    $(".checkbox-toggle").click(function () {
      var clicks = $(this).data('clicks');
      if (clicks) {
        //Uncheck all checkboxes
        $(".mailbox-messages input[type='checkbox']").iCheck("uncheck");
        $(".fa", this).removeClass("fa-check-square-o").addClass('fa-square-o');
      } else {
        //Check all checkboxes
        $(".mailbox-messages input[type='checkbox']").iCheck("check");
        $(".fa", this).removeClass("fa-square-o").addClass('fa-check-square-o');
      }
      $(this).data("clicks", !clicks);
    });

    

    //Handle starring for glyphicon and font awesome
    $(".mailbox-star").click(function (e) {
      e.preventDefault();
      //detect type
      var $this = $(this).find("a > i");
      var glyph = $this.hasClass("glyphicon");
      var fa = $this.hasClass("fa");

      //Switch states
      if (glyph) {
        $this.toggleClass("fa-star");
        $this.toggleClass("glyphicon-star-empty");
      }

      if (fa) {
        $this.toggleClass("fa-star");
        $this.toggleClass("fa-star-o");
      }
    });




 
 $('.btn-close').click(function(e){
    e.preventDefault();
    $(this).parent().parent().parent().fadeOut();
  });
  $('.btn-minimize').click(function(e){
    e.preventDefault();
    alert('ok');
    var $target = $(this).parent().parent().next('.box-content');
    if($target.is(':visible')) $('i',$(this)).removeClass('chevron-up').addClass('chevron-down');
    else             $('i',$(this)).removeClass('chevron-down').addClass('chevron-up');
    $target.slideToggle();
  });



