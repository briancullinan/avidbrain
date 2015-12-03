<div class="row">
	<div class="col s12 m3 l3">
		<div class="block">
            <?php if(isset($app->payaffiliates)): ?>
            	<?php foreach($app->payaffiliates as $payaffiliates): ?>
            		<div>
                        <a href="/admin-everything/pay-affiliates/<?php echo $payaffiliates->id; ?>"><?php echo $payaffiliates->first_name.' '.$payaffiliates->last_name; ?></a>
                    </div>
            	<?php endforeach; ?>
            <?php endif; ?>
        </div>
	</div>
	<div class="col s12 m9 l9">
		<?php if(isset($app->affiliateuser)): ?>

			<?php
				$pay = (count($app->affiliateuser->everything)*20);
			?>


			<h2>
				<?php echo $app->affiliateuser->first_name.' '.$app->affiliateuser->last_name; ?>

				<span class="blue-text">$<?php echo numbers($pay); ?></span>

			</h2>

			<?php if(isset($app->affiliateuser->getpaid) && !empty($app->affiliateuser->getpaid)): ?>
				<form method="post" action="<?php echo $app->request->getPath(); ?>">

					<input type="hidden" name="paytheaffiliate[target]" value="paytheaffiliate"  />
					<input type="hidden" name="<?php echo $csrf_key; ?>" value="<?php echo $csrf_token; ?>">

					<?php if($app->affiliateuser->getpaid=='directdeposit' && !empty($app->affiliateuser->account_id) && !empty($app->affiliateuser->managed_id)): ?>


							<input type="hidden" name="paytheaffiliate[type]" value="directdeposit" />

							<div class="form-submit">
								<button class="btn confirm-submit" type="button">Direct Deposit</button>
							</div>



					<?php elseif($app->affiliateuser->getpaid=='snailmail'): ?>

							<input type="hidden" name="paytheaffiliate[type]" value="snailmail" />

							<div class="form-submit">
								<button class="btn confirm-submit" type="button">Snail Mail</button>
							</div>


					<?php else: ?>
						<button>No Payment Method On File</button>
					<?php endif; ?>

				</form>
			<?php endif; ?>

        <?php endif; ?>
	</div>
</div>
