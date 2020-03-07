
	
$( "#form_nouveau_patient" ).submit(function( event ) {
  $('#btn_save_patient').attr("disabled", true);
  
 var parametres = $(this).serialize();
	 $.ajax({
			type: "POST",
			url: "ajax/nouveau_patient.php",
			data: parametres,
			 beforeSend: function(objet){
				$("#resultat_ajax").html("Message: Chargement...");
			  },
			success: function(data){
			$("#resultat_ajax").html(data);
			$('#btn_save_patient').attr("disabled", false);
			
			load(1);
		  }
	});
  event.preventDefault();
})


$('.datepicker').datepicker({
     autoclose: true,
     language: 'fr'
 });		


$('.close_form').on('click', function(e){

	$("#form_nouveau_patient")[0].reset();
})

//traitement des regions pour avoir les departements

$("#region_patient").on('change', function(e){
    var idregion = $(this).val();    
    $.ajax({
        dataType : 'JSON',
        url : 'ajax/get_departement.php?idregion='+idregion,
        
        beforeSend: function(object){
            $('#loader_departement').html('<img src="./img/ajax-loader.gif"> Chargement...');
        },
        success : function(data){
            $('#departement_patient').empty();
            $('#departement_patient').append(confirme);
            $.each(data, function(id, label){
                $('#departement_patient').append('<option value="'+id+'">'+label+'</option>');
            })            
           $('#loader_departement').html("");            
        }
    })
})

//traitement des département pour avoir les arrondissements

$("#departement_patient").on('change', function(e){
    var iddepartement = $(this).val();
    $.ajax({
        data: 'iddepartement='+iddepartement,
        dataType : 'JSON',
        url : 'ajax/get_arrondissement.php',
        
        beforeSend: function(object){
            $('#loader_arrondissement').html('<img src="./img/ajax-loader.gif"> Chargement...');
        },
        success : function(data){
            $('#arrondissement_patient').empty();
            $('#arrondissement_patient').append(confirme1)
            $.each(data, function(id, label){
                $('#arrondissement_patient').append('<option value="'+id+'">'+label+'</option>');
            })
            $('#loader_arrondissement').html("");
            
        }
    })
})
