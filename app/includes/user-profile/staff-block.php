<?php
	$sql = "SELECT * FROM avid___admins WHERE email = :email";
	$prepeare = array(':email'=>$email);
	$aviduser = $app->connect->executeQuery($sql,$prepeare)->fetch();

	if(isset($aviduser->first_name)){
	
		if(isset($aviduser->my_upload)){
			$image = $aviduser->my_upload;
		}
		else{
			$image = $aviduser->my_avatar;
		}
	}
?>


<?php if(isset($aviduser->first_name)): ?>					
<div class="user-block center-align staff-block">
						
	<div class="profile-image avatar">
		<a href="<?php echo $aviduser->url; ?>"><img class="responsive-img" src="<?php echo $image; ?>" /></a>
	</div>
	<div class="user-name">
		<a href="<?php echo $aviduser->url; ?>"><?php echo short($aviduser); ?></a>
		<div class="badge blue white-text">Staff</div>
	</div>
	
</div>
<?php endif; ?>