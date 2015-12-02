<div class="row">
	<div class="col s12 m6 l6">
        <h3>
            Your Information
        </h3>
        <div class="block">
            <form method="post" action="/affiliates/information" class="automatic post-form" id="myinfo">
                <div class="row">
                	<div class="col s12 m6 l6">
                        <div class="input">
                            <label for="first_name">First Name</label>
                            <input id="first_name" type="text" name="affiliateinfo[first_name]" value="<?php echo $app->affiliate->first_name; ?>" />
                        </div>
                	</div>
                	<div class="col s12 m6 l6">
                        <div class="input">
                            <label for="last_name">Last Name</label>
                            <input id="last_name" type="text" name="affiliateinfo[last_name]" value="<?php echo $app->affiliate->last_name; ?>" />
                        </div>
                	</div>
                </div>


                <input type="hidden" name="affiliateinfo[target]" value="affiliate"  />
            	<input type="hidden" name="<?php echo $csrf_key; ?>" value="<?php echo $csrf_token; ?>">
            </form>

        </div>

        <h3>
            Your Affiliate Code / Links
        </h3>
        <div class="block">
            <div class="row">
            	<div class="col s12 m4 l4">
                    <div class="input affiliate-code">
                        <label for="mycode">Affiliate Code</label>
                        <input id="mycode" type="text" readonly="readonly" value="<?php echo $app->affiliate->mycode; ?>" />
                    </div>
            	</div>
            	<div class="col s12 m4 l4">
                    <div class="input">
                        <label for="studentsignup">Student Signup</label>
                        <input onclick="select();" id="studentsignup" type="text" value="<?php echo $app->dependents->DOMAIN; ?>/signup/student/<?php echo $app->affiliate->mycode; ?>" />
                    </div>
            	</div>
                <div class="col s12 m4 l4">
                    <div class="input">
                        <label for="tutorsignup">Tutor Signup</label>
                        <input onclick="select();" type="text" id="tutorsignup" value="<?php echo $app->dependents->DOMAIN; ?>/signup/tutor/<?php echo $app->affiliate->mycode; ?>" />
                    </div>
            	</div>
            </div>
        </div>
	</div>
	<div class="col s12 m6 l6">
		<h3>Get Paid</h3>
		<div class="block">
			How would you like to get paid?

			<form method="post" class="automatic" action="/affiliates/information" id="getpaid">
				<span>
					<input <?php if(isset($app->affiliate->getpaid) && $app->affiliate->getpaid=='directdeposit'){ echo 'checked="checked"';} ?> class="with-gap" name="getpaidaffiliate[type]" type="radio" id="directdeposit" value="directdeposit"  />
					<label for="directdeposit">Direct Deposit</label>
				</span>
				<span>
					<input <?php if(isset($app->affiliate->getpaid) && $app->affiliate->getpaid=='snailmail'){ echo 'checked="checked"';} ?> class="with-gap" name="getpaidaffiliate[type]" type="radio" id="snailmail"  value="snailmail" />
					<label for="snailmail">Mailed Check</label>
				</span>

				<input type="hidden" name="getpaidaffiliate[target]" value="getpaidaffiliate"  />
            	<input type="hidden" name="<?php echo $csrf_key; ?>" value="<?php echo $csrf_token; ?>">
			</form>

			<br>
			<?php if(!empty($app->affiliate->getpaid)): ?>
				<?php include($app->affiliate->getpaid.'.php'); ?>
			<?php endif; ?>

		</div>
	</div>
</div>


<script type="text/javascript">

	$(document).ready(function() {
		$('.automatic input, .automatic textarea').on('change',function(){

			var closestform = '#'+$(this).closest('form').attr('id');
            $(closestform).submit();
		});
	});

</script>
<style type="text/css">
.affiliate-code input{
	background: #e3e3e3;
	text-align: center;
	color: #000 !important;
	font-size: 16px;
}
</style>
