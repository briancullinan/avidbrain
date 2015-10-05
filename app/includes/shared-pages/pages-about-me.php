<?php if(isset($app->user->email) && $app->user->email == $app->currentuser->email): ?>

	<?php if($app->user->usertype=='admin'): ?>

		<div class="row">
			<div class="col s12 m6 l6">
				<h2>Un-Verified Copy</h2>
				<h3 class="edit-change">
					<input type="text" name="editprofile[short_description]" maxlength="40" value="<?php echo $app->currentuser->short_description; ?>"	/>
				</h3>				
				<div class="edit-change">
					<textarea name="editprofile[personal_statement]" class="materialize-textarea"><?php echo $app->currentuser->personal_statement; ?></textarea>
				</div>
			</div>
			<div class="col s12 m6 l6">
				<h2>Verified Copy</h2>
				<h3 class="edit-change">
					<input type="text" name="editprofile[short_description_verified]" maxlength="40" value="<?php echo $app->currentuser->short_description_verified; ?>"	/>
				</h3>				
				<div class="edit-change">
					<textarea name="editprofile[personal_statement_verified]" class="materialize-textarea"><?php echo $app->currentuser->personal_statement_verified; ?></textarea>
				</div>
			</div>
		</div>

	<?php else: ?>
	
		<?php if(isset($app->currentuser->short_description_verified_status)): ?>
			<div class="alert red white-text">
				You have modified your short description, your previous short description will show on your profile, until it's been reviewed.
			</div>
		<?php elseif(isset($app->currentuser->short_description_verified)): ?>
			<div class="alert blue white-text">
				Your short description has been verified, if you modify it, <?php echo $app->dependents->SITE_NAME_PROPPER; ?> will have to re-verify it, before it's public.
			</div>
		<?php endif; ?>
	
		<h3 class="edit-change" id="addshortdescription">
			<input type="text" name="editprofile[short_description]" placeholder="Please add a short description about yourself" maxlength="40" value="<?php echo $app->currentuser->short_description; ?>"	/>
		</h3>
	
		<?php if(isset($app->currentuser->personal_statement_verified_status)): ?>
			<div class="alert red white-text">
				You have modified your personal statement, your previous personal statement will show on your profile, until it's been reviewed.
			</div>
		<?php elseif(isset($app->currentuser->personal_statement_verified)): ?>
			<div class="alert blue white-text">
				Your personal statement has been verified, if you modify it, <?php echo $app->dependents->SITE_NAME_PROPPER; ?> will have to re-verify it, before it's public.
			</div>
		<?php endif; ?>
		
		<div class="edit-change" id="addpersonalstatement">
			<textarea name="editprofile[personal_statement]" placeholder="Please describe yourself" class="materialize-textarea"><?php echo $app->currentuser->personal_statement; ?></textarea>
		</div>
	
	<?php endif; ?>

<?php else: ?>

	<h3>
		<?php echo $app->currentuser->short_description_verified; ?>
	</h3>
	<div class="tutor-statement"><?php echo nl2br($app->currentuser->personal_statement_verified); ?></div>

<?php endif; ?>