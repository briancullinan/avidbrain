<div class="row">
	<div class="col s12 m6 l6">
		Enter your phone number and click submit to get a phone call with instructions on how to validate your account.
	</div>
	<div class="col s12 m6 l6">
        <div class="block">
			<?php if(isset($app->phonevalidation->active)): ?>
				Thank you for validating your account, you may now <a href="/tutors">contact a tutor</a>.
			<?php elseif(isset($app->phonevalidation->id)): ?>
				<form method="post" class="form-post" action="<?php echo $app->request->getPath(); ?>" id="validatephonewithcode">

	            	<div class="input-field">
	            		<input id="code" type="tel" name="igotmycode[code]" class="validate" value="">
	            		<label for="code">
	            			SMS Code
	            		</label>
	            	</div>

	            	<input type="hidden" name="igotmycode[target]" value="igotmycode"  />
	            	<input type="hidden" name="<?php echo $csrf_key; ?>" value="<?php echo $csrf_token; ?>">

	            	<div class="form-submit">
	            		<button class="btn blue" type="submit">
	            			Submit
	            		</button>
	            	</div>

	            </form>
			<?php else: ?>
            <form method="post" class="form-post" action="<?php echo $app->request->getPath(); ?>" id="validatephone">

            	<div class="input-field">
            		<input id="phone" type="tel" name="validatephone[number]" class="validate" value="<?php echo $app->user->phone; ?>">
            		<label for="phone">
            			Phone Number
            		</label>
            	</div>

            	<input type="hidden" name="validatephone[target]" value="validatephone"  />
            	<input type="hidden" name="<?php echo $csrf_key; ?>" value="<?php echo $csrf_token; ?>">

            	<div class="form-submit">
            		<button class="btn blue" type="submit">
            			Submit
            		</button>
            	</div>

            </form>
			<?php endif; ?>
        </div>
	</div>
</div>
