<h1>Profile Approvals</h1>

<div class="row">

	<div class="col s12 m6 l6">
		<h2>Tutors</h2>
		<?php if(isset($app->tutorrequests[0])): ?>
			<?php foreach($app->tutorrequests as $request): ?>

				<div class="row">
					<div class="col s12 m6 l6">
						<a href="<?php echo $request->url; ?>">
							<?php echo $request->name; ?> <br>
							<?php echo $request->email; ?>
						</a>
					</div>
					<div class="col s12 m6 l6">
						<?php echo $request->type; ?>
					</div>
				</div>

			<?php endforeach; ?>
		<?php else: ?>
			There are no Tutor requests
		<?php endif; ?>
	</div>

	<div class="col s12 m6 l6">
		<h2>Students</h2>
		<?php if(isset($app->studentrequests[0])): ?>
			<?php foreach($app->studentrequests as $request): ?>
				<div class="row">
					<div class="col s12 m6 l6">
						<a href="<?php echo $request->url; ?>">
							<?php echo $request->name; ?> <br>
							<?php echo $request->email; ?>
						</a>
					</div>
					<div class="col s12 m6 l6">
						<?php echo $request->type; ?>
					</div>
				</div>
			<?php endforeach; ?>
		<?php else: ?>
			There are no Student requests
		<?php endif; ?>
	</div>

</div>
