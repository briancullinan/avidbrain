<div class="bgcheck-step">Step 5</div>
<div class="bgcheck-step-info"> Purchase Background Check </div>

<?php if(isset($app->newtutor->step5)): ?>
    Thank you for purchasing a background check.
<?php elseif(empty($app->newtutor->step1) || empty($app->newtutor->step2) || empty($app->newtutor->step3) || empty($app->newtutor->step4)): ?>
    Please fill out all steps before continuing.
<?php else: ?>

    <?php if(isset($app->newtutor->comp)): ?>

        <form method="post" action="<?php echo $app->request->getPath(); ?>">

        	<input type="hidden" name="completebackgroundcheck[target]" value="completebackgroundcheck"  />
        	<input type="hidden" name="<?php echo $csrf_key; ?>" value="<?php echo $csrf_token; ?>">

        	<div class="form-submit">
                <button class="btn green confirm-submit" type="button">
                    Click Here To Complete, it's on us
                </button>
        	</div>

        </form>

    <?php else: ?>
        <p>Background checks are <span class="green-text">$29.99</span>, which is non-refundable.</p>


        <form id="paybackgroundcheck" action="" method="POST">
            <script src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                data-email = "<?php echo $app->newtutor->email; ?>"
                data-key = "<?php echo $app->dependents->stripe->STRIPE_PUBLIC; ?>"
                data-amount = "2999"
                data-panel-label = "Pay"
                data-label = "Purchase Background Check"
                data-name = "AvidBrain Background Check"
                data-description = "$29.99"
                data-allow-remember-me = "false"
            ></script>

                <?php if(isset($app->newtutor->location) && $app->newtutor->location=='completecheck'): ?>
            		<input type="hidden" name="backgroundcheckstep5[location]" value="completecheck"  />
            	<?php endif; ?>

                <input type="hidden" name="backgroundcheckstep[target]" value="backgroundcheckstep"  />
                <input type="hidden" name="<?php echo $csrf_key; ?>" value="<?php echo $csrf_token; ?>">

        </form>

    <?php endif; ?>

<?php endif; ?>
