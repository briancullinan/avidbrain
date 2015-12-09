<?php if(isset($app->spammessages)): ?>
	<?php foreach($app->spammessages as $value): ?>
		<div class="block">
            <div>Subject: <?php echo $value->subject; ?></div>
            <div>Message: <?php echo $value->message; ?></div>
            <div>Date: <?php echo formatdate($value->send_date); ?></div>
            <div>Message ID: <?php echo $value->id; ?></div>
            <div>Who Flagged: <?php echo $value->spam_who_flagged; ?></div>
        </div>
	<?php endforeach; ?>
<?php else: ?>
	You have no spammers
<?php endif; ?>
