	<?php
		if (isset($con))
		{
	?>
	<!-- Modal -->
	<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel"><i class='fa fa-edit'></i> <?php echo $lang['editerUse']; ?></h4>
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" method="post" id="editer_users" name="editer_users">
			<div id="resultats_ajax2"></div>
			<!--user -->
			<input type="hidden" class="form-control" id="idusers" name="idusers">
			<!--personne-->
			<input type="hidden" class="form-control" id="idpersonne" name="idpersonne">

			<div class="form-group">
				<label for="old_email" class="col-sm-4 control-label"><?php echo $lang['ancienAdresse']; ?></label>
				<div class="col-sm-8">
				  <input type="email" class="form-control" id="old_email" name="old_email" title="Ancienne adresse électronique" required readonly>
				</div>
			</div>
			  <div class="form-group">
				<label for="new_email" class="col-sm-4 control-label"><?php echo $lang['nouvelleAdresse']; ?><span class="obligatoire">*</span></label>
				<div class="col-sm-8">
				  <input type="email" class="form-control" id="new_emails" name="new_email" placeholder="<?php echo $lang['nouvelleAdresse']; ?>" required>
				</div>
			  </div>
			  <div class="form-group">
				<label for="confirmer_email" class="col-sm-4 control-label"><?php echo $lang['confirmation']; ?><span class="obligatoire">*</span></label>
				<div class="col-sm-8">
				  <input type="email" class="form-control" id="confirmer_email" name="confirmer_email" placeholder="<?php echo $lang['confirmation']; ?>" required>
				</div>
			  </div>
						 	 
			
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-warning" data-dismiss="modal"><?php echo $lang['annuler']; ?></button>
			<button type="submit" class="btn btn-primary" id="actualiser_data"><?php echo $lang['miseAjour']; ?></button>
		  </div>
		  </form>
		</div>
	  </div>
	</div>
	<?php
		}
	?>