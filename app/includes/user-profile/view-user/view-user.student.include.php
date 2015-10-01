<?php if(isset($app->setupinstructions)): ?>
	<?php include($page = $app->dependents->APP_PATH.'includes/shared-pages/setup-instructions.php'); ?>
<?php else: ?>


	<?php if(isset($app->currentuser->thisisme)): ?>
	<form class="form-post hide" method="post" action="<?php echo $app->currentuser->url ?>" id="editprofile">
		
		<input type="hidden" name="editprofile[target]" value="editprofile"  />
		<input type="hidden" name="<?php echo $csrf_key; ?>" value="<?php echo $csrf_token; ?>">
	</form>
	<?php endif; ?>
	
	<div class="tutor-profile">
		
		<div class="tutor-profile-inside">
		
			<div class="row">
				<div class="col s12 m4 l4">
					<div class="tutor-left">
						
						<div class="profile-image center-align avatar">
							
							<?php $app->currentuser->dontshow = 1; echo show_avatar($app->currentuser,$app->user,$app->dependents); ?>
							
							<?php if(isset($app->user->email) && $app->user->email == $app->currentuser->promocode): ?>
							<div class="alert blue white-text">
								Your Student
							</div>
							<?php endif; ?>
							
						</div>
						
						<?php if(isset($app->childen)): ?>
							<div class="my-links">
								
								<div class="my-links-title">
									My Profile
								</div>
								<ul>
									<?php foreach($app->childen as $key=> $mylinks): ?>
										<li <?php if($app->request->getPath()==$mylinks->slug || $key=='about-me' && empty($pagename)){ echo 'class="active"';} ?>>
											<a href="<?php echo $mylinks->slug; ?>">
												<?php echo $mylinks->name; ?>
											</a>
										</li>
									<?php endforeach; ?>
								</ul>
								
							</div>
						<?php endif; ?>
						
						<div class="about-me">
							
							<?php if(isset($app->currentuser->toplinks['send-message'])): ?>
							<div class="message-box">
								<a href="<?php echo $app->currentuser->url; ?>/send-message" class="btn send waves-effect waves-light">
									Send Message
								</a>
							</div>
							<?php endif; ?>
							
							<ul class="collection my-info">
								<?php if($app->currentuser->status==NULL): ?>
									<?php if(isset($app->currentuser->hidden) && isset($app->currentuser->thisisme)): ?>
									<a href="<?php echo $app->currentuser->url; ?>/makevisible" class="btn btn-block light-green black-text waves-effect waves-light">Make Profile Visible</a>
									<?php elseif(empty($app->currentuser->hidden) && isset($app->currentuser->thisisme)): ?>
									<a href="<?php echo $app->currentuser->url; ?>/makehidden" class="btn btn-block light-green lighten-3 waves-effect waves-light">Make Profile Hidden</a>
									<?php endif; ?>
								<?php endif; ?>
								
								<?php if(isset($app->user->usertype) && $app->user->usertype=='admin'): ?>
									<?php if(isset($app->currentuser->status) && $app->currentuser->status=='needs-review'): ?>
									<a href="<?php echo $app->currentuser->url; ?>/approveprofile" class="btn btn-block green waves-effect waves-light"> <i class="fa fa-check white-text"></i> Approve Profile</a>
									<?php else: ?>
									<a href="<?php echo $app->currentuser->url; ?>/disapproveprofile" class="btn btn-block red waves-effect waves-light">Dis-Approve Profile</a>
									<?php endif; ?>
									
									<?php if(isset($app->currentuser->lock)): ?>
									<a href="<?php echo $app->currentuser->url; ?>/unlockprofile" class="btn btn-block green waves-effect waves-light"> <i class="fa fa-unlock white-text"></i> Un-Lock Profile</a>
									<?php elseif(empty($app->currentuser->lock)): ?>
									<a href="<?php echo $app->currentuser->url; ?>/lockprofile" class="btn btn-block red waves-effect waves-light"> <i class="fa fa-lock white-text"></i> Lock Profile</a>
									<?php endif; ?>
									
								<?php endif; ?>
								
								<div class="gray-box">
									<div class="title">My Info</div>
								</div>
								
								<?php include($app->dependents->APP_PATH.'includes/shared-pages/pages-sidebar.php'); ?>
								
								
							</ul>
							
						</div>
						
						<div class="badges">
							<?php echo badge('payment_on_file',$app->currentuser); ?>
						</div>
						
					</div>
				</div>
				<div class="col s12 m8 l8">
					<div class="tutor-right">
						<div class="edit-block">
							<h1><?php
								if(isset($app->currentuser->showfullname) && $app->currentuser->showfullname=='yes'){
									echo $app->currentuser->first_name.' '.$app->currentuser->last_name;
								}
								else{
									echo short($app->currentuser);	
								}
								
							?></h1>
							<?php if(isset($app->currentuser->thisisme)): ?>
							<div class="edit-profile-container">
								<div class="edit-profile tooltipped" data-position="left" data-delay="50" data-tooltip="Change Name" data-status="closed" data-target="name"><i class="fa fa-pencil"></i></div>
								<div class="edit-profile-box edit-change" id="name">
									<div class="row">
										<div class="col s12 m6 l6">
											<input type="text" name="editprofile[first_name]" value="<?php echo $app->currentuser->first_name; ?>" />
										</div>
										<div class="col s12 m6 l6">
											<input type="text" name="editprofile[last_name]" value="<?php echo $app->currentuser->last_name; ?>" />
										</div>
									</div>
								</div>
							</div>
							<?php endif; ?>
							
						</div>
						<div class="edit-block">
							<h2> <i class="mdi-action-room"></i> <?php echo $app->currentuser->city.' '.ucwords($app->currentuser->state_long).', '.$app->currentuser->zipcode; ?> </h2>
							<?php if(isset($app->currentuser->thisisme)): ?>
							<div class="edit-profile-container">
								<div class="edit-profile tooltipped" data-position="left" data-delay="50" data-tooltip="Change Zip Code / Location" data-status="closed" data-target="zipcode"><i class="fa fa-pencil"></i></div>
								<div class="edit-profile-box edit-change" id="zipcode">
									<input type="text" maxlength="5" name="editprofile[zipcode]" value="<?php echo $app->currentuser->zipcode; ?>" />
								</div>
							</div>
							<?php endif; ?>
						</div>

						<div class="my-stars">
							&nbsp;
						</div>
						
						<div class="tutor-info left">					
							
							<?php
								$page = $app->dependents->APP_PATH.'includes/shared-pages/pages-'.$app->pagename.'.php';
								if(file_exists($page)){
									include($page);
								}
								else{
									coder($page);
								}
							?>
							
						</div>
						
						
					</div>
				</div>
			</div>
		</div>
		
		
	</div>

<?php endif; ?>