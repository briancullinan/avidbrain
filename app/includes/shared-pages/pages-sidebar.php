<?php if(isset($app->currentuser->thisisme)): ?>

	
	<li class="collection-item edit-block">
		I Will Travel <span class="change-me" id="travel_distance"><?php echo $app->currentuser->travel_distance; ?></span> Miles
		
		<?php
			$travRangeLow = range(0,100,5);
			$travRangeHigh = range(200,1000,100);
			$travRange = array_merge($travRangeLow,$travRangeHigh);
		?>
		<select class="browser-default changer" id="travel_distance_select" data-name="editprofile[travel_distance]" data-target="#travel_distance">
			<?php foreach($travRange as $range): ?>
			<option data-value="<?php echo $range; ?>" <?php if(isset($app->currentuser->travel_distance) && $app->currentuser->travel_distance==$range){ echo 'selected="selected"';} ?> value="<?php echo $range; ?>">
				<?php echo $range; ?> Miles
			</option>
			<?php endforeach; ?>
		</select>
	</li>
	
	<li class="collection-item edit-block">
		I'm <span class="change-me" id="gender"><?php echo ucwords($app->currentuser->gender); ?></span>
		
		<?php
			$genderrange = array("Don't show my gender"=>NULL,'Male'=>'male','Female'=>'female');
		?>
		<select class="browser-default changer" id="gender_select" data-name="editprofile[gender]" data-target="#gender">
			<?php foreach($genderrange as $key=> $range): ?>
			<option data-value="<?php echo strtolower($range); ?>" <?php if(isset($app->currentuser->gender) && $app->currentuser->gender==strtolower($range)){ echo 'selected="selected"';} ?> value="<?php echo $key; ?>">
				<?php echo $key; ?>
			</option>
			<?php endforeach; ?>
		</select>
	</li>
	
	<?php if($app->currentuser->usertype=='tutor'): ?>
	<li class="collection-item edit-block">
		I Tutor <span class="change-me" id="online_tutor"><?php echo online_tutor($app->currentuser->online_tutor); ?></span>
		
		<?php
			$genderrange = array(
				'both'=>'Online & In Person',
				'offline'=>'In Person',
				'online'=>'Online'
			);
		?>
		<select class="browser-default changer" id="online_tutor_select" data-name="editprofile[online_tutor]" data-target="#online_tutor">
			<?php foreach($genderrange as $key=> $range): ?>
			<option data-value="<?php echo $key; ?>" <?php if(isset($app->currentuser->online_tutor) && $app->currentuser->online_tutor==$key){ echo 'selected="selected"';} ?> value="<?php echo $range; ?>">
				<?php echo $range; ?>
			</option>
			<?php endforeach; ?>
		</select>
	</li>
	
	<li class="collection-item edit-block">
		<span class="change-me" id="cancellation_policy"><?php echo $app->currentuser->cancellation_policy; ?></span> Hour Cancelation Policy
		
		<?php
			$policyrangeLow = range(0,11,1);
			$policyrangeHigh = range(12,48,2);
			$policyrange = array_merge($policyrangeLow,$policyrangeHigh);
		?>
		<select class="browser-default changer" id="cancellation_policy_select" data-name="editprofile[cancellation_policy]" data-target="#cancellation_policy">
			<?php foreach($policyrange as $range): ?>
			<option data-value="<?php echo $range; ?>" <?php if(isset($app->currentuser->cancellation_policy) && $app->currentuser->cancellation_policy==$range){ echo 'selected="selected"';} ?> value="<?php echo $range; ?>">
				<?php echo $range; ?> Hours
			</option>
			<?php endforeach; ?>
		</select>
	</li>
	
	<li class="collection-item edit-block">
		<span class="change-me" id="cancellation_rate">$<?php echo $app->currentuser->cancellation_rate; ?></span> Cancelation Fee
		
		<?php
			$cancelfee = range(0,100,10);
		?>
		<select class="browser-default changer" id="cancellation_rate_select" data-name="editprofile[cancellation_rate]" data-target="#cancellation_rate">
			<?php foreach($cancelfee as $range): ?>
			<option data-value="<?php echo $range; ?>" <?php if(isset($app->currentuser->cancellation_rate) && $app->currentuser->cancellation_rate==$range){ echo 'selected="selected"';} ?> value="$<?php echo $range; ?>">
				$<?php echo $range; ?>
			</option>
			<?php endforeach; ?>
		</select>
	</li>
	<?php else: ?>
	
	<li class="collection-item edit-block">
		I Want An <span class="change-me" id="online_tutor"><?php echo online_tutor($app->currentuser->online_tutor); ?></span> Tutor
		
		<?php
			$genderrange = array(
				'both'=>'Online & In Person',
				'offline'=>'In Person',
				'online'=>'Online'
			);
		?>
		<select class="browser-default changer" id="online_tutor_select" data-name="editprofile[online_tutor]" data-target="#online_tutor">
			<?php foreach($genderrange as $key=> $range): ?>
			<option data-value="<?php echo $key; ?>" <?php if(isset($app->currentuser->online_tutor) && $app->currentuser->online_tutor==$key){ echo 'selected="selected"';} ?> value="<?php echo $range; ?>">
				<?php echo $range; ?>
			</option>
			<?php endforeach; ?>
		</select>
	</li>
	
	
	<?php endif; ?>

	

<?php else: ?>
	
	<?php if(isset($app->currentuser->travel_distance) && $app->currentuser->travel_distance>0): ?>
	<li class="collection-item edit-block">
		I Will Travel <span><?php echo $app->currentuser->travel_distance; ?></span> Miles
	</li>
	<?php endif; ?>
	
	<?php if(isset($app->currentuser->gender) && !empty($app->currentuser->gender)): ?>
	<li class="collection-item edit-block">
		I'm <span><?php echo ucwords($app->currentuser->gender); ?></span>
	</li>
	<?php endif; ?>
	
	<?php if(isset($app->currentuser->online_tutor) && $app->currentuser->usertype=='tutor'): ?>
	<li class="collection-item edit-block">
		I Tutor <span><?php echo online_tutor($app->currentuser->online_tutor); ?></span>
	</li>
	<?php endif; ?>
	
	<?php if(isset($app->currentuser->cancellation_policy) && $app->currentuser->cancellation_policy!=0 && $app->currentuser->usertype=='tutor'): ?>
	<li class="collection-item edit-block">
		<span><?php echo $app->currentuser->cancellation_policy; ?></span> Hour Cancelation Policy
	</li>
	<?php endif; ?>
	
	<?php if(isset($app->currentuser->cancellation_rate) && $app->currentuser->cancellation_rate!=0 && $app->currentuser->usertype=='tutor'): ?>
	<li class="collection-item edit-block">
		<span>$<?php echo $app->currentuser->cancellation_rate; ?></span>  Cancelation Fee
	</li>
	<?php endif; ?>

<?php endif; ?>