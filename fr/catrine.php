<?php if ($lang['langue']=='Fr'):?> 

	<script type="text/javascript">
			$("#region_patient").on('change', function(e){
		    var idregion = $(this).val();    
		    $.ajax({
		        dataType : 'JSON',
		        url : 'ajax/get_departement.php?idregion='+idregion,
		        
		        beforeSend: function(object){
		            $('#loader_departement').html('<img src="img/ajax-loader.gif"> Chargement...');
		        },
		        success : function(data){
		            $('#departement_patient').empty();
		            $('#departement_patient').append("<option disabled selected>Choisir un département</option>");
		            $.each(data, function(id, label){
		                $('#departement_patient').append('<option value="'+id+'">'+label+'</option>');
		            });            
		           $('#loader_departement').html("");            
		        }
		    });
		});

		//traitement des département pour avoir les arrondissements

		$("#departement_patient").on('change', function(e){
		    var iddepartement = $(this).val();
		    $.ajax({
		        data: 'iddepartement='+iddepartement,
		        dataType : 'JSON',
		        url : 'ajax/get_arrondissement.php',
		        
		        beforeSend: function(object){
		            $('#loader_arrondissement').html('<img src="img/ajax-loader.gif"> Chargement...');
		        },
		        success : function(data){
		            $('#arrondissement_patient').empty();
		            $('#arrondissement_patient').append("<option disabled selected>Choisir un arrondissement</option>");
		            $.each(data, function(id, label){
		                $('#arrondissement_patient').append('<option value="'+id+'">'+label+'</option>');
		            });
		            $('#loader_arrondissement').html("");
		            
		        }
		    });
		});
	</script>	

	<?php elseif ($lang['langue']=='Deutch'):?>
		<script type="text/javascript">
			$("#region_patient").on('change', function(e){
		    var idregion = $(this).val();    
		    $.ajax({
		        dataType : 'JSON',
		        url : 'ajax/get_departement.php?idregion='+idregion,
		        
		        beforeSend: function(object){
		            $('#loader_departement').html('<img src="img/ajax-loader.gif"> Chargement...');
		        },
		        success : function(data){
		            $('#departement_patient').empty();
		            $('#departement_patient').append("<option disabled selected>Wählen Sie eine Abteilung aus</option>");
		            $.each(data, function(id, label){
		                $('#departement_patient').append('<option value="'+id+'">'+label+'</option>');
		            });            
		           $('#loader_departement').html("");            
		        }
		    });
		});

		//traitement des département pour avoir les arrondissements

		$("#departement_patient").on('change', function(e){
		    var iddepartement = $(this).val();
		    $.ajax({
		        data: 'iddepartement='+iddepartement,
		        dataType : 'JSON',
		        url : 'ajax/get_arrondissement.php',
		        
		        beforeSend: function(object){
		            $('#loader_arrondissement').html('<img src="img/ajax-loader.gif"> Chargement...');
		        },
		        success : function(data){
		            $('#arrondissement_patient').empty();
		            $('#arrondissement_patient').append("<option disabled selected>Wählen Sie einen Bezirk aus</option>");
		            $.each(data, function(id, label){
		                $('#arrondissement_patient').append('<option value="'+id+'">'+label+'</option>');
		            });
		            $('#loader_arrondissement').html("");
		            
		        }
		    });
		});
	</script>

	<?php elseif ($lang['langue']=='Eng'):?>
		<script type="text/javascript">
			$("#region_patient").on('change', function(e){
		    var idregion = $(this).val();    
		    $.ajax({
		        dataType : 'JSON',
		        url : 'ajax/get_departement.php?idregion='+idregion,
		        
		        beforeSend: function(object){
		            $('#loader_departement').html('<img src="img/ajax-loader.gif"> Chargement...');
		        },
		        success : function(data){
		            $('#departement_patient').empty();
		            $('#departement_patient').append("<option disabled selected>Choose a department</option>");
		            $.each(data, function(id, label){
		                $('#departement_patient').append('<option value="'+id+'">'+label+'</option>');
		            });            
		           $('#loader_departement').html("");            
		        }
		    });
		});

		//traitement des département pour avoir les arrondissements

		$("#departement_patient").on('change', function(e){
		    var iddepartement = $(this).val();
		    $.ajax({
		        data: 'iddepartement='+iddepartement,
		        dataType : 'JSON',
		        url : 'ajax/get_arrondissement.php',
		        
		        beforeSend: function(object){
		            $('#loader_arrondissement').html('<img src="img/ajax-loader.gif"> Chargement...');
		        },
		        success : function(data){
		            $('#arrondissement_patient').empty();
		            $('#arrondissement_patient').append("<option disabled selected>Choose a borough</option>");
		            $.each(data, function(id, label){
		                $('#arrondissement_patient').append('<option value="'+id+'">'+label+'</option>');
		            });
		            $('#loader_arrondissement').html("");
		            
		        }
		    });
		});
	</script>		

	<?php endif; ?>











