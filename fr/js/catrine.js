
								
								var depart = '<option disabled selected>'+ departement +'</option>';
								var arrond = '<option disabled selected>'+ arrondissement +'</option>';


							     $("#region_medecin").on('change', function(e){
							    var idregion = $(this).val();    
							    $.ajax({
							        dataType : 'JSON',
							        url : 'ajax/get_departement.php?idregion='+idregion,
							        
							        beforeSend: function(object){
							            $('#loader_departement').html('<img src="./img/ajax-loader.gif"> '+chargement);
							        },
							        success : function(data){
							            $('#departement_medecin').empty();
							            $('#departement_medecin').append(depart);//"<option disabled selected>departement </option>");
							            $.each(data, function(id, label){
							                $('#departement_medecin').append('<option value="'+id+'">'+label+'</option>');
							            });            
							           $('#loader_departement').html("");            
							        }
							    });
							});

							//traitement des département pour avoir les arrondissements

							$("#departement_medecin").on('change', function(e){
							    var iddepartement = $(this).val();
							    $.ajax({
							        data: 'iddepartement='+iddepartement,
							        dataType : 'JSON',
							        url : 'ajax/get_arrondissement.php',
							        
							        beforeSend: function(object){
							            $('#loader_arrondissement').html('<img src="./img/ajax-loader.gif"> '+chargement);
							        },
							        success : function(data){
							            $('#arrondissement_medecin').empty();
							            $('#arrondissement_medecin').append(arrond);
							            $.each(data, function(id, label){
							                $('#arrondissement_medecin').append('<option value="'+id+'">'+label+'</option>');
							            });
							            $('#loader_arrondissement').html("");
							            
							        }
							    });
							});		
						
