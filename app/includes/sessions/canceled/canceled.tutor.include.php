<?php if(isset($app->sessions[0])): ?>
	<?php
		foreach($app->sessions as $jobsessions){
			include($app->target->base.'each-session.php');
		}
	?>
	<?php echo $app->pagination; ?>
<?php else: ?>
	You have no pending sessions
<?php endif; ?>