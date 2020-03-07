	<?php
		if (isset($con))
		{
	?>
	<!-- Modal -->
	<div class="modal fade" id="myModal3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel"><i class='fa fa-edit'></i><?php echo $lang['changePassword']; ?> </h4>
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" method="post" id="editer_password" name="editar_password"  action = "ajax/edit_pass.php">
			<div id="resultats_ajax3"></div>
			 
			  <div class="form-group">
				<label for="user_password_new3" class="col-sm-4 control-label"><?php echo $lang['newPassword']; ?></label>
				<div class="col-sm-8">
				  <input type="password" class="form-control" id="user_password_new3" name="user_password_new3" placeholder="<?php echo $lang['newPassword']; ?>" pattern=".{6,}" title="Mot de passe ( min . 6 caracteres)" required>
					<!-- <input type="hidden" id="mod_id_user" name="mod_id_user"> -->
				</div>
			  </div>
			  <div class="form-group">
				<label for="user_password_repeat3" class="col-sm-4 control-label"><?php echo $lang['confirmation']; ?></label>
				<div class="col-sm-8">
				  <input type="password" class="form-control" id="user_password_repeat3" name="user_password_repeat3" placeholder="<?php echo $lang['confirmation']; ?>" pattern=".{6,}" required>
				</div>
			  </div>
			 
			  

			 
			 
			
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-warning" id="annuler" data-dismiss="modal"><?php echo $lang['annuler']; ?></button>
			<button type="submit" class="btn btn-primary" id="btn_modifier_password"><?php echo $lang['miseAjour']; ?></button>
		  </div>
		  </form>
		</div>
	  </div>
	</div>
	<?php
		}
	?>	