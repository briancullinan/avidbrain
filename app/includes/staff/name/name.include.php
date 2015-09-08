<div class="row">
	<div class="col s12 m3 l3">
		<?php
			$email = $app->staff->email;
			include($app->dependents->APP_PATH.'includes/user-profile/staff-block.php');
		?>
	</div>
	<div class="col s12 m9 l9">
		<h1><?php echo short($aviduser); ?></h1>
		<h2><?php echo $aviduser->short_description; ?></h2>
		<div class="hr"></div>
		<p class="description"><?php echo nl2br($aviduser->personal_statement); ?></p>
		
		<?php if(isset($app->user->email)): ?>
			<h4>Send <?php echo short($aviduser); ?> a message</h4>
			<?php

				$messagingsystem = new Forms($app->connect);
				$messagingsystem->formname = 'messagingsystem';
				$messagingsystem->url = $app->request->getPath();
				$messagingsystem->dependents = $app->dependents;
				$messagingsystem->csrf_key = $csrf_key;
				$messagingsystem->csrf_token = $csrf_token;
				$messagingsystem->makeform();
		
			?>
		<?php else: ?>
			<a href="#loginModule" class="btn modal-trigger modal-login">Login To Message <?php echo $aviduser->first_name; ?></a>
		<?php endif; ?>
		
	</div>
</div>