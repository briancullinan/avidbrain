<p>Before you photo is public it will need to be reviewed.</p>

<form method="post" action="<?php echo $app->request->getPath(); ?>">
	
	<input type="hidden" name="requestprofilereview[target]" value="requestprofilereview"  />
	<input type="hidden" name="<?php echo $csrf_key; ?>" value="<?php echo $csrf_token; ?>">
	
	<input type="hidden" name="requestprofilereview[type]" value="My Photo"  />
	
	<button type="button" class="btn red confirm-submit" data-value="reviewmyprofile" data-name="requestprofilereview">Request Photo Review</button>
	
</form>