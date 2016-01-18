<?php if(isset($app->joblog->id)): ?>

    <h3><?php echo $app->job->subject_name; ?></h3>

    <div>Date: <?php echo formatdate($app->joblog->date); ?></div>
    <div> Job: <a href="/admin-everything/post-a-job/<?php echo $app->joblog->job_id; ?>"><?php echo $app->joblog->job_id; ?></a> </div>
    <div>Emails Sent To:</div>
    <div class="block">
        <?php
            foreach(json_decode($app->joblog->email_list) as $list){
                echo '<div>'.$list->name.': '.$list->email.'</div>';
            }
        ?>
    </div>

<?php endif; ?>
