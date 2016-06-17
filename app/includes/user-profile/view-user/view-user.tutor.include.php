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
							<img src="<?php echo userphotographs($app->user,$app->currentuser); ?>" />
						</div>

						<?php if(isset($app->user->usertype) && $app->user->usertype=='student'): ?>
							<?php
								$sql = "SELECT * FROM avid___approved_tutors WHERE tutor_email = :tutor_email AND student_email = :student_email LIMIT 1 ";
								$prepare = array(':tutor_email'=>$app->currentuser->email,':student_email'=>$app->user->email);
								$results = $app->connect->executeQuery($sql,$prepare)->fetch();
							?>
							<div>
								<?php if(isset($results->id)): ?>
									<form method="post" action="<?php echo $app->request->getPath(); ?>">

										<input type="hidden" name="approvedtutors[status]" value="remove"  />
										<input type="hidden" name="approvedtutors[target]" value="approvedtutors"  />
										<input type="hidden" name="<?php echo $csrf_key; ?>" value="<?php echo $csrf_token; ?>">

										<div class="form-submit">
											<button type="button" class="btn btn-block purple confirm-submit"><i class="fa fa-remove"></i> Remove Tutor from Approved Tutors List</button>
										</div>

									</form>
								<?php else: ?>
									<form method="post" action="<?php echo $app->request->getPath(); ?>">

										<input type="hidden" name="approvedtutors[status]" value="save"  />
										<input type="hidden" name="approvedtutors[target]" value="approvedtutors"  />
										<input type="hidden" name="<?php echo $csrf_key; ?>" value="<?php echo $csrf_token; ?>">

										<div class="form-submit">
											<button type="button" class="btn btn-block pink confirm-submit"><i class="fa fa-heart"></i> Add Tutor to Approved Tutors List</button>
										</div>

										<div class="approved-tutors-list">Only tutors on this list can setup a tutoring session with you</div>

									</form>
								<?php endif; ?>
							</div>
						<?php endif; ?>

						<!-- <?php if(isset($app->childen)): ?>
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
						<?php endif; ?> -->

						<div class="about-me" id="about-me">

							<?php //if(isset($app->currentuser->toplinks['send-message'])): ?>
							<div class="row">
								<div class="col s6 m6 l6 right-align">
										<a href="<?php echo $app->currentuser->url?>"	class="btn">View Details</a>
								</div>
								<div class="col s6 m6 l6">
										<a href="<?php echo $app->currentuser->url; ?>/send-message" class="btn send waves-effect waves-light">
											Send Message
										</a>
							</div>
							</div>
							<?php //endif; ?>

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

								<!-- <div class="gray-box">
									<div class="title">My Info</div>
								</div> -->

								<?php include(APP_PATH.'includes/shared-pages/pages-sidebar.php'); ?>


							</ul>

						</div>

						<div class="badges">

							<div class="ajax-badges" id="<?php echo str_replace('/','',$app->currentuser->url); ?>" data-url="<?php echo $app->currentuser->url; ?>"></div>

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

							if(isset($app->pagename) && $app->pagename == 'send-message'){

								$page = APP_PATH.'includes/shared-pages/pages-'.$app->pagename.'.php';
								if(file_exists($page)){
									include($page);
								}
								else{
									coder($page);
								}
							}
							else {

									$page = APP_PATH.'includes/shared-pages/pages-about-me.php';
									if(file_exists($page)){
										include($page);
									}


									$page = APP_PATH.'includes/shared-pages/pages-my-subjects.php';
									if(file_exists($page)){
										include($page);
									}

									$page = APP_PATH.'includes/shared-pages/pages-my-subjects.php';
									if(file_exists($page)){
										include($page);
									}

									// $page = APP_PATH.'includes/shared-pages/pages-i-need-help-with.php';
									// if(file_exists($page)){
									// 	include($page);
									// }

							}

							?>

						</div>


					</div>
				</div>
			</div>
		</div>

	</div>


	<div class="hide" id="csrf_key"><?php echo $csrf_key; ?></div>
	<div class="hide" id="csrf_token"><?php echo $csrf_token; ?></div>
<?php $app->modal = 'tutormodal'; ?>
