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
	$dropdownnav[] = (object)array('url'=>'/','text'=>'<i class="fa fa-home"></i> Home','class'=>'dll-home');
	//$dropdownnav[] = (object)array('class'=>'divider');
	
	
	if($app->user->usertype=='admin'){
		$dropdownnav[] = (object)array('url'=>'/admin-everything','text'=>'<i class="fa fa-gear"></i> Admin Everything');
		$dropdownnav[] = (object)array('url'=>'/admin-everything/edit-profile','text'=>' Edit Profile');
	}
	else{
		
		if($app->user->status=='needs-review'){
			//$dropdownnav[] = (object)array('url'=>'/request-profile-review','class'=>'attention','text'=>'<i class="fa fa-warning"></i> Request Profile Review');
		}
		else{
			$dropdownnav[] = (object)array('url'=>'/request-profile-review','class'=>'request','text'=>'Request Profile Review','class'=>'dll-rpp');
		}
		
		if(isset($app->user->url)){
			$dropdownnav[] = (object)array('url'=>$app->user->url,'text'=>'View/Edit Your Profile','class'=>'dll-veyp');
		}
		
		$dropdownnav[] = (object)array('url'=>'/account-settings','text'=>'Account Settings','class'=>'dll-acts');
		$dropdownnav[] = (object)array('url'=>'/payment','text'=>'Payment','class'=>'dll-pay');
		
	}
	
	$dropdownnav[] = (object)array('class'=>'divider');
	$dropdownnav[] = (object)array('url'=>'/logout','text'=>'<i class="mdi-action-exit-to-app"></i> Logout','class'=>'dll-logout');
?>

<ul id="user-dropdown" class="dropdown-content">
	<li class="my-info-drop">
		<div class="row valign-wrapper">
			<div class="col s5 m5 l5 my-info-img">
				<?php $userinfo = $app->user; echo show_avatar($userinfo,$app->user,$app->dependents); ?> 
			</div>
			<div class="col s7 m7 l7 ">
				
				<div class="valign">
					<?php echo $app->user->first_name; ?> <?php echo $app->user->last_name; ?>
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