<div class="row">
	<div class="col s12 m6 l6">


		<div class="row">
			<div class="col s12 m6 l6">

				<p>Whatever walk of life you are in there are several ways anyone can advertise for AvidBrain and make a some extra cash.</p>

				<p>Become an AvidBrain affiliate and earn <strong class="green-text">$20</strong> for every student or tutor who signs up and completes a session.</p>

			</div>
			<div class="col s12 m6 l6">

				<ul class="collection">
		        	<li class="collection-item">
		        		<div class="row">
		        			<div class="col s1 m1 l1">
		        				<i class="fa fa-check green-text"></i>
		        			</div>
		        			<div class="col s11 m11 l11">
		        				Earn Easy Money
		        			</div>
		        		</div>
		        	</li>
					<li class="collection-item">
		        		<div class="row">
		        			<div class="col s1 m1 l1">
		        				<i class="fa fa-check green-text"></i>
		        			</div>
		        			<div class="col s11 m11 l11">
		        				Track Signups
		        			</div>
		        		</div>
		        	</li>
					<li class="collection-item">
		        		<div class="row">
		        			<div class="col s1 m1 l1">
		        				<i class="fa fa-check green-text"></i>
		        			</div>
		        			<div class="col s11 m11 l11">
		        				Work When and Where You Want
		        			</div>
		        		</div>
		        	</li>
					<li class="collection-item">
		        		<div class="row">
		        			<div class="col s1 m1 l1">
		        				<i class="fa fa-check green-text"></i>
		        			</div>
		        			<div class="col s11 m11 l11">
		        				Be Your Own Boss
		        			</div>
		        		</div>
		        	</li>
					<li class="collection-item">
		        		<div class="row">
		        			<div class="col s1 m1 l1">
		        				<i class="fa fa-check green-text"></i>
		        			</div>
		        			<div class="col s11 m11 l11">
		        				Sit Back &amp; Relax
		        			</div>
		        		</div>
		        	</li>
		        </ul>

			</div>
		</div>

	</div>
	<div class="col s12 m6 l6">


        <form method="post" class="form-post block" action="<?php echo $app->request->getPath(); ?>" id="affsignup">
			<h3>Signup</h3>

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
