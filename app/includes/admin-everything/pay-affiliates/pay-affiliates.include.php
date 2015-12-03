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
            <?php printer($app->affiliateuser); ?>
        <?php endif; ?>
	</div>
</div>
