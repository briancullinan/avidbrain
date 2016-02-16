<?php if(isset($app->actualuser->finalscore)): ?>
	<div class="starbox">
		<?php foreach($app->actualuser->finalscore->scores as $key=> $finalscore): ?>
			<?php $percent = round((($finalscore/$app->actualuser->finalscore->total)*100)); ?>
			<div class="row">
				<div class="col s4 m4 l3">
					<?php echo $key; ?>
				</div>
				<div class="col s8 m8 l9">
					<div class="wide-count-total">
						<div class="wide-count" style="width:<?php echo $percent; ?>%;"></div>
					</div>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
<?php endif; ?>


<?php if(isset($app->actualuser->myreviews)): ?>
    <?php foreach($app->actualuser->myreviews as $myreviews):  ?>
        <div class="my-content-block">
            <div class="my-content-block-title">
                <?php if(isset($app->user->email)): ?> <a href="<?php echo $myreviews->url; ?>"> <?php endif; ?>
                    <?php echo short($myreviews); ?> <div class="myStars"><?php echo mystars($myreviews->review_score) ?></div>
                <?php if(isset($app->user->email)): ?> </a> <?php endif; ?>
            </div>
            <div class="my-content-block-copy">
                <?php echo $myreviews->review_text; ?>
            </div>
            <div class="my-content-block-date">
                <?php echo formatdate($myreviews->review_date); ?>
            </div>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    I have no reviews yet
<?php endif; ?>
