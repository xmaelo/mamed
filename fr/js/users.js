		$(document).ready(function(){
			load(1);
		});

		function load(page){
			var q= $("#q").val();
			$("#loader").fadeIn('slow');
			$.ajax({
				url:'./ajax/rechercher_users.php?action=ajax&page='+page+'&q='+q,
				 beforeSend: function(objeto){
				 $('#loader').html('<img src="./img/ajax-loader.gif"> '+chargement);
			  },
				success:function(data){
					$(".outer_div").html(data).fadeIn('slow');
					$('#loader').html('');
					
				}
			})
		}

	
		
			function eliminar (id)
		{
			var q= $("#q").val();
		if (confirm(confirme)){	
		$.ajax({
        type: "GET",
        url: "./ajax/rechercher_users.php",
        data: "id="+id,"q":q,
		 beforeSend: function(objeto){
			$("#resultats").html("Message: "+chargement);
		  },
        success: function(data){
		$("#resultats").html(data);
		load(1);
		}
			});
		}
		}
		
		
		
		

