<div class="row">
	<div class="col s12 m6 l6">
        <p>Signup to become an MindSpree affiliate and earn $20 for every student or tutor who signs up and completes a session.</p>

        <ul class="collection">
        	<li class="collection-item">
        		<div class="row">
        			<div class="col s1 m1 l1">
        				<i class="fa fa-star green-text"></i>
        			</div>
        			<div class="col s11 m11 l11">
        				Earn Money
        			</div>
        		</div>
        	</li>
        </ul>

	</div>
	<div class="col s12 m6 l6">

        <h3>Signup</h3>
        <form method="post" class="form-post" action="<?php echo $app->request->getPath(); ?>" id="affsignup">

            <div class="new-inputs">
                <div class="row">

                    <div class="col s12 m6 l6">
                        <div class="input-wrapper" id="aff_email"><input type="text" name="affsignup[email]" autofocus="autofocus" placeholder="Email" /></div>
                    </div>

                    <div class="col s12 m6 l6">
                        <div class="input-wrapper" id="aff_password"><input type="password" name="affsignup[password]" placeholder="Password" /></div>
                    </div>

                </div>
            </div>

        	<input type="hidden" name="affsignup[target]" value="affsignup"  />
        	<input type="hidden" name="<?php echo $csrf_key; ?>" value="<?php echo $csrf_token; ?>">

        	<div class="form-submit">
        		<button class="btn blue" type="submit">
        			Signup
        		</button>
        	</div>

        </form>
	</div>
</div>
