<h1>Crop Your Photo</h1>
<p>Please crop your photo for your profile. Only cropped photos will be approved.</p>

<p>
	<div id="cropbox" data-image="/image/photograph/<?php echo $app->currentuser->username; ?>">
		<img <?php if(isset($app->imgwidth)){ echo 'data-width="'.$app->imgwidth.'"';} ?> src="/image/photograph/<?php if(isset($app->imgwidth)){ echo 'width----'.$app->imgwidth.'/';} ?><?php echo $app->currentuser->username; ?>" />
	</div>
</p>
<form id="cropform" action="<?php echo $app->currentuser->url; ?>/my-photos/crop-photo" method="post">
	<input type="hidden" id="x" name="crop[x]" />
	<input type="hidden" id="y" name="crop[y]" />
	<input type="hidden" id="w" name="crop[w]" />
	<input type="hidden" id="h" name="crop[h]" />
	<?php if(isset($app->imgwidth)): ?>
		<input type="hidden" id="cropwidth" name="crop[fullwidth]" value="<?php echo $app->imgwidth; ?>" />
	<?php endif; ?>

	<input type="hidden" name="crop[target]" value="crop"  />
	<input type="hidden" name="<?php echo $csrf_key; ?>" value="<?php echo $csrf_token; ?>">

	<button type="submit" class="btn btn-success">
		Crop Photo
	</button>
</form>
