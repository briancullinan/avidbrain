<?php if(isset($app->top)): ?>
	<?php foreach($app->top as $top): ?>
		<div>
			<a href="/top/<?php echo $top->subject_slug; ?>-tutors">
				<?php echo $top->subject_name; ?>
				<?php //echo $top->count; ?>
			</a>
		</div>
	<?php endforeach; ?>
<?php else: ?>
<?php endif; ?>
