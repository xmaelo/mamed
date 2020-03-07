		
		//Au chargement de la page
		$(document).ready(function(){
			load(1);
		});

		function load(page){
				var q= $("#q").val();
				$("#loader").fadeIn('slow');
				if(page != 1){
					window.location.reload();
				}else{
					url = './ajax/rechercher_mesure.php?action=ajax&page='+page+'&q='+q;
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
		}


	function eliminar(id)
		{
		var q= $("#q").val();
		if (confirm(confirme)){	
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
		//le chronomètre

		    $('#toggle-event_apres_repas').change(function() {
		      if($(this).prop('checked') == ''){
		      	$('#chronotime').show();
		      	//alert()
		      	chronoStart();

		      	//alert(min)      		
		      }else{
		      	chronoStopReset();
		      	$('#chronotime').hide();
		      }
		    })

		    $('#toggle-event_preventive').change(function() {
		      if($(this).prop('checked') == ''){
		      	$('#chronotime2').show();

		      	chronoStart(heur, mn, sc);
		      }else{
		      	chronoStopReset();
		      	$('#chronotime2').hide();
		      }
		    })

		    //Formulaire de d'ajout d'une nouvelle mesure
		    $( "#form_nouvelle_mesure" ).submit(function( event ) {
			  $('#btn_save_mesure').attr("disabled", true);
			  
			 var parametres = $(this).serialize();
				 $.ajax({
						type: "POST",
						url: "ajax/nouvelle_mesure.php",
						data: parametres,
						 beforeSend: function(objet){
							$("#resultat_ajax").html("Message: Chargement...");
						  },
						success: function(data){
						$("#resultat_ajax").html(data);
                                                 if(data.indexOf('alert-danger') == -1){
                                                     //alert(0)
                                                    $('#form_nouvelle_mesure')[0].reset();  
                                                 }
						$('#btn_save_mesure').attr("disabled", false);
						
						load(1);
					  }
				});
			  event.preventDefault();
			})

			//formulaire de modification d'une mesure
			$( "#form_editer_mesure" ).submit(function( event ) {
			  $('#btn_editer_mesure').attr("disabled", true);  
			 var parametres = $(this).serialize();		
			 
			 	 $.ajax({
						type: "POST",
						url: "ajax/editer_mesure.php",
						data: parametres,
						 beforeSend: function(objet){
							$("#resultat_ajax_mesure").html("Message: Chargement...");							
						  },
						success: function(data){
						$("#resultat_ajax_mesure").html(data);
                                                if(data.indexOf('alert-danger') == -1){
                                                    efface_formulaire();   
                                                     window.setTimeout(function() {
                                                        $(".alert").fadeTo(2000, 0).slideUp(500, function(){
                                                        $(this).remove();});
                                                        load(1);
                                                    }, 2000);

                                                }
						$('#btn_editer_mesure').attr("disabled", false);
						
					  }
				});
			  event.preventDefault();
			})

		    //vider le formulaire
			$('.close_form').on('click', function(e){

				$("#form_nouvelle_mesure")[0].reset();
				$("#resultat_ajax").hide();
				$('#form_editer_mesure')[0].reset();
			})

			//formulaire editer les informations des patients
			$( "#form_editer_patientt" ).submit(function( event ) {
			  
			 $('#mise_a_jour_patientt').attr("disabled", true);  
			 	var parametres = $(this).serialize();
			 	//var user_appelant = $('#mod_appelant').val();
			 	//alert(user_appelant);
			 	
			 	 $.ajax({
						type: "POST",
						url: "ajax/editer_patient.php",
						// contentType: false, // obligatoire pour de l'upload
                 		// processData: false, // obligatoire pour de l'upload
						data: parametres,
						 beforeSend: function(objet){
							$("#resultat_ajax2").html("Message: Chargement..."); 
						  },
						success: function(data){
						$("#resultat_ajax2").html(data);
						$('#mise_a_jour_patient').attr("disabled", false);
					
						if(data.indexOf("alert-danger") == -1){

							load(2);

						}else{

							load(1);
						}
						
					  }
				});
			  event.preventDefault();

			})

			
			//Chargement des info dans le formulaire du patient
	$('#modal_editer_patient').on('show.bs.modal', function (event) {
	  var button = $(event.relatedTarget) // Button that triggered the modal
	  var idpatient = button.data('idpatient') 
	  var idtype_diabete = button.data('idtype_diabete') 
	  var idpersonne = button.data('idpersonne') 
	  var nom = button.data('nom') 
	  var prenom = button.data('prenom') 
	  var adresse = button.data('adresse')
	   var datenaiss = button.data('datenaiss')
	  var sexe = button.data('sexe') 
	  var email = button.data('email') 
	  var telephone1 = button.data('telephone1') 
	  var telephone2 = button.data('telephone2')
	  var poids = button.data('poids')  
	  var taille = button.data('taille') 
	  var personne_urgence = button.data('personne_urgence') 
	  var telephone_urgence = button.data('telephone_urgence') 
	  var appelant = button.data('appelant')
	

	  var modal = $(this)
	  modal.find('.modal-body #mod_idpatient').val(idpatient)
	  modal.find('.modal-body #mod_idpersonne').val(idpersonne)
	  modal.find('.modal-body #mod_idtype_diabete').val(idtype_diabete)
	  modal.find('.modal-body #mod_nom').val(nom)
	  modal.find('.modal-body #mod_prenom').val(prenom) 
	  modal.find('.modal-body #mod_datenaiss').val(datenaiss)
	  modal.find('.modal-body #mod_adresse').val(adresse)
	  modal.find('.modal-body #mod_sexe').val(sexe)
	  modal.find('.modal-body #mod_telephone1').val(telephone1)
	  modal.find('.modal-body #mod_telephone2').val(telephone2)
	  modal.find('.modal-body #mod_poids').val(poids)
	  modal.find('.modal-body #mod_taille').val(taille)
	  modal.find('.modal-body #mod_personne_urgence').val(personne_urgence)
	  modal.find('.modal-body #mod_telephone_urgence').val(telephone_urgence)
	  modal.find('.modal-body #mod_appelant').val(appelant);
	

	})

	//Chargement des info dans le formulaire d'ajout des mesures
	$('#editerMesure').on('show.bs.modal', function (event) {
	  var button = $(event.relatedTarget) // Button that triggered the modal
	  var idjournal = button.data('idjournal') 
	  var valeur = button.data('valeur') 
	  var creneau = button.data('creneau')
	  var idmesure = button.data('idmesure') 
	  var insuline = button.data('insuline') 
	  var insuline2 = button.data('insuline2') 
	  var pression_arterielle = button.data('pression_arterielle') 
	  var acetone = button.data('acetone')
	   var hba1c = button.data('hba1c')
	  var notes = button.data('notes') 	  

	  var modal = $(this)
	  modal.find('.modal-body #mod_idjournal').val(idjournal)
	  modal.find('.modal-body #mod_idmesure').val(idmesure)
	  modal.find('.modal-body #mod_valeur').val(valeur)
	  modal.find('.modal-body #mod_insuline').val(insuline)
	  modal.find('.modal-body #mod_insuline2').val(insuline2)
	  modal.find('.modal-body #mod_pression_arterielle').val(pression_arterielle) 
	  modal.find('.modal-body #mod_acetone').val(acetone)
	  modal.find('.modal-body #mod_hba1c').val(hba1c)
	  modal.find('.modal-body #mod_notes').val(notes)
	})
        
        $('#annuler').click(function(){
		efface_formulaire();
 })

	function efface_formulaire() {
            $('form')[0].reset();
	}


	$('#form_editer_patienttt').on('submit', function (e) {
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
