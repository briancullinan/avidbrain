<div class="searching-container-box">

	<div class="searching-results-left">
		<?php if(isset($app->searching)): ?>
			<div class="searching-count">
				<div class="row">
					<div class="col s12 m8 l8">

							<div class="the-count">
								<?php
									echo $app->meta->titletext;
									/*<span><?php echo numbers($app->count,1); ?></span> <?php if(isset($app->cachedSubjectQuery->subject_name)){ echo '<strong>'.$app->cachedSubjectQuery->subject_name.'</strong>'; } ?> Tutors Found */
								?>
							</div>

					</div>
					<div class="col s12 m4 l4 right-align">
						<div class="sort-by">
							<?php if(isset($app->sortable)): ?>
								<select class="browser-default sorting-feature">
									<?php foreach($app->sortable as $key=> $sortable): ?>
									<option <?php if(isset($app->queries->sort) && $app->queries->sort == $key){ echo 'selected="selected"';} ?> value="<?php echo $key; ?>"><?php echo $sortable; ?></option>
									<?php endforeach; ?>
								</select>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
			<div class="searching-results">
				<?php foreach($app->searching as $key=> $searching): ?>
					<div class="tutoring-block">

						<div class="row">
							<div class="col s12 m12 l3 center-align">
								<div>
									<a href="<?php echo $searching->url; ?>">
										<img class="responsive-img" src="<?php echo $searching->img; ?>" />
									</a>
								</div>
								<div class="user-name">
									<a href="<?php echo $searching->url; ?>">
										<?php echo $searching->short; ?>
									</a>
								</div>
								<div class="searching-location">
									<i class="fa fa-map-marker green-text"></i> <?php echo $searching->location; ?>
								</div>
								<?php if(isset($searching->distance)): ?>
									<div><?php echo numbers($searching->distance,1); ?> Miles Away</div>
								<?php endif; ?>
								<div class="my-rate">$<?php echo $searching->hourly_rate; ?><span>/ Hour</span></div>
							</div>
							<div class="col s12 m12 l9">
								<div class="row">
									<div class="col s12 m12 l8">
										<div class="im-a-tutor-short">
											<a href="<?php echo $searching->url; ?>"><?php echo $searching->short_description_verified; ?></a>
										</div>
										<div class="im-a-tutor-long"><?php echo $searching->personal_statement_verified; ?></div>
										<?php if(isset($searching->subjects[0])): ?>
											<div class="subject-i-tutor">
												<div class="subjects-i-tutor-title">
													Subjects I Tutor
												</div>


												<?php //printer($searching->subjects); ?>

												<div class="subjects-i-tutor-subs">
													<?php $count = count($searching->subjects); foreach($searching->subjects as $key=> $subjects): //printer($subjects);   ?>

														<?php
															if(isset($app->queries->subject) && strtolower($app->queries->subject) == strtolower($subjects->subject_slug) || isset($app->queries->subject) && strtolower($app->queries->subject) == strtolower($subjects->subject_name)){
																echo '<a href="/searching/'.$subjects->subject_slug.'"><strong class="green-text">'.$subjects->subject_name.'</strong></a>';
															}
															elseif(isset($app->queries->subject) && $app->queries->subject==$subjects->parent_slug || isset($app->queries->subject) &&  strtolower($app->queries->subject)==strtolower($subjects->parent_slug)){
																echo '<a href="/searching/'.$subjects->subject_slug.'"><strong class="blue-text">'.$subjects->subject_name.'</strong></a>';
															}
															elseif(isset($app->queries->subject) && (strpos($subjects->subject_name, $app->queries->subject) !== false)){
																echo '<a href="/searching/'.$subjects->subject_slug.'"><strong class="cyan-text">'.$subjects->subject_name.'</strong></a>';
															}
															elseif(isset($app->queries->subject) && (strpos($subjects->parent_slug, $app->queries->subject) !== false)){
																echo '<a href="/searching/'.$subjects->subject_slug.'"><strong class="light-green-text">'.$subjects->subject_name.'</strong></a>';
															}
															else{
																echo '<a href="/searching/'.$subjects->subject_slug.'">'.$subjects->subject_name.'</a>';
															}
															if(($key+1)!=$count){
																echo ', ';
															}
														?>
													<?php endforeach; ?>
												</div>

											</div>

										<?php endif; ?>

									</div>
									<div class="col s12 m12 l4">
										<div><a href="<?php echo $searching->url; ?>" class="btn btn-block blue">View profile</a></div>
										<div><a href="<?php echo $searching->url; ?>/send-message" class="btn btn-block success">Send Message</a></div>
										<div class="ajax-badges badges" id="mybadges-<?php echo $searching->username; ?>" data-url ="<?php echo $searching->url; ?>"></div>
									</div>
								</div>
							</div>
						</div>

						<?php //printer($searching); ?>
					</div>
				<?php endforeach; ?>
				<?php echo $app->pagination; ?>
			</div>

		<?php else: ?>

			<?php if(isset($app->top)): ?>
				<div class="select-a-subject">
					<h1>Top Tutored Subjects</h1>
					<div class="block">
						<ul class="top-listed-subjects">
							<?php foreach($app->top as $top): ?>
								<div class="bubble"><a href="/searching/<?php echo $top->subject_slug; ?>">
									<span class="top-count"><?php echo $top->count; ?></span> <?php echo $top->subject_name; ?> Tutors
								</a></div>
							<?php endforeach; ?>
						</ul>
					</div>
				</div>
			<?php endif; ?>


		<?php endif; ?>
	</div>


	<div class="searching-results-right">
		<div class="pull-tab" data-status="closed"><span>Search</span> <i class="fa fa-arrow-up"></i></div>
		<div class="searching-results-search"><?php include($app->dependents->APP_PATH.'includes/searching/searchbox.php'); ?></div>
	</div>

</div>


<input id="csrf" type="hidden" name="<?php echo $csrf_key; ?>" value="<?php echo $csrf_token; ?>">
<div class="hide" id="csrf_key"><?php echo $csrf_key; ?></div>
<div class="hide" id="csrf_token"><?php echo $csrf_token; ?></div>


<style type="text/css">
.subjects-i-tutor-subs a{
	color: #999;
}
.subjects-i-tutor-subs a:hover{
	text-decoration: underline;
}
</style>
