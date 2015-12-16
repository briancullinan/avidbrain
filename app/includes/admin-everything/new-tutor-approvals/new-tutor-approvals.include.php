
<?php
	$thetypes = array(
		'haventfinished'=>'Haven\'t Finished',
		'newtutors'=>'Waiting For Approval',
		'rejectedtutors'=>'Rejected Tutors',
		'approvedtutors'=>'Approved Tutors'
	);
?>

<div class="row">
	<div class="col s12 m4 l3">
		<ul class="block">
			<?php foreach($thetypes as $key=> $types): ?>
				<li <?php if(isset($action) && $action==$key){ echo 'class="active"';} ?>>
					<a href="/admin-everything/new-tutor-approvals/<?php echo $key; ?>">
						<?php echo $types; ?>
					</a>
				</li>
			<?php endforeach; ?>
		</ul>

		<?php if(isset($action) && isset($app->$action)): ?>
			<ul class="block">
				<?php foreach($app->$action as $user): ?>
					<li <?php if(isset($id) && $id==$user->id){ echo 'class="active"';} ?>>
						<a href="/admin-everything/new-tutor-approvals/<?php echo $action; ?>/<?php echo $user->id; ?>">
							<?php echo $user->first_name; ?> <?php echo $user->last_name; ?>
						</a>
					</li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>

	</div>
	<div class="col s12 m8 l9">
		<?php if(isset($app->thetutor)): ?>
			<?php //printer($app->thetutor->promocode); ?>
			<!-- -->
			<?php if(isset($app->thetutor->activated)): ?>
				<div>Account Activated</div>
				<a href="<?php echo $app->thetutor->url; ?>" target="_blank">View Profile</a>
			<?php else: ?>
				<?php if(isset($app->thetutor)): ?>
		            <div class="block">

						<?php if(!empty($app->thetutor->promocode)): ?>
							<div class="promocode">Promo Code: <span><?php echo $app->thetutor->promocode; ?></span></div>
						<?php endif; ?>

						<?php if(isset($app->thetutor->comper)): ?>
							<div class="green white-text padd5 center-align">Background Check Comped</div><br>
						<?php else: ?>
							<form method="post" action="<?php echo $app->request->getPath(); ?>">

								<input type="hidden" name="compbackgroundcheck[email]" value="<?php echo $app->thetutor->email; ?>"  />
								<input type="hidden" name="compbackgroundcheck[target]" value="compbackgroundcheck"  />
								<input type="hidden" name="<?php echo $csrf_key; ?>" value="<?php echo $csrf_token; ?>">

								<div class="form-submit <?php if(isset($app->thetutor->promocode) && $app->thetutor->promocode=='get80--free-backgroundcheck'){echo ' promote-me '; } ?>">
									<button class="btn green confirm-submit" type="button">
										Comp Background Check $29.99
									</button>
								</div>

							</form><br>
						<?php endif; ?>

						<?php if(isset($app->thetutor->approval_status) && $app->thetutor->approval_status=='rejected'): ?>
							<div class="red padd5 center-align white-text">Application Rejected</div>
							<br>
						<?php endif; ?>

						<div class="some-info">

							<?php if(!empty($app->thetutor->over18)){ echo "<span class=' blue white-text'>I'm Over 18</span>";} ?>
							<?php if(!empty($app->thetutor->legalresident)){ echo "<span class=' blue white-text'>I'm Am A Legal US Resident</span>";} ?>
							<?php if(!empty($app->thetutor->tutoredbefore)){ echo "<span class=' blue white-text'>I Have Tought or Tutored Before</span>";} ?>
							<?php if(!empty($app->thetutor->howdidyouhear)){ echo "<span class=' blue white-text'>I Heard About AvidBrain From: ".$app->thetutor->howdidyouhear."</span>";} ?>
							<?php if(isset($app->thetutor->my_resume) && $app->thetutor->my_resume!=$app->thetutor->resume_text){ echo "<span class=' blue white-text'><a target='_blank' href='/admin-everything/new-tutor-approvals/".$id."/download'>Download Resume</a></span>";} //".$app->thetutor->my_resume." ?>
							<?php if(empty($app->thetutor->my_resume)){echo '<span class="red white-text">NO RESUME</span>'; $ignore = true;} ?>
						</div>

						<?php if(!empty($app->thetutor->charge_id) && !empty($app->thetutor->candidate_id)): ?>

								<div class="alert red white-text">
									I've Paid &amp; Sent For My Background Check
								</div>
								<?php
									$sql = "SELECT status FROM avid___bgcheckstatus WHERE email = :email";
									$prepare = array(':email'=>$app->thetutor->email);
									$results = $app->connect->executeQuery($sql,$prepare)->fetchAll();
									if(isset($results[0])){
										echo '<div class="bgcheck-status">';
										foreach($results as $status){
											echo '<span class="bgcheck '.$status->status.'">'.$status->status.'</span>';
										}
										echo '</div>';
									}
								?>
						<?php endif; ?>

						<?php if(!empty($app->thetutor->yesinterview)): ?>
						<div class="row infos">

							<div class="col s12 m12 l12">
								<div class="title"> I would like to have an interview: </div>
								<div>
									Please call me: <?php echo $app->thetutor->timeday ?>
								</div>
							</div>
						</div>
						<?php endif; ?>

						<div class="row infos">
							<div class="col s12 m4 l4">
								<div class="title"> Email </div>
								<div>
									<?php echo $app->thetutor->email; ?>
								</div>
							</div>
							<div class="col s12 m4 l4">
								<div class="title"> Phone </div>
								<div>
									<?php echo $app->thetutor->phone; ?>
								</div>
							</div>
							<div class="col s12 m4 l4">
								<div class="title"> Signup Date </div>
								<div>
									<?php echo formatdate($app->thetutor->signupdate); ?>
								</div>
							</div>
						</div>

						<div class="row infos">
							<div class="col s12 m6 l6">
								<div class="title"> Photo </div>
								<div>
									<?php if(!empty($app->thetutor->upload)): ?>
										<div class="profile-image avatar maxus"><img src="/image/tutorphotos/cropped/<?php echo $app->thetutor->id; ?>" class="responsive-img" /></div>
									<?php else: ?>
										<div class="alert red white-text">NO PHOTO</div> <?php $ignore = true; ?>
									<?php endif; ?>
								</div>
							</div>
							<div class="col s12 m6 l6">
								<div class="title"> Name </div>
								<div>
									<?php echo $app->thetutor->first_name.' '.$app->thetutor->middle_name.' '.$app->thetutor->last_name; ?>
								</div>
							</div>
						</div>

						<?php if(!empty($app->thetutor->resume_text)): ?>
						<div>
							<div class="title"> My Skills - Why I should be a tutor </div>
							<?php
								echo nl2br($app->thetutor->resume_text);
							?>
							<br><br>
						</div>
						<?php endif; ?>

						<div class="row infos">
							<div class="col s12 m12 l12">
								<div class="title"> Why do you want to tutor with AvidBrain? </div>
								<div>
									<?php echo nl2br($app->thetutor->whytutor); ?>
								</div>
							</div>
						</div>

						<div class="row infos">
							<div class="col s12 m12 l12">
								<div class="title"> Location info </div>
								<div>
									<?php echo $app->thetutor->city; ?> - <?php echo $app->thetutor->state_long; ?>, <?php echo $app->thetutor->zipcode; ?>
								</div>
							</div>
						</div>

						<div class="row infos">
							<div class="col s12 m12 l12">
								<div class="title"> Short Description </div>
								<div>
									<?php echo $app->thetutor->short_description; ?>
								</div>
							</div>
						</div>

						<div class="row infos">
							<div class="col s12 m12 l12">
								<div class="title"> Detailed Description </div>
								<div>
									<?php echo nl2br($app->thetutor->personal_statement); ?>
								</div>
							</div>
						</div>

						<div class="row infos">
							<div class="col s12 m4 l4">
								<div class="title"> Hourly Rate </div>
								<div>
									$<?php echo $app->thetutor->hourly_rate; ?>
								</div>
							</div>
							<div class="col s12 m4 l4">
								<div class="title"> Gender </div>
								<div>
									<?php echo $app->thetutor->gender; ?>
								</div>
							</div>
							<div class="col s12 m4 l4">
								<div class="title"> Travel Distance </div>
								<div>
									<?php echo $app->thetutor->travel_distance; ?> Miles
								</div>
							</div>
						</div>

						<div class="row infos">
							<div class="col s12 m4 l4">
								<div class="title"> Tutor Type </div>
								<div>
									<?php echo online_tutor($app->thetutor->online_tutor); ?>
								</div>
							</div>
							<div class="col s12 m4 l4">
								<div class="title"> Cancellation Policy </div>
								<div>
									<?php echo $app->thetutor->cancellation_policy; ?>
								</div>
							</div>
							<div class="col s12 m4 l4">
								<div class="title"> Cancellation Rate </div>
								<div>
									$<?php echo numbers($app->thetutor->cancellation_rate); ?>
								</div>
							</div>
						</div>

						<?php
							/*
							<div class="row infos">
								<div class="col s12 m12 l12">
									<div class="title"> 3 References </div>
									<div>
										<?php echo nl2br($app->thetutor->references); ?>
									</div>
								</div>
							</div>
							*/
						?>

						<?php
							//$computer = json_decode($app->thetutor->mysubs_computer)->computer;
							function subinfo($connect,$id){
								$sql = "SELECT * FROM avid___available_subjects WHERE id = :id";
								$prepare = array(':id'=>$id);
								return $connect->executeQuery($sql,$prepare)->fetch();
							}
							$thesubjectarray = array(
								'art'=>$app->thetutor->mysubs_art,
								'business'=>$app->thetutor->mysubs_business,
								'college-prep'=>$app->thetutor->mysubs_collegeprep,
								'computer'=>$app->thetutor->mysubs_computer,
								'elementary-education'=>$app->thetutor->mysubs_elementaryeducation,
								'english'=>$app->thetutor->mysubs_english,
								'games'=>$app->thetutor->mysubs_games,
								'history'=>$app->thetutor->mysubs_history,
								'language'=>$app->thetutor->mysubs_language,
								'math'=>$app->thetutor->mysubs_math,
								'music'=>$app->thetutor->mysubs_music,
								'science'=>$app->thetutor->mysubs_science,
								'special-needs'=>$app->thetutor->mysubs_specialneeds,
								'sports-and-recreation'=>$app->thetutor->mysubs_sportsandrecreation,
								'test-preparation'=>$app->thetutor->mysubs_testpreparation
							);
						?>

						<form method="post" action="<?php echo $app->request->getPath(); ?>">
						<div class="title">Subjects I Teach / Tutor</div>

						<?php
						if(
							empty($app->thetutor->mysubs_business) &&
							empty($app->thetutor->mysubs_collegeprep) &&
							empty($app->thetutor->mysubs_computer) &&
							empty($app->thetutor->mysubs_elementaryeducation) &&
							empty($app->thetutor->mysubs_english) &&
							empty($app->thetutor->mysubs_games) &&
							empty($app->thetutor->mysubs_history) &&
							empty($app->thetutor->mysubs_language) &&
							empty($app->thetutor->mysubs_math) &&
							empty($app->thetutor->mysubs_music) &&
							empty($app->thetutor->mysubs_science) &&
							empty($app->thetutor->mysubs_specialneeds) &&
							empty($app->thetutor->mysubs_sportsandrecreation) &&
							empty($app->thetutor->mysubs_testpreparation)
						){
							$nosubs = true;
							echo '<div class="padd5 red white-text">NO SUBJECTS</div><br>';
						}
						?>

						<?php foreach($thesubjectarray as $key=> $subjects): ?>
							<div>
								<?php
									if($data = json_decode($subjects)){
										foreach($data as $subject){
											$subdata = subinfo($app->connect,$subject->id);
											echo '<div>';
								                echo '<input type="hidden" name="approveprofile['.$subdata->parent_slug.'---'.$subdata->subject_slug.'][email]" value="'.$app->thetutor->email.'" />';
								                echo '<input type="hidden" name="approveprofile['.$subdata->parent_slug.'---'.$subdata->subject_slug.'][subject_slug]" value="'.$subdata->subject_slug.'" />';
								                echo '<input type="hidden" name="approveprofile['.$subdata->parent_slug.'---'.$subdata->subject_slug.'][parent_slug]" value="'.$subdata->parent_slug.'" />';
								                echo '<input type="hidden" name="approveprofile['.$subdata->parent_slug.'---'.$subdata->subject_slug.'][last_modified]" value="'.thedate().'" />';
								                echo '<input type="hidden" name="approveprofile['.$subdata->parent_slug.'---'.$subdata->subject_slug.'][usertype]" value="tutor" />';
								                echo '<input type="hidden" name="approveprofile['.$subdata->parent_slug.'---'.$subdata->subject_slug.'][subject_name]" value="'.$subdata->subject_name.'" />';
								                echo '<div class="infos-title">'.$subdata->subject_name.'</div>';
								                echo '<div class="infos-text">'.$subdata->subject_parent.'</div>';
												if(isset($subject->description)){
													echo '<textarea name="approveprofile['.$subdata->parent_slug.'---'.$subdata->subject_slug.'][description]" class="materialize-textarea">'.$subject->description.'</textarea>';
												}
								            echo '</div>';
										}
									}
								?>
							</div>
						<?php endforeach; ?>

							<?php if(empty($ignore)): ?>
							<button type="button" class="btn green white-text confirm-submit">
								Approve Profile
							</button>
							<?php endif; ?>

							<input type="hidden" name="approveprofile[id]" value="<?php echo $id; ?>"  />
							<input type="hidden" name="approveprofile[target]" value="approveprofile"  />
							<input type="hidden" name="<?php echo $csrf_key; ?>" value="<?php echo $csrf_token; ?>">
						</form>




						<?php if(empty($ignore)): ?>
						<br>
						<form method="post" action="<form method="post" action="<?php echo $app->request->getPath(); ?>">">
							<button type="button" class="btn red white-text confirm-submit">
								Reject Profile
							</button>

							<input type="hidden" name="rejectprofile[id]" value="<?php echo $id; ?>"  />
							<input type="hidden" name="rejectprofile[target]" value="rejectprofile"  />
							<input type="hidden" name="<?php echo $csrf_key; ?>" value="<?php echo $csrf_token; ?>">
						</form>
						<?php else: ?>

							<?php
								//printer($app->thetutor);
								$body = '';

									$body = '<p>Hello, '.ucwords($app->thetutor->first_name).'. It looks like you haven\'t finished your application. </p>';
									$body.= '<div>Please Complete The Following: </div>';
									$body.= '<ul>';


								if(empty($app->thetutor->zipcode)){
									$body.= '<li>Enter your <strong>Zip Code</strong></li>';
								}

								if(isset($nosubs)){
									$body.= '<li>Add the subjects that you would like to tutor</li>';
								}
								if(empty($app->thetutor->hourly_rate)){
									$body.= '<li>Add an <strong>Hourly Rate</strong></li>';
								}
								if(empty($app->thetutor->my_resume)){
									$body.= '<li>Upload your <strong>Resume</strong></li>';
								}
								if(empty($app->thetutor->upload)){
									$body.= '<li>Upload a <strong>Photo</strong></li>';
								}
								// if(empty($app->thetutor->references)){
								// 	$body.= '<li>List 3 <strong>References</strong></li>';
								// }


								$body.= '</ul>';

								$body.= '<p>You can login and complete your application by going here: https://www.avidbrain.com/signup/tutor and clicking the <strong>Complete Signup Proccess</strong> button.</p>';
							?>

							<div class="red white-text padd5">
								Incomplete Application. Please Email
								<a class="yellow-text" href="mailto:<?php echo $app->thetutor->email; ?>?subject=Incomplete Profile&amp;body=<?php echo $body; ?>">
									<?php echo ucwords($app->thetutor->first_name); ?>
								</a>

							</div>

							<div  class="copyme"><?php echo $body; ?></div>

						<?php endif; ?>

					</div>
		        <?php endif; ?>
			<?php endif; ?>
			<!-- -->
		<?php endif; ?>
	</div>
</div>



<style type="text/css">
.promote-me{
	position: relative;;
}
.promote-me:before{
	width: 19px;
	height: 26px;
	position: absolute;
	left: -32px;
	top:7px;
	color: #ccc;
	display:inline-block;font:normal normal normal 14px/1 FontAwesome;font-size:inherit;text-rendering:auto;-webkit-font-smoothing:antialiased;-moz-osx-font-smoothing:grayscale;transform:translate(0, 0);
	content:"\f061";
	font-size: 22px;
}
.promocode{
	background: #efefef;
	padding: 5px;
	margin-bottom: 10px;
}
.promocode span{
	background: #7800ff;
	color: #fff;
	padding: 5px;
}
ul.block li.active a{
	background: #333;
	color: #fff;
}
ul.block li a{
	display: block;
	padding: 5px;
}
.copyme{
	padding: 10px;
	border: solid 1px #ccc;
}
.maxus img{
	max-height: 220px;
}
.row.infos, .infos{
	margin-bottom: 15px;
}
.some-info{
	margin-bottom: 10px;
}
.some-info span{
	padding: 5px;
	display: inline-block;
	margin-bottom: 5px;
}
.some-info a{
	color: #fff;
}
.infos-title{
	font-weight: bold;
}
.infos-text{
	color:#999;
	font-size: 12px;
}
.bgcheck-status{
	background: #efefef;
	padding: 10px;
	margin-bottom: 10px;
	float: left;
	width: 100%;
	margin-top: -10px;
}
.bgcheck-status .bgcheck{
	display: inline-block;
	margin-right: 10px;
	padding: 2px 10px;
	color: #fff;
}
.bgcheck.clear{
	background: green;
}
.bgcheck.pending{
	background: orange;
}
</style>
