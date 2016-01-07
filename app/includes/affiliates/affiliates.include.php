<h1>Affiliate Program</h1>

<div class="row">
	<div class="col s12 m4 l4">

        <h3>Get Paid</h3>
        <div class="block">
            <?php if(!empty($app->affiliate->getpaid)): ?>
                <p>
                    You have selected

                    <span class="green-text">
                        <?php if($app->affiliate->getpaid=='directdeposit'): ?>
                        Direct Deposit
                        <?php else: ?>
                            Mailed Check
                        <?php endif; ?>
                    </span>

                    as your prefered payment method.
                </p>

				<?php
					if(isset($app->user->email)){
						$link = '/payment/get-paid';
					}
					else{
						$link = '/affiliates/information';
					}
				?>
                <div>If you would like to change your payment method <a href="<?php echo $link; ?>">click here</a>.</div>

            <?php else: ?>
                You have not enterd a payment method yet, <a href="/payment/get-paid">please go here to continue</a>
            <?php endif; ?>
        </div>

        <h3>
            Your Affiliate Code / Links
        </h3>
        <div class="block">
            <div class="row">
                <div class="col s12">
                    <div class="input affiliate-code">
                        <label for="mycode">Affiliate Code</label>
                        <input id="mycode" type="text" readonly="readonly" value="<?php echo $app->affiliate->mycode; ?>" />
                    </div>
                </div>
                <div class="col s12">
                    <div class="input">
                        <label for="studentsignup">Student Signup</label>
                        <input onclick="select();" id="studentsignup" type="text" value="<?php echo $app->dependents->DOMAIN; ?>/signup/student/<?php echo $app->affiliate->mycode; ?>" />
                    </div>
                </div>
                <div class="col s12">
                    <div class="input">
                        <label for="tutorsignup">Tutor Signup</label>
                        <input onclick="select();" type="text" id="tutorsignup" value="<?php echo $app->dependents->DOMAIN; ?>/signup/tutor/<?php echo $app->affiliate->mycode; ?>" />
                    </div>
                </div>
            </div>
        </div>

        <h3>Affiliate Tools</h3>
        <div class="block">
            Need some help or want some ideas on how to make money with our affiliate progam? Visit our <a href="/affiliate-tools">Affiliate Tools Page</a>
        </div>

	</div>
	<div class="col s12 m8 l8">
		<div class="row">
			<div class="col s12 m3 l3">
				<div class="block">
		            <div class="title">Total Pay</div>
		            $<?php echo numbers(total_affiliate($app->affiliatecount)); ?>
		        </div>
			</div>
			<div class="col s12 m9 l9">
				<?php if(isset($app->signups)): ?>
		            <h2>All Signups</h2>
		            <table class="bordered striped condensed">
		                <tr class="blue white-text">
		                    <td>
		                        Usertype
		                    </td>
		                    <td>
		                        Name
		                    </td>
		                    <td>
		                        Signup Date
		                    </td>
		                    <td>
		                        Paid
		                    </td>
		                </tr>

		                <?php foreach($app->signups as $signups): ?>
		                    <tr>
		                        <td><?php echo ucwords($signups->usertype); ?></td>
		                        <td><?php echo ucwords($signups->first_name); ?></td>
		                        <td><?php echo formatdate($signups->signup_date); ?></td>
		                        <td><?php if(isset($signups->id)){ echo '<i class="fa fa-check green-text"></i>'; } ?></td>
		                    </tr>
		                <?php endforeach; ?>

		            </table>

		        <?php else: ?>
		            <div>You have no Signups</div>
		        <?php endif; ?>

		        <?php if(isset($app->studentsiwthsessions)): ?>
		            <br>
		            <h2>Students With Sessions</h2>
		            <table class="bordered striped condensed">
		                <tr class="blue white-text">
		                    <td>
		                        Name
		                    </td>
		                    <td>
		                        Signup Date
		                    </td>
		                    <td>
		                        Session?
		                    </td>
		                </tr>

		                <?php foreach($app->studentsiwthsessions as $signups): ?>
		                    <tr>
		                        <td><?php echo ucwords($signups->first_name); ?></td>
		                        <td><?php echo formatdate($signups->signup_date); ?></td>
		                        <td><?php if(!empty($signups->id)){ echo 'Yes';}else{ echo 'No';} ?></td>
		                    </tr>
		                <?php endforeach; ?>

		            </table>


		        <?php endif; ?>


		        <?php if(isset($app->tutorswithsessions)): ?>
		            <br>
		            <h2>Tutors With Sessions</h2>
		            <table class="bordered striped condensed">
		                <tr class="blue white-text">
		                    <td>
		                        Name
		                    </td>
		                    <td>
		                        Signup Date
		                    </td>
		                    <td>
		                        Session?
		                    </td>
		                </tr>

		                <?php foreach($app->tutorswithsessions as $signups): ?>
		                    <tr>
		                        <td><?php echo ucwords($signups->first_name); ?></td>
		                        <td><?php echo formatdate($signups->signup_date); ?></td>
		                        <td><?php if(!empty($signups->id)){ echo 'Yes';}else{ echo 'No';} ?></td>
		                    </tr>
		                <?php endforeach; ?>

		            </table>


		        <?php endif; ?>

			</div>
		</div>

	</div>
</div>
