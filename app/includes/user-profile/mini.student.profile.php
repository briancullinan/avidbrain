<?php
	$query = $app->connect->createQueryBuilder();
	$subjects = $query->select('*')
					 ->from('avid___jobs')
					 ->where('email = :email AND open IS NOT NULL')
					 ->setParameter(':email',$searchResults->email)
					 ->orderBy('date', 'ASC')
					 ->setMaxResults(7)
					 ->execute()
					 ->fetchAll();
					 if(count($subjects)>0){
						 $searchResults->ineedhelp = $subjects;
					 }
?>
<div class="tutor-results">

	<div class="row">
		<div class="col s12 m3 l3 center-align">

			<div class="user-photograph">
				<a href="<?php echo $searchResults->url; ?>">
					<img src="<?php echo userphotographs($app->user,$searchResults); ?>" />
				</a>
			</div>
			<div class="user-name">
				<a href="<?php echo $searchResults->url; ?>"><?php echo ucwords(short($searchResults)); ?></a>
			</div>

			<?php if(isset($searchResults->city)): ?>
			<div class="tutor-location">
				<i class="mdi-action-room"></i> <?php echo $searchResults->city; ?>, <?php echo ucwords($searchResults->state_long); ?>
			</div>
			<?php endif; ?>
			<?php if(isset($searchResults->distance)): ?>
			<div class="tutor-distance">
				<?php echo number_format(round($searchResults->distance), 0, '', ','); ?> Miles Away
			</div>
			<?php endif; ?>

			<?php
				if(isset($userinfo->promocode) && isset($app->user->email) && $userinfo->promocode==$app->user->email){
					echo '<div class="badge blue white-text your-student">Your Student</div>';
				}
			?>

		</div>
		<div class="col s12 m9 l9">
			<div class="row">
				<div class="col s12 m7 l9">

					<?php //printer($subjects); ?>

					<?php if(isset($searchResults->short_description_verified)): ?>
						<div class="short-description">
								<a href="<?php echo $searchResults->url; ?>">
										<?php echo $searchResults->short_description_verified; ?>
								</a>
						</div>
					<?php endif; ?>
					<?php if(isset($searchResults->personal_statement_verified)): ?>
						<div class="personal-statement"><?php echo truncate($searchResults->personal_statement_verified,300); ?></div>
					<?php endif; ?>

					<?php if(empty($searchResults->short_description_verified) && empty($searchResults->personal_statement_verified)): ?>

					<?php endif; ?>

					<?php if(isset($searchResults->ineedhelp[0])): ?>
					<div class="short-description">I'm Looking For Help With</div>
						<div class="tutor-results-subjects">
							<?php $total = (count($searchResults->ineedhelp)-1); ?>
							<?php foreach($searchResults->ineedhelp as $key=> $ineedhelp): ?>
								<a href="/jobs/apply/<?php echo $ineedhelp->id; ?>"><?php echo $ineedhelp->subject_name; ?></a><?php if($total!=$key){echo', ';} ?>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>

				</div>
				<div class="col s12 m5 l3">
					<?php if(isset($app->user->email) && $app->user->email == $searchResults->email): ?>
						<div class="view-profile"><a class="btn orange btn-block" href="<?php echo $searchResults->url; ?>">Edit Your Profile</a></div>
					<?php else: ?>
						<!-- <div class="view-profile"><a class="btn btn-block" href="<?php echo $searchResults->url; ?>">View Profile</a></div> -->
						<div class="view-profile"><a class="btn btn-block" href="<?php echo $searchResults->url; ?>/send-message">Send Message</a></div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>

</div>
