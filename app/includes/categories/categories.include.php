<ul class="breadcrumb">
	<li><a href="/categories">Categories</a></li>
</ul>

<div class="avid-brain-subjects">
	<div class="row">
		<?php if(isset($app->allthesubjects[0])): ?>
			<?php foreach($app->allthesubjects as $value): ?>
				<div class="col s6 m4 l3">
					<a title="<?php echo $value->subject_name; ?> Tutors" href="/categories/<?php echo $value->parent_slug; ?>">
						<?php echo $value->subject_parent; ?>
					</a>
				</div>
			<?php endforeach; ?>
		<?php endif; ?>
	</div>
</div>
