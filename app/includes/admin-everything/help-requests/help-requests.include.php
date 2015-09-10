<?php if(isset($app->helpme[0])): ?>
	<?php foreach($app->helpme as $helpme): ?>
	
	<?php
		$emailVars = "?subject=".$app->dependents->SITE_NAME_PROPPER." Help Request&body=Hello, I'm here with ".$app->dependents->SITE_NAME_PROPPER." Support. <br><br><br> <strong>Your Message:</strong> ".$helpme->message;
	?>
	
		<div class="block">
			<?php if(isset($helpme->activeuser)): ?>
			<div class="alert green white-text">
				This is an active avidbrain user
			</div>
			<?php endif; ?>
			<div class="row">
				<div class="col s12 m2 l2">
					<strong>Name</strong>
				</div>
				<div class="col s12 m10 l10">
					<?php echo $helpme->name; ?>
				</div>
			</div>
			<div class="row">
				<div class="col s12 m2 l2">
					<strong>Email</strong>
				</div>
				<div class="col s12 m10 l10">
					<a href="mailto:<?php echo $helpme->email.$emailVars; ?>"><?php echo $helpme->email; ?></a>
				</div>
			</div>
			<div class="row">
				<div class="col s12 m2 l2">
					<strong>Message</strong>
				</div>
				<div class="col s12 m10 l10">
					<?php echo $helpme->message; ?>
				</div>
			</div>
			<div class="row">
				<div class="col s12 m2 l2">
					<strong>Date</strong>
				</div>
				<div class="col s12 m10 l10">
					<?php echo formatdate($helpme->date); ?>
				</div>
			</div>
			
			<div class="row">
				<div class="col s12 m2 l2">
					<strong>Status</strong>
				</div>
				<div class="col s12 m10 l10">
					<form class="checkbox-post" method="post" action="<?php echo $app->request->getPath(); ?>" id="<?php echo $helpme->id; ?>">
	
						<?php if(isset($helpme->read)): ?>
							<p>
							<input type="checkbox" class="filled-in" name="helprequests[status]" value="closehelp" id="<?php echo $helpme->id; ?>closehelp"   />
							<label for="<?php echo $helpme->id; ?>closehelp">Close Help Request</label>
							</p>
							<input type="hidden" name="helprequests[status]" value="closehelp" />
						<?php else: ?>
							<p>
							<input type="checkbox" class="filled-in" name="helprequests[status]" value="markread" id="<?php echo $helpme->id; ?>markread"   />
							<label for="<?php echo $helpme->id; ?>markread">Mark as Read</label>
							</p>
							<input type="hidden" name="helprequests[status]" value="markread" />
						<?php endif; ?>
						
						<input type="hidden" name="helprequests[id]" value="<?php echo $helpme->id; ?>"  />
						<input type="hidden" name="helprequests[target]" value="helprequests"  />
						<input type="hidden" name="<?php echo $csrf_key; ?>" value="<?php echo $csrf_token; ?>">
						
					</form>
				</div>
			</div>
			
			
			
		</div>
	<?php endforeach; ?>
<?php else: ?>
	You have no help requests
<?php endif; ?>