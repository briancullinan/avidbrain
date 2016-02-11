<?php if(isset($app->searchResults)): ?>

	<div class="filter-by right-align">
		<a class="dropdown-button grey btn btn-s" href="#" data-activates="filterby">
			Filter By <i class="fa fa-chevron-down"></i>
		</a>

		<!-- Dropdown Structure -->
		<ul id="filterby" class="dropdown-content">
			<?php foreach($app->filtertype as $key=>$value): ?>
			<li <?php if(isset($app->filterby) && $app->filterby==$key){ echo 'class="active"';} ?>>
				<a href="<?php echo '/filterby/'.$app->filterbylocation.'/'.$key.'/'.$app->number; ?>">
					<?php echo $value; ?>
				</a>
			</li>
			<?php endforeach; ?>
		</ul>
	</div>
	<?php
		$plurals = NULL;
		if($app->count!=1){
			$plurals = 's';
		}
	?>
	<h1><?php echo numbers($app->count,1); ?>  <span class="blue-text"> <?php echo ucwords($app->search->search); ?> Tutor<?php echo $plurals; ?></span></h1>

	<?php foreach($app->searchResults as $searchResults):?>
		<div class="imatutor">
			<div class="row no-bottom">
				<div class="col s12 m4 l3 center-align">
					<div class="image">
						<a href="<?php echo $searchResults->url; ?>">
							<img src="<?php echo userphotographs($app->user,$searchResults); ?>" />
						</a>
					</div>
					<div class="user-name">
						<a href="<?php echo $searchResults->url; ?>"><?php echo short($searchResults); ?></a>
					</div>

					<?php if(isset($searchResults->city)): ?>
					<div class="tutor-location">
						<i class="mdi-action-room"></i>
						<a href="/tutors/<?php echo $searchResults->state_slug; ?>/<?php echo $searchResults->city_slug; ?>"><?php echo $searchResults->city; ?></a>, <a href="/tutors/<?php echo $searchResults->state_slug; ?>"><?php echo ucwords($searchResults->state_long); ?></a>
					</div>
					<?php endif; ?>
					<?php if(isset($searchResults->distance)): ?>
					<div class="tutor-distance">
						<?php echo number_format(round($searchResults->distance), 0, '', ','); ?> Miles Away
					</div>
					<?php endif; ?>

					<div class="my-rate">
						$<?php echo numbers($searchResults->hourly_rate,1); ?><span>/ Hour <?php if(isset($searchResults->negotiableprice) && $searchResults->negotiableprice=='yes'){ echo '<i class="fa fa-asterisk"></i>';} ?></span>
					</div>

				</div>
				<div class="col s12 m8 l9">
					<div class="row">
						<div class="col s12 m12 l8">
							<?php if(isset($searchResults->short_description_verified)): ?>
								<div class="short-description"><a href="<?php echo $searchResults->url; ?>"><?php echo $searchResults->short_description_verified; ?></a></div>
							<?php endif; ?>
							<?php if(isset($searchResults->personal_statement_verified)): ?>
								<div class="personal-statement"><?php echo truncate($searchResults->personal_statement_verified,400); ?></div>
							<?php endif; ?>
						</div>
						<div class="col s12 m12 l4">
							<div class="badges minisdfadges">
								<?php
									//printer($searchResults);
									if(empty($searchResults->emptybgcheck)){
										include(APP_PATH.'includes/badges/badge.backgroundcheck.php');
									}

									if(!empty($searchResults->star_score)){
										include(APP_PATH.'includes/badges/badge.average_score.php');
									}

									if(isset($searchResults->negotiableprice) && $searchResults->negotiableprice=='yes'){
										include(APP_PATH.'includes/badges/badge.negotiable_rate.php');
									}

									//negotiableprice

									#echo(APP_PATH.'includes/badges/badge.review_count.php');
									#echo(APP_PATH.'includes/badges/badge.hours_tutored.php');
									#echo(APP_PATH.'includes/badges/badge.student_count.php');
									#echo(APP_PATH.'includes/badges/badge.fancy_hours_badge.php');
									#
								?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	<?php endforeach; ?>

	<?php echo $app->pagination; ?>

<?php else: ?>

<?php endif; ?>
