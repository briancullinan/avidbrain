<?php if(isset($app->pendingsessions[0])): ?>
	<?php
		foreach($app->pendingsessions as $jobsessions){
			include($app->target->base.'each-session.php');
		}
	?>
	<?php echo $app->pagination; ?>
<?php else: ?>
	You have no pending sessions
<?php endif; ?>