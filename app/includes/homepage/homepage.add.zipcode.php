<div class="row">
	<div class="col s12 m6 l6">
		<h1>Account Creation</h1>
		<p>Please enter your zip code, so we can create a profile for you.</p>
		<p>You can always change your zip code later if you would like.</p>
	</div>
	<div class="col s12 m6 l6">
		
		<form class="form-post" method="post" action="/">
			
			<div class="input-field">
				<input id="userzip" name="userzip[zipcode]" type="text" class="validate">
				<label for="userzip">Your Zip Code</label>
			</div>
			
			<input type="hidden" name="userzip[target]" value="userzip"  />
			<input type="hidden" name="<?php echo $csrf_key; ?>" value="<?php echo $csrf_token; ?>">
			
			<button class="btn" type="submit">GO!</button>
			
		</form>
	</div>
</div>