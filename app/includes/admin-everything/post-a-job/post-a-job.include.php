<div class="row">
	<div class="col s12 m3 l3">
        
		<a href="/admin-everything/post-a-job" class="btn btn-block">Post New Job</a>
		<div class="block block-list">
            <?php if(isset($app->postedjobs)): ?>
            	<?php foreach($app->postedjobs as $postedjobs): ?>
            		<a <?php if(isset($id) && $id == $postedjobs->id){ echo 'class="active"';} ?> href="/admin-everything/post-a-job/<?php echo $postedjobs->id; ?>">
                        <?php echo $postedjobs->subject_name; ?>
                    </a>
            	<?php endforeach; ?>
            <?php else: ?>
            	There are no posts
            <?php endif; ?>
        </div>
	</div>
	<div class="col s12 m9 l9">


        <!-- RIGHT HERE -->

        <div class="block">
            <?php

    			$jobOptions = array();
    			$jobOptions['type'] = (object)array(
    				'No Preference'=>'both',
    				'Online'=>'online',
    				'In Person'=>'offline'
    			);
    			$jobOptions['skill_level'] = (object)array(
    				'Novice','Advanced Beginner','Competent','Proficient','Expert'
    			);
    			$app->jobOptions = $jobOptions;
    		?>
            <div class="title">
                Post an anonymous job posting from craigslist.
            </div>
            <div class="green-text">(Posts are not attatched to an account, untill you attatch it.)</div>
            <form class="form-post" method="post" action="<?php echo $app->request->getPath(); ?>">

                <div class="input-field">
                    <input type="text" name="postjob[subject_name]" id="findasubject" class="autogenerate--subject" data-name="postjob" value="<?php if(isset($app->thejob->subject_name)){ echo $app->thejob->subject_name; } ?>" <?php if(isset($app->thejob->subject_name)){ echo 'readonly="readonly"'; } ?> />
                    <label for="findasubject">
                        Find The Subject You Want To Learn
                    </label>
                </div>

                <div class="input-field">
                    <textarea id="job_description" name="postjob[job_description]" class="materialize-textarea"><?php if(isset($app->thejob->job_description)){ echo $app->thejob->job_description; } ?></textarea>
                    <label for="job_description">
                        Please explain why you need help with this subject
                    </label>
                </div>

                <div class="input-field input-range jobs-range">

                    <div class="jobs-price-range">What is your price range?</div>

                    <div class="pricerange slidebox"></div>
                    <div class="slidebox-inputs">
                        <input type="text" name="postjob[price_range_low]" id="pricerangeLower" data-value="<?php if(isset($app->thejob->price_range_low)){ echo $app->thejob->price_range_low; }else{ echo '15';} ?>" />
                        <input type="text" name="postjob[price_range_high]" id="pricerangeUpper" data-value="<?php if(isset($app->thejob->price_range_high)){ echo $app->thejob->price_range_high; }else{ echo '65';} ?>" />
                    </div>

                </div>
                <p></p>

                <div class="row">
                    <div class="col s12 m6 l6">
                        <div class="input-field">
                            <label class="select-label" for="textarea1">
                                What type of tutor are you looking for?
                            </label>
                            <select name="postjob[type]" class="browser-default">
                                <?php foreach($app->jobOptions['type'] as $key => $type): ?>
                                <option <?php if(isset($app->thejob->type) && $app->thejob->type == $type){ echo 'selected="selected"';} ?> value="<?php echo $type; ?>"><?php echo $key; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col s12 m6 l6">
                        <div class="input-field">
                            <label class="select-label" for="textarea1">
                                What is your skill level?
                            </label>
                            <select name="postjob[skill_level]" class="browser-default">
                                <option value="">Select Skill Level</option>
                                <?php foreach($app->jobOptions['skill_level'] as  $skill_level): ?>
                                    <option <?php if(isset($app->thejob->skill_level) && $app->thejob->skill_level == $skill_level){ echo 'selected="selected"';} ?> value="<?php echo $skill_level; ?>"><?php echo $skill_level; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>

				<div>
					<input type="checkbox" id="assigntoaccount" />
      				<label for="assigntoaccount">Assign To New Account</label>
					<input class="hide assigntoaccount" placeholder="Enter new account email address" type="email" name="postjob[newemail]" data-status="closed"  />
				</div>

				<?php if(isset($app->thejob->subject_slug)): ?>
                <input type="hidden" name="postjob[subject_slug]" value="<?php echo $app->thejob->subject_slug; ?>"  />
                <?php endif; ?>

				<?php if(isset($app->thejob->parent_slug)): ?>
                <input type="hidden" name="postjob[parent_slug]" value="<?php echo $app->thejob->parent_slug; ?>"  />
                <?php endif; ?>

				<?php if(isset($app->thejob->subject_id)): ?>
                <input type="hidden" name="postjob[subject_id]" value="<?php echo $app->thejob->subject_id; ?>"  />
                <?php endif; ?>

                <?php if(isset($app->thejob)): ?>
                <input type="hidden" name="postjob[type]" value="update"  />
                <?php endif; ?>
                <input type="hidden" name="postjob[target]" value="postjob"  />
                <input type="hidden" name="<?php echo $csrf_key; ?>" value="<?php echo $csrf_token; ?>">

                <p></p>
                <div class="form-submit">
                    <?php if(isset($app->thejob)): ?>
                        <button class="btn green" type="submit">
                            Update Job
                        </button>
                    <?php else: ?>
                        <button class="btn blue" type="submit">
                            Post Job
                        </button>
                    <?php endif; ?>
                </div>

            </form>
        </div>

        <!-- RIGHT HERE -->



	</div>
</div>


<script type="text/javascript">

	$(document).ready(function() {
		$('#assigntoaccount').on('click',function(){
			var status = $('.assigntoaccount').attr('data-status');
			if(status=='closed'){
				$('.assigntoaccount').attr('data-status','open');
				$('.assigntoaccount').removeClass('hide').hide().slideDown();
			}
			else{
				$('.assigntoaccount').attr('data-status','closed');
				$('.assigntoaccount').slideUp();
			}
		});
	});

</script>
