<?php if(isset($app->completed[0])): ?>
	<?php
		foreach($app->completed as $jobsessions){
			include($app->target->base.'each-session.php');
		}
	?>
	<?php echo $app->pagination; ?>
<?php else: ?>
	You have no completed sessions
<?php endif; ?>