<div class="avid-brain-subjects">
<?php if(isset($app->tutorsbylocation[0])): ?>
	<div class="row">
		<?php foreach($app->tutorsbylocation as $tutorsbylocation): ?>
			<div class="col s6 m4 l3">
				<a href="/tutors/<?php echo $tutorsbylocation->state_slug; ?>">
					<span class="badge normal blue white-text"> <?php echo $tutorsbylocation->count; ?></span><?php echo ucwords($tutorsbylocation->state_long); ?> Tutors
				</a>
			</div>
		<?php endforeach; ?>
	</div>
<?php endif; ?>
</div>
