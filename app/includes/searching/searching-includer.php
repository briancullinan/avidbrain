<div class="row">
	<div class="col s12 m4 l4">
		<?php include($app->dependents->APP_PATH.'includes/searching/searchbox.php'); ?>
	</div>
	<div class="col s12 m8 l8">
		<?php if(isset($app->searching)): ?>
			<div class="searching-count">
				<?php echo $app->count; ?> <?php if(isset($app->cachedSubjectQuery->subject_name)){ echo $app->cachedSubjectQuery->subject_name; } ?> Tutors Found
			</div>
			<?php echo $app->pagination; ?>
			<div class="searching-results">
				<?php foreach($app->searching as $searching): ?>
					<div class="tutoring-block">
						<?php printer($searching->url); ?>
					</div>
				<?php endforeach; ?>
			</div>
			<?php echo $app->pagination; ?>
		<?php else: ?>
			potato
		<?php endif; ?>
	</div>
</div>
