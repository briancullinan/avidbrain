<div class="right">
	<?php if(isset($app->user->status) && $app->user->status=='needs-review'): ?>
		<a href="/request-profile-review" class="btn btn-s red white-text left top-request"> <i class="fa fa-bolt"></i> Request Review</a>
	<?php endif; ?>
	
	<a class="dropdown-button left" href="#" data-activates="user-dropdown">
		<i class="fa fa-sort-down"></i> <?php echo $app->user->short(); ?>
	</a>
</div>

<?php
	
	$dropdownnav = array();
	$dropdownnav[] = (object)array('url'=>'/','text'=>'<i class="fa fa-home"></i> Home');
	$dropdownnav[] = (object)array('class'=>'divider');
	
	
	if($app->user->usertype=='admin'){
		$dropdownnav[] = (object)array('url'=>'/admin-everything','text'=>'<i class="fa fa-gear"></i> Admin Everything');
		$dropdownnav[] = (object)array('url'=>'/admin-everything/edit-profile','text'=>' Edit Profile');
	}
	else{
		
		if($app->user->status=='needs-review'){
			//$dropdownnav[] = (object)array('url'=>'/request-profile-review','class'=>'attention','text'=>'<i class="fa fa-warning"></i> Request Profile Review');
		}
		else{
			$dropdownnav[] = (object)array('url'=>'/request-profile-review','class'=>'request','text'=>'Request Profile Review');	
		}
		
		if(isset($app->user->url)){
			$dropdownnav[] = (object)array('url'=>$app->user->url,'text'=>'View/Edit Your Profile');
		}
		
		$dropdownnav[] = (object)array('url'=>'/account-settings','text'=>'Account Settings');
		$dropdownnav[] = (object)array('url'=>'/payment','text'=>'Payment');
		
	}
	
	$dropdownnav[] = (object)array('class'=>'divider');
	$dropdownnav[] = (object)array('url'=>'/logout','text'=>'<i class="mdi-action-exit-to-app"></i> Logout');
?>

<ul id="user-dropdown" class="dropdown-content">
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