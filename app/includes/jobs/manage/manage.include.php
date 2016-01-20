<h1>Manage Job</h1>


<div class="row">
	<div class="col s12 m6 l6">


		<?php if(empty($app->thejob->open)): ?>
			<div class="alert grey white-text">
				Job Post Closed
			</div>
		<?php endif; ?>
        <div class="block">
			<?php if(isset($app->thejob->open)): ?>
            <form class="form-post" method="post" action="<?php echo $app->request->getPath(); ?>" id="updatejob">
			<?php endif; ?>

                <div class="input-field">
                    <input type="text" id="subject" name="updatejob[subject]" data-name="updatejob" class="autogenerate--subject" value="<?php echo $app->thejob->subject_name; ?>" />
                    <label for="subject">
                        Subject
                    </label>
                </div>

                <div class="input-field">
                    <textarea id="why" name="updatejob[why]" class="materialize-textarea"><?php echo $app->thejob->job_description; ?></textarea>
                    <label for="why">
                        Explain why you need help
                    </label>
                </div>

                <div class="input-field input-range jobs-range">

                    <div class="jobs-price-range">What is your price range?</div>

                    <div class="pricerange slidebox"></div>
                    <div class="slidebox-inputs">
                        <input type="text" name="updatejob[price_range_low]" id="pricerangeLower" data-value="<?php echo $app->thejob->price_range_low; ?>" />
                        <input type="text" name="updatejob[price_range_high]" id="pricerangeUpper" data-value="<?php echo $app->thejob->price_range_high; ?>" />
                    </div>

                </div>

                <div class="row">
                    <div class="col s12 m6 l6">
                        <div class="input-field">
                            <label class="select-label" for="textarea1">
                                What type of tutor are you looking for?
                            </label>
                            <select name="updatejob[type]" class="browser-default">
                                <?php foreach($app->jobOptions['type'] as $key => $type): ?>
                                <option <?php if(!empty($app->thejob->type) && $app->thejob->type==$type){ echo 'selected="selected"'; } ?>  value="<?php echo $type; ?>"><?php echo $key; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col s12 m6 l6">
                        <div class="input-field">
                            <label class="select-label" for="textarea1">
                                What is your skill level?
                            </label>
                            <select name="updatejob[skill_level]" class="browser-default">
                                <option value="">Select Skill Level</option>
                                <?php foreach($app->jobOptions['skill_level'] as  $skill_level): ?>
                                    <option <?php if(!empty($app->thejob->skill_level) && $app->thejob->skill_level==$skill_level){ echo 'selected="selected"'; } ?> value="<?php echo $skill_level; ?>"><?php echo $skill_level; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>

                <br/>
                <div>
                    <span>
                        <input id="openopen" type="radio" name="updatejob[open]" value="OPEN" <?php if(!empty($app->thejob->open)){ echo 'checked="checked"'; } ?> />
                        <label for="openopen">Open</label>
                    </span>
                    <span>
                        <input id="openclosed"  type="radio" name="updatejob[open]" value="CLOSED" <?php if(empty($app->thejob->open)){ echo 'checked="checked"'; } ?> />
                        <label for="openclosed">Closed</label>
                    </span>
                </div>


                <input type="hidden" name="updatejob[email]" value="<?php echo $app->thejob->email; ?>" />

                <br/>


                <?php if (strpos($app->thejob->email, 'ghost-') !== false): ?>
                    <div class="attatch-to-user">

                        <div>Attatch Real User Email</div>

                        <label for="subject">
                            User's Email Address
                        </label>
                        <input type="text"  name="updatejob[attatchuser]"  />


                    </div>
                <?php endif; ?>


                <input type="hidden" name="updatejob[target]" value="updatejob"  />
            	<input type="hidden" name="<?php echo $csrf_key; ?>" value="<?php echo $csrf_token; ?>">

				<?php if(isset($app->thejob->open)): ?>
                <button type="submit" class="btn success">
                    Update Job
                </button>
				<?php endif; ?>

			<?php if(isset($app->thejob->open)): ?>
            </form>
			<?php endif; ?>
        </div>


	</div>
	<div class="col s12 m6 l6">

        <?php if(!empty($app->thejob->applicants) && !empty($app->thejob->open)): ?>
            <h2>Job Applicants</h2>
        	<?php foreach($app->thejob->applicants as $applicants): ?>
        		<div class="block">
                    <div class="title">
						<a href="<?php echo $applicants->url; ?>" target="_blank">
							<?php echo $applicants->first_name; ?>
						</a>
					</div>

					<div class="description"><?php echo $applicants->message; ?></div>
					<div class="date"><?php echo formatdate($applicants->date); ?></div>
					<div class="hr"></div>

					<?php if(isset($app->user->creditcard()->id)): ?>

						<form method="post" action="<?php echo $app->request->getPath(); ?>">

							<input type="hidden" name="acceptapplication[email]" value="<?php echo $applicants->email; ?>"  />
							<input type="hidden" name="acceptapplication[target]" value="acceptapplication"  />
							<input type="hidden" name="acceptapplication[id]" value="<?php echo $applicants->id; ?>"  />
							<input type="hidden" name="<?php echo $csrf_key; ?>" value="<?php echo $csrf_token; ?>">
							<br>
							<button class="btn blue confirm-submit" data-value="accept" data-name="acceptapplication" type="button">
								Accept Application
							</button>

						</form>

					<?php else: ?>
						<br>
						<p>You must first have a credit card on file, to accept a job application</p>
						<a class="btn blue" href="/payment">Add Payment Method</a>
					<?php endif; ?>

                </div>
        	<?php endforeach; ?>
		<?php elseif(isset($app->thejob->applicantinfo)): //printer($app->thejob->applicantinfo); ?>
			<h2>Accepted Application</h2>
			<div class="block">
				<a href="<?php echo $app->thejob->applicantinfo->url; ?>" target="_blank">
					<?php echo $app->thejob->applicantinfo->first_name; ?>
				</a>
				<div>
					<?php echo $app->thejob->applicantinfo->message; ?>
				</div>
			</div>
			<?php if(isset($app->thejob->applicantinfo->sessionid)): ?>
				<div class="block">
					<div><?php echo $app->thejob->applicantinfo->session_subject; ?></div>
					<div>$<?php echo $app->thejob->applicantinfo->session_rate; ?>/Hour</div>
					<div><?php echo formatdate($app->thejob->applicantinfo->session_timestamp); ?></div>
					<a href="/sessions/view/<?php echo $app->thejob->applicantinfo->sessionid; ?>">
						View Session Details
					</a>
				</div>
			<?php endif; ?>
        <?php else: ?>
        	You have no applicants
        <?php endif; ?>
	</div>
</div>
