<?php if(isset($app->actualuser->subjects->approved)): ?>
    <?php $count = count($app->actualuser->subjects->approved); foreach($app->actualuser->subjects->approved as $key=> $approved): ?>
        <div class="my-content-block">
            <div class="my-content-block-title">
                <i class="mdi-maps-beenhere tooltipped verified-by" data-position="top" data-delay="50" data-tooltip="Verified By MindSpree"></i>
                <?php echo $approved->subject_name; ?>
            </div>
            <div class="my-content-block-copy"><?php echo ($approved->description_verified); ?></div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>


<?php if(isset($app->actualuser->subjects->notApproved)): ?>
    <?php $count = count($app->actualuser->subjects->notApproved); foreach($app->actualuser->subjects->notApproved as $key=> $notApproved): ?>
        <?php
            echo $notApproved->subject_name;
            if($key!=($count-1)){ echo ','; }
        ?>
    <?php endforeach; ?>
<?php endif; ?>
