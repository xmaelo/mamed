$('.btn-minimize').click(function(e){
    e.preventDefault();
    var $target = $(this).parent().parent().next('.box-content');
    if($target.is(':visible')) $('i',$(this)).removeClass('glyphicon-chevron-down').addClass('glyphicon-chevron-down');
    else             $('i',$(this)).removeClass('glyphicon-chevron-down').addClass('glyphicon-chevron-up');    	
    $target.slideToggle();
    var val = $(this).attr('href');
    $.ajax({

                url:'ajax/marquer_comme_lu.php',
                data:'val='+val,
                dataType:'json',
                success:function(json){
                     
                     if(json != true){

                     	$('.bg-important').hide();
                     }
                }
            });       

  });

if(count_message_patient($idpatient, $idmedecin) != 0) echo "  <span class='badge bg-important'>".count_message_patient($idpatient, $idmedecin)."</span>"; 