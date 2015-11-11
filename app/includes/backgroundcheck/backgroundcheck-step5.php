<div class="bgcheck-step">Step 5</div>
<div class="bgcheck-step-info"> Purchase Background Check </div>

<?php if(isset($app->newtutor->step5)): ?>
    Thank you for purchasing a background check.
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
