<h1>Post a Job, It's Free</h1>


<div class="row">
	<div class="col s12 m6 l6">

        <h2>Post New Job</h2>

        <div class="block">
            <form class="form-post" method="post" action="<?php echo $app->request->getPath(); ?>" id="postanewjob">

				<input type = "hidden" name="postanewjob[jobid]" value="<?php echo random_numbers(11); ?>" />


                <div class="input-field">
                    <input type="text" id="subject" name="postanewjob[subject]" data-name="postanewjob" class="autogenerate--subject" />
                    <label for="subject">
                        Subject
                    </label>
                </div>

                <div class="input-field">
                    <textarea id="why" name="postanewjob[why]" class="materialize-textarea"></textarea>
                    <label for="why">
                        Explain why you need help
                    </label>
                </div>

                <div class="input-field input-range jobs-range">

                    <div class="jobs-price-range">What is your price range?</div>

                    <div class="pricerange slidebox"></div>
                    <div class="slidebox-inputs">
                        <input type="text" name="postanewjob[price_range_low]" id="pricerangeLower" data-value="<?php if(isset($app->thejob->price_range_low)){ echo $app->thejob->price_range_low; }else{ echo '15';} ?>" />
                        <input type="text" name="postanewjob[price_range_high]" id="pricerangeUpper" data-value="<?php if(isset($app->thejob->price_range_high)){ echo $app->thejob->price_range_high; }else{ echo '65';} ?>" />
                    </div>

                </div>

                <div class="row">
                    <div class="col s12 m6 l6">
                        <div class="input-field">
                            <label class="select-label" for="textarea1">
                                What type of tutor are you looking for?
                            </label>
                            <select name="postanewjob[type]" class="browser-default">
                                <?php foreach($app->jobOptions['type'] as $key => $type): ?>
                                <option  value="<?php echo $type; ?>"><?php echo $key; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col s12 m6 l6">
                        <div class="input-field">
                            <label class="select-label" for="textarea1">
                                What is your skill level?
                            </label>
                            <select name="postanewjob[skill_level]" class="browser-default">
                                <option value="">Select Skill Level</option>
                                <?php foreach($app->jobOptions['skill_level'] as  $skill_level): ?>
                                    <option value="<?php echo $skill_level; ?>"><?php echo $skill_level; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>

                <br/>
                <input type="hidden" name="postanewjob[target]" value="postanewjob"  />
            	<input type="hidden" name="<?php echo $csrf_key; ?>" value="<?php echo $csrf_token; ?>">

				<div class="form-submit">
                <button type="submit" class="btn success">
                    Post Job
                </button>
				</div>

            </form>
        </div>


	</div>
	<div class="col s12 m6 l6">
        <?php if(isset($app->myJobs)): ?>
			<h2>My Jobs</h2>
			<ul class="collection">
        	<?php foreach($app->myJobs as $myJobs): ?>


					<li class="collection-item">
						<a href="/jobs/manage/<?php echo $myJobs->id; ?>">
							<?php echo $myJobs->subject_name; ?>
						</a>
						<?php if(isset($myJobs->applicants)): ?>
							<span class="badge <?php if(isset($myJobs->open)){ echo 'blue';}else{ echo 'green';} ?> white-text"><?php echo $myJobs->applicants; ?></span>
						<?php elseif(isset($myJobs->flag)): ?>
							<span class="badge red white-text"><i class="fa fa-flag"></i></span>
						<?php endif; ?>
					</li>


        	<?php endforeach; ?>
			</ul>
        <?php else: ?>
        	You haven't posted any jobs
        <?php endif; ?>
	</div>
</div>
