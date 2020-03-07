


			function onCatrine () {
				//alert('cliquer');
				// var ms = document.getElementById('startstop').valueAsNumber;
				// e.preventDefault();

					// if (!isNaN(ms)) {

						$('#alarmSet').on('submit', function (e) {
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
		                        success: function(data) {

		                            if(data=='success'){

		                              //alert('Heure modifier avec succes');
		                                

		                            }else{
		                                                       
		                                //alert('Il y\'a eu une erreur');
		                            }
		                        },

		                    });
		                  
		                   
		                });


						var ms = document.getElementById('alarmTime').valueAsNumber;

						if(!isNaN(ms)) {
                			alert(var3);
						}
						 else {
						 	alert(var1);
						 }
                		}


                		function onCatrine2 () {
				//alert('cliquer');
				// var ms = document.getElementById('startstop').valueAsNumber;
				// e.preventDefault();

					// if (!isNaN(ms)) {

						$('#alarmSetCat').on('submit', function (e) {
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
		                        success: function(data) {

		                            if(data=='success'){

		                              //alert('Heure modifier avec succes');
		                                

		                            }else{
		                                                       
		                                //alert('Il y\'a eu une erreur');
		                            }
		                        },

		                    });
		                  
		                   
		                });


						var ms = document.getElementById('alarmTimeC').valueAsNumber;

						if(!isNaN(ms)) {
                			alert(var2);
						}
						 else {
						 	alert(var1);
						 }
                		}