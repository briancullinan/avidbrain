<div class="row">
	<div class="col s12 m4 l4">

		<?php
		    $results = NULL;
		    $fromuser = $app->markcomplete->to_user;
		    $sql = "SELECT user.username,user.url,user.first_name,user.last_name,profile.my_avatar,profile.my_upload,profile.my_upload_status FROM avid___user user INNER JOIN avid___user_profile profile on profile.email = user.email WHERE user.email = :email LIMIT 1";
		    $prepare = array(':email'=>$fromuser);
		    $results = $app->connect->executeQuery($sql,$prepare)->fetch();
		?>

		<?php if(isset($results->username)): ?>
		    <div class="user-photograph">
		        <a href="<?php echo $results->url; ?>">
		            <img src="<?php echo userphotographs($app->user,$results,$app->dependents); ?>" />
		        </a>
		    </div>
		    <div class="user-name">
		        <a href="<?php echo $results->url; ?>"><?php echo ucwords(short($results)); ?></a>
		    </div>
		<?php endif; ?>

		<div class="confirm-payment hide"></div>

	</div>
	<div class="col s12 m8 l8">
		<h2>Session Details</h2>

		<?php if($app->markcomplete->session_status=='complete'): ?>
			<div>
				<a class="block active-block" href="/sessions/view/<?php echo $id; ?>">Your session is complete</a>
			</div>
		<?php else: ?>

		<div class="block active-block">
			<div>Please confirm the charge amount below, by clicking the <span>Green Button</span></div>
		</div>

			<div class="complete-session">
				<?php

					$app->markcomplete->session_length = $app->markcomplete->proposed_length;

					$setupsession = new Forms($app->connect);
					$setupsession->formname = 'completesession';
					$setupsession->url = '/sessions/complete-active/'.$id;
					$setupsession->dependents = $app->dependents;
					$setupsession->csrf_key = $csrf_key;
					$setupsession->csrf_token = $csrf_token;
						$setupsession->formvalues = $app->markcomplete;
					$setupsession->makeform();
				?>
			</div>

		<?php endif; ?>
	</div>
</div>

<?php include($app->target->base.'what-is-a-whiteboard.php'); ?>
