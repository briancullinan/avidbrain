<?php if(isset($app->easysignup)): ?>
    <div class="block">

        <form method="post" action="<?php echo $app->request->getPath(); ?>" id="finisheasy">

        	<div class="input-field">
        		<input id="first_name" type="text" name="finisheasy[first_name]" class="validate" value="<?php echo $app->easysignup->first_name; ?>">
        		<label for="first_name">
        			First Name
        		</label>
        	</div>
            <div class="input-field">
        		<input id="last_name" type="text" name="finisheasy[last_name]" class="validate">
        		<label for="last_name">
        			Last Name
        		</label>
        	</div>
            <div class="input-field">
        		<input id="zipcode" type="text" name="finisheasy[zipcode]" class="validate">
        		<label for="zipcode">
        			Zip Code
        		</label>
        	</div>
            <div class="input-field">
        		<input id="phone" type="text" name="finisheasy[phone]" class="validate" value="<?php echo $app->easysignup->phone; ?>">
        		<label for="phone">
        			Phone Number
        		</label>
        	</div>

        	<input type="hidden" name="something[target]" value="something"  />
        	<input type="hidden" name="<?php echo $csrf_key; ?>" value="<?php echo $csrf_token; ?>">

        	<div class="form-submit">
        		<button class="btn blue" type="submit">
        			Save
        		</button>
        	</div>

        </form>
    </div>
<?php endif; ?>
