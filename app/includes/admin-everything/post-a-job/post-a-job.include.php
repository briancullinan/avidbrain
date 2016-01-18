<div class="row">
	<div class="col s12 m3 l3">
        <a href="/admin-everything/post-a-job" class="btn btn-block">Post New Job</a>
		<div class="block block-list new-order-list">
            <?php if(isset($app->postedjobs)): ?>
            	<?php foreach($app->postedjobs as $postedjobs): ?>
            		<a class="block-list-user <?php if(isset($id) && $id == $postedjobs->id){ echo ' active ';} ?>" href="/admin-everything/post-a-job/<?php echo $postedjobs->id; ?>">
                        <?php echo $postedjobs->subject_name; ?>
                    </a>
            	<?php endforeach; ?>
            <?php else: ?>
            	There are no posts
            <?php endif; ?>
        </div>
	</div>
	<div class="col s12 m9 l9">

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

	            if(isset($app->thejob)){
	                include('postajob.existing.php');
	            }
	            else{
	                include('postajob.new.php');
	            }
	        ?>
		</div>

	</div>
</div>
