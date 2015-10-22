<div class="easy-signup">

    <div class="easy-signup-inside">

        <div class="easy-signup-title">Sign up for your Free student account</div>
        <div class="easy-signup-phrase">
            We will email or call you and walk you through the process. Simple &amp; Easy.
        </div>

        <form method="post" action="/easy" class="form-post" id="itseasy">

            <div class="row">
            	<div class="col s12 m12 l4">
            		<div class="input-wrap" id="name"><input type="text" name="easy[name]" placeholder="Your Name" /></div>
            	</div>
            	<div class="col s12 m12 l4">
            		<div class="input-wrap" id="email"><input type="email" name="easy[email]" placeholder="Your Email" /></div>
            	</div>
            	<div class="col s12 m12 l4">
            		<div class="input-wrap" id="phone"><input type="tel" name="easy[phone]" placeholder="Phone Number" /></div>
            	</div>
            </div>

            <input type="hidden" name="easy[target]" value="easy"  />
        	<input type="hidden" name="<?php echo $csrf_key; ?>" value="<?php echo $csrf_token; ?>">

            <div class="easy-signup-tiny">By clicking this button, you agree to our <a href="/terms-of-use">Terms of Service.</a></div>


            <button class="btn btn-block">
                Create Account
            </button>

        </form>

    </div>

</div>
