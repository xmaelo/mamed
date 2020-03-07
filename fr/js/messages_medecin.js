  //Au chargement de la page
    $(document).ready(function(){
      setTimeout(load(1), 300);
    });

    function load(page){
        var q= $("#q").val();

        $("#loader").fadeIn('slow');
        if(page != 1){
          window.location.reload();
        }else{
          url = './ajax/rechercher_message_medecin.php?action=ajax&page='+page+'&q='+q;

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
function eliminar(id)
    {
    var q= $("#q").val();
    if (confirm(confirme)){  
    $.ajax({
        type: "GET",
        url: "./ajax/messages_medecin.php",
        data: "id="+id,"q":q,
     beforeSend: function(objet){
      $("#resultats").html('<img src="./img/ajax-loader.gif">');
      },
        success: function(data){
    $("#resultats").html(data);
      load(1);
    }
      });
    }
  }

  
