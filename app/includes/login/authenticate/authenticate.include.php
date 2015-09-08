<h1>Authenticate Your Profile</h1>

<div class="row">
	<div class="col s12 m6 l6">
		Please enter the secret code you got via SMS
	</div>
	<div class="col s12 m6 l6">
		<form method="post" action="<?php echo $app->request->getPath(); ?>">
			
			<input type="text" name="authenticate[dualauth]" autofocus="autofocus" />
			<input type="hidden" name="authenticate[target]" value="authenticate" />
			<input type="hidden" name="<?php echo $csrf_key; ?>" value="<?php echo $csrf_token; ?>" />
			
			<button class="btn btn-default" type="submit">
				Submit
			</button>
			
		</form>
	</div>
</div>