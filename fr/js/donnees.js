		
		$(document).ready(function(){
			load(1);
		});


		
		function load(page){
			var q_debut = $("#date_debut").val();
			var q_fin= $("#date_fin").val();
			$("#loader").fadeIn('slow');
			$.ajax({
				url:'./ajax/rechercher_donnees.php?action=ajax&page='+page+'&q_debut='+q_debut+'&q_fin='+q_fin,
				 beforeSend: function(objet){
				 $('#loader').html('<img src="./img/ajax-loader.gif"> ');
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
        url: "./ajax/rechercher_donnees.php",
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
		
		
	
$( "#form_nouveau_donnees" ).submit(function( event ) {
  $('#btn_save_donnees').attr("disabled", true);
  
 var parametres = $(this).serialize();
	 $.ajax({
			type: "POST",
			url: "ajax/nouveau_donnees.php",
			data: parametres,
			 beforeSend: function(objet){
				$("#resultat_ajax").html("Message: "+chargement);
			  },
			success: function(data){
			$("#resultat_ajax").html(data);
			$('#btn_save_donnees').attr("disabled", false);
			
			load(1);
		  }
	});
  event.preventDefault();
})



$( "#form_editer_donnees" ).submit(function( event ) {
  $('#mise_a_jour_donnees').attr("disabled", true);  
 	var parametres = $(this).serialize();
 	
 	 $.ajax({
			type: "POST",
			url: "ajax/editer_donnees.php",
			data: parametres,
			 beforeSend: function(objet){
				$("#resultat_ajax2").html("Message: "+chargement);
			  },
			success: function(data){
			$("#resultat_ajax2").html(data);
			$('#mise_a_jour_donnees').attr("disabled", false);
			load(1);
		  }
	});
  event.preventDefault();
})

	
	$('#modal_editer_donnees').on('show.bs.modal', function (event) {
	  var button = $(event.relatedTarget) // Button that triggered the modal
	  var iddonnees = button.data('iddonnees') 
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
	  modal.find('.modal-body #mod_iddonnees').val(iddonnees)
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
		

$('.datepicker').datepicker({
     autoclose: true,
     language: 'fr'
 });		


$('.close_form').on('click', function(e){

	$("#form_nouveau_donnees")[0].reset();
	$('#form_editer_donnees')[0].reset();
})


