$(document).ready(function(){
			//load(1);
		});

		function load(page){
			var q= $("#q").val();
			$("#loader").fadeIn('slow');
			$.ajax({
				url:'./ajax/getUser.php?action=ajax&page='+page+'&q='+q,
				 beforeSend: function(objet){
				 $('#loader').html('<img src="img/ajax-loader.gif">'+chargement); 
			  },
				success:function(data){
					$(".outer_div").html(data).fadeIn('slow');
					$('#loader').html('');
					console.log('hdgdgdfdfdfdfdfdd');
					
				}
			})
		}