<ul class="breadcrumb">
	<li><a href="/categories">Categories</a></li>
	<li><a href="/categories/<?php echo $category; ?>"><?php echo $app->zero->subject_parent; ?></a></li>
	<li><a href="/categories/<?php echo $category; ?>"><?php echo $app->zero->subject_name; ?></a></li>
</ul>

<?php if(!empty($app->pagedescription) && $app->dependents->DEBUG==true):?>
<div class="block">
	<?php echo nl2br($app->pagedescription); ?>
</div>
<?php endif; ?>

<?php include($app->dependents->APP_PATH.'includes/tutors/tutors.include.php'); ?>
