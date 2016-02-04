<div class="row">
	<div class="col s12 m6 l6">
		<div>Top States</div>
		<?php foreach($app->cities as $value): ?>
			<div class="top-locations">
				<a href="/tutors/<?php echo $value->state_slug; ?>"><?php echo ucwords($value->state_long); ?> Tutors</a>
			</div>
		<?php endforeach; ?>

	</div>
	<div class="col s12 m6 l6">
		<div>Top Cities</div>
		<?php foreach($app->states as $value): ?>
			<div class="top-locations">
				<a href="/searching/---/<?php echo $value->zipcode; ?>/"><?php echo ucwords($value->city); ?> <?php echo ucwords($value->state_long); ?> Tutors</a>
			</div>
		<?php endforeach; ?>
	</div>
</div>
