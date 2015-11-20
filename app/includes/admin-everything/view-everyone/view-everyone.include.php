<div class="box">
	<form method="post" action="<?php echo $app->request->getPath(); ?>">

		<div class="input-field">
			<input id="textid" type="text" name="findatutor[search]" class="validate" placeholder="First Name, Last Name, Email" value="<?php if(isset($app->findatutor->search)){ echo $app->findatutor->search;} ?>">
			<label for="textid">
				Search for a user
			</label>
		</div>

		<input type="hidden" name="findatutor[target]" value="findatutor"  />
		<input type="hidden" name="<?php echo $csrf_key; ?>" value="<?php echo $csrf_token; ?>">

		<div class="form-submit">
			<button class="btn blue" type="submit">
				Search
			</button>
		</div>

	</form>


</div>

<div class="block-in-block">
	<?php if(isset($app->results)): ?>
		<?php foreach($app->results as $results): ?>
			<div class="block">

				<div class="title"><a href="<?php echo $results->url; ?>"><?php echo $results->first_name.' '.$results->last_name; ?></a></div>
				<div><?php echo $results->email; ?></div>
				<div><?php echo $results->usertype; ?></div>

			</div>
		<?php endforeach; ?>
	<?php endif; ?>
</div>

<div class="row">
	<div class="col s12 m4 l4">
		<h3>All Tutors</h3>
		<?php if(isset($app->viewtutors[0])): ?>
			<?php foreach($app->viewtutors as $value): ?>
				<div><a href="<?php echo $value->url; ?>"> -- <?php echo $value->first_name.' '.$value->last_name; ?></a></div>
			<?php endforeach; ?>
		<?php else: ?>
			There are no tutors
		<?php endif; ?>
	</div>
	<div class="col s12 m4 l4">
		<h3>All Students</h3>
		<?php if(isset($app->viewstudents[0])): ?>
			<?php foreach($app->viewstudents as $value): ?>
				<div><a href="<?php echo $value->url; ?>"><?php echo the_users_name($value); ?></a></div>
			<?php endforeach; ?>
		<?php else: ?>
			There are no students
		<?php endif; ?>
	</div>
	<div class="col s12 m4 l4">
		<h3>All Temps</h3>
		<?php if(isset($app->viewpending[0])): ?>
			<?php foreach($app->viewpending as $value): ?>
				<div><?php echo short($value); ?></div>
			<?php endforeach; ?>
		<?php else: ?>
			There are no temps
		<?php endif; ?>
	</div>
</div>
