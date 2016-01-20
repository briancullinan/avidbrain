<?php if(isset($app->jobposts)): ?>
	<?php foreach($app->jobposts as $jobpost): ?>
		<?php include('jobpost.php'); ?>
	<?php endforeach; ?>
    <?php echo $app->pagination; ?>
<?php else: ?>
	No jobs where found
<?php endif; ?>
