<?php if(isset($app->staff[0])): ?>
	<?php foreach($app->staff as $staff): ?>
		<div class="staff">
			<div class="row">
				<div class="col s12 m3 l3 center-align">
					<?php
						if(isset($staff->my_upload)){
							$image = $staff->my_upload;
						}
						elseif(isset($staff->my_avatar)){
							$image = $staff->my_avatar;
						}
						else{
							$image = '/images/amozek.png';
						}
					?>
					<div class="avatar staff"><img class="responsive-img" src="<?php echo $image; ?>" /></div>
				</div>
				<div class="col s12 m9 l9">
					<h2><?php echo $staff->first_name.' '.$staff->last_name; ?></h2>
					<h3><?php echo $staff->short_description; ?></h3>
					<p><?php echo truncate($staff->personal_statement,400); ?></p>
					<p><a class="btn btn-s" href="<?php echo $staff->url; ?>">View Full Profile</a></p>
				</div>
			</div>
		</div>
	<?php endforeach; ?>
<?php endif; ?>