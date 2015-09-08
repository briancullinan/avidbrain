<?php if(isset($app->dispute[0])): ?>
	<?php
		foreach($app->dispute as $jobsessions){
			include($app->target->base.'each-session.php');
		}
	?>
	<?php echo $app->pagination; ?>
<?php else: ?>
	You have no disputed sessions
<?php endif; ?>