		
		//Au chargement de la page
		$(document).ready(function(){
			load(1);
		});

		function load(page){ 
				var q= $("#q").val();
				$("#loader").fadeIn('slow');
				var idpersonne = $('#petient_idpersonne').val();
				//alert(idpersonne);
					url = './ajax/dossier_patient.php?action=ajax&idpersonne='+idpersonne+'&page='+page+'&q='+q;
					$.ajax({
						url:url,
					    beforeSend: function(objet){
							$('#loader').html('<img src="./img/ajax-loader.gif"> Chargement...');
					  	},
						success:function(data){
							$(".outer_div").html(data).fadeIn('slow');
							$('#loader').html('');
						
						}
					})
							
		}


	function eliminar(id)
		{
		var q= $("#q").val();
		if (confirm("Voulez vous supprimer cette mesure?")){	
		$.ajax({
        type: "GET",
        url: "./ajax/rechercher_mesure.php",
        data: "id="+id,"q":q,
		 beforeSend: function(objet){
			$("#resultats").html("Message: Chargement...");
		  },
        success: function(data){
		$("#resultats").html(data);
			load(1);
		}
			});
		}
	}

	$( "#form_message_medecin" ).submit(function( event ) {
		  $('#btn_message_medecin').attr("disabled", true);
		  var form = $(this);
		 var parametres = $(this).serialize();
			 $.ajax({
					type: "POST",
					url: "ajax/send_message_medecin.php",
					data: parametres,
					 beforeSend: function(objet){
						$("#resultats_ajax").html("Message: Chargement...");
					  },
					success: function(data){
					$("#resultats_ajax").html(data);
                                        if(data.indexOf('alert-danger') == -1){
                                            efface_formulaire();   
                                             window.setTimeout(function() {
                                                $(".alert").fadeTo(2000, 0).slideUp(500, function(){
                                                $(this).remove();});
                                                location.replace('');
                                            }, 2000);
                                            
                                        }
					$('#btn_message_medecin').attr("disabled", false);
					
					load(1);
				  }
			});
		  event.preventDefault();
		})

		
		//vider le formulaire
		$('.close_form').on('click', function(e){
			$("#form_message_medecin")[0].reset();
			$("#resultats_ajax").hide();
		})

			
			


	//Chargement des info dans le formulaire d'ajout des mesures
	$('#modal_message_medecin').on('show.bs.modal', function (event) {
	  var button = $(event.relatedTarget) // Button that triggered the modal
	  var idpatient = button.data('idpatient') 
	  var patient = button.data('patient') 
	  var email = button.data('email')
	  var idmedecin = button.data('idmedecin') 

	  var modal = $(this)
	  modal.find('.modal-body #idpatient').val(idpatient)
	  modal.find('.modal-body #idmedecin').val(idmedecin)
	  modal.find('.modal-body #patient').val(patient)
	  modal.find('.modal-body #email').val(email)
	})