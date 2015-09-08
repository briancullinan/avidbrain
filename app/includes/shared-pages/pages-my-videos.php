<?php if(isset($app->currentuser->thisisme)): ?>
	<form class="form-post hide" method="post" action="<?php echo $app->request->getPath(); ?>" id="myvideosorder">
		<input type="hidden" name="videosorder[target]" value="videosorder"  />
		<input type="hidden" name="<?php echo $csrf_key; ?>" value="<?php echo $csrf_token; ?>">
		<div class="theorder"></div>
	</form>
	
		
	<p>Add a youtube video to your profile. It's quick and easy, just find a <a href="https://www.youtube.com/watch?v=XW7Of3g2JME" target="_blank">video</a> you like and click on the share button, copy and paste the url into the form below, then click Add Video.</p>
	<form class="form-post" method="post" action="<?php echo $app->request->getPath(); ?>">
		
		<div class="row">
			<div class="col s12 m8 l8">
				<input type="text" name="addvideo[newvideo]" />
			</div>
			<div class="col s12 m4 l4 right-align">
				<button class="btn">
					<i class="fa fa-plus"></i> Add Video
				</button>
			</div>
		</div>
		
		<input type="hidden" name="addvideo[target]" value="addvideo"  />
		<input type="hidden" name="<?php echo $csrf_key; ?>" value="<?php echo $csrf_token; ?>">
		
	</form>
	
<?php endif; ?>

<div id="myvideos">
	<?php if(isset($app->currentuser->my_videos[0])): ?>
		<?php foreach($app->currentuser->my_videos as $video): ?>
			<div class="block" <?php if(isset($video->order)){ echo 'data-info="'.$video->id.'"'; } ?> <?php if(isset($video->order)){ echo 'data-id="'.$video->order.'"'; } ?> >
				<?php if(isset($app->currentuser->thisisme)): ?>
				<div class="reorder-subjects"><i class="fa fa-reorder"></i></div>
				<?php endif; ?>
				<div class="video-container">
					<iframe width="853" height="480" src="//www.youtube.com/embed/<?php echo str_replace('https://youtu.be/','',$video->url) ?>?rel=0" frameborder="0" allowfullscreen></iframe>
				</div>
				<?php if(isset($app->currentuser->thisisme)): ?>
				<div class="hr"></div>
					<form method="post" action="<?php echo $app->request->getPath(); ?>" id="deletevideo-<?php echo $video->id; ?>">
						
						<input type="hidden" name="deletevideo[id]" value="<?php echo $video->id; ?>"  />
						<input type="hidden" name="deletevideo[target]" value="deletevideo"  />
						<input type="hidden" name="<?php echo $csrf_key; ?>" value="<?php echo $csrf_token; ?>">
						
						<button class="btn red confirm-submit" type="button" data-value="deletevideo" data-name="deletevideo-<?php echo $video->id; ?>">
							<i class="fa fa-trash"></i> Delete Video
						</button>
						
					</form>
				<?php endif; ?>
			</div>
		<?php endforeach; ?>
	<?php endif; ?>
</div>