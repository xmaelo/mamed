

/*Mon script permet de contacter php a tous moment pour obtenir l'heure courant et verifier le mail*/

/* Develloper par startBoy*/
		//console.log('hxdjdjcjcjccjcjcj');
		function catrine() 
			{
				$(function() {
		        
		          $.ajax({
		            type: 'GET',
		            url: 'php.php',
		            timeout: 3000,
		            success: function(data) {


		           console.log(data);
		            //console.log(((new Date)).getTime());


		            

		             },
		            error: function() {
		              //alert('La requête n\'a pas abouti'); }
		          });    
		        });  
		     

			}

			setInterval("catrine()", 500);

			function catrine2() 
			{
				$(function() {
		        
		          $.ajax({
		            type: 'GET',
		            url: 'phpH.php',
		            timeout: 3000,
		            success: function(data) {


		            //alert(data);


		            

		             },
		            error: function() {
		              //alert('La requête n\'a pas abouti'); }
		          });    
		        });  
		     

			}

			setInterval("catrine2()", 500);
