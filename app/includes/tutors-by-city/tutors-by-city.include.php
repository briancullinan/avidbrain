<div class="row">
	<div class="col s12 m6 l6">
		<input type="text" id="target" placeholder="Type a city name" />
	</div>
	<div class="col s12 m6 l6">
		<?php if(isset($app->tutorsbycity[0])): ?>
			<ul>
				<?php foreach($app->tutorsbycity as $tutorsbycity): ?>
					<li>
					<a href="/tutors/<?php echo $tutorsbycity->state_slug; ?>/<?php echo $tutorsbycity->city_slug; ?>">
						<?php echo $tutorsbycity->city; ?> <?php echo ucwords($tutorsbycity->state_long); ?> Tutors
					</a>
					</li>
				<?php endforeach; ?>
			</ul>
		<?php else: ?>
			There are no tutors available
		<?php endif; ?>
	</div>
</div>
