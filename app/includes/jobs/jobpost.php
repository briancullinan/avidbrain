<div class="block job-post <?php if(!empty($jobpost->open)){ echo ' status-open ';}else{ echo ' status-closed ';} ?>">
    <div class="row">
    	<div class="col s12 m12 l7">
            <div class="job-post-title">
                <?php if(!empty($jobpost->open)): ?>
                <a href="/jobs/apply/<?php echo $jobpost->id; ?>">
                    <?php echo $jobpost->subject_name; ?> Student
                </a>
                <?php else: ?>
                    <?php echo $jobpost->subject_name; ?> Student
                <?php endif; ?>
            </div>
            <div class="job-post-location">
                <?php echo $jobpost->city; ?>,
                <?php echo ucwords($jobpost->state_long); ?>
                <?php echo $jobpost->zipcode; ?>
                <?php if(isset($jobpost->distance)): ?>
                    <span class="job-post-distance"><?php echo $jobpost->distance; ?> Miles Away</span>
                <?php endif; ?>
            </div>

            <div class="job-post-description">
                <?php echo nl2br(truncate($jobpost->job_description,350)); ?>
            </div>

    	</div>
    	<div class="col s12 m12 l5">

            <?php if(!empty($jobpost->type)): ?>
            <div>

                I'm looking for <strong class="blue-text"><?php echo online_tutor($jobpost->type); ?> Tutoring</strong>

            </div>
            <?php endif; ?>

            <?php if(!empty($jobpost->skill_level)): ?>
            <div>
                My Skill Level: <strong><?php echo $jobpost->skill_level; ?></strong>
            </div>
            <?php endif; ?>


            <div>
                Applicants: <strong class="applicant-count <?php echo applicantcount($jobpost->applicants); ?>"><?php echo $jobpost->applicants; ?></strong>
            </div>
            <div>
                Price Range:
                    <strong class="green-text">$<?php echo $jobpost->price_range_low; ?> - $<?php echo $jobpost->price_range_high; ?></strong>
            </div>

            <div>
                Posted By: <?php echo $jobpost->first_name; ?> on <?php echo formatdate($jobpost->date, 'M. jS, Y @ g:i a') ?>
            </div>


            <?php if(isset($app->user->usertype) && $app->user->usertype=='admin'): ?>
                <a href="/admin-everything/post-a-job/<?php echo $jobpost->id; ?>" class="btn red">
                    Manage Post
                </a>
            <?php elseif(!empty($jobpost->open)): ?>
                <div class="apply-now">
                    <a href="/jobs/apply/<?php echo $jobpost->id; ?>" class="btn blue">
                        Apply Now
                    </a>
                </div>
            <?php endif; ?>

    	</div>
    </div>
</div>
