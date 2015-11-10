<?php

	printer('GONE MISSING UH OH!');
	/*
	<?php

		if(isset($userinfo->usertype) && $userinfo->usertype=='student' && empty($userinfo->dontshow)){
			$cachedname = 'cc-'.$userinfo->url;
			$cccachename = $app->connect->cache->get($cachedname);
			if($cccachename == null) {
			    $returnedData = get_creditcard($userinfo->customer_id);
			    $cccachename = $returnedData;
			    $app->connect->cache->set($cachedname, $returnedData, 3600);
			}
		}

	?>

	<div class="user-block center-align">
		<div class="profile-image avatar">

			<?php echo show_avatar($userinfo,$app->user,$app->dependents); ?>

		</div>
		<div class="user-name">
			<?php if(isset($userinfo->usertype) && isset($userinfo->url) && $userinfo->usertype=='student' && isset($app->user->email)): ?>
				<a href="<?php echo $userinfo->url; ?>"><?php echo the_users_name($userinfo); ?></a>
			<?php elseif(isset($userinfo->usertype) && isset($userinfo->url) && $userinfo->usertype=='student' && empty($app->user->email)): ?>
				<?php echo the_users_name($userinfo); ?>
			<?php elseif(isset($userinfo->usertype) && isset($userinfo->url) && $userinfo->usertype=='tutor'): ?>
				<a href="<?php echo $userinfo->url; ?>"><?php echo the_users_name($userinfo); ?></a>
			<?php endif; ?>
		</div>

		<?php if(empty($userinfo->dontshow)): ?>
			<?php if(isset($cccachename)): ?>
				<div class="cc-box">
					<div class="credit-card">
						<i class="fa fa-credit-card"></i> Payment On File
					</div>
				</div>
			<?php elseif(empty($cccachename) && $userinfo->usertype=='student'): ?>
				<div class="cc-box">
					<div class="alert red white-text">
						No Payment On File
					</div>
				</div>
			<?php endif; ?>
		<?php endif; ?>

	</div>
	*/

?>
