<div class="right user-dropdown-container">
	<a class="dropdown-button left" href="#" data-activates="user-dropdown">
		<div class="dropdown-item">
			<span class="fa-stack fa-lg">
				<i class="fa fa-circle-thin fa-stack-2x"></i>
				<i class="fa fa-user fa-stack-1x"></i>
			</span>
			<span class="my-name"><?php echo $app->user->first_name; ?></span>
		</div>
		<div class="dropdown-sort"><i class="fa fa-sort-down"></i> </div>
	</a>
</div>

<?php

	$dropdownnav = array();
	//$dropdownnav[] = (object)array('url'=>'/','text'=>'<i class="fa fa-home"></i> Home','class'=>'dll-home');
	//$dropdownnav[] = (object)array('class'=>'divider');

	if(isset($app->user->needs_bgcheck)){
		$dropdownnav[] = (object)array('url'=>'/background-check','text'=>'Complete Background Check','class'=>'bgcheck');
	}


	if($app->user->usertype=='admin'){
		$dropdownnav[] = (object)array('url'=>'/admin-everything','text'=>'<i class="fa fa-gear"></i> Admin Everything');
		$dropdownnav[] = (object)array('url'=>'/admin-everything/edit-profile','text'=>' Edit Profile');
	}
	else{

		if(isset($app->user->url)){
			$dropdownnav[] = (object)array('url'=>$app->user->url,'text'=>'View/Edit Your Profile','class'=>'dll-veyp');
		}

		if(isset($app->user->usertype) && $app->user->usertype=='tutor'){
			$dropdownnav[] = (object)array('url'=>'/request-profile-review','class'=>'request-review','text'=>'Request Profile Review','class'=>'dll-rpp');
		}

		$dropdownnav[] = (object)array('url'=>'/account-settings','text'=>'Account Settings','class'=>'dll-acts');

		// if(isset($app->enableaffiliates)){
		// 	//$settings = $app->user->settings();
		//
		// 	if(isset($settings->affiliateprogram) && $settings->affiliateprogram=='yes'){
		// 		$dropdownnav[] = (object)array('url'=>'/affiliates','text'=>'Affiliates','class'=>'dll-affiliates');
		// 	}
		// }

		$dropdownnav[] = (object)array('url'=>'/payment','text'=>'Payment','class'=>'dll-pay');

	}

	$dropdownnav[] = (object)array('class'=>'divider');
	$dropdownnav[] = (object)array('url'=>'/logout','text'=>'<i class="mdi-action-exit-to-app"></i> Logout','class'=>'dll-logout');
?>

<ul id="user-dropdown" class="dropdown-content">
	<li class="my-info-drop">
		<div class="row valign-wrapper">
			<div class="col s5 m5 l5 my-info-img">
				<img src="<?php echo userphotographs($app->user,$app->user); ?>" />
			</div>
			<div class="col s7 m7 l7 ">

				<div class="valign">
					<a href="<?php echo $app->user->url; ?>"><?php echo $app->user->first_name; ?> <?php echo $app->user->last_name; ?></a>
				</div>

			</div>
		</div>
	</li>
	<?php foreach($dropdownnav as $droplink): ?>
		<li class="<?php if(isset($droplink->class)){ echo $droplink->class;} if(isset($droplink->url) && $app->request->getPath()==$droplink->url /*|| isset($droplink->url) && myrootisyourroot($app->request->getPath(),$droplink->url)*/ ){ echo ' active ';} ?>">
			<?php if(isset($droplink->url)): ?>
			<a href="<?php echo $droplink->url; ?>">
				<?php echo $droplink->text; ?>
			</a>
			<?php endif; ?>
		</li>
	<?php endforeach; ?>
</ul>
