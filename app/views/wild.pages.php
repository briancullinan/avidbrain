<?php if(isset($app->meta->h1) && $app->meta->h1==false): ?>

		<?php elseif(isset($app->meta->h1)): ?>
			<h1><?php echo $app->meta->h1; ?></h1>
		<?php elseif(isset($app->meta->title)): ?>
			<h1><?php echo $app->meta->title; ?></h1>
		<?php endif; ?>

		<?php
			if(isset($app->target->include) && file_exists($app->target->include)){
				include($app->target->include);
			}
			elseif(isset($app->target->include) && !file_exists($app->target->include) && $app->dependents->DEBUG==true){
				include($app->dependents->APP_PATH.'debug/makeme.php');
			}
			else{
				//echo 'makeme';
			}
		?>
