	<?php

	if (isset($con))

		{
	?>
	<!-- Modal -->
	<div class="modal fade" id="modal_message_medecin" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close close_form" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-envelope'></i> <?php echo $lang['sendMessage'] ?> </h4>
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" method="post" id="form_message_medecin" name="form_message_medecin">
			<div id="resultats_ajax"></div>
			  <div class="form-group">
			  	<input type="hidden" name="idpatient" id="idpatient">
			  	<input type="hidden" name="idmedecin" id="idmedecin">
				<label for="patient" class="col-md-3 control-label"><?php echo $lang['patient']; ?></label>
				<div class="col-md-8">
				  <input type="text" class="form-control" id="patient" name="patient" readonly required>
				</div>
			  </div>
			
			  <div class="form-group">
				<label for="email" class="col-md-3 control-label"><?php echo $lang['email']; ?></label>
				<div class="col-md-8">
				  <input type="text" class="form-control" id="email" name="email" readonly required>
				</div>
			  </div>
			  <div class="form-group">
				<label for="message" class="col-md-3 control-label"><?php echo $lang['message']; ?></label>
				<div class="col-md-8">
				  <textarea  class="form-control"  id="message" name="message" placeholder="Votre message"  required></textarea>
				</div>
			  </div>
			 		 
			 
			
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-warning close_form" data-dismiss="modal"><?php echo $lang['annuler']; ?></button>
			<button type="submit" class="btn btn-primary" id="btn_message_medecin"> <?php echo $lang['envoyer']; ?></button>
		  </div>
		  </form>
		</div>
	  </div>
	</div>
	<?php
		}
	?>