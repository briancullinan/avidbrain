<?php if(isset($app->contest_dispute)): ?>
	<?php foreach($app->contest_dispute as $contest_dispute): ?>
		<?php printer($contest_dispute); ?>
	<?php endforeach; ?>
<?php else: ?>
	There are no Contested Sessions
<?php endif; ?>