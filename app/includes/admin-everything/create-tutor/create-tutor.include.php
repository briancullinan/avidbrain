<h1>Create A Tutor</h1>

<div class="row">
	<div class="col s12 m6 l6">
		<div class="box">
			<form class="form-post" id="createtutor" method="post" action="<?php echo $app->request->getPath(); ?>">

				<div class="input-field">
					<input id="first_name" name="create[first_name]" type="text" class="validate">
					<label for="first_name">
						First Name
					</label>
				</div>

				<div class="input-field">
					<input id="last_name" name="create[last_name]" type="text" class="validate">
					<label for="last_name">
						Last Name
					</label>
				</div>

				<div class="input-field">
					<input id="email" name="create[email]" type="email" class="validate">
					<label for="email">
						Email Address
					</label>
				</div>

				<div class="input-field">
					<input id="password" name="create[password]" type="text" value="<?php echo random_all(6); ?>" class="validate">
					<label for="password">
						Password
					</label>
				</div>

				<input type="hidden" name="create[target]" value="create"  />
				<input type="hidden" name="<?php echo $csrf_key; ?>" value="<?php echo $csrf_token; ?>">

				<div class="form-submit">
					<button class="btn blue" type="submit">
						Create
					</button>
				</div>

			</form>
		</div>
	</div>
	<div class="col s12 m6 l6">
		<h2>List of Tutors</h2>

		<?php
			$sql = "SELECT * FROM avid___user WHERE usertype = :usertype ORDER BY first_name ASC";
			$prepeare = array(':usertype'=>'tutor');
			$tutors = $app->connect->executeQuery($sql,$prepeare)->fetchAll();
		?>

		<?php if(isset($tutors[0])): ?>
			<?php foreach($tutors as $value): ?>
				<div><a href="<?php echo $value->url; ?>"><?php echo short($value); ?></a></div>
			<?php endforeach; ?>
		<?php else: ?>
			You have no tutors
		<?php endif; ?>

	</div>
</div>
