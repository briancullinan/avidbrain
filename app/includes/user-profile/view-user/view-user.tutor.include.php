	<?php if(isset($app->currentuser->thisisme)): ?>
	<form class="form-post hide" method="post" action="<?php echo $app->currentuser->url ?>" id="editprofile">

		<input type="hidden" name="editprofile[target]" value="editprofile"  />
		<input type="hidden" name="<?php echo $csrf_key; ?>" value="<?php echo $csrf_token; ?>">
	</form>
	<?php endif; ?>

	<div class="tutor-profile">

			<div class="hourly-rate valign-wrapper edit-change <?php if(isset($app->currentuser->negotiableprice) && $app->currentuser->negotiableprice=='yes'){ echo 'negotiable-price';} ?>" id="changehourlyrate">
				<span class="valign">
					<?php if(isset($app->currentuser->thisisme)): ?>
					<div class="edit-profile tooltipped" data-position="right" data-delay="50" data-tooltip="Change Hourly Rate"><i class="fa fa-pencil"></i></div>
					$<span class="input"><input type="text" name="editprofile[hourly_rate]" class="reset-input hourly_rate" value="<?php echo $app->currentuser->hourly_rate; ?>" /></span>
					<?php else: ?>
					$<?php echo $app->currentuser->hourly_rate; ?><?php if(isset($app->currentuser->negotiableprice) && $app->currentuser->negotiableprice=='yes'){ echo '<span class="asterisk"><i class="fa fa-asterisk"></i></span>';} ?>
					<?php endif; ?>
				</span>
			</div>

			<div class="row">
				<div class="col s12 m5 l4">
					<div class="tutor-left">

						<div class="user-photograph">
							<img src="<?php echo userphotographs($app->user,$app->currentuser,$app->dependents); ?>" />
						</div>

						<?php if(isset($app->childen)): ?>
							<div class="my-links" id="mylinks">
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

						<div class="about-me" id="about-me">

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

									<a href="#adminModule" class="btn btn-block orange modal-trigger">Admin Module</a>

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
							<?php
								if(empty($app->currentuser->emptybgcheck)){
									echo badge('background_check',$app->currentuser);
								}
								if(activenow($app->currentuser)){
									echo badge('imonline',$app->currentuser);
								}
								echo badge('average_score',$app->currentuser);
								echo badge('review_count',$app->currentuser);
								echo badge('hours_tutored',$app->currentuser);
								echo badge('student_count',$app->currentuser);
								echo badge('fancy_hours_badge',$app->currentuser);
								echo badge('negotiable_rate',$app->currentuser);
							?>
						</div>

					</div>
				</div>
				<div class="col s12 m7 l8">
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


						<?php if(isset($app->currentuser->reviewinfo->star_score)): ?>
						<div class="my-stars">
							<span class="the-star-score">
							<?php echo average_stars($app->currentuser->reviewinfo->review_average); ?>
							</span>

							<span class="my-stars-text">
								<?php echo $app->currentuser->reviewinfo->count; ?> Review<?php if($app->currentuser->reviewinfo->count!=1){ echo 's';} ?>
							</span>

						</div>
						<?php else: ?>
						<div class="my-stars">
							&nbsp;
						</div>
						<?php endif; ?>

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



<?php $app->modal = 'tutormodal'; ?>
