<div class="row">
	<div class="col s12 m3 l2">
        <?php if(isset($app->newtutors)): ?>
            <div class="block block-list">
    			<?php foreach($app->newtutors as $link): ?>
    			<a <?php if(isset($id) && $id==$link->id){ echo 'class="active"';} ?> href="/admin-everything/new-tutor-approvals/<?php echo $link->id; ?>">
                    <?php echo $link->first_name; ?> <?php echo $link->last_name; ?>
                </a>
    			<?php endforeach; ?>
    		</div>
        <?php endif; ?>
	</div>
	<div class="col s12 m9 l10">
		<?php if(isset($app->thetutor)): ?>
            <div class="block">

				<div class="some-info">
					<?php if(!empty($app->thetutor->over18)){ echo "<span class=' blue white-text'>I'm Over 18</span>";} ?>
					<?php if(!empty($app->thetutor->legalresident)){ echo "<span class=' blue white-text'>I'm Am A Legal US Resident</span>";} ?>
					<?php if(!empty($app->thetutor->tutoredbefore)){ echo "<span class=' blue white-text'>I Have Tought or Tutored Before</span>";} ?>
					<?php if(!empty($app->thetutor->howdidyouhear)){ echo "<span class=' blue white-text'>I Heard About AvidBrain From: ".$app->thetutor->howdidyouhear."</span>";} ?>
				</div>

				<?php if(!empty($app->thetutor->charge_id) && !empty($app->thetutor->candidate_id)): ?>
						<div class="alert red white-text">
							I've Paid &amp; Sent For My Background Check
						</div>
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
						<div class="title"> Phone </div>
						<div>
							<?php echo formatdate($app->thetutor->signupdate); ?>
						</div>
					</div>
				</div>

				<div class="row infos">
					<div class="col s12 m6 l6">
						<div class="title"> Photo </div>
						<div>
							<div class="profile-image avatar maxus"><img src="/image/tutorphotos/cropped/<?php echo $app->thetutor->id; ?>" class="responsive-img" /></div>
						</div>
					</div>
					<div class="col s12 m6 l6">
						<div class="title"> Name </div>
						<div>
							<?php echo $app->thetutor->first_name.' '.$app->thetutor->middle_name.' '.$app->thetutor->last_name; ?>
						</div>
					</div>
				</div>

				<div class="row infos">
					<div class="col s12 m12 l12">
						<div class="title"> Why do you want to tutor with AvidBrain? </div>
						<div>
							<?php echo $app->thetutor->whytutor; ?>
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
							<?php echo $app->thetutor->personal_statement; ?>
						</div>
					</div>
				</div>

				<div class="row infos">
					<div class="col s12 m4 l4">
						<div class="title"> Hourly Rate </div>
						<div>
							$<?php echo numbers($app->thetutor->hourly_rate); ?>
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
						<div class="title"> Cancelation Policy </div>
						<div>
							<?php echo $app->thetutor->cancellation_policy; ?>
						</div>
					</div>
					<div class="col s12 m4 l4">
						<div class="title"> Canelation Rate </div>
						<div>
							$<?php echo numbers($app->thetutor->cancellation_rate); ?>
						</div>
					</div>
				</div>

				<div class="row infos">
					<div class="col s12 m12 l12">
						<div class="title"> 3 References </div>
						<div>
							<?php echo nl2br($app->thetutor->references); ?>
						</div>
					</div>
				</div>

				<?php
					//$computer = json_decode($app->thetutor->mysubs_computer)->computer;
					function subinfo($connect,$id){
						$sql = "SELECT * FROM avid___available_subjects WHERE id = :id";
						$prepare = array(':id'=>$id);
						return $connect->executeQuery($sql,$prepare)->fetch();
					}
					$thesubjectarray = array(
						$app->thetutor->mysubs_art,
						$app->thetutor->mysubs_business,
						$app->thetutor->mysubs_collegeprep,
						$app->thetutor->mysubs_computer,
						$app->thetutor->mysubs_elementaryeducation,
						$app->thetutor->mysubs_english,
						$app->thetutor->mysubs_games,
						$app->thetutor->mysubs_history,
						$app->thetutor->mysubs_language,
						$app->thetutor->mysubs_math,
						$app->thetutor->mysubs_music,
						$app->thetutor->mysubs_science,
						$app->thetutor->mysubs_specialneeds,
						$app->thetutor->mysubs_sportsandrecreation,
						$app->thetutor->mysubs_testpreparation
					);
				?>

				<form method="post" action="/admin-everything/new-tutor-approvals/<?php echo $id; ?>">
				<div class="title">Subjects I Teach / Tutor</div>
				<?php foreach($thesubjectarray as  $subjects): ?>
					<div class="row">
						<?php
							if(!empty($subjects)){
								$json = json_decode($subjects);
								$key = key($json);
								if(!empty($key)){

									foreach($json->$key as $key=> $subid){
										$subdata = subinfo($app->connect,$subid);
										echo '<div class="col s12 m4 l4 infos">';
											echo '<input type="hidden" name="approveprofile['.$subdata->parent_slug.'---'.$subdata->subject_slug.'][email]" value="'.$app->thetutor->email.'" />';
											echo '<input type="hidden" name="approveprofile['.$subdata->parent_slug.'---'.$subdata->subject_slug.'][subject_slug]" value="'.$subdata->subject_slug.'" />';
											echo '<input type="hidden" name="approveprofile['.$subdata->parent_slug.'---'.$subdata->subject_slug.'][parent_slug]" value="'.$subdata->parent_slug.'" />';
											echo '<input type="hidden" name="approveprofile['.$subdata->parent_slug.'---'.$subdata->subject_slug.'][last_modified]" value="'.thedate().'" />';
											echo '<input type="hidden" name="approveprofile['.$subdata->parent_slug.'---'.$subdata->subject_slug.'][usertype]" value="tutor" />';
											echo '<input type="hidden" name="approveprofile['.$subdata->parent_slug.'---'.$subdata->subject_slug.'][subject_name]" value="'.$subdata->subject_name.'" />';
											echo '<div class="infos-title">'.$subdata->subject_name.'</div>';
											echo '<div class="infos-text">'.$subdata->subject_parent.'</div>';
										echo '</div>';
									}

								}
							}
						?>
					</div>
				<?php endforeach; ?>

				<?php
				/*
				<?php foreach(array('mysubs_art','mysubs_computer') as $subjects): ?>
					<?php
						if($json = json_decode($app->thetutor->$subjects)){
							foreach($json as $value){
								printer($value);
							}
						};
					?>
				<?php endforeach; ?>

				<div class="row infos">
					<div class="col s12 m12 l12">
						<div class="title"> xxx </div>
						<div>
							<?php echo $app->thetutor->xxx; ?>
						</div>
					</div>
				</div>

				<div class="row infos">
					<div class="col s12 m6 l6">
						<div class="title"> xxx </div>
						<div>
							<?php echo $app->thetutor->xxx; ?>
						</div>
					</div>
					<div class="col s12 m6 l6">
						<div class="title"> xxx </div>
						<div>
							<?php echo $app->thetutor->xxx ?>
						</div>
					</div>
				</div>

				<div class="row infos">
					<div class="col s12 m4 l4">
						<div class="title"> xxx </div>
						<div>
							<?php echo $app->thetutor->xxx; ?>
						</div>
					</div>
					<div class="col s12 m4 l4">
						<div class="title"> xxx </div>
						<div>
							<?php echo $app->thetutor->xxx; ?>
						</div>
					</div>
					<div class="col s12 m4 l4">
						<div class="title"> xxx </div>
						<div>
							<?php echo $app->thetutor->xxx; ?>
						</div>
					</div>
				</div>
				*/
				?>

				<?php //printer($app->thetutor); ?>



					<button type="button" class="btn green white-text confirm-submit">
						Approve Profile
					</button>

					<input type="hidden" name="approveprofile[id]" value="<?php echo $id; ?>"  />
					<input type="hidden" name="approveprofile[target]" value="approveprofile"  />
					<input type="hidden" name="<?php echo $csrf_key; ?>" value="<?php echo $csrf_token; ?>">
				</form>

			</div>
        <?php endif; ?>
	</div>
</div>

<style type="text/css">
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
.infos-title{
	font-weight: bold;
}
.infos-text{
	color:#999;
	font-size: 12px;
}
</style>
