<?php
	$width = NULL;
	$datawidth = NULL;
	if(isset($promocode) && is_numeric($promocode)){
		$width = '/width----'.$promocode;
		$datawidth = ' data-width="'.$width.'" ';
	}
?>

<h1>Crop Your Photo</h1>
<p>Please crop your photo for your profile. Only cropped photos will be approved.</p>
<p>
	<div id="cropbox" data-image="/image/tutorphotos/<?php echo $app->newtutor->id; ?>">
        <img <?php echo $datawidth; ?> src="/image/tutorphotos<?php echo $width; ?>/<?php echo $app->newtutor->id; ?>">
    </div>
</p>
<form id="cropform" action="/signup/tutor" method="post">
	<input type="hidden" id="x" name="crop[x]" />
	<input type="hidden" id="y" name="crop[y]" />
	<input type="hidden" id="w" name="crop[w]" />
	<input type="hidden" id="h" name="crop[h]" />

	<?php if(isset($promocode)): ?>
		<input type="hidden" id="cropwidth" name="crop[fullwidth]" value="<?php echo $promocode; ?>" />
	<?php endif; ?>

	<input type="hidden" name="crop[target]" value="crop"  />
	<input type="hidden" name="<?php echo $csrf_key; ?>" value="<?php echo $csrf_token; ?>">

	<button type="submit" class="btn btn-success">
		Crop Photo
	</button>
</form>
