<?php if(isset($app->actualuser->qaposts)): ?>
	<?php foreach($app->actualuser->qaposts as $qaposts): ?>
		<div class="my-content-block">
            <div class="my-content-block-title">
                <?php echo $qaposts->title; ?>
            </div>
            <div class="my-content-block-copy">
                <?php echo truncate($qaposts->content,200); ?>
                <div class="read-more">
                    <a href="https://qa.avidbrain.com/<?php echo $qaposts->parentid; ?>">View Full Answer</a>
                </div>
            </div>
            <div class="my-content-block-date">
                <?php echo formatdate($qaposts->created); ?>
            </div>
        </div>
	<?php endforeach; ?>
<?php else: ?>
	You have not answered any Q&amp;A Posts
<?php endif; ?>
