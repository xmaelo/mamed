		$(document).ready(function(){
			load(1);
		});

		function load(page){ 
			var q= $("#q").val();
			$("#loader").fadeIn('slow');
			$.ajax({
				url:'./ajax/rechercher_medecin.php?action=ajax&page='+page+'&q='+q,
				 beforeSend: function(objet){
				 $('#loader').html('<img src="./img/ajax-loader.gif"> '+chargement);
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
			if (confirm(confirme)){	
			$.ajax({
	        type: "GET",
	        url: "./ajax/rechercher_medecin.php",
	        data: "id="+id,"q":q,
			 beforeSend: function(objet){
				$("#resultats").html("Message: "+chargement);
			  },
	        success: function(data){
			$("#resultats").html(data);
			load(1);
			}
				});
			}
		}

		$( "#form_nouveau_medeci" ).submit(function( event ) {
		  $('#btn_save_medeci').attr("disabled", true);
		  
		 var parametres = $(this).serialize();
			 $.ajax({
					type: "POST",
					url: "ajax/nouveau_medecin.php",
					data: parametres,
					 beforeSend: function(objet){
						$("#resultat_ajax").html("Message: "+chargement);
					  },
					success: function(data){
					$("#resultat_ajax").html(data);
                                        if(data.indexOf('alert-danger') == -1){
                                            efface_formulaire();                                          
                                        }
					$('#btn_save_medeci').attr("disabled", false);
					
					load(1);
				  }
			});
		  event.preventDefault();
		})

		$( "#form_editer_medecin" ).submit(function( event ) {
		  $('#mise_a_jour_medecin').attr("disabled", true);
		  
		 var parametres = $(this).serialize();
			 $.ajax({
					type: "POST",
					url: "ajax/editer_medecin.php",
					data: parametres,
					 beforeSend: function(objet){
						$("#resultat_ajax2").html("Message: "+chargement);
					  },
					success: function(data){
					$("#resultat_ajax2").html(data);
					$('#mise_a_jour_medecin').attr("disabled", false);
					load(1);
				  }
			});
		  event.preventDefault();
		})

		$('#myModal2').on('show.bs.modal', function (event) {
	  var button = $(event.relatedTarget) // Button that triggered the modal
	  var idmedecin = button.data('idmedecin') 
	  var idspecialite = button.data('idspecialite') 
	  var idpersonne = button.data('idpersonne') 
	  var nom = button.data('nom') 
	  var prenom = button.data('prenom') 
	  var adresse = button.data('adresse')
	   var datenaiss = button.data('datenaiss')
	  var sexe = button.data('sexe') 
	  var email = button.data('email') 
	  var telephone1 = button.data('telephone1') 
	  var telephone2 = button.data('telephone2') 
	  var anciennete = button.data('anciennete') 
	  var modal = $(this)
	  modal.find('.modal-body #mod_idmedecin').val(idmedecin)
	  modal.find('.modal-body #mod_idpersonne').val(idpersonne)
	  modal.find('.modal-body #mod_idspecialite').val(idspecialite)
	  modal.find('.modal-body #mod_nom').val(nom)
	  modal.find('.modal-body #mod_prenom').val(prenom) 
	  modal.find('.modal-body #mod_datenaiss').val(datenaiss)
	  modal.find('.modal-body #mod_adresse').val(adresse)
	  modal.find('.modal-body #mod_sexe').val(sexe)
	  modal.find('.modal-body #mod_telephone1').val(telephone1)
	  modal.find('.modal-body #mod_telephone2').val(telephone2)
	  modal.find('.modal-body #mod_anciennete').val(anciennete)
	})

$('.datepicker').datepicker({
     autoclose: true,
     language: 'fr'
 });		


$('.close_form').on('click', function(e){

	$("#form_nouveau_medecin")[0].reset();
	$('#form_editer_medecin')[0].reset();
})

$('#annuler').click(function(){
		efface_formulaire();
 })

	function efface_formulaire() {
            $('form')[0].reset();
	}

	$('#form_nouveau_medecin').on('submit', function (e) {
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
