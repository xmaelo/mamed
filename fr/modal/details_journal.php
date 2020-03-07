<?php

	if (isset($con))
	{
		require_once ("functions.php");

?>	
	<div class="modal fade" id="medecin_patient_Modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document" style="width:80%;">
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel"><i class='fa fa-edit'></i> Journal résumé</h4>
			  </div>
			  <div class="modal-body">	
			  	<form class="form-horizontal" method="post" id="editar_producto" name="editar_producto">		  
				  	<input type="text" class="form-control" id="journal_idpersonne" name="idpatient">
				  	<input type="text" class="form-control" id="" name="idpersonne">
				  	<span id="journal_idpatient"></span>
 				</form>
			</div>  
		</div>	
	</div>

</div>
<?php } ?>